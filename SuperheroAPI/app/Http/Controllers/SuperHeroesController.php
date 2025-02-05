<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperHeroesController extends Controller
{
    public function index()
    {
        $books = User::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $books = new User();
        $books->firstname = $request->firstname;
        $books->email = $request->email;
        $books->password = bcrypt($request->password);
        $books->lastname = $request->lastname;
        $books->save();
        return response()->json([
            "message" => "User added !"
            ], 201);
    }

    public function show($id)
    {
        $book = User::find($id);
        if(empty($book))
        {
            return response()->json($book);
        }
        else
        {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if (User::where("id", $id)->exists()) {
            $book = User::find($id);
            $book->firstname = is_null($request->firstname) ? $book->firstname : $request->firstname;
            $book ->lastname = is_null($request->lastname) ? $book->lastname : $request->lastname;
            $book->email = $request->email;
            $book->password = bcrypt($request->password);
            $book->save();
                return response()->json([
                    "message" => "User updated"
                    ],404);
        } else {
            return response()->json([
                "message" => "User not found"
                ],404);
        }
    }

    public function destroy($id)
    {
        if(User::where("id", $id)->exists()) {
            $book = User::find($id);
            $book->delete();

            return response()->json([
                "message" => "records deleted"
                ],202);
        }else{
            return response()->json([
                "message" => "User not found"
                ],404);
        }
    }
}
