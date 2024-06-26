<?php

namespace Eckinox\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractAddress implements \Stringable
{
    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $address = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $suite = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $city = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $province = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $country = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $postalCode = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $phoneNumber = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $faxNumber = null;

    public function __toString(): string
    {
        return "{$this->name} ({$this->getFullAddress()})";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function setSuite(?string $suite): self
    {
        $this->suite = $suite;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getFaxNumber(): ?string
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(?string $faxNumber): self
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    public function getFullAddress(): string
    {
        return implode(', ', [
            $this->address,
            $this->city,
            $this->province,
            $this->country,
            $this->postalCode,
        ]);
    }
}
