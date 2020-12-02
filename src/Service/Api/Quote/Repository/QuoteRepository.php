<?php


namespace App\Service\Api\Quote\Repository;


use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class QuoteRepository implements QuoteRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Quote::class);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Quote
    {
        return $this->objectRepository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function save(Quote $quote): Quote
    {
        $this->entityManager->persist($quote);
        $this->entityManager->flush();

        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function remove(Quote $quote): void
    {
        $this->entityManager->remove($quote);
        $this->entityManager->flush();
    }

}