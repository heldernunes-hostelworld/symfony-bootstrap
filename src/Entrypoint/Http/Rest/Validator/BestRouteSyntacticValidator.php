<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Validator;

use App\Entrypoint\Http\Rest\Exception\BestRouteParamsMissingException;
use App\Entrypoint\Http\Rest\Exception\BestRouteParamsWrongTypeException;
use Symfony\Component\HttpFoundation\Request;

class BestRouteSyntacticValidator
{
    /**
     * @param Request $request
     *
     * @throws BestRouteParamsMissingException
     * @throws BestRouteParamsWrongTypeException
     *
     * @return bool
     */
    public static function validate(Request $request): bool
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        if (is_null($from) || is_null($to)) {
            throw new BestRouteParamsMissingException();
        }

        if (!is_numeric($from) || !is_numeric($to)) {
            throw new BestRouteParamsWrongTypeException();
        }

        return true;
    }
}