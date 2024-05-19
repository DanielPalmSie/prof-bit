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

        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'desc');

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
}