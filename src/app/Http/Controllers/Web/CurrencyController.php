<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCurrencyItemRequest;
use App\Services\CurrencyCbr;
use App\Services\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * @var \App\Services\CurrencyService
     */
    public CurrencyService $service;

    /**
     * @var \App\Services\CurrencyCbr
     */
    public CurrencyCbr $cbrService;

    public function __construct()
    {
        $this->service = new CurrencyService();
        $this->cbrService = new CurrencyCbr();
    }

    public function index()
    {
        $currencies = $this->service->getCurrencyItems();
        return view("currencies.index", compact('currencies'));
    }

    public function sync(): RedirectResponse
    {
        $this->service->syncCurrencyData($this->cbrService->xmlDaily());
        return redirect()->back()->with("success", "Synced data successfully!");
    }

    public function show(int $id)
    {
        $currency = $this->service->getCurrencyOneItem($id);
        return view('currencies.show', compact('currency'));
    }

    public function syncCurrencyChild(GetCurrencyItemRequest $request): RedirectResponse
    {
        $this->service->syncCurrencyChild($this->cbrService->xmlDynamic($request->valuteID, $request->from, $request->to), $request);
        return redirect()->back()->with("success", "Synced data successfully!");
    }
}
