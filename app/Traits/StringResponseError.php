<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait StringResponseError
{
    private $message;

    public function makeErrorMessage(string $error, string $errorDetail = null): string
    {
        $messages = [$error, $errorDetail];
        return implode("|", $messages);
    }

    public function parseMessageToArray($message): array
    {
        $messages = explode("|", $message);
        return [
            'message' => $messages[0],
            'detail' => $messages[1],
        ];
    }
}
