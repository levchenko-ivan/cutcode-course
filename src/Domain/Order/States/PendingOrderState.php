<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class PendingOrderState extends OrderState
{
    use StatusStateType;

    protected array $allowedTransition = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function getType(): OrderStatuses
    {
        return OrderStatuses::Pending;
    }
}
