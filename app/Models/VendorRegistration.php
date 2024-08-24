<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRegistration extends Model
{
    use HasFactory;
    
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'user_id',
        'business_license',
        'tax_id',
        'incorporation_certificate',
        'insurance_certificates',
        'business_logo',
        'premises_photo',
        'product_images',
        'status',
        'submitted_at',
    ];

    // If you want to cast dates to Carbon instances
    protected $dates = ['submitted_at'];
}

