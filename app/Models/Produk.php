<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'nama',
        'stok',
        'harga',
        'status',
        'jenis_id',
        'created_by',
    ];

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
