<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'full_name', 
        'deliver_address', 
        'total_price', 
        'transaction_date',
        'status'
    ];

    protected $attributes = [
        'status' => 'process', // Default status 'process'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Fungsi untuk mendapatkan nilai ENUM status
    public static function getStatusValues()
    {
        $type = DB::select("SHOW COLUMNS FROM `transactions` WHERE Field = 'status'")[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
        return $enum;
    }
}
