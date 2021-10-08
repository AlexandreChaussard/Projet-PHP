<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 * @Vich\Uploadable
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $superficy;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity=Region::class, inversedBy="rooms")
     */
    private $regions;

    /**
     * @ORM\OneToOne(targetEntity=UnavailablePeriod::class, mappedBy="Room", cascade={"persist", "remove"})
     */
    private $unavailablePeriod;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="Room", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @Vich\UploadableField(mapping="pastes", fileNameProperty="adImageName")
     * @var File
     */
    private $adImageFile;


    /**
     * @Vich\UploadableField(mapping="pastes", fileNameProperty="previewImageName")
     * @var File
     */
    private $previewImageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $previewImageName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $adImageName;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     *
     * @param File|null $imageFile
     */
    public function setAdImageFile(?File $imageFile = null): void
    {
        $this->adImageFile = $imageFile;
    }

    public function getAdImageFile(): ?File
    {
        return $this->adImageFile;
    }

    /**
     *
     * @param File|null $imageFile
     */
    public function setPreviewImageFile(?File $imageFile = null): void
    {
        $this->previewImageFile = $imageFile;
    }

    public function getPreviewImageFile(): ?File
    {
        return $this->previewImageFile;
    }

    public function setPreviewImageName(?string $imageName): void
    {
        $this->previewImageName = $imageName;
    }

    public function getPreviewImageName(): ?string
    {
        return $this->previewImageName;
    }

    public function setAdImageName(?string $imageName): void
    {
        $this->adImageName = $imageName;
    }

    public function getAdImageName(): ?string
    {
        return $this->adImageName;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSuperficy(): ?int
    {
        return $this->superficy;
    }

    public function setSuperficy(int $superficy): self
    {
        $this->superficy = $superficy;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function printRegions(): string
    {
        $str = "";
        foreach($this->getRegions() as $region)
        {
            $str = $str . "," . $region->getName();
        }

        return $str;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        $this->regions->removeElement($region);

        return $this;
    }

    public function getUnavailablePeriod(): ?UnavailablePeriod
    {
        return $this->unavailablePeriod;
    }

    public function setUnavailablePeriod(?UnavailablePeriod $unavailablePeriod): self
    {
        // unset the owning side of the relation if necessary
        if ($unavailablePeriod === null && $this->unavailablePeriod !== null) {
            $this->unavailablePeriod->setRoom(null);
        }

        // set the owning side of the relation if necessary
        if ($unavailablePeriod !== null && $unavailablePeriod->getRoom() !== $this) {
            $unavailablePeriod->setRoom($this);
        }

        $this->unavailablePeriod = $unavailablePeriod;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRoom($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoom() === $this) {
                $reservation->setRoom(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function regionsAsString(): ?string
    {
        $str = "";
        foreach($this->getRegions() as $region)
        {
            $str = $str . ", " . $region->getName();
        }
        return substr($str, 1);
    }
}
