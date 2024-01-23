<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault(); // Menggunakan withDefault() agar tidak menyebabkan kesalahan jika pelanggan tidak dipilih
    }

    public function holdItems()
    {
        return $this->hasMany(HoldItem::class);
    }
}
