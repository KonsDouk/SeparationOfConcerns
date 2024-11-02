<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Services\CalculatorService;
use App\Http\Requests\CalculatorRequest as Request;

class CalculatorController extends Controller
{
    public function __construct(private readonly CalculatorService $calculatorService)
    {
    }

    public function add(Request $request): JsonResponse
    {
        // @TODO implement
    }

    public function subtract(Request $request): JsonResponse
    {
        // @TODO implement
    }

    public function multiply(Request $request): JsonResponse
    {
        // @TODO implement
    }

    public function divide(Request $request): JsonResponse
    {
        // @TODO implement
    }

    public function modulo(Request $request): JsonResponse
    {
        // @TODO implement
    }
}
