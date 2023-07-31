<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\menus;
use App\Models\userMenu;
class subMenu extends Model
{
    use HasFactory;

    protected $table = 'subMenus';

    protected $primaryKey = 'subMenusId';

    protected $fillable = [
            'subMenuIcon',
            'subMenuName',
            'subMenuUrl',
            'menuId'
    ];

    public function menus(): BelongsTo
    {
        return $this->belongsTo(menus::class,'menuId');
    }

    public function userMenu(): HasMany
    {
        return $this->hasMany(userMenu::class,'subMenusId');
    }
}
