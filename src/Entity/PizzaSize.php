<?php

namespace App\Entity;

use App\Repository\PizzaSizeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaSizeRepository::class)
 */
class PizzaSize
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $size;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_dollar;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_cent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPriceDollar(): ?int
    {
        return $this->price_dollar;
    }

    public function setPriceDollar(int $price_dollar): self
    {
        $this->price_dollar = $price_dollar;

        return $this;
    }

    public function getPriceCent(): ?int
    {
        return $this->price_cent;
    }

    public function setPriceCent(int $price_cent): self
    {
        $this->price_cent = $price_cent;

        return $this;
    }
}
