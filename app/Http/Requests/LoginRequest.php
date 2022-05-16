<?php

namespace App\Http\Requests;

use App\Traits\ResponseApi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class LoginRequest extends FormRequest
{
    use ResponseApi;
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
            //
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            $this->responseError(Response::HTTP_BAD_REQUEST, "Data yang dikirim tidak lengkap", $validator->errors())
        );
    }
}
