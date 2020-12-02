<?php


namespace App\Service\Api\Quote\Repository;


use App\Entity\Quote;

interface QuoteRepositoryInterface
{
    /**
     * @return Quote[]
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return Quote|null
     */
    public function getById(int $id): ?Quote;

    /**
     * @param Quote $quote
     * @return Quote
     */
    public function save(Quote $quote): Quote;

    public function remove(Quote $quote): void;
}