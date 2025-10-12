<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class ZiinaPaymentHandler
{
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?? config('services.ziina.api_key');
        $this->baseUrl = config('services.ziina.base_url', 'https://api-v2.ziina.com/api');

        if (empty($this->apiKey)) {
            throw new Exception('Ziina API key is not configured');
        }
    }

    private function calculateTripPrice($trip, $roomType = null)
    {
        if ($trip->private_room_price && $roomType) {
            switch ($roomType) {
                case 'shared':
                    return $trip->shared_room_price ?? $trip->price;
                case 'private':
                    return $trip->private_room_price;
                default:
                    return $trip->price;
            }
        }
        return $trip->price ?? 0;
    }

    public function calculatePriceWithFees($trip, $roomType = null)
    {
        $basePrice = $this->calculateTripPrice($trip, $roomType);
        $feePercent = 0.029;
        return $basePrice * (1 + $feePercent);
    }

    public function createTripPaymentIntent($trip, $successUrl, $cancelUrl, $isTest = false, $finalPrice = null, $roomType = null)
    {
        try {
            if (!$trip) {
                throw new Exception('Trip data is missing');
            }

            $totalPrice = $finalPrice ?? $this->calculateTripPrice($trip, $roomType);

            if ($totalPrice < 2) {
                throw new Exception("Trip price ($totalPrice AED) is below minimum (2 AED)");
            }

            $amountInFils = (int)($totalPrice * 100);

            $title = $trip->title_ar ?? $trip->title ?? 'رحلة';
            $title = mb_substr($title, 0, 80);

            $message = "حجز رحلة: {$title}";
            if ($roomType) {
                $roomTypeAr = $roomType === 'shared' ? 'غرفة مشتركة' : 'غرفة خاصة';
                $message .= " - {$roomTypeAr}";
            }

            if (mb_strlen($message) < 10) {
                $message .= " - حجز";
            }

            $data = [
                'amount' => $amountInFils,
                'currency_code' => 'AED',
                'message' => $message,
                'success_url' => $successUrl . '?payment_intent_id={PAYMENT_INTENT_ID}&invoice_id=' . $trip->id,
                'cancel_url' => $cancelUrl . '?trip_id=' . $trip->id,
                'metadata' => [
                    'invoice_id' => (string)$trip->id,
                    'trip_id' => (string)$trip->id,
                    'trip_title' => $trip->title_ar ?? $trip->title ?? '',
                    'customer_id' => (string)(auth()->id() ?? 'guest'),
                    'room_type' => $roomType ?? 'standard',
                    'final_price_with_fees' => $totalPrice,
                    'environment' => app()->environment()
                ]
            ];

            // if ($isTest || app()->environment('local', 'testing')) {
            //     $data['test'] = true;
            // }

            Log::info('Creating Ziina payment intent', [
                'trip_id' => $trip->id,
                'amount' => $amountInFils,
                'room_type' => $roomType,
                'final_price' => $totalPrice,
                'message' => $message,
                'test_mode' => false
                
            ]);

            $response = $this->makeApiCall('/payment_intent', 'POST', $data);

            if (!isset($response['redirect_url'])) {
                throw new Exception('Payment intent created but no redirect URL received');
            }

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to create Ziina payment intent', [
                'trip_id' => $trip->id ?? null,
                'room_type' => $roomType ?? null,
                'final_price' => $finalPrice ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getPaymentIntent($paymentIntentId)
    {
        try {
            if (empty($paymentIntentId)) {
                throw new Exception('Payment intent ID is required');
            }

            $response = $this->makeApiCall('/payment_intent/' . $paymentIntentId, 'GET');

            Log::info('Retrieved payment intent status', [
                'payment_intent_id' => $paymentIntentId,
                'status' => $response['status'] ?? 'unknown'
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get payment intent', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function makeApiCall($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Laravel-App/' . app()->version()
        ];

        Log::info('Making Ziina API call', [
            'method' => $method,
            'endpoint' => $endpoint,
            'url' => $url
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            Log::error('cURL error in Ziina API call', [
                'error' => $curlError,
                'url' => $url
            ]);
            throw new Exception('Network error: ' . $curlError);
        }

        if (empty($response)) {
            Log::error('Empty response from Ziina API', [
                'http_code' => $httpCode,
                'url' => $url
            ]);
            throw new Exception('Empty response from payment service');
        }

        $decodedResponse = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Invalid JSON response from Ziina API', [
                'response' => substr($response, 0, 500),
                'json_error' => json_last_error_msg()
            ]);
            throw new Exception('Invalid response format from payment service: ' . json_last_error_msg());
        }

        if ($httpCode >= 400) {
            $errorMessage = $decodedResponse['message'] ?? 'Unknown API error';
            Log::error('Ziina API error', [
                'http_code' => $httpCode,
                'error_message' => $errorMessage,
                'full_response' => $decodedResponse
            ]);
            throw new Exception('Payment service error: ' . $errorMessage);
        }

        return $decodedResponse;
    }

    public function validateWebhook($payload, $signature, $secret = null)
    {
        $webhookSecret = $secret ?? config('services.ziina.webhook_secret');

        if (empty($webhookSecret)) {
            Log::info('Webhook validation skipped - no secret configured');
            return true;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        return hash_equals($expectedSignature, $signature);
    }
    
}
