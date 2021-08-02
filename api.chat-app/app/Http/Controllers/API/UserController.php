<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return response()->json([
            'data' => $users
        ]);
    }

    public function show($id)
    {
         $current_user = User::find($id);

         return response()->json([
             'data' => $current_user
         ]);
    }
}
