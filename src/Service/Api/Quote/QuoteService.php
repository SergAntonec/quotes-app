<?php


namespace App\Service\Api\Quote;


use App\Entity\Quote;
use App\Service\Api\Quote\QuoteParameters\QuoteParametersInterface;
use App\Service\Api\Quote\Repository\QuoteRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

class QuoteService
{
    /**
     * @var QuoteRepositoryInterface
     */
    private $quoteRepository;
    /**
     * @var QuoteConverter
     */
    private $quoteConverter;

    public function __construct(QuoteRepositoryInterface $quoteRepository, QuoteConverter $quoteConverter)
    {
        $this->quoteRepository = $quoteRepository;
        $this->quoteConverter = $quoteConverter;
    }

    /**
     * @return Quote[]
     */
    public function getAll(): array
    {
        return $this->quoteRepository->getAll();
    }

    /**
     * @param int $id
     * @return Quote
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Quote
    {
        $quote = $this->quoteRepository->getById($id);
        if ($quote === null) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Quote::class, [$id]);
        }

        return $quote;
    }

    /**
     * @param QuoteParametersInterface $quoteParameters
     * @return Quote
     */
    public function create(QuoteParametersInterface $quoteParameters): Quote
    {
        $quote = $this->quoteConverter->createQuote($quoteParameters);
        $quote = $this->quoteRepository->save($quote);

        return $quote;
    }

    /**
     * @param int $id
     * @param QuoteParametersInterface $quoteParameters
     * @return Quote
     * @throws EntityNotFoundException
     */
    public function update(int $id, QuoteParametersInterface $quoteParameters): Quote
    {
        $quote = $this->quoteRepository->getById($id);
        if ($quote === null) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Quote::class, [$id]);
        }
        $quote = $this->quoteConverter->updateQuote($quote, $quoteParameters);
        $quote = $this->quoteRepository->save($quote);

        return $quote;
    }

    /**
     * @param int $id
     * @throws EntityNotFoundException
     */
    public function delete(int $id): void
    {
        $quote = $this->quoteRepository->getById($id);
        if ($quote === null) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Quote::class, [$id]);
        }
        $this->quoteRepository->remove($quote);
    }

}