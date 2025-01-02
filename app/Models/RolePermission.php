<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'role_permission';

    // Fillable fields
    protected $fillable = ['user_role_id', 'permission_id'];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class, 'user_role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
