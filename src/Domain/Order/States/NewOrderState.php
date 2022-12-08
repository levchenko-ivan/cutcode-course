<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class NewOrderState extends OrderState
{
    use StatusStateType;

    protected array $allowedTransition = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function getType(): OrderStatuses
    {
        return OrderStatuses::New;
    }
}
