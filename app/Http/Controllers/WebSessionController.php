<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class WebSessionController extends Controller
{
    public function changeRoleActive(Request $request)
    {
        $role_active = $request->role_active;
        
        if (Auth::changeRoleActive($role_active)) {
            return response()->json([
                'message' => 'Berhasil mengubah peran aktif',
                'code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Cannot change role active',
                'code' => 403
            ], 403);
        }
    }
}
