<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\purchase;
use App\Models\product;
use App\Models\unit;

class purchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchasedetails';

    protected $primaryKey = 'purchaseDetailId';

    protected $fillable = ['purchaseId','productId','unitId','prices','qty'];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(purchase::class,'purchaseId');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(product::class,'productId');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(unit::class,'unitId');
    }
}
