<?php

namespace App\Entity;

use App\Enum\DocumentTypesFormat;
use App\Repository\DocumentTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: DocumentTypesRepository::class)]
#[HasLifecycleCallbacks]
class DocumentTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private $format;

    #[ORM\Column(type: 'boolean')]
    private $esigned;

    #[ORM\Column(type: 'boolean')]
    private $email;

    #[ORM\Column(type: 'boolean')]
    private $post;

    #[ORM\Column(type: 'boolean')]
    private $updated;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $update_at;

    #[ORM\OneToMany(mappedBy: 'documentType', targetEntity: Document::class)]
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    private function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    #[PrePersist]
    public function createdSlugPrePersist()
    {
        $slugName = $this->createSlug();
        $this->setSlug($slugName);
    }

    private function createSlug()
    {
        $slug = new AsciiSlugger();

        return $slug->slug($this->getName(), '_');
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        if (!in_array($format, array(DocumentTypesFormat::FORMAT_CONTRACT, DocumentTypesFormat::FORMAT_LETTER))) {
            throw new \InvalidArgumentException("Invalid format");
        }

        $this->format = $format;

        return $this;
    }

    public function getEsigned(): ?bool
    {
        return $this->esigned;
    }

    public function setEsigned(bool $esigned): self
    {
        $this->esigned = $esigned;

        return $this;
    }

    public function getEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(bool $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPost(): ?bool
    {
        return $this->post;
    }

    public function setPost(bool $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUpdated(): ?bool
    {
        return $this->updated;
    }

    public function setUpdated(bool $updated): self
    {
        $this->updated = $updated;

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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    #[PreUpdate]
    public function updatedDateTimePreUpdate()
    {
        $this->setUpdateAt(new \DateTimeImmutable());
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setDocumentType($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDocumentType() === $this) {
                $document->setDocumentType(null);
            }
        }

        return $this;
    }
}
