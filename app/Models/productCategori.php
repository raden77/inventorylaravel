<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\product;

class productCategori extends Model
{
    use HasFactory;

    protected $table = 'productcategoris';

    protected $primaryKey = 'productCategoriId';

    protected $fillable = ['categori'];

    public function product(): HasMany
    {
        return $this->hasMany(product::class,'productCategoriId');
    }
}
