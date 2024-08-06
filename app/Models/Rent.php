<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $table = 'rents';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function return_product()
    {
        return $this->hasOne(Pengembalian::class, 'rents_id', 'id');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'rents_id', 'id');
    }
}
