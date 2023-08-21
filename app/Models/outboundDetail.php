<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\outbound;
use App\Models\product;
use App\Models\unit;

class outboundDetail extends Model
{
    use HasFactory;

    protected $table = 'outboundetails';

    protected $primaryKey = 'outboundDetailId';

    protected $fillable = ['outboundId','productId','unitId','prices','qty'];

    public function inbound(): BelongsTo
    {
        return $this->belongsTo(inbound::class,'outboundId');
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
