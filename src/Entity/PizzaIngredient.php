<?php

namespace App\Entity;

use App\Repository\PizzaIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaIngredientRepository::class)
 */
class PizzaIngredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ingredient_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $ingredient_type_id;

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

    public function getIngredientName(): ?string
    {
        return $this->ingredient_name;
    }

    public function setIngredientName(string $ingredient_name): self
    {
        $this->ingredient_name = $ingredient_name;

        return $this;
    }

    public function getIngredientTypeId(): ?int
    {
        return $this->ingredient_type_id;
    }

    public function setIngredientTypeId(int $ingredient_type_id): self
    {
        $this->ingredient_type_id = $ingredient_type_id;

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
