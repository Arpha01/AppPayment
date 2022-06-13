<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Event;
use App\Models\Transaction;
Use Carbon\Carbon;
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

    public function index() 
    {
        $transactions = Transaction::where('user_id', auth('sanctum')->user()->id)->orderBy('created_at')->get();

        return TransactionResource::collection($transactions);
    }

    public function createPayment(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:App\Models\Event,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:bri,bca,bni,indomaret,alfamart,gopay'
        ], [
            'event_id.required' => 'Event belum dipilih',
            'event_id.exists' => 'Event tidak ditemukan',
            'amount.required' => 'Jumlah tiket belum diisi',
            'amount.numeric' => 'Jumlah tiket tidak valid',
            'payment_method.required' => 'Metode pembayaran belum dipilih',
            'payment_method.in' => 'Metode pembayaran tidak ditemukan'
        ]);

        if($validator->fails()) {
            return ErrorHandler::errorResource($validator->errors()->all(), 400);
        }

        $event = Event::select('price')->find($request->event_id);

        $transaction = new Transaction();
        $transaction->id = Transaction::generateOrderID($request->event_id);
        $transaction->event_id = $request->event_id;
        $transaction->amount = $request->amount;
        $transaction->total_price = $event->price * $request->amount;
        $transaction->status = 'pending';
        $transaction->payment_method = $request->payment_method;
        $transaction->user_id = auth('sanctum')->user()->id;
        $transaction->expired_at = Carbon::now()->addDays(1)->format('Y-m-d H:i');

        if($transaction->save()) {
            $transaction->load('event');
            $transaction->load('user');
    
            $data =  PaymentDataBuilder::build($transaction);
            

            $createPayment = Http::withBasicAuth('SB-Mid-server-W-skb6JH2OtcZF60aS6nMlxI', '')
            ->acceptJson()
            ->post('https://api.sandbox.midtrans.com/v2/charge', $data);

            if($createPayment->failed()) {
                $transaction->delete();

                return ErrorHandler::errorResource('Gagal membuat pembayaran', 400);

            }

            return (new TransactionResource($transaction))
                ->additional($this->additionalResource($transaction));
        }

        return ErrorHandler::errorResource('Gagal membuat pembayaran', 400);
    }
}
