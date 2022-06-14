<?php

namespace App\Http\Controllers;

use PaymentStatusTranslator;
use ErrorHandler;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');        
    }

    public function index()
    {
        $transactions = Transaction::where('user_id', auth('sanctum')->user()->id)->orderBy('created_at')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if($transaction->user_id != auth('sanctum')->user()->id) {
            return ErrorHandler::errorResource('Transaction not found', 404);
        }

        $getPaymentStatus = Http::acceptJson()->withBasicAuth('SB-Mid-server-W-skb6JH2OtcZF60aS6nMlxI', '')
            ->get("https://api.sandbox.midtrans.com/v2/$transaction->id/status");

        if($getPaymentStatus->failed()) {
            return ErrorHandler::errorResource('Tidak dapat mengambil status order', 404);
        }

        $response = json_decode($getPaymentStatus);

        $transaction->status = PaymentStatusTranslator::translate($response->transaction_status);
        $transaction->save();
    
        return (new TransactionResource($transaction))->additional(
            $this->additionalResource($transaction)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if($transaction->user_id != auth('sanctum')->user()->id) {
            return ErrorHandler::errorResource('Transaction not found', 404);
        }

        $transaction->status = 'cancelled';

        if($transaction->save()) {
            return (new TransactionResource($transaction))->additional(
                $this->additionalResource($transaction)
            );
        }
    }
}
