<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CurrencyRepository
{
    public function paginateItems(): LengthAwarePaginator
    {
        return Currency::query()->latest()->paginate();
    }

    public function syncCurrencies(array $syncCurrencies)
    {
        $oldCurrencies = Currency::query()->get([
            "valuteId",
            "numCode",
            "charCode",
            "name",
        ])->toArray();

        $newCurrencies = [];
        foreach ($oldCurrencies as $item => $oldCurrency) {
            foreach ($syncCurrencies as $syncCurrency) {
                if ($oldCurrency["valuteId"] !== $syncCurrency["valuteId"])
                {
                    $newCurrencies[] = $syncCurrencies[$item];
                }
            }
        }
        $countNewCurrencies = count($newCurrencies);

        if ($countNewCurrencies)
        {
            $currencies = [];
            for ($i = 0; $i < $countNewCurrencies; $i++)
            {
                $currencies[] = [
                    "valuteId" => $newCurrencies["valuteId"],
                    "numCode" => $newCurrencies["numCode"],
                    "charCode" => $newCurrencies["charCode"],
                    "name" => $newCurrencies["name"],
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            DB::table("currencies")->insert($currencies);
        }
    }

    public function getCurrencyChildesWithFromTo(string $currencyId, string $startDate, string $endDate)
    {
        return Currency::query()->where("valuteId", $currencyId)
            ->with(["currencyChildes" => function ($query) use ($startDate, $endDate) {
                $query->whereBetween("date", [$startDate, $endDate]);
            }])->get();
    }

    public function getOneItem(int $id)
    {
        return Currency::with(['currencyChildes' => fn($query) => $query->orderBy('date', 'desc')])->find($id);
    }
}
