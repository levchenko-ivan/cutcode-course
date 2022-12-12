<?php

namespace Domain\Order\Payment;

use Domain\Order\Contracts\PaymentGatewayContract;

class PaymentSystem
{
    protected static PaymentGatewayContract $provider;

}
