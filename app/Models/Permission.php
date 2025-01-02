<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Table name (optional if the table name matches the pluralized model name)
    protected $table = 'permissions';

    // Fillable fields
    protected $fillable = ['name'];

    // Relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'user_role_id');
    }
}
