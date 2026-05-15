<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description'];

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
