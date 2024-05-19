<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $queryBuilder = $em->getRepository(Product::class)->createQueryBuilder('p');

        // Получение параметров для сортировки
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'asc');

        if (!in_array($sortField, ['id', 'code', 'name', 'type', 'priceAmount', 'currency'])) {
            $sortField = 'id';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $queryBuilder->orderBy('p.' . $sortField, $sortDirection);

        $query = $queryBuilder->getQuery();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('product/index.html.twig', [
            'pagination' => $pagination,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    #[Route('/products/report', name: 'product_report')]
    public function report(EntityManagerInterface $em): Response
    {
        $products = $em->getRepository(Product::class)->findAll();

        $report = [];
        foreach ($products as $product) {
            $code = $product->getCode()->value;
            $type = $product->getType()->value;
            $price = $product->getPrice()->getAmount() / 100; // Переводим из центов в доллары

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

        return $this->render('product/report.html.twig', [
            'report' => $report,
        ]);
    }
}