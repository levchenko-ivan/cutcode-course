<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

trait StatusStateType
{
    abstract function getType(): OrderStatuses;

    public function value(): string
    {
        return $this->getType()->value;
    }

    public function humanValue(): string
    {
        return $this->getType()->humanValue();
    }
}
