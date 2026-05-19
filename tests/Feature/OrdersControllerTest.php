<?php

declare(strict_types=1);

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\getJson;

beforeEach(function (): void {
    config(['wb.api_key' => 'secret-token']);
});

test('rejects requests without a valid key', function (): void {
    $missingKeyResponse = getJson(route('api.orders', [
        'dateFrom' => '2026-05-01',
        'dateTo' => '2026-05-02',
    ]));
    $wrongKeyResponse = getJson(route('api.orders', [
        'key' => 'wrong',
        'dateFrom' => '2026-05-01',
        'dateTo' => '2026-05-02',
    ]));

    $missingKeyResponse->assertUnauthorized();
    $wrongKeyResponse->assertUnauthorized();

    expect($missingKeyResponse->json('message'))->toBe('Unauthenticated.');
});

test('returns paginated orders filtered by date range and limited by query parameter', function (): void {
    Order::factory()->create([
        'date' => '2026-05-01 10:00:00',
        'barcode' => '100',
        'total_price' => 1000,
        'g_number' => 'before',
    ]);
    $inside = Order::factory()->create([
        'date' => '2026-05-03 12:00:00',
        'barcode' => '200',
        'total_price' => 1500,
        'g_number' => 'inside',
    ]);
    Order::factory()->create([
        'date' => '2026-05-07 12:00:00',
        'barcode' => '300',
        'total_price' => 2000,
        'g_number' => 'after',
    ]);

    $response = getJson(route('api.orders', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-02',
        'dateTo' => '2026-05-04',
        'limit' => 1,
    ]));
    $response->assertOk();

    expect($response->headers->get('content-type'))->toBe('application/vnd.api+json')
        ->and($response->json('meta.current_page'))->toBe(1)
        ->and($response->json('meta.per_page'))->toBe(1)
        ->and($response->json('meta.total'))->toBe(1)
        ->and($response->json('data.0.id'))->toBe($inside->id)
        ->and($response->json('data.0.type'))->toBe('orders')
        ->and($response->json('data.0.attributes.g_number'))->toBe('inside')
        ->and($response->json('data.0.attributes'))->not->toHaveKey('created_at')
        ->and($response->json('data.0.attributes'))->not->toHaveKey('updated_at');
});

test('uses a default limit of 500 records', function (): void {
    Order::factory(501)
        ->sequence(fn(Sequence $sequence): array => [
            'barcode' => (string) ($sequence->index + 1),
            'g_number' => 'order-'.($sequence->index + 1),
        ])
        ->create([
            'date' => '2026-05-03 12:00:00',
            'total_price' => 1000,
        ]);

    $response = getJson(route('api.orders', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-03',
        'dateTo' => '2026-05-03',
    ]));
    $response->assertOk();

    expect($response->json('meta.per_page'))->toBe(500)
        ->and($response->json('meta.total'))->toBe(501)
        ->and($response->json('data'))->toHaveCount(500);
});

test('uses the page query parameter to traverse paginated data and preserves query parameters in links', function (): void {
    Order::factory()->create([
        'date' => '2026-05-02 12:00:00',
        'barcode' => 'first',
        'total_price' => 1000,
        'g_number' => 'first-page',
    ]);
    $second = Order::factory()->create([
        'date' => '2026-05-03 12:00:00',
        'barcode' => 'second',
        'total_price' => 1000,
        'g_number' => 'second-page',
    ]);

    $response = getJson(route('api.orders', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-02',
        'dateTo' => '2026-05-03',
        'limit' => 1,
        'page' => 2,
    ]));
    $response->assertOk();

    expect($response->json('meta.current_page'))->toBe(2)
        ->and($response->json('meta.per_page'))->toBe(1)
        ->and($response->json('data.0.id'))->toBe($second->id)
        ->and($response->json('data.0.attributes.g_number'))->toBe('second-page')
        ->and($response->json('links.first'))
        ->toContain('key=secret-token')
        ->toContain('dateFrom=2026-05-02')
        ->toContain('dateTo=2026-05-03')
        ->toContain('limit=1');
});

test('serializes order datetime fields using the format from the specification', function (): void {
    $order = Order::factory()->create([
        'date' => '2026-05-03 12:34:56',
        'last_change_date' => '2026-05-03 13:14:15',
        'cancel_date' => '2026-05-03 14:15:16',
        'barcode' => 'datetime-order',
        'total_price' => 1000,
    ]);

    $response = getJson(route('api.orders', [
        'key' => 'secret-token',
        'dateFrom' => '2026-05-03',
        'dateTo' => '2026-05-03',
    ]));
    $response->assertOk();

    expect($response->json('data.0.id'))->toBe($order->id)
        ->and($response->json('data.0.attributes.date'))->toBe('2026-05-03 12:34:56')
        ->and($response->json('data.0.attributes.last_change_date'))->toBe('2026-05-03 13:14:15')
        ->and($response->json('data.0.attributes.cancel_date'))->toBe('2026-05-03 14:15:16');
});
