<?php

namespace App\Models\User\Order;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'user_id', 'name', 'address',
        'lat', 'lng', 'date', 'time', 'status',
        'total_price', 'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class)
            ->with('orderProductOptions');
    }
}
