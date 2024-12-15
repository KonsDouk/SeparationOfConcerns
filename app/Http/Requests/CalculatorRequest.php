<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatorRequest extends FormRequest
{
    public function rules(): array
    {
        // @TODO define rules
        return [
            'a'=>'required|integer',
            'b'=>'required|integer',
        ];
    }

    public function getA(): int
    {
        // @TODO return validated "a" param
        return intval($this->validated('a')); //validated() apo FormRequest (Illuminate\Foundation\Http)
        return 0;
    }

    public function getB(): int
    {
        // @TODO return validated "b" param
        return intval($this->validated('b'));
        return 0;
    }
}
