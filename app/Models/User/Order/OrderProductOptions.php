<?php

namespace App\Models\User\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductOptions extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_product_id','option_id'
    ];
}
