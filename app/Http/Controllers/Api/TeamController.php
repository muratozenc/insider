<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderby('id', 'desc')->get();

        foreach ($teams as $team){
            $team->nationality_name = $team->nationality->name;
        }

        return response()->json($teams);
    }

    public function store(Request $request)
    {

        $team = Team::create($request->all());

        return response()->json([
            'status' => 'success',
            'team'   => $team
        ]);
    }

    public function show($id)
    {
        $team = Team::find($id);

        return response()->json($team);
    }

    public function update(Request $request, $id)
    {
        $team = Team::find($id);
        $team->update($request->all());

        return response()->json([
            'status' => 'success',
            'post'   => $team
        ]);
    }

    public function destroy($id)
     {
         $team = Team::find($id);
         $team->delete();

         return response()->json('Team successfully deleted!');
     }
}