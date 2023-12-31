<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [

        'name', 'price','product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
