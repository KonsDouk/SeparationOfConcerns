<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculatorTest extends TestCase
{
    use RefreshDatabase;

    private const USER_BASIC   = User::USER_BASIC;
    private const USER_PREMIUM = User::USER_PREMIUM;

    #[Test]
    #[DataProvider('authenticationDataProvider')]
    public function it_accepts_authenticated_request(string $action, string $userType): void
    {
        $a = rand(1, 10);
        $b = rand(1, 10);

        $response = $this
            ->actingAs($this->createUserOfType($userType))
            ->getJson($this->buildUrl($action, $a, $b));

        $response->assertStatus(200);
    }

    #[Test]
    #[DataProvider('authenticationDataProvider')]
    public function it_doesnt_accept_unauthenticated_request(string $action): void
    {
        $a = rand(1, 10);
        $b = rand(1, 10);

        $response = $this->getJson($this->buildUrl($action, $a, $b));
        $response->assertStatus(401);
    }

    #[Test]
    public function it_requires_premium_account_for_calculate_modulo(): void
    {
        $a = rand(1, 10);
        $b = rand(1, 10);

        $response = $this
            ->actingAs($this->createUserOfType(self::USER_BASIC))
            ->getJson($this->buildUrl('modulo', $a, $b));

        $response->assertStatus(403);

        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl('modulo', $a, $b));

        $response->assertStatus(200);
    }

    #[Test]
    #[DataProvider('resultDataProvider')]
    public function it_returns_calculation_result(string $action, int $a, int $b, int|float $expectedResult): void
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl($action, $a, $b));

        $response->assertStatus(200);
        $response->assertJson(['result' => $expectedResult]);
    }

    #[Test]
    #[DataProvider('validationDataProvider')]
    public function it_validates_calculation_parameters(string $action, mixed $a, mixed $b, array $invalidParameters): void
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl($action, $a, $b));

        $response->assertJsonValidationErrors($invalidParameters);
        $response->assertStatus(422);
    }

    #[Test]
    public function it_limits_requests_rate(): void
    {
        $limit = 100;

        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl('add', 1, 1));

        $response->assertHeader('X-RateLimit-Limit', $limit);
    }

    private function buildUrl(string $action, mixed $a, mixed $b): string
    {
        return sprintf(
            '/api/calculator/%s?%s',
            $action,
            http_build_query(['a' => $a, 'b' => $b])
        );
    }

    public static function authenticationDataProvider(): array
    {
        return [
            ['add', self::USER_BASIC],
            ['subtract', self::USER_BASIC],
            ['divide', self::USER_BASIC],
            ['multiply', self::USER_BASIC],
            ['modulo', self::USER_PREMIUM],
        ];
    }

    public static function resultDataProvider(): array
    {
        return [
            ['add', 1, 4, 5],
            ['add', 0, 4, 4],
            ['subtract', 1, 4, -3],
            ['subtract', 10, 5, 5],
            ['divide', 1, 1, 1],
            ['divide', 10, 5, 2],
            ['divide', 10, 3, 10 / 3],
            ['multiply', 0, 1, 0],
            ['multiply', 10, 15, 150],
            ['modulo', 10, 5, 0],
            ['modulo', 10, 6, 4],
        ];
    }

    public static function validationDataProvider(): array
    {
        return [
            ['add', '', '', ['a', 'b']],
            ['add', '', 1, ['a']],
            ['add', 1, '', ['b']],
            ['add', '1.5', 'Abc', ['a', 'b']],
            ['add', '1a', 5, ['a']],
            ['add', 5, '0.0', ['b']],
            ['add', 5.5, 1.3, ['a', 'b']],
            ['add', 2.33, 4.13, ['a', 'b']],
            ['subtract', '', '', ['a', 'b']],
            ['subtract', '', 2, ['a']],
            ['subtract', 3, '', ['b']],
            ['subtract', '8!', 10, ['a']],
            ['subtract', 15, '33.33', ['b']],
            ['multiply', '', '', ['a', 'b']],
            ['multiply', '', 1, ['a']],
            ['multiply', 1, '', ['b']],
            ['multiply', '1a', 5, ['a']],
            ['multiply', 5, '0.0', ['b']],
            ['multiply', 56.11, 5.1, ['a', 'b']],
            ['divide', '', '', ['a', 'b']],
            ['divide', '', 8, ['a']],
            ['divide', 7, '', ['b']],
            ['divide', 'Aaaa', 54, ['a']],
            ['divide', 65, '0.0', ['b']],
            ['divide', 75, 0, ['b']],
            ['divide', 57.1, 4.6, ['a', 'b']],
            ['modulo', '', '', ['a', 'b']],
            ['modulo', '', 54, ['a']],
            ['modulo', 23, '', ['b']],
            ['modulo', 'zzz', 38, ['a']],
            ['modulo', 257, '0.5', ['b']],
            ['modulo', 156, 0, ['b']],
            ['modulo', 33.16, 14.3, ['a', 'b']],
        ];
    }
}
