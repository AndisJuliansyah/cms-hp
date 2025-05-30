<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'group',
    ];

    public function permissions()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Permission::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
