<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Order extends Model
{
    use HasApiTokens;

    protected $guarded = [
        'id',
        'user_id'
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }


    public function odetails()
    {

        return $this->hasMany(Odetail::class);
    }
}
