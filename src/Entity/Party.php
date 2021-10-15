<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"party:read"}},
 *      denormalizationContext={"groups"={"party:write"}},
 *      collectionOperations={
 *         "get"={"security"="is_granted('ROLE_USER')"},
 *         "post"={"security"="is_granted('ROLE_CONTRIB')"},
 *          "party_near"={"route_name"="party_near", "security"="is_granted('ROLE_CONTRIB')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=PartyRepository::class)
 */
class Party
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("party:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     *  @Groups({"party:read", "party:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * 
     *  @Groups({"party:read", "party:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * 
     *  @Groups({"party:read", "party:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     *  @Groups({"party:read", "party:write"})
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     *  @Groups({"party:read", "party:write"})
     */
    private $nbPlaces;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("party:read")
     */
    private $lieux;

    /**
     * 
     * @Groups("party:write")
     */
    private int $numeroLieux;

    /**
     * 
     * @Groups("party:write")
     */
    private $rue;

    /**
     * 
     * @Groups("party:write")
     */
    private $ville;

    /**
     * 
     * @Groups("party:write")
     */
    private int $codePostal;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    private $longitude;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    private $latitude;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"party:read", "party:write"})
     */
    private $isMajeur;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"party:read", "party:write"})
     */
    private $isOutdoor;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"party:read", "party:write"})
     */
    private $isReserved;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Groups({"party:read", "party:write"})
     */
    private $reservDesc;

    /**
     * @ORM\ManyToOne(targetEntity=App\Entity\User::class, inversedBy="partyOrganized")
     * 
     * @Groups("party:read")
     * 
     */
    private $organisateur;

    /**
     * @ORM\ManyToMany(targetEntity=user::class, inversedBy="parties")
     * 
     * @Groups("party:read")
     * 
     */
    private $participant;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(?int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    /**
     * Get the value of codePostal
     */ 
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set the value of codePostal
     *
     * @return  self
     */ 
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of rue
     */ 
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set the value of rue
     *
     * @return  self
     */ 
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get the value of numeroLieux
     */ 
    public function getNumeroLieux()
    {
        return $this->numeroLieux;
    }

    /**
     * Set the value of numeroLieux
     *
     * @return  self
     */ 
    public function setNumeroLieux($numeroLieux)
    {
        $this->numeroLieux = $numeroLieux;

        return $this;
    }

    public function getLongitude(): ?float 
    {
        return $this->longitude;
    }

    public function setLongitude(float  $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float 
    {
        return $this->latitude;
    }

    public function setLatitude(float  $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getIsMajeur(): ?bool
    {
        return $this->isMajeur;
    }

    public function setIsMajeur(bool $isMajeur): self
    {
        $this->isMajeur = $isMajeur;

        return $this;
    }

    public function getIsOutdoor(): ?bool
    {
        return $this->isOutdoor;
    }

    public function setIsOutdoor(bool $isOutdoor): self
    {
        $this->isOutdoor = $isOutdoor;

        return $this;
    }

    public function getIsReserved(): ?bool
    {
        return $this->isReserved;
    }

    public function setIsReserved(bool $isReserved): self
    {
        $this->isReserved = $isReserved;

        return $this;
    }

    public function getReservDesc(): ?string
    {
        return $this->reservDesc;
    }

    public function setReservDesc(?string $reservDesc): self
    {
        $this->reservDesc = $reservDesc;

        return $this;
    }

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participant->contains($participant)) {
            $this->participant[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participant->removeElement($participant);

        return $this;
    }

    
}
