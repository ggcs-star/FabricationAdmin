<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'gst_number',
        'pan_number',
        'aadhaar_number',
        'address',
        'status',
        'approved_by',
        'approved_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}