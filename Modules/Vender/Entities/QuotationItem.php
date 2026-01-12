<?php

namespace Modules\Vender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\Entities\JobType;
use Modules\Admin\Entities\PriceType;

class QuotationItem extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class, 'quotation_id', 'id');
    }

    /**************** job_type ************************/

    public function job_type(): BelongsTo
    {
        return $this->belongsTo(JobRequest::class, 'job_type_id', 'id');
    }
    /**************** job_type ************************/

    public function price_type(): BelongsTo
    {
        return $this->belongsTo(PriceType::class, 'price_type_id', 'id');
    }

    public function job_types(): HasMany
    {
        return $this->hasMany(QuotationJobItemJobType::class, 'job_item_id', 'id');
    }
    
      protected $appends = ['job_item_no']; // Optional: include in JSON

    public function getJobItemNoAttribute($value)
    {
        // You can use any attribute from the model
        $id = $this->quotation->trading_id;
        $prefix = 'TRU';

        return 'JIT-'."TRU".str_pad($id, 5, "0", STR_PAD_LEFT)."-". str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
