<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use SimpleXMLElement;

class CurrencyCbr
{
    /**
     * @param string $lang
     * @return array
     */
    public function xmlDaily(string $lang = "ru"): array
    {
        $currencies = [];
        /** @var SimpleXMLElement $xml */
        $xml = simplexml_load_file(env("XML_DAILY_".strtoupper($lang)));
        for($i = 0; $i <= $xml->count(); $i++)
        {
            $current = (array)json_decode(json_encode($xml->Valute[$i]));
            if ((array_key_exists("@attributes", $current) && property_exists($current["@attributes"], "ID")) &&
                array_key_exists("NumCode", $current) &&
                array_key_exists("CharCode", $current) &&
                array_key_exists("Name", $current)
            ) {
                $currencies[] = [
                    "valuteId" => $current["@attributes"]->ID,
                    "numCode" => $current["NumCode"],
                    "charCode" => $current["CharCode"],
                    "name" => $current["Name"],
                ];
            } else {
                continue;
            }
        }

        return $currencies;
    }

    /**
     * @param string $valuteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function xmlDynamic(string $valuteId, string $startDate, string $endDate)
    {
        $startDate = (new Carbon($startDate))->format("d/m/Y");
        $endDate = (new Carbon($endDate))->format("d/m/Y");

        $url = env("XML_DYNAMIC")."?date_req1=$startDate&date_req2=$endDate&VAL_NM_RQ=$valuteId";

        $xml = simplexml_load_file($url);
        $currencies = [];

        for ($i = 0; $i <= $xml->count(); $i++)
        {
            $current = (array)json_decode(json_encode($xml->Record[$i]));

            if ((array_key_exists("@attributes", $current) && property_exists($current["@attributes"], "Date")) &&
                array_key_exists("Nominal", $current) &&
                array_key_exists("Value", $current)
            ) {
                $currencies[] = [
                    "nominal" => $current["Nominal"],
                    "value" => $current["Value"],
                    "date" => (new Carbon($current["@attributes"]->Date))->format("Y-m-d")
                ];
            } else {
                continue;
            }
        }

        return $currencies;
    }
}
