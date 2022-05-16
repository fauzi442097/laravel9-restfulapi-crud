<?php

namespace App\Http\Controllers;

use App\Traits\ResponseApi;
use App\Traits\StringResponseError;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ResponseApi, StringResponseError;

    public function ServiceExceptionHandler($e)
    {
        $arrMsg = $this->parseMessageToArray($e->getMessage());
        $message = $arrMsg['message'];
        $detail = $arrMsg['detail'];
        return $this->responseError($e->getCode(), $message, $detail);
    }
}
