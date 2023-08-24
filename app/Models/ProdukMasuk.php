<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukMasuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = 
    [
        'nota',
        'suppliers_id',
        'subtotal',
        'created_by',
        'tanggal_masuk'
    ];

    public function detail(): HasMany
    {
        return $this->hasMany(DetailProdukMasuk::class, 'prod_masuk_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class, 'suppliers_id');
    }
}
