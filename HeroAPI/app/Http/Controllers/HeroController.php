<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class HeroController extends Controller
{
    public function index()
    {
        return response()->json(
            Hero::all()->makeHidden(["UserId"]),
        );
    }

    public function show($id)
    {
        $hero = Hero::find($id);
        if (!empty($hero))
        {
            
            return response()->json($hero);
        }
        else
        {
            return response()->json([
                "message" => "Hero not found"
            ],404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required',
            'Sex' => 'required',
            'OriginPlanet' => 'required',
            'Description' => 'required',
            "UserId" => "required",
        ]);
    
        $hero = Hero::create([
            'Name' => $request->Name,
            'Sex' => $request->Sex,
            'OriginPlanet' => $request->OriginPlanet,
            'Description' => $request->Description,
            'Powers' => $request->Powers,
            'Town' => $request->Town,
            'Gadgets' => $request->Gadgets,
            'Team' => $request->Team,
            'Vehicule' => $request->Vehicule,
            "UserId" => $request->UserId
        ]);
    
        return response()->json($hero->makeHidden(["UserId"]), 201);  
    }

    public function update(Request $request)
    {
        if (!Hero::where("HeroId",$request->HeroId)->exists()) {
            return response()->json([
                "message" => "Hero not found"
            ],404);
        } else {
            $hero = Hero::find($request->HeroId);
            $hero->Name = is_null($request->Name) ? $hero-> Name : $request->Name;
            $hero->Sex = is_null($request->Sex) ? $hero->Sex : $request->Sex;
            $hero->OriginPlanet = is_null($request->OriginPlanet) ? $hero->OriginPlanet : $request->OriginPlanet;
            $hero->Description = is_null($request->Description) ? $hero->Description : $request->Description;
            $hero->Powers = is_null($request->Powers) ? $hero->Powers : $request->Powers;
            $hero->Town = is_null($request->Town) ? $hero->Town : $request->Town;
            $hero->Gadgets = is_null($request->Gadgets) ? $hero->Gadgets : $request->Gadgets;
            $hero->Team = is_null($request->Team) ? $hero->Team : $request->Team;
            $hero->Vehicule = is_null($request->Vehicule) ? $hero->Vehicule : $request->Vehicule;
            $hero->save();
            return response()->json([
                "message" => "Hero updated"
            ],200);
        }
    }

    public function destroy($id)
    {
        if (Hero::where("HeroId",$id)->exists()) {
            $hero = Hero::find($id);
            $hero->delete();
            return response()->json([
                "message" => "records deleted"
            ],202);
        } else {
            return response()->json([
                "message" => "Hero not found"
            ],404);
        }
    }
}

