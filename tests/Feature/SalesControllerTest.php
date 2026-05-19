<?php

declare(strict_types=1);

use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['wb.api_key' => 'secret-token']);
});

test('returns sales filtered by date range as json api resources', function (): void {
    $sale = Sale::factory()->create([
        'date' => '2026-05-03 10:00:00',
        'sale_id' => 'S123',
        'total_price' => 1200,
    ]);

    $response = getJson(route('api.sales', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-03',
        'dateTo' => '2026-05-03',
    ]));
    $response->assertOk();

    expect(str($sale->id)->isUuid())->toBeTrue()
        ->and($response->json('data.0.id'))->toBe($sale->id)
        ->and($response->json('data.0.type'))->toBe('sales')
        ->and($response->json('data.0.attributes.sale_id'))->toBe('S123');
});

test('validates sales date format and maximum limit', function (): void {
    $invalidDateResponse = getJson(route('api.sales', [
        'key' => 'secret-token',
        'dateFrom' => '2026/05/01',
        'dateTo' => '2026-05-02',
    ]));
    $invalidLimitResponse = getJson(route('api.sales', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-01',
        'dateTo' => '2026-05-02',
        'limit' => 501,
    ]));

    $invalidDateResponse->assertUnprocessable();
    $invalidLimitResponse->assertUnprocessable();

    expect($invalidDateResponse->json('errors.dateFrom'))->not->toBeNull()
        ->and($invalidLimitResponse->json('errors.limit'))->not->toBeNull();
});

test('returns json error responses for api exceptions even without an accept json header', function (): void {
    $validationResponse = get(route('api.sales', [
        'key' => 'secret-token',
        'dateFrom' => '2026/05/01',
        'dateTo' => '2026-05-02',
    ]));
    $notFoundResponse = get('/api/missing-route?key=secret-token');

    $validationResponse->assertUnprocessable();
    $notFoundResponse->assertNotFound();

    expect($validationResponse->headers->get('content-type'))->toBe('application/json')
        ->and($validationResponse->json('errors.dateFrom'))->not->toBeNull()
        ->and($notFoundResponse->headers->get('content-type'))->toBe('application/json')
        ->and($notFoundResponse->json('message'))->toBe('The route api/missing-route could not be found.');
});
