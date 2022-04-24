<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "valuteId" => $this->resource->valuteId,
            "numCode" => $this->resource->numCode,
            "charCode" => $this->resource->charCode,
            "name" => $this->resource->name,
            "currency_childes" => CurrencyChildResource::collection($this->resource->currencyChildes)
        ];
    }
}
