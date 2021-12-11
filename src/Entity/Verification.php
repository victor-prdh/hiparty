<?php

namespace App\Entity;

use App\Repository\VerificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VerificationRepository::class)
 */
class Verification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\Length(
     *      min = 50,
     *      minMessage = "Merci de saisir au moins {{ limit }} caractères."
     * )
     * 
     * @Assert\NotBlank(message = "Merci de remplir le champs pour votre demande")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $traitement;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="verificationrequests")
     */
    private $FromUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTraitement(): ?int
    {
        return $this->traitement;
    }

    public function setTraitement(int $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFromUser(): ?User
    {
        return $this->FromUser;
    }

    public function setFromUser(?User $FromUser): self
    {
        $this->FromUser = $FromUser;

        return $this;
    }

}
