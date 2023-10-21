<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','seller_id','number','total_price','payment_status','delivery_addres','payment_url'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function OrderItem():HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
