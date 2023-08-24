<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailProdukMasuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = 
    [
        'jumlah',
        'satuan',
        'harga_satuan',
        'prod_masuk_id',
        'produk_id'
    ];

    public function produk(): belongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(ProdukMasuk::class, 'prod_masuk_id');
    }
}
