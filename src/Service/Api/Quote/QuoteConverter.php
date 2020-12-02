<?php


namespace App\Service\Api\Quote;


use App\Entity\Quote;
use App\Service\Api\Quote\QuoteParameters\QuoteParametersInterface;

class QuoteConverter
{
    /**
     * @param Quote $quote
     * @param QuoteParametersInterface $quoteParameters
     * @return Quote
     */
    public function updateQuote(Quote $quote, QuoteParametersInterface $quoteParameters): Quote
    {
        return $quote
            ->setQuote($quoteParameters->getQuote())
            ->setAuthorName($quoteParameters->getAuthorName());
    }

    /**
     * @param QuoteParametersInterface $quoteParameters
     * @return Quote
     */
    public function createQuote(QuoteParametersInterface $quoteParameters): Quote
    {
        return (new Quote())
            ->setQuote($quoteParameters->getQuote())
            ->setAuthorName($quoteParameters->getAuthorName());
    }
}