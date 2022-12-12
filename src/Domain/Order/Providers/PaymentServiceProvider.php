<?php

namespace Domain\Order\Providers;

use Carbon\Laravel\ServiceProvider;
use Domain\Order\Payment\Gateways\YooKassa;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        PaymentSystem::provider(function () {
            return new YooKassa();
        });

        PaymentSystem::onCreating(function (PaymentData $paymentData) {
            return $paymentData;
        });

        PaymentSystem::onSuccess(function (Payment $payment) {
            //return $paymentData;
        });
    }
}
