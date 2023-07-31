<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\unit;

class unitConversion extends Model
{
    use HasFactory;

    protected $table = 'unitconversions';

    protected $primaryKey = 'unitConversionId';

    protected $fillable = ['fromUnit,toUnit,ratio'];

    public function fromUnit()
    {
        return $this->belongsTo(unit::class, 'fromUnit', 'unitId');
    }

    public function toUnit()
    {
        return $this->belongsTo(unit::class, 'toUnit', 'unitId');
    }
}
