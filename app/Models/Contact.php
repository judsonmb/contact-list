<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_code',
        'state',
        'city',
        'district',
        'address',
        'number',
        'name',
        'email',
        'phone',
    ];
}
