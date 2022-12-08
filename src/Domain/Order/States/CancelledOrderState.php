<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class CancelledOrderState extends OrderState
{
    use StatusStateType;

    public function canBeChanged(): bool
    {
        return false;
    }

    public function getType(): OrderStatuses
    {
        return OrderStatuses::Cancelled;
    }
}
