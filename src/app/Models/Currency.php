<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasMany, SoftDeletes};

/**
 * @template Currency
 *
 * @property string $valuteId
 * @property integer $numCode
 * @property string $charCode
 * @property string $name
 * @property CurrencyChild $currencyChildes
 */
class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "currencies";

    protected $fillable = [
      "valuteId",
      "numCode",
      "charCode",
      "name",
    ];

    protected $casts = [
        "valuteId" => "string",
        "numCode" => "integer",
        "charCode" => "string",
        "name" => "string",
        "created_at" => "datetime"
    ];

    public function currencyChildes(): HasMany
    {
        return $this->hasMany(CurrencyChild::class, 'currency_id', 'id');
    }
}
