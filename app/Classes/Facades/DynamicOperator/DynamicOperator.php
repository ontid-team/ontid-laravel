<?php

namespace App\Classes\Facades\DynamicOperator;

class DynamicOperator
{
    private $operatorToMethodTranslation = [
        '==' => 'equal',
        '===' => 'totallyEqual',
        '!=' => 'notEqual',
        '>' => 'greaterThan',
        '<' => 'lessThan',
        '>=' => 'greaterThanOrEqual',
        '<=' => 'lessThanOrEqual',
    ];

    public function is($value_a, $operation, $value_b)
    {
        if ($method = $this->operatorToMethodTranslation[$operation]) {
            return $this->$method($value_a, $value_b);
        }
        throw new \Exception('Unknown Dynamic Operator.');
    }

    private function equal($value_a, $value_b)
    {
        return $value_a == $value_b;
    }

    private function totallyEqual($value_a, $value_b)
    {
        return $value_a === $value_b;
    }

    private function notEqual($value_a, $value_b)
    {
        return $value_a != $value_b;
    }

    private function greaterThan($value_a, $value_b)
    {
        return $value_a > $value_b;
    }

    private function lessThan($value_a, $value_b)
    {
        return $value_a < $value_b;
    }

    private function greaterThanOrEqual($value_a, $value_b)
    {
        return $value_a >= $value_b;
    }

    private function lessThanOrEqual($value_a, $value_b)
    {
        return $value_a <= $value_b;
    }

}
