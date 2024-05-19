<?php

namespace App\Controller;

use App\Services\ProductService;
use App\Services\ReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly ReportService $reportService
    ) {
    }

    #[Route('/products', name: 'product_list')]
    public function index(Request $request): Response
    {
        $sortField = [];

        /**
         *  Problem: Incorrect behavior of pagination library when sorting parameter is present.
         *  Solution: Retrieve and process the sorting parameter separately, then return the processed parameters.
         */
        $queryParams = $request->query->all();
        if (isset($queryParams['sort'])) {
            $sortField = $queryParams['sort'];
            unset($queryParams['sort']);
            $request->query->replace($queryParams);
        }

        $queryParams = array_merge(['sort' => $sortField],$queryParams);

        $data = $this->productService->getProducts($queryParams);

        return $this->render('product/index.html.twig', $data);
    }

    #[Route('/products/report', name: 'product_report')]
    public function report(): Response
    {
        $report = $this->reportService->generateProductReport();

        return $this->render('product/report.html.twig', [
            'report' => $report,
        ]);
    }
}