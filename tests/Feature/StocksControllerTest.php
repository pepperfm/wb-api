<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use App\Models\Stock;

use function Pest\Laravel\getJson;

beforeEach(function (): void {
    config(['wb.api_key' => 'secret-token']);
});

afterEach(function (): void {
    CarbonImmutable::setTestNow();
});

test('returns only current-day stock data', function (): void {
    CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-05-19 12:00:00'));

    $stock = Stock::factory()->create([
        'last_change_date' => '2026-05-19 09:00:00',
        'barcode' => 'stock-today',
        'quantity' => 5,
    ]);
    Stock::factory()->create([
        'last_change_date' => '2026-05-18 09:00:00',
        'barcode' => 'stock-yesterday',
        'quantity' => 7,
    ]);

    $response = getJson(route('api.stocks', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-19',
    ]));
    $response->assertOk();

    $invalidDateResponse = getJson(route('api.stocks', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-18',
    ]));
    $invalidDateResponse->assertUnprocessable();

    expect($response->json('meta.total'))->toBe(1)
        ->and($response->json('data.0.id'))->toBe($stock->id)
        ->and($response->json('data.0.type'))->toBe('stocks')
        ->and($response->json('data.0.attributes.barcode'))->toBe('stock-today');
});
