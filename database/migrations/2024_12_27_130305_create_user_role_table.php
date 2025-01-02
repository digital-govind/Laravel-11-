<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->foreignId('role_id')->nullable()->constrained('user_roles')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->unique(); // Permission name (e.g., edit-posts)
            $table->string('description')->nullable(); // Description of the permission
            $table->timestamps();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_role_id')->constrained('user_roles')->onDelete('cascade'); // Foreign key to user_roles
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade'); // Foreign key to permissions
            $table->timestamps();

            $table->unique(['user_role_id', 'permission_id']); // Ensure unique combinations of role and permission
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('user_role_id')->constrained('user_roles')->onDelete('cascade'); // Foreign key to user_roles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('user_roles');
    }
};
