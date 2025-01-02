<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleMapping extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_role';

    // Fillable fields
    protected $fillable = ['user_id', 'user_role_id'];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class, 'user_role_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
