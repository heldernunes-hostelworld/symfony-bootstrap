<?php declare(strict_types=1);

namespace App\Tests\Unit\Entrypoint\Http\Rest\Controller;

use App\Entrypoint\Http\Rest\Controller\AirportRouteController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AirportRouteControllerTest extends TestCase
{
    /** @var AirportRouteController */
    private $airportRouteController;

    protected function setUp(): void
    {
        $this->airportRouteController = new AirportRouteController();
    }

    /**
     * @param Request $request
     *
     * @dataProvider bestRouteActionWhenParametersAreMissingDataProvider
     */
    public function testBestRouteActionWhenParametersAreMissing(Request $request): void
    {
        $expectedResponse = new JsonResponse([
            'success' => false,
            'data' => null,
            'message' => 'From and To route airport ID parameters are mandatory'
        ]);

        $response = $this->airportRouteController->bestRouteAction($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function bestRouteActionWhenParametersAreMissingDataProvider(): array
    {
        return [
            'Missing both parameters' => [
                'request' => new Request()
            ],
            'Missing "from" parameter' => [
                'request' => new Request(['to' => 2])
            ],
            'Missing "to" parameter' => [
                'request' => new Request(['from' => 1])
            ],
        ];
    }

    /**
     * @param Request $request
     *
     * @dataProvider bestRouteActionWhenParametersHaveInvalidValuesDataProvider
     */
    public function testBestRouteActionWhenParametersHaveInvalidValues(Request $request): void
    {
        $expectedResponse = new JsonResponse([
            'success' => false,
            'data' => null,
            'message' => 'Invalid parameter type. From and To parameters need to have a valid airport ID'
        ]);

        $response = $this->airportRouteController->bestRouteAction($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function bestRouteActionWhenParametersHaveInvalidValuesDataProvider(): array
    {
        return [
            'Both parameters have invalid values' => [
                'request' => new Request(['from' => 'aaa', 'to' => 'bbb'])
            ],
            '"from" parameter has invalid value' => [
                'request' => new Request(['from' => 'aaa', 'to' => 2])
            ],
            '"to" parameter has invalid value' => [
                'request' => new Request(['from' => 1, 'to' => 'bbb'])
            ],
        ];
    }

    /**
     * @dataProvider bestRouteActionWhenParametersHaveInvalidValuesDataProvider
     */
    public function testBestRouteActionWhenParametersAreValid(): void
    {
        $request = new Request(['from' => 1, 'to' => 2]);

        $expectedResponse = new JsonResponse([
            'success' => true,
            'data' => 'Best route endpoint still in development',
            'from' => 1,
            'to' => 2
        ]);

        $response = $this->airportRouteController->bestRouteAction($request);

        $this->assertEquals($expectedResponse, $response);
    }
}