<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StockStatisticsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->query('page', 1),
            'limit' => $this->query('limit', 500),
        ]);
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $today = CarbonImmutable::now(config('app.timezone'))->format('Y-m-d');

        return [
            'dateFrom' => ['required', 'date_format:Y-m-d', Rule::in([$today])],
            'page' => ['integer', 'min:1'],
            'limit' => ['integer', 'min:1', 'max:500'],
        ];
    }

    public function limit(): int
    {
        return $this->integer('limit', 500);
    }
}
