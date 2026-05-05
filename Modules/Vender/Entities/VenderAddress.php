<?php

namespace Modules\Vender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VenderAddress extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getStatusAttribute($value)
{
    if ($value === 'Active') {
        return 'Todo';
    }

    return $value;
}
}
