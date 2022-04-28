<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\CreateDocument;
use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: ['get',
        'post' => [
            'method' => 'POST',
            'controller' => CreateDocument::class,
            'denormalization_context' => ['groups' => ['document:write']],
        ]
    ],
    itemOperations: [
        "get", "put", "delete",
        "patch" => ["security" => "is_granted('DOCUMENT_EDIT', object)"],
    ],
    attributes: [
        "pagination_items_per_page" => 10,
    ],
    normalizationContext: ['groups' => ['document:read']]
)]
#[ApiFilter(
    SearchFilter::class, properties: ['user.id' => 'exact', 'documentType.slug' => 'exact', 'description' => 'partial']
)]
#[ApiFilter(RangeFilter::class, properties: ['created_at', 'updated_at'])]
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[HasLifecycleCallbacks]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['document:write', 'document:read'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: DocumentTypes::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['document:write', 'document:read'])]
    private $documentType;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['document:write','document:read'])]
    private $user;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['document:read'])]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['document:read'])]
    private $updated_at;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['document:read'])]
    private $esigne;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['document:read'])]
    private $email;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['document:read'])]
    private $post;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['document:read'])]
    private $locked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentType(): ?DocumentTypes
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypes $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[PrePersist]
    public function createdAtDateTimePrePersist()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[PreUpdate]
    public function updatedDateTimePreUpdate()
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }

    public function getEsigne(): ?bool
    {
        return $this->esigne;
    }

    public function setEsigne(?bool $esigne): self
    {
        $this->esigne = $esigne;

        return $this;
    }

    public function getEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(?bool $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPost(): ?bool
    {
        return $this->post;
    }

    public function setPost(?bool $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(?bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }
}
