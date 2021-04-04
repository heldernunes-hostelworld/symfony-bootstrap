<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Controller;

use App\Domain\Context\AirportRoute\FindBestPath\Handler as FindBestPathHandler;
use App\Entrypoint\Http\Rest\Builder\AirportCollectionArray as AirportCollectionArrayBuilder;
use App\Entrypoint\Http\Rest\Factory\BestRouteRequestModelFactory;
use App\Entrypoint\Http\Rest\Validator\BestRouteSyntacticValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class AirportRouteController
{
    private FindBestPathHandler $findBestPathHandler;

    public function __construct(FindBestPathHandler $findBestPathHandler)
    {
        $this->findBestPathHandler = $findBestPathHandler;
    }

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

            $result = $this->findBestPathHandler->findBestRoute(
                BestRouteRequestModelFactory::create((int) $from, (int) $to)
            );

            return new JsonResponse([
                'success' => true,
                'data' => AirportCollectionArrayBuilder::build($result->getAirportCollection()),
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