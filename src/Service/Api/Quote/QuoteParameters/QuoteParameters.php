<?php


namespace App\Service\Api\Quote\QuoteParameters;

use Symfony\Component\Validator\Constraints as Assert;

class QuoteParameters implements QuoteParametersInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=512)
     * @var string
     */
    private $quote;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=20)
     * @var string
     */
    private $authorName;

    public function __construct(string $quote, string $authorName)
    {
        $this->quote = $quote;
        $this->authorName = $authorName;
    }

    public function getQuote(): string
    {
        return $this->quote;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }


}