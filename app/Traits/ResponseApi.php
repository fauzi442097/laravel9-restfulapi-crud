<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseApi
{
    public function responseSuccess($data = null)
    {
        $responseBody['code'] = Response::HTTP_OK;
        $responseBody['message'] = "Sukses";
        if (!is_null($data)) {
            $responseBody['data'] = $data;
        }

        return response()->json($responseBody, Response::HTTP_OK);
    }

    public function responseError($statusCode, $error = null, $errorDetail = null)
    {
        $responseMessage = (is_null($error)) ? Response::$statusTexts[$statusCode] : $error;

        $responseBody['code'] = $statusCode;
        $responseBody['error'] = Response::$statusTexts[$statusCode];
        $responseBody['message'] = $responseMessage;

        if (!is_null($errorDetail)) {
            $responseBody['details'] = $errorDetail;
        }
        return response()->json($responseBody, $statusCode);
    }
}
