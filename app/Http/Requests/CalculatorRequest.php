<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatorRequest extends FormRequest
{
    public function rules(): array
    {
        // @TODO define rules
        return [];
    }

    public function getA(): int
    {
        // @TODO return validated "a" param
        return 0;
    }

    public function getB(): int
    {
        // @TODO return validated "b" param
        return 0;
    }
}
