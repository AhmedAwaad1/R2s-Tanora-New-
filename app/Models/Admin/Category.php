<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function getImageAttribute($value)
    {
        return url('uploads/' . $value);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value->store('Category');
    }
}


