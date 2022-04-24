<?php

namespace App\Services;

use App\Http\Requests\GetCurrencyItemRequest;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CurrencyService
{
    /**
     * @var \App\Repositories\CurrencyRepository
     */
    private CurrencyRepository $respositories;

    public function __construct()
    {
        $this->respositories = new CurrencyRepository();
    }

    public function getCurrencyItems(): LengthAwarePaginator
    {
        return $this->respositories->paginateItems();
    }

    public function syncCurrencyData(array $syncCurrencies): void
    {
        $this->respositories->syncCurrencies($syncCurrencies);
    }

    public function getCurrencyWithFromTo(string $currencyId, string $startDate, string $endDate)
    {
        return $this->respositories->getCurrencyChildesWithFromTo($currencyId, $startDate, $endDate);
    }

    public function getCurrencyOneItem(int $id)
    {
        return $this->respositories->getOneItem($id);
    }

    public function syncCurrencyChild(array $currencyChild, GetCurrencyItemRequest $request)
    {
        $currency = $this->respositories
            ->getCurrencyChildesWithFromTo($request->valuteID, $request->from, $request->to)
            ->first();
        $currencyChildItems = $currency->currencyChildes->toArray();
        $newCurrencyChildItems = [];

        foreach ($currencyChild as $item) {
            if (count($currencyChildItems))
            {
                $itemExist = false;
                foreach ($currencyChildItems as $currencyChildItem) {
                    if ($item['date'] == $currencyChildItem['date'])
                    {
                        $itemExist = false;
                        break;
                    } else {
                        $itemExist = true;
                    }
                }
                if ($itemExist)
                {
                    $item["created_at"] = now();
                    $item["updated_at"] = now();
                    $item["currency_id"] = $currency->id;
                    $newCurrencyChildItems[] = $item;
                }
            } else {
                $item["created_at"] = now();
                $item["updated_at"] = now();
                $item["currency_id"] = $currency->id;
                $newCurrencyChildItems[] = $item;
            }
        }

        $currency->currencyChildes()->insert($newCurrencyChildItems);
    }
}
