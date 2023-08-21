<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\inbound;
use App\Models\product;
use App\Models\unit;

class inboundetail extends Model
{
    use HasFactory;

    protected $table = 'inboundetails';

    protected $primaryKey = 'inboundDetailId';

    protected $fillable = ['inboundId','productId','unitId','prices','qty'];

    public function inbound(): BelongsTo
    {
        return $this->belongsTo(inbound::class,'inboundId');
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
