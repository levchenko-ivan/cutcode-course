<?php

namespace Domain\Order\States;

class PaidOrderState extends OrderState
{
    protected array $allowedTransition = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    //Todo
    public function value(): string
    {
        return 'paid';
    }

    public function humanValue(): string
    {
        return 'Оплачено';
    }
}
