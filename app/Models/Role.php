<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    

    // Fillable fields
    protected $fillable = ['name'];

    // Relationships
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'user_roles_id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany(UserRoleMapping::class, 'user_roles_id');
    }

}
