<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\MessageResponse;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone_number',
        'customer_id',
        'code'
    ];

    public function responses()
    {
        return $this->hasMany(MessageResponse::class, 'customer_id', 'customer_id');
    }

}
