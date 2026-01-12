<?php

namespace Modules\Vender\Entities;

use App\Models\Log;
use App\Models\User;
use Modules\Admin\Entities\Services;
use Illuminate\Database\Eloquent\Model;
use Modules\Vender\Entities\TradingName;
use Modules\Vender\Entities\TradingUnit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get the user that owns the Quotation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**************** vehicle ************************/

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    /**************** Contact Detail ************************/

    public function contact_detail(): BelongsTo
    {
        return $this->belongsTo(ContactDetail::class, 'contact_detail_id', 'id');
    }
    /**************** Service ************************/

    public function service(): BelongsTo
    {
        return $this->belongsTo(Services::class, 'service_id', 'id');
    }

    public function work_stream(): BelongsTo
    {
        return $this->belongsTo(WorkStream::class, 'workstream_id', 'id');
    }

    /**************** Job Request ************************/

    /**
     * Get all of the comments for the Quotation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_requests(): HasMany
    {
        return $this->hasMany(BookingJobRequest::class, 'booking_id', 'id');
    }

    /**************** Quotation Item ************************/

    /**
     * Get all of the comments for the Quotation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function booking_items(): HasMany
    {
        return $this->hasMany(BookingJobItem::class, 'booking_id', 'id');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class, 'booking_id', 'id');
    }


    /**
     * Get the user associated with the Booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'booking_id', 'id')->orderBy('id','desc');
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'booking_id', 'id')->orderBy('id','desc');
    }
    public function job_invoices()
    {
        return $this->hasMany(Invoice::class, 'booking_id', 'id')->where('status','!=','REJECTED');
    }


    /**
     * Get the user that owns the Booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vender_id', 'id');
    }

    public function trading_name(): BelongsTo
    {
        return $this->belongsTo(TradingUnit::class, 'trading_id', 'id');
    }


    // protected function firstName(): Attribute
    // {
    //     return
    // }

    public function getStatusAttribute($value)
    {
        if($value=="READ_FOR_COLLECTION"){

            return 'READY_FOR_COLLECTION' ;
        }else{
            return $value;
        }
    }
    public function job_logs(): HasMany
    {
        return $this->hasMany(Log::class, 'type_id', 'id')->whereIn('type',['Book','Job']);
    }
    public function getServiceTypeAttribute($value)
    {
        if($value=="On-Premises"){
            return 'On-site';
        }
        return ucfirst($value);
    }

     protected $appends = ['booking_no','job_no']; // Optional: include in JSON
    //  protected $appends = ['job_no'];

    public function getBookingNoAttribute($value)
    {
        // You can use any attribute from the model
        $id = $this->trading_id;
        $prefix = 'TRU';

        return 'BKG-'."TRU".str_pad($id, 5, "0", STR_PAD_LEFT)."-". str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
     // Optional: include in JSON

    public function getJobNoAttribute($value)
    {
        // You can use any attribute from the model
        if($this->job_id!=0){


        $id = $this->trading_id;
        $prefix = 'TRU';

        return 'JOB-'."TRU".str_pad($id, 5, "0", STR_PAD_LEFT)."-". str_pad($this->job_id, 5, "0", STR_PAD_LEFT);
        }
        else{
            return null;
        }
    }
}
