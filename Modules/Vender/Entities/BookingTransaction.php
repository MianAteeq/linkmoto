<?php

namespace Modules\Vender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    /**
     * Get the user that owns the BookingTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    
      protected $appends = ['pay_no']; // Optional: include in JSON

   public function getPayNoAttribute($value)
{
    $prefix = 'TRU';

    // Use optional() helper to avoid errors if relation is null
    $tradingId = optional(optional($this->invoice)->booking)->trading_id ?? 0;

    return 'PAY-' . $prefix . str_pad($tradingId, 5, '0', STR_PAD_LEFT) 
        . '-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
}

}
