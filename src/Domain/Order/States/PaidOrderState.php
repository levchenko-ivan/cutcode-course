<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class PaidOrderState extends OrderState
{
    use StatusStateType;

    protected array $allowedTransition = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function getType(): OrderStatuses
    {
        return OrderStatuses::Paid;
    }
}
