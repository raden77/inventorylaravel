<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\product;

class productPrice extends Model
{
    use HasFactory;

    protected $table = 'productprices';

    protected $primaryKey = 'productPriceId';

    protected $fillable = [
            'productId',
            'price'
    ];

    public function product(): HasOne
    {
        return $this->hasOne(product::class,'productPriceId');
    }
}
