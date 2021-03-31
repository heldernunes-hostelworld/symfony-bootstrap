<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Controller;

use App\Entrypoint\Http\Rest\Validator\BestRouteSyntacticValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class AirportRouteController
{
    /**
     * @Route("/", name="helloWorld", methods="GET")
     */
    public function helloWorldAction(): JsonResponse
    {
        return new JsonResponse(['success' => true, 'data' => 'Hello World']);
    }

    /**
     * @Route("/best-route", name="bestRoute", methods="GET")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function bestRouteAction(Request $request): JsonResponse
    {
        try {
            $from = $request->query->get('from');
            $to = $request->query->get('to');

            BestRouteSyntacticValidator::validate($request);

            return new JsonResponse([
                'success' => true,
                'data' => 'Best route endpoint still in development',
                'from' => $from,
                'to' => $to
            ]);
        } catch (Throwable $throwable) {
            return new JsonResponse([
                'success' => false,
                'data' => null,
                'message' => $throwable->getMessage()
            ]);
        }
    }
}