<?php

namespace Domain\Order\Payment;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Exceptions\PaymentProviderException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

class PaymentSystem
{
    use PaymentEvents;

    protected static PaymentGatewayContract $provider;

    /**
     * @throws PaymentProviderException
     */
    public static function provider(PaymentGatewayContract|Closure $providerOrClosure): void
    {
        if(is_callable($providerOrClosure)) {
            $providerOrClosure = call_user_func($providerOrClosure);
        }

        self::validatePaymentContract($providerOrClosure);

        self::$provider = $providerOrClosure;
    }

    public static function create(PaymentData $paymentData): PaymentGatewayContract
    {
        self::validatePaymentContract(self::$provider);


        Payment::query()->create([
            'payment_id' => $paymentData->id
        ]);

        if(is_callable(self::$onCreating)) {
            $paymentData = call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider->data($paymentData);
    }

    public static function validate(): PaymentGatewayContract
    {
        self::validatePaymentContract(self::$provider);

        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider)
        ]);

        if(is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if(self::$provider->validate() && self::$provider->paid()) {
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->paymentId())
                ->firstOr(function () {
                    throw PaymentProviderException::paymentRequired();
                });

                if(is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(PaidPaymentState::class);

            } catch (PaymentProviderException $e) {

                if(is_callable(self::$onError)) {
                    call_user_func(self::$onError, self::$provider->errorMessage() ?? $e->getMessage());
                }
            }
        }

        return self::$provider;
    }

    private static function validatePaymentContract($object)
    {
        if(!$object instanceof PaymentGatewayContract) {
            throw PaymentProviderException::providerRequired();
        }
    }
}
