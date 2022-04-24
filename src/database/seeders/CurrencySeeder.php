<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Services\CurrencyCbr;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endDate = now()->subDay()->format("d.m.Y");
        $startDate = now()->subDays(29)->format("d.m.y");
        $currencyService = new CurrencyCbr();

        $currencies = $currencyService->xmlDaily();
        for ($i = 0;  $i < count($currencies); $i++)
        {
            /** @var Currency $currency */
            $currency = Currency::query()->create($currencies[$i]);
            $currencyChildes = $currencyService->xmlDynamic($currency->valuteId, $startDate, $endDate);
            foreach ($currencyChildes as $item) {
                $currency->currencyChildes()->create($item);
            }
        }
    }
}
