<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\purchase;
class suppliers extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $primaryKey = 'supplierId';

    protected $fillable = ['supplierName','address'];

    public function product(): HasMany
    {
        return $this->hasMany(purchase::class,'supplierId');
    }
}
