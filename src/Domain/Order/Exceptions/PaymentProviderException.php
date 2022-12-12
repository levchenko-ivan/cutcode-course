<?php

namespace Domain\Order\Exceptions;

use Exception;

class PaymentProviderException extends Exception
{
    public static function providerRequired(): self
    {
        return new self('Provider is required');
    }

    public static function paymentRequired(): self
    {
        return new self('Payment is not a valid');
    }
}
