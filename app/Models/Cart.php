<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relasi dengan model User (pengguna)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Product (produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
