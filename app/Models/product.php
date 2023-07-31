<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\unit;
use App\Models\productCategori;
use App\Models\productPrice;

class product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'productId';

    protected $fillable = [
            'productName',
            'dimensions',
            'qty',
            'productCategoriId',
            'unitId'
    ];

    public function categori(): BelongsTo
    {
        return $this->belongsTo(productCategori::class,'productCategoriId');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(unit::class, 'unitId');
    }

    public function productPrice(): BelongsTo
    {
        return $this->belongsTo(productPrice::class, 'productPriceId');
    }
}
