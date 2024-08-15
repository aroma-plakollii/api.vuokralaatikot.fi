<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/get-package-price',
        '/api/mb-prices-continue',
        '/api/get-day-price',
        '/api/mb-bookings-create'
    ];
}
