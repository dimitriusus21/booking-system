<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Константы для удобства
    const ADMIN = 1;
    const ORGANIZATION = 2;
    const CLIENT = 3;
}
