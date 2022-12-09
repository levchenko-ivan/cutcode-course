<?php

namespace Support;

use Closure;
use DB;
use Throwable;

class Transaction
{
    /**
     * @throws Throwable
     */
    public static function run(
        Closure $callback,
        Closure $finished = null,
        Closure $onError = null,
    )
    {
        try {
            DB::beginTransaction();

            return tap($callback(), function ($result) use ($finished) {
                if(!is_null($finished)) {
                    $finished($result);
                }
                DB::commit();
            });

        } catch (Throwable $e) {
            DB::rollback();

            if(!is_null($onError)) {
                $onError($e);
            }

            throw $e;
        }
    }
}
