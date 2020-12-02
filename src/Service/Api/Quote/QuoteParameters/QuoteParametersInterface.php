<?php


namespace App\Service\Api\Quote\QuoteParameters;


use App\Service\Api\ParameterInterface;

interface QuoteParametersInterface extends ParameterInterface
{
    /**
     * @return string
     */
    public function getQuote(): string;

    /**
     * @return string
     */
    public function getAuthorName(): string;
}