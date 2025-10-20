<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{

    protected $fillable = [
    'receiver_address',
    'receiver_phone',
    'user_id',
    'product_id',
    'status',
    ];


    use HasFactory;
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

     public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }


}
