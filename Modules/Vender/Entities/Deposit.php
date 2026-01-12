<?php

namespace Modules\Vender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
    
    protected $appends = ['deposit_no']; // Optional: include in JSON
    //  protected $appends = ['job_no'];

    public function getDepositNoAttribute($value)
    {
        // You can use any attribute from the model
        $id = $this->booking->trading_id;
        $prefix = 'TRU';

        return 'PAY-'."TRU".str_pad($id, 5, "0", STR_PAD_LEFT)."-". str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
