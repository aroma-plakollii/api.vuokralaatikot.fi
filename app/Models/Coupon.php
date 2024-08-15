<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'quantity',
        'code',
        'price',
        'available_at',
        'used',
        'status',
        'is_percentage',
        'is_unlimited'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function checkAndUpdateStatus()
    {
        $usedCodes = explode(',', $this->used);
        $allCodes = explode(',', rtrim($this->code, ',')); // remove the last comma from the string

        if (count($usedCodes) >= count($allCodes)) { // use greater than or equal to operator
            $this->status = false;
        } else {
            $this->status = true;
        }

        $this->save();
    }
}