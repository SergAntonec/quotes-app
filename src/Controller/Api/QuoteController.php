<?php


namespace App\Controller\Api;


use App\Service\Api\ParameterInterface;
use App\Service\Api\Quote\QuoteParameters\QuoteParameters;
use App\Service\Api\Quote\QuoteService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuoteController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var QuoteService
     */
    private $quoteService;

    public function __construct(ValidatorInterface $validator, QuoteService $quoteService)
    {
        $this->validator = $validator;
        $this->quoteService = $quoteService;
    }

    /**
     * @Route("/api/quotes", methods={Request::METHOD_GET})
     * @return JsonResponse
     */
    public function getQuotes(): JsonResponse
    {
        return $this->json($this->quoteService->getAll());
    }

    /**
     * @Route("/api/quote/{id}", requirements={"id"="\d+"}, methods={Request::METHOD_GET})
     * @param int $id
     * @return JsonResponse
     */
    public function getQuote(int $id): JsonResponse
    {
        try {
            $quote = $this->quoteService->getById($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->json($quote);
    }

    /**
     * @Route("/api/quote", methods={Request::METHOD_POST})
     * @param Request $request
     * @return JsonResponse
     */
    public function createQuote(Request $request): JsonResponse
    {
        $quoteParameters = new QuoteParameters(
            $request->get('quote', ''),
            $request->get('authorName', '')
        );
        $this->validateParameters($quoteParameters);

        return $this->json($this->quoteService->create($quoteParameters));
    }

    /**
     * @Route("/api/quote/{id}", requirements={"id"="\d+"}, methods={Request::METHOD_PATCH})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateQuote(int $id, Request $request): JsonResponse
    {
        $quoteParameters = new QuoteParameters(
            $request->get('quote', ''),
            $request->get('authorName', '')
        );
        $this->validateParameters($quoteParameters);

        try {
            $quote = $this->quoteService->update($id, $quoteParameters);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->json($quote);
    }

    /**
     * @Route("/api/quote/{id}", requirements={"id"="\d+"}, methods={Request::METHOD_DELETE})
     * @param int $id
     * @return JsonResponse
     */
    public function deleteQuote(int $id): JsonResponse
    {
        try {
            $this->quoteService->delete($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->json([]);
    }

    private function validateParameters(ParameterInterface $parameters): void
    {
        $errors = $this->validator->validate($parameters);
        if (\count($errors) > 0) {
            throw new UnprocessableEntityHttpException('Validation error');
        }
    }
}