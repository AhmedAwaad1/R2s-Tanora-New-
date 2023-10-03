<?php

namespace App\Models\User\Order;

use App\Models\Admin\Option;
use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'price', 'qty',
        'image', 'option', 'total_item_price', 'name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'options' => 'array'
    ];


    public function setImageAttribute($value)
    {
        $this->attributes['image'] = ($value) ? url('uploads' . ($value)) : url('/default.png');
    }


    public function orderProductOptions()
    {
        return $this->belongsToMany(Option::class, 'order_product_options');
    }
}
