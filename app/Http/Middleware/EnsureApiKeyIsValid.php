<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureApiKeyIsValid
{
    public function handle(Request $request, \Closure $next): Response
    {
        $configuredKey = config('wb.api_key');
        $providedKey = $request->query('key');

        if (!is_string($configuredKey) || $configuredKey === '') {
            return response()->json([
                'message' => 'API key is not configured.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if (!is_string($providedKey) || !hash_equals($configuredKey, $providedKey)) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
