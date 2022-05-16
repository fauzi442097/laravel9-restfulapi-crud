<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

use function PHPSTORM_META\map;

class ModelResource extends JsonResource
{
    private $message;

    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'status' => $this->message,
            'data' => parent::toArray($request)
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application-json');
    }
}
