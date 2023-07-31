<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\subMenu;

class menus extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $primaryKey = 'menuId';

    protected $fillable = [
            'menuIcon',
            'menuName',
    ];

    public function submenus():HasMany
    {
        return $this->hasMany(subMenu::class,'menuId');
    }
}
