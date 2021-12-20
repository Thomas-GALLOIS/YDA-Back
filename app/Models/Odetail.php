<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Odetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function order()
    {

        return $this->belongsTo(Order::class);
    }

    public function product()
    {

        return $this->hasOne(Product::class);
    }
}
