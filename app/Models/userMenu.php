<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\subMenu;

class userMenu extends Model
{
    use HasFactory;

    protected $table = 'userMenu';

    protected $primaryKey = 'userMenuId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'subMenusId'
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'id');
    }

    public function subMenu(): BelongsTo
    {
        return $this->belongsTo(subMenu::class,'subMenusId');
    }
}
