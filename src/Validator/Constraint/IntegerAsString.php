<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class IntegerAsString extends Constraint
{
    public $message;

    public function __construct(string $message)
    {
        parent::__construct();
        $this->message = $message;
    }
}
