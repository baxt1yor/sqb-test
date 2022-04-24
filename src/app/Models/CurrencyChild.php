<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasOne, SoftDeletes};

/**
 * @template  CurrencyChild
 * @property integer $nominal
 * @property string $value
 * @property Currency $currency
 */
class CurrencyChild extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "currency_children";

    protected $fillable = [
        "nominal",
        "value",
        "currency_id",
    ];

    protected $casts = [
        "nominal" => "integer",
        "value" => "string",
        "currency_id" => "integer",
    ];

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function getValueAttribute(): float
    {
        return floatval(implode(".", explode(",", $this->attributes["value"])));
    }
}
