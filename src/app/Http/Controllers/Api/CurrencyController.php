<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCurrencyItemRequest;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * @var \App\Services\CurrencyService
     */
    private CurrencyService $service;

    public function __construct()
    {
        $this->service = new CurrencyService();
    }

    public function index(GetCurrencyItemRequest $request)
    {
        $currencyChildes = $this->service->getCurrencyWithFromTo($request->valuteID, $request->from, $request->to);

        return CurrencyResource::collection($currencyChildes);
    }
}
