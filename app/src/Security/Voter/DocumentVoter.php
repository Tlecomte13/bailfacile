<?php

namespace App\Security\Voter;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class DocumentVoter extends Voter
{

    const DOCUMENT_EDIT = 'DOCUMENT_EDIT';
    const DOCUMENT_DELETE = 'DOCUMENT_DELETE';

    const AVAILABLEATTRIBUTE = [
        self::DOCUMENT_EDIT,
        self::DOCUMENT_DELETE
    ];

    public function __construct(private EntityManagerInterface $entityManager)
    {}

    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array($attribute, self::AVAILABLEATTRIBUTE);
        $supportsSubject = $subject instanceof Document;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param Document $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        switch ($attribute) {
            case self::DOCUMENT_EDIT:
                if (!$subject->getLocked()){
                    return true;
                } else {
                    return throw new AccessDeniedHttpException('Le document est vérouiller, vous ne pouvez plus le mettre à jour.');
                }
            case self::DOCUMENT_DELETE:
                if (!$subject->getLocked()){
                    return true;
                } else {
                    return throw new AccessDeniedHttpException('Le document est vérouiller, vous ne pouvez pas le supprimer.');
                }
                break;
        }

        return false;
    }
}