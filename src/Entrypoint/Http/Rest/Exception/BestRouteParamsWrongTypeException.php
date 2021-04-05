<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Exception;

use Exception;

class BestRouteParamsWrongTypeException extends Exception
{
    protected $message = 'Invalid parameter type. From and To parameters need to have a valid airport ID';
}