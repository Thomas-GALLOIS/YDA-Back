<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $guarded = ['id'];

    public function service()
    {

        return $this->belongsTo(Service::class, 'service_id');
    }

    public function odetails()
    {

        return $this->hasMany(Odetail::class, 'product_id');
    }
}
