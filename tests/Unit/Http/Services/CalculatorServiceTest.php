<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Services;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Http\Services\CalculatorService;
use App\Http\Exceptions\DivisionByZeroException;

class CalculatorServiceTest extends TestCase
{
    private CalculatorService $calculatorService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculatorService = new CalculatorService();
    }

    #[Test]
    public function it_adds_two_numbers(): void
    {
        $result = $this->calculatorService->add(2, 3);
        $this->assertSame(5, $result);
    }

    #[Test]
    public function it_subtracts_two_numbers(): void
    {
        $result = $this->calculatorService->subtract(3, 2);
        $this->assertSame(1, $result);
    }

    #[Test]
    public function it_multiplies_two_numbers(): void
    {
        $result = $this->calculatorService->multiply(2, 3);
        $this->assertSame(6, $result);
    }

    #[Test]
    public function it_divides_two_numbers(): void
    {
        $result = $this->calculatorService->divide(10, 5);
        $this->assertSame(2.0, $result);
    }

    #[Test]
    public function it_calculates_modulo_of_two_numbers(): void
    {
        $result = $this->calculatorService->modulo(8, 7);
        $this->assertSame(1, $result);
    }

    #[Test]
    public function it_throws_division_by_zero_exception_when_dividing(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $this->calculatorService->divide(2, 0);
    }

    #[Test]
    public function it_throws_division_by_zero_exception_when_calculating_modulo(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $this->calculatorService->modulo(2, 0);
    }
}
