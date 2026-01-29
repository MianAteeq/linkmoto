<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementAcceptance extends Model
{
    use HasFactory;
    protected $table = 'agreementag_acceptances';
    protected $guarded = [];
}
