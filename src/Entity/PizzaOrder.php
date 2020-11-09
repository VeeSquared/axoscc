<?php

namespace App\Entity;

use App\Repository\PizzaOrderRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PizzaOrderRepository::class)
 */
class PizzaOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $order_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_status_id;

  
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_price_dollar;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_price_cent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->order_date;
    }

    public function setOrderDate(\DateTimeInterface $order_date): self
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getOrderStatusId(): ?int
    {
        return $this->order_status_id;
    }

    public function setOrderStatusId(int $order_status_id): self
    {
        $this->order_status_id = $order_status_id;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->price;
    }

    private function setTotalPrice(): self
    {
        $this->price = strval($this->total_price_dollar) + "." + strval($this->total_price_cent);

        return $this;
    }
    
    public function getTotalPriceDollar(): ?int
    {
        return $this->total_price_dollar;
    }

    public function setTotalPriceDollar(int $total_price_dollar): self
    {
        $this->total_price_dollar = $total_price_dollar;
        $this->setTotalPrice();

        return $this;
    }

    public function getTotalPriceCent(): ?int
    {
        return $this->total_price_cent;
    }

    public function setTotalPriceCent(int $total_price_cent): self
    {
        $this->total_price_cent = $total_price_cent;
        $this->setTotalPrice();

        return $this;
    }
}
