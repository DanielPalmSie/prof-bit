<?php

namespace App\Services;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly PaginatorInterface $paginator
    ) {
    }

    public function getPaginatedProducts(array $queryParams): array
    {
        $sortField = $queryParams['sort'] ?? 'id';
        $sortDirection = $queryParams['direction'] ?? 'desc';
        $page = $queryParams['page'] ?? 1;

        if (!in_array($sortField, ['id', 'code', 'name', 'type', 'priceAmount', 'currency'])) {
            $sortField = 'id';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $queryBuilder = $this->em->getRepository(Product::class)->createQueryBuilder('p');
        $queryBuilder->orderBy('p.' . $sortField, $sortDirection);

        $query = $queryBuilder->getQuery();

        $pagination = $this->paginator->paginate(
            $query,
            (int) $page,
            20
        );

        return [
            'pagination' => $pagination,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ];
    }
}