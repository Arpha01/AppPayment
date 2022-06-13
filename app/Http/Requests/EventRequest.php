<?php

namespace App\Http\Requests;

use ErrorHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->user()->is_organization;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'description' => 'required|min:5',
            'price' => 'required|numeric',
            'schedule' => 'required',
            'location' => 'required',
            'location_description' => 'required',
            'rules' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama event belum diisi',
            'name.min' => 'Nama event minimal 3 karakter',
            'description.required' => 'Deskripsi event belum diisi',
            'description.min' => 'Deskripsi event minimal 5 karakter',
            'price.required' => 'Harga event belum diisi',
            'price.numeric' => 'Harga event harus berupa angka',
            'schedule.required' => 'Jadwal event belum diisi',
            'location.required' => 'Lokasi event belum diisi',
            'location_description.required' => 'Deskripsi lokasi event belum diisi',
            'rules.required' => 'Ketentuan event belum diisi',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(ErrorHandler::errorResource($validator->errors()->all(), 400)));
    }
}
