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
    private $id;

    #[ORM\Column(type: 'string', enumType: ProductCode::class)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', enumType: ProductType::class)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $priceAmount;

    #[ORM\Column(type: 'string', length: 3)]
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ProductCode
    {
        return $this->code;
    }

    public function setCode(ProductCode $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ProductType
    {
        return $this->type;
    }

    public function setType(ProductType $type): self
    {
        $this->type = $type;

        return $this;
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
