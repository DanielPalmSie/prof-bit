<?php

namespace App\Entity;

use App\Enum\ProductCode;
use App\Enum\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $code;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $priceAmount;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ProductCode
    {
        return ProductCode::from($this->code);
    }

    public function setCode(ProductCode $code): self
    {
        $this->code = $code->value;
        return $this;
    }

    public function getType(): ProductType
    {
        return ProductType::from($this->type);
    }

    public function setType(ProductType $type): self
    {
        $this->type = $type->value;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): Money
    {
        return new Money($this->priceAmount, new Currency($this->currency));
    }

    public function setPrice(Money $price): self
    {
        $this->priceAmount = $price->getAmount();
        $this->currency = $price->getCurrency()->getCode();
        return $this;
    }
}
