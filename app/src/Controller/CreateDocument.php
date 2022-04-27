<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\DocumentTypes;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CreateDocument extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function __invoke(Request $request, $data)
    {
        $requestBody = $request->toArray();

        $this->verifyRequestBody($requestBody);

        $documentType = $this->verifyDocumentTypeExist($requestBody);

        $user = $this->entityManager->getReference(User::class, $requestBody['user']['id']);

        $document = new Document();

        $document->setDocumentType($documentType)
                 ->setUser($user);

        return $document;
    }

    private function verifyRequestBody($requestBody)
    {
        if (!array_key_exists('documentType',$requestBody) || !array_key_exists('slug',$requestBody['documentType']))
        {
            return throw new BadRequestException('The slug is mandatory to post');
        }

        if (!array_key_exists('user',$requestBody) || !array_key_exists('id',$requestBody['user']))
        {
            return throw new BadRequestException('The user_id is mandatory to post');
        }
    }

    private function verifyDocumentTypeExist($requestBody): DocumentTypes
    {
        $documentType = $this->entityManager->getRepository(DocumentTypes::class)->findOneBy([
            'slug' => $requestBody['documentType']['slug']
        ]);

        if (empty($documentType)){
            return throw new BadRequestException('the slug in documenttype does not exist');
        }

        return $documentType;
    }
}