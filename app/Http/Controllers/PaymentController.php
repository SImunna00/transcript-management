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

        // Save the request details in the database
        $order = TranscriptRequest::create([
            'user_id' => auth()->user()->id,
            'academic_year' => $request->year,
            'term' => $request->term,
            'additional_info' => $request->additional_info,
            'payment_status' => 'pending',  // Default payment status
        ]);

        // Prepare payment details for SSLCommerz
        $orderData = [
            'total_amount' => $request->amount,  // Payment amount
            'currency' => 'BDT',  // Currency in BDT
            'tran_id' => $order->id,  // Use the order ID as the transaction ID
            'success_url' => route('sslc.success'),
            'fail_url' => route('sslc.failure'),
            'cancel_url' => route('sslc.cancel'),
            'cus_name' => auth()->user()->name,
            'cus_email' => auth()->user()->email,
            'cus_phone' => auth()->user()->phone,  // Ensure this field exists in your user model
            'additional_info' => $request->additional_info,  // Optional additional information
        ];

        // Step 2: Create payment link with SSLCommerz
        $response = Sslcommerz::setOrder($request->amount, $order->id, "Transcript Request")
            ->setCustomer(auth()->user()->name, auth()->user()->email, auth()->user()->phone)
            ->setShippingInfo(1, 'Shipping Address')  // You can pass actual shipping data here
            ->makePayment();

        // Step 3: Handle Payment Response
        if ($response->success()) {
            // Redirect user to SSLCommerz payment gateway page
            return redirect($response->gatewayPageURL());
        } else {
            // Handle payment initiation failure
            return redirect()->back()->with('error', 'Payment initiation failed. Please try again.');
        }
    }

    // Step 4: Handle Payment Success
    public function paymentSuccess(Request $request)
    {
        $transactionId = $request->input('tran_id');  // Get the transaction ID
        $amount = $request->input('amount');  // Get the payment amount from the response

        // Step 5: Validate Payment
        $isValid = Sslcommerz::validatePayment($request->all(), $transactionId, $amount);

        if ($isValid) {
            // If payment is valid, update the order status to 'paid'
            $order = TranscriptRequest::find($transactionId);
            if ($order) {
                $order->payment_status = 'paid';  // Update payment status
                $order->save();
            }

            // Step 6: Show success view
            return view('payment.success', ['transactionId' => $transactionId]);
        } else {
            // If payment is invalid, show failure view
            return view('payment.fail');
        }
    }

    // Step 7: Handle Payment Failure
    public function paymentFail(Request $request)
    {
        // Handle failed payment
        return view('payment.fail');
    }

    // Step 8: Handle Payment Cancellation
    public function paymentCancel(Request $request)
    {
        // Handle canceled payment
        return view('payment.cancel');
    }

    // Step 9: Handle Instant Payment Notification (IPN)
    public function paymentIPN(Request $request)
    {
        // Log the incoming request for debugging
        // \Log::info('SSLCommerz IPN Response:', $request->all());

        // Extract transaction details from the IPN response
        $transactionId = $request->input('tran_id');
        $paymentStatus = $request->input('status');  // Get payment status (success, failed, etc.)

        // Find the corresponding order in the database
        $order = TranscriptRequest::find($transactionId);
        if ($order) {
            // Update the order with the payment status
            $order->payment_status = $paymentStatus;
            $order->save();
        }

        // Respond to SSLCommerz (acknowledge receipt of the IPN)
        return response()->json(['status' => 'success']);
    }
}
