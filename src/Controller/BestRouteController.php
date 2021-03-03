<?php

namespace App\Controller;

use App\Exception\RuntimeException;
use App\Serializer\FlatteningObjectNormalizer;
use App\Service\BestRouteFinder;
use App\Validator\Constraint\IntegerAsString;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BestRouteController extends AbstractController
{
    private const PARAM_FROM = 'from';
    private const PARAM_TO = 'to';

    /**
     * @Route("/best-route", name="best_route")
     */
    public function index(Request $request, ValidatorInterface $validator, BestRouteFinder $bestRouteFinder): Response
    {
        $queryParams = $request->query->all();
        $constraint = new Constraints\Collection([
            self::PARAM_FROM => new IntegerAsString('Invalid parameter From ID'),
            self::PARAM_TO => new IntegerAsString('Invalid parameter To ID'),
        ]);
        $constraint->missingFieldsMessage = 'Required parameter {{ field }} is missing';
        $violations = $validator->validate($queryParams, $constraint);
        if ($violations->count()) {
            throw new BadRequestHttpException($violations[0]->getMessage());
        }

        $bestRoute = $bestRouteFinder->find($queryParams[self::PARAM_FROM], $queryParams[self::PARAM_TO]);

        return $this->json(
            ['success' => true, 'data' => $bestRoute],
            Response::HTTP_OK,
            [],
            [FlatteningObjectNormalizer::FLAT_PROPERTIES => true, 'groups' => ['bestRoute']]
        );
    }
}
