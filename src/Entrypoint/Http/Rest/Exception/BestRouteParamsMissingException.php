<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Exception;

use Exception;

class BestRouteParamsMissingException extends Exception
{
    protected $message = 'From and To route airport ID parameters are mandatory';
}