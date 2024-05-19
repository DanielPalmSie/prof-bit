<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use App\Entity\Product;
use App\Enum\ProductCode;
use App\Enum\ProductType;
use Money\Money;
use Money\Currency;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class FillProductDataCommand extends Command
{
    protected static $defaultName = 'app:fill-product-data';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fill the product table with random data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $types = ProductType::cases();
        $codes = ProductCode::cases();

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setCode($codes[array_rand($codes)]);
            $product->setName('Product-' . bin2hex(random_bytes(5)));
            $product->setType($types[array_rand($types)]);

            $priceValue = rand(100, 1000) * 100;
            $price = new Money($priceValue, new Currency('USD'));
            $product->setPrice($price);

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $output->writeln('Filled product table with 100 random entries.');
        return Command::SUCCESS;
    }
}