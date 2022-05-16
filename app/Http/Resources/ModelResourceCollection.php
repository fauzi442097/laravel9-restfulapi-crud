<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ModelResourceCollection extends ResourceCollection
{
    private $message;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status' => $this->message,
            'data' => parent::toArray($request)
        ];
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }
}
