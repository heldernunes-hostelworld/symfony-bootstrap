<?php declare(strict_types=1);
namespace App\Tests\Unit\Entrypoint\Http\Rest\Validator;

use App\Entrypoint\Http\Rest\Exception\BestRouteParamsMissingException;
use App\Entrypoint\Http\Rest\Exception\BestRouteParamsWrongTypeException;
use App\Entrypoint\Http\Rest\Validator\BestRouteSyntacticValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class BestRouteSyntacticValidatorTest extends TestCase
{
    /**
     * @param Request $request
     *
     * @throws BestRouteParamsMissingException
     * @throws BestRouteParamsWrongTypeException
     *
     * @dataProvider validateWhenParametersAreMissingDataProvider
     */
    public function testValidateWhenParametersAreMissing(Request $request): void
    {
        $expectedException = new BestRouteParamsMissingException();

        $this->expectException(BestRouteParamsMissingException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        BestRouteSyntacticValidator::validate($request);
    }

    public function validateWhenParametersAreMissingDataProvider(): array
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
     * @throws BestRouteParamsWrongTypeException
     * @throws BestRouteParamsMissingException
     *
     * @dataProvider validateWhenParametersHaveInvalidValuesDataProvider
     */
    public function testValidateWhenParametersHaveInvalidValues(Request $request): void
    {
        $expectedException = new BestRouteParamsWrongTypeException();

        $this->expectException(BestRouteParamsWrongTypeException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        BestRouteSyntacticValidator::validate($request);
    }

    public function validateWhenParametersHaveInvalidValuesDataProvider(): array
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
     * @throws BestRouteParamsWrongTypeException
     * @throws BestRouteParamsMissingException
     */
    public function testValidateWhenAllIsValid(): void
    {
        $request = new Request(['from' => 1, 'to' => 2]);

        $result = BestRouteSyntacticValidator::validate($request);

        $this->assertEquals(true, $result);
    }
}