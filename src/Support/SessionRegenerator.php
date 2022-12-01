<?php

namespace Support;

use App\Events\AfterSessionRegenerated;

class SessionRegenerator
{
    public static function run(\Closure $callback = null)
    {
        $old = request()->session()->getId();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        if(!is_null($callback)) {
            $callback();
        }

        event(new AfterSessionRegenerated($old, request()->session()->getId()));
    }
}
