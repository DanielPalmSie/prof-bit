<?php

namespace App\Services;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ReportService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function generateProductReport(): array
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        $report = [];
        foreach ($products as $product) {
            $code = $product->getCode()->value;
            $type = $product->getType()->value;
            $price = $product->getPrice()->getAmount() / 100;

            if (!isset($report[$code])) {
                $report[$code] = [
                    'total_count' => 0,
                    'total_price' => 0,
                    'type_1_count' => 0,
                    'type_1_price' => 0,
                    'type_2_count' => 0,
                    'type_2_price' => 0,
                    'type_3_count' => 0,
                    'type_3_price' => 0,
                ];
            }

            $report[$code]['total_count']++;
            $report[$code]['total_price'] += $price;

            if ($type === 'type-1') {
                $report[$code]['type_1_count']++;
                $report[$code]['type_1_price'] += $price;
            } elseif ($type === 'type-2') {
                $report[$code]['type_2_count']++;
                $report[$code]['type_2_price'] += $price;
            } elseif ($type === 'type-3') {
                $report[$code]['type_3_count']++;
                $report[$code]['type_3_price'] += $price;
            }
        }

        return $report;
    }
}