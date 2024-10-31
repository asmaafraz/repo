<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $newuser = $request->input('name');

        $filePath = storage_path('app/users.txt');

        if (File::exists($filePath)) {
            $existingUsers = File::get($filePath);
            $existingUsers = explode("\n", trim($existingUsers));

            if (in_array($newuser, $existingUsers)) {
                return response()->json(['message' => 'User already exists'], 400);
            }

            File::append($filePath, $newuser . "\n");
            return response()->json(['message' => 'User added successfully']);
        } else {
            return response()->json(['message' => 'User file not found'], 404);
        }
    }
}
