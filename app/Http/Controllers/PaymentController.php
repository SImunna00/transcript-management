<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranscriptRequest;
use \Raziul\Sslcommerz\Facades\Sslcommerz;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Step 1: Initiate the Payment
    public function initiatePayment(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'year' => 'required|string',
            'term' => 'required|string',
            'additional_info' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);

        // Generate unique transaction ID first
        $transactionId = 'TXN_' . time() . '_' . rand(1000, 9999);

        // Save the request details in the database
        $order = TranscriptRequest::create([
            'user_id' => auth()->user()->id,
            'academic_year' => $request->year,
            'term' => $request->term,
            'additional_info' => $request->additional_info,
            'amount' => $request->amount,
            'payment_status' => 'pending',
            'payment_method' => 'sslcommerz',
            'transaction_id' => $transactionId,
        ]);

        // Create payment link with SSLCommerz
        $response = Sslcommerz::setOrder($request->amount, $transactionId, "Transcript Request")
            ->setCustomer(auth()->user()->name, auth()->user()->email, auth()->user()->phone ?? '01700000000')
            ->setShippingInfo(1, 'Dhaka, Bangladesh')
            ->makePayment();

        // Handle Payment Response
        if ($response->success()) {
            // Redirect user to SSLCommerz payment gateway page
            return redirect($response->gatewayPageURL());
        } else {
            // Handle payment initiation failure
            return redirect()->back()->with('error', 'Payment initiation failed. Please try again.');
        }
    }

    // Step 2: Handle Payment Success
    public function paymentSuccess(Request $request)
    {
        // Log the response for debugging
        Log::info('SSLCommerz Success Response:', $request->all());

        $transactionId = $request->input('tran_id');
        $amount = $request->input('amount');
        $status = $request->input('status');

        // Validate Payment with SSLCommerz
        $isValid = Sslcommerz::validatePayment($request->all(), $transactionId, $amount);

        if ($isValid && $status == 'VALID') {
            // Find order by transaction_id instead of using tran_id as primary key
            $order = TranscriptRequest::where('transaction_id', $transactionId)->first();
            
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'sslcommerz'
                ]);

                Log::info('Payment successful for transaction: ' . $transactionId);
                
                return view('payment.success', [
                    'transactionId' => $transactionId,
                    'order' => $order
                ]);
            } else {
                Log::error('Order not found for transaction: ' . $transactionId);
                return view('payment.fail')->with('error', 'Order not found');
            }
        } else {
            Log::error('Payment validation failed for transaction: ' . $transactionId);
            return view('payment.fail')->with('error', 'Payment validation failed');
        }
    }

    // Step 3: Handle Payment Failure
    public function paymentFail(Request $request)
    {
        Log::info('SSLCommerz Fail Response:', $request->all());
        
        $transactionId = $request->input('tran_id');
        
        if ($transactionId) {
            $order = TranscriptRequest::where('transaction_id', $transactionId)->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_method' => 'sslcommerz'
                ]);
            }
        }

        return view('payment.fail');
    }

    // Step 4: Handle Payment Cancellation
    public function paymentCancel(Request $request)
    {
        Log::info('SSLCommerz Cancel Response:', $request->all());
        
        $transactionId = $request->input('tran_id');
        
        if ($transactionId) {
            $order = TranscriptRequest::where('transaction_id', $transactionId)->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'cancelled',
                    'payment_method' => 'sslcommerz'
                ]);
            }
        }

        return view('payment.cancel');
    }

    // Step 5: Handle Instant Payment Notification (IPN)
    public function paymentIPN(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('SSLCommerz IPN Response:', $request->all());

        $transactionId = $request->input('tran_id');
        $paymentStatus = $request->input('status');
        $amount = $request->input('amount');

        // Validate the IPN request
        $isValid = Sslcommerz::validatePayment($request->all(), $transactionId, $amount);

        if ($isValid) {
            // Find the corresponding order in the database
            $order = TranscriptRequest::where('transaction_id', $transactionId)->first();

            if ($order) {
                // Map SSLCommerz status to your application status
                $status = 'pending';
                switch ($paymentStatus) {
                    case 'VALID':
                        $status = 'paid';
                        break;
                    case 'FAILED':
                        $status = 'failed';
                        break;
                    case 'CANCELLED':
                        $status = 'cancelled';
                        break;
                }

                $order->update([
                    'payment_status' => $status,
                    'payment_method' => 'sslcommerz'
                ]);

                Log::info('IPN processed successfully for transaction: ' . $transactionId);
            }
        }

        // Respond to SSLCommerz (acknowledge receipt of the IPN)
        return response()->json(['status' => 'success']);
    }
}