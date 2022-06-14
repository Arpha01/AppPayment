<?php

namespace App\Http\Requests;

use ErrorHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id' => 'required|exists:App\Models\Event,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:bri,bca,bni,indomaret,alfamart,gopay',
            'ticket_schedules' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'event_id.required' => 'Event belum dipilih',
            'event_id.exists' => 'Event tidak ditemukan',
            'amount.required' => 'Jumlah tiket belum diisi',
            'amount.numeric' => 'Jumlah tiket tidak valid',
            'payment_method.required' => 'Metode pembayaran belum dipilih',
            'payment_method.in' => 'Metode pembayaran tidak ditemukan',
            'ticket_schedules.required' => 'Jadwal tiket belum dipilih'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(ErrorHandler::errorResource($validator->errors()->all(), 400)));
    }
}
