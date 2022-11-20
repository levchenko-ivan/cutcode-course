<?php

use Domain\Catalog\Filters\FilterManager;
use Support\Flash\Flash;

if(!function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}

if(!function_exists('userIdIp')) {
    function userIdIp(): string
    {
        try {
            return request()->user()?->id ?? request()->ip();
        } catch (Throwable $e) {
            return  '';
        }
    }
}

if(!function_exists('filters')) {
    /**
     * @return array<\Domain\Catalog\Filters\AbstractFilter>
     */
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}
