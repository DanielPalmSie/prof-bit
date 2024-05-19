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

    #[ORM\Column(type: 'integer')]
    private $code;

    #[ORM\Column(type: 'string')]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

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
        // Предполагаем, что код в базе данных хранится как int
        return ProductCode::from($this->code);
    }

    public function setCode(ProductCode $code): self
    {
        $this->code = $code->value; // Преобразуем объект ProductCode в его значение (int)
        return $this;
    }

    public function getType(): ProductType
    {
        // Предполагаем, что тип в базе данных хранится как строка
        return ProductType::from($this->type);
    }

    public function setType(ProductType $type): self
    {
        $this->type = $type->value; // Преобразуем объект ProductType в его значение (string)
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
