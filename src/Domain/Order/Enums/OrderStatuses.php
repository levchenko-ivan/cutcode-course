<?php

namespace Domain\Order\Enums;

use Domain\Order\Models\Order;
use Domain\Order\States\OrderStatus\CancelledOrderState;
use Domain\Order\States\OrderStatus\NewOrderState;
use Domain\Order\States\OrderStatus\OrderState;
use Domain\Order\States\OrderStatus\PaidOrderState;
use Domain\Order\States\OrderStatus\PendingOrderState;

enum OrderStatuses: string
{
    case New = 'new';
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function createState(Order $order): OrderState
    {
        return match ($this) {
            self::New => new NewOrderState($order),
            self::Pending => new PendingOrderState($order),
            self::Paid => new PaidOrderState($order),
            self::Cancelled => new CancelledOrderState($order),
        };
    }

    public function humanValue(): string
    {
        return match ($this) {
            self::New => 'Новый',
            self::Pending => 'В обработке',
            self::Paid => 'Оплачено',
            self::Cancelled => 'Отменен',
        };
    }
}
