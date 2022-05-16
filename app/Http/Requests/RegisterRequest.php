<?php

namespace App\Http\Requests;

use App\Traits\ResponseApi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|max:255|unique:users,email|email',
            'password' => 'required|min:8|same:confPassword',
            'confPassword' => 'required|min:8|same:password'
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            $this->responseError(Response::HTTP_BAD_REQUEST, "Data yang dikirim tidak lengkap", $validator->errors())
        );
    }
}
