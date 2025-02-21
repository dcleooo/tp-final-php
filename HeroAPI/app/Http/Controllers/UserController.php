<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all()->makeHidden(["Email","Password"]));
    }

    public function modify(Request $request)
    {
        if (!User::where("UserId",$request->UserId)->exists())
        {
            return response()->json([
                "message" => "User not found"
            ],404);
        } else {
            $user = User::find($request->UserId);
            $user->Name = is_null($request->Name) ? $user->Name : $request->Name;
            $user->FirstName = is_null($request->FirstName) ? $user->FirstName : $request->FirstName;
            $user->save();
            return response()->json([
                "message" => "User updated"
            ],200);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            "Name" => "required",
            "FirstName" => "required",
            "Email" => "required",
            "Password" => "required"
        ]);

        if (User::where("Email",$request->Email)->exists()) {
            return response()->json([
                "message" => "Email already in use"
            ],400);
        }
        $user = User::create([
            "Name" => $request->Name,
            "FirstName" => $request->FirstName,
            "Email" => $request->Email,
            "Password" => password_hash($request->Password,PASSWORD_DEFAULT)
        ]);

        return response()->json($user->makeHidden(["Email","Password"]), 201);
    }

    public function connection(Request $request)
    {
        $request->validate([
            "Email" => "required",
            "Password" => "required"
        ]);

        if (!User::where("Email",$request->Email)->exists()) {
            return response()->json([
                "message" => "User not found"
            ],404);
        }

        $user = User::where("Email",$request->Email)->first();
        if (!password_verify($request->Password, $user->Password)) {
            return response()->json([
                "message" => "Password Incorect",
                "check" => "false"
            ], 401);
        } else {
            return response()->json([
                "UserId" => $user->UserId,
                "message" => "User Connected",
                "check" => "true"
            ],202);
        }
    }

    public function destroy($id)
    {
        if (User::where("UserId",$id)->exists())
        {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                "message" => "user deleted"
            ],202);
        } else {
            return response()->json([
                "message" => "User not found"
            ],404);
        }
    }
}
