<?php

namespace public\api\controller\webhook;

use public\api\services\webhook\StripeWebhook_service;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhook_controller
{
    private StripeWebhook_service $stripe_webhook_service;

    public function __construct()
    {
        $this->stripe_webhook_service = new StripeWebhook_service();
    }

    public function updateData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $payload = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $_ENV['STRIPE_WEBHOOK_SECRET']
            );
        } catch (\UnexpectedValueException $e) {
            http_response_code(400);
            return;
        } catch (SignatureVerificationException $e) {
            http_response_code(400);
            return;
        }

        if ($event->type === 'payment_intent.succeeded') {

            $paymentIntent = $event->data->object;

            $data = [
                'professional_id'=>$paymentIntent->metadata->professional_id ?? '',
                'booking_id' => $paymentIntent->metadata->booking_id ?? '',
                'payment_id' => $paymentIntent->metadata->payment_id ?? '',
                'payment_method' => $paymentIntent->payment_method_types[0] ?? null,
                'stripe_payment_intent_id' => $paymentIntent->id ?? '',
                'paid_at' => date('Y-m-d H:i:s', $event->created) ?? '',
                'payFor' => $paymentIntent->metadata->payFor ?? '',
            ];

            error_log(print_r($data, true));
 

            if ($data['payFor'] == 'booking') {
                $this->stripe_webhook_service->payment_booking_success($data);
                http_response_code(200);
                return;
            }  
        }

        if ($event->type === 'payment_intent.canceled') {

            $paymentIntent = $event->data->object;

            $data = [
                'professional_id'=>$paymentIntent->metadata->professional_id ?? '',
                'booking_id' => $paymentIntent->metadata->booking_id,
                'payment_id' => $paymentIntent->metadata->payment_id,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'payFor' => $paymentIntent->metadata->payFor ?? '',
            ];


            if ($data['payFor'] == 'booking') {
                $this->stripe_webhook_service->payment_booking_failed($data);
                http_response_code(200);
                return;
            }
  
        }

        if ($event->type === 'checkout.session.expired') {

            $session = $event->data->object;

            $data = [
                'professional_id'=>$session->metadata->professional_id ?? '',
                'booking_id' => $session->metadata->booking_id,
                'payment_id' => $session->metadata->payment_id,
                'stripe_checkout_session_id' => $session->id,
                'payFor' => $session->metadata->payFor ?? '',
            ];

            if ($data['payFor'] == 'booking') {
                $this->stripe_webhook_service->payment_booking_failed($data);
                http_response_code(200);
                return;
            }
        }

        http_response_code(500);
    }
}
