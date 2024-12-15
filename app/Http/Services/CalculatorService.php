<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Exceptions\DivisionByZeroException;

class CalculatorService
{
    public function add(int $a, int $b): int
    {
        // @TODO implement
        return $a + $b;
        return 0;
    }

    public function subtract(int $a, int $b): int
    {
        // @TODO implement
        return $a - $b;
        return 0;
    }

    public function multiply(int $a, int $b): int
    {
        // @TODO implement
        return 0;
    }

    public function divide(int $a, int $b): float
    {
        // @TODO implement
        if ($b === 0) throw new DivisionByZeroException('Cannot divide with zero');
        return $a/$b;
    }

    public function modulo(int $a, int $b): int
    {
        // @TODO implement
        if ($b === 0) throw new DivisionByZeroException('Cannot divide with zero');
        return $a % $b;
        return 0;
    }
}
