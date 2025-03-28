<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $createdAt = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    #[ORM\ManyToOne] // Предположим, что у вас есть связь ManyToOne с Users
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?Users $user_id = null;

    #[ORM\ManyToMany(targetEntity: Goods::class)]
    private Collection $goods;

    public function __construct()
    {
        $this->goods = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
        $this->createdAt = new DateTime(); // Инициализация поля createdAt текущей датой и временем
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function addOrdersItem(OrderItem $item): static
    {

        if (!$this->orderItems->contains($item)) {
            $this->orderItems->add($item);
            $item->setOrderId($this);
        }

        return $this;
    }

    public function removeOrdersItem(OrderItem $item): static
    {
        if ($this->orderItems->removeElement($item)) {

            if ($item->getOrderId() === $this) {
                $item->setOrderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }


}
