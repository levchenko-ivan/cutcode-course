<?php

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
