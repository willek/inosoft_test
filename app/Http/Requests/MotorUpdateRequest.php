<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'tahun_keluaran' => 'nullable|digits:4',
            'warna' => 'nullable',
            'harga' => 'nullable|numeric',
            'mesin' => 'nullable',
            'tipe_suspensi' => 'nullable',
            'tipe_transmisi' => 'nullable',
        ];
    }
}
