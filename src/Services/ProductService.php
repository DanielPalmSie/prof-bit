<?php

namespace App\Services;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class ProductService
{
    private const ITEMS_PER_PAGE = 20;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly PaginatorInterface $paginator
    ) {
    }

    public function getProducts(array $queryParams): array
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
            self::ITEMS_PER_PAGE
        );

        return [
            'pagination' => $pagination,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ];
    }
}