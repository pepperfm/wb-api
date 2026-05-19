<?php

declare(strict_types=1);

use App\Models\Income;

use function Pest\Laravel\getJson;

beforeEach(function (): void {
    config(['wb.api_key' => 'secret-token']);
});

test('returns incomes filtered by date range as json api resources', function (): void {
    $income = Income::factory()->create([
        'income_id' => 123,
        'date' => '2026-05-03',
        'quantity' => 10,
    ]);

    $response = getJson(route('api.incomes', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-03',
        'dateTo' => '2026-05-03',
    ]));
    $response->assertOk();

    expect(str($income->id)->isUuid())->toBeTrue()
        ->and($response->json('data.0.id'))->toBe($income->id)
        ->and($response->json('data.0.type'))->toBe('incomes')
        ->and($response->json('data.0.attributes.income_id'))->toBe(123);
});

test('serializes income date and datetime fields using the formats from the specification', function (): void {
    $income = Income::factory()->create([
        'income_id' => 456,
        'date' => '2026-05-03',
        'last_change_date' => '2026-05-03 11:22:33',
        'quantity' => 10,
    ]);

    $response = getJson(route('api.incomes', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-03',
        'dateTo' => '2026-05-03',
    ]));
    $response->assertOk();

    expect($response->json('data.0.id'))->toBe($income->id)
        ->and($response->json('data.0.attributes.date'))->toBe('2026-05-03')
        ->and($response->json('data.0.attributes.last_change_date'))->toBe('2026-05-03 11:22:33');
});
