<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Document;
use App\Entity\DocumentTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DocumentPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Document;
    }

    public function persist($data, array $context = [])
    {
        $ITEM_OPERATION_NAME = array_key_exists('item_operation_name', $context);

        if ($ITEM_OPERATION_NAME) {
            switch ($context['item_operation_name'])
            {
                case 'patch':
                    $this->canSign($data);
                    $data->setLocked(true);
                    break;
            }
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

    private function canSign($data)
    {
        $permission = $this->diffBetweenDocumentTypePermissionAndData($data);

        if ($permission)
        {
            return throw new AccessDeniedHttpException('Ce document ne permet pas une signature '. $permission);
        }

        return true;
    }

    private function diffBetweenDocumentTypePermissionAndData($data)
    {
        $documentType = $this->entityManager->getReference(DocumentTypes::class, $data->getDocumentType()->getId());

        $documentTypePermission = [
            'esign' => $documentType->getEsigned(),
            'email' => $documentType->getEmail(),
            'post' => $documentType->getPost()
        ];

        $dataPermission = [
            'esign' => $data->getEsigne(),
            'email' => $data->getEmail(),
            'post' => $data->getPost()
        ];

        $dataPermissionFilter = array_filter($dataPermission);


        return array_key_first(array_diff_assoc($dataPermissionFilter, $documentTypePermission));
    }

}