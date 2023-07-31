<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\product;
use App\Models\unitConversion;

class unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    protected $primaryKey = 'unitId';

    protected $fillable = ['unitName'];

    public function product(): HasMany
    {
        return $this->hasMany(product::class,'unitId');
    }

    public function unitConversions():HasMany
    {
        return $this->hasMany(unitConversion::class, 'fromUnit', 'unitId');
    }

}
