<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as StatusCodeResponse;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserRoleMapping;


class RoleController extends Controller
{
    public function roles(){
        try {
            $roles = Role::whereNull('role_id')->get();
    
            return response()->json([
                'success' => true,
                'data' => $roles
            ], StatusCodeResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve roles. Please try again.',
                'error' => $e->getMessage()
            ], StatusCodeResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }
}
