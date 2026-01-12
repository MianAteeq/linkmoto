<?php

namespace Modules\Vender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TradingName extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Vender\Database\factories\TradingNameFactory::new();
    }
    public function trading_unit(): HasOne
    {
        return $this->hasOne(TradingUnit::class, 'trading_name_id', 'id');
    }
}
