<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Event;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Enums\PaymentMethod;
use App\Http\Requests\TransactionRequest;
use ErrorHandler;
use PaymentDataBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function createPayment(TransactionRequest $request) 
    {
        $event = Event::select('price')->find($request->event_id);

        $transaction = new Transaction();
        $transaction->id = Transaction::generateOrderID($request->event_id);
        $transaction->event_id = $request->event_id;
        $transaction->amount = $request->amount;
        $transaction->status = 'pending';
        $transaction->payment_method = $request->payment_method;
        $transaction->user_id = auth('sanctum')->user()->id;
        $transaction->expired_at = Carbon::now()->addDays(1)->format('Y-m-d H:i');
        $transaction->ticket_schedules = json_encode($request->ticket_schedules);

        // Count number of schedules selected 
        if(is_array($request->ticket_schedules)) {
            $countSchedules = count($request->ticket_schedules);
            $transaction->total_price = ($event->price * $request->amount) * $countSchedules;
        } else {
            $transaction->total_price = $event->price * $request->amount;
        }

        if($transaction->save()) {
            $transaction->load('event');
            $transaction->load('user');
    
            $data = PaymentDataBuilder::build($transaction);
            
            $createPayment = Http::withBasicAuth('SB-Mid-server-W-skb6JH2OtcZF60aS6nMlxI', '')
            ->acceptJson()
            ->post('https://api.sandbox.midtrans.com/v2/charge', $data);

            if($createPayment->failed()) {
                $transaction->delete();

                return ErrorHandler::errorResource('Gagal membuat pembayaran', 400);
            }

            $response = json_decode($createPayment);

            // If payment using indomaret or alfamart then add payment code to transaction
            // If using bank transfer (va) add va number to payment code

            if($request->payment_method == PaymentMethod::INDOMARET 
            || $request->payment_method == PaymentMethod::ALFAMART) {
                $transaction->payment_code = $response->payment_code;
                $transaction->save();
            } else if ($request->payment_method == PaymentMethod::BCA || $request->payment_method == PaymentMethod::BNI 
            || $request->payment_method == PaymentMethod::BRI) {
                $transaction->payment_code = $response->va_numbers[0]->va_number;
                $transaction->save();
            }

            return (new TransactionResource($transaction))
                ->additional($this->additionalResource($transaction));
        }

        return ErrorHandler::errorResource('Gagal membuat pembayaran', 400);
    }
}
