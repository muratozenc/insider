<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fixture;
use App\Models\Team;

class StandingController extends Controller
{
    public function index()
    {
        $teams = Team::where('selected',1)->get();
        $fixtures = Fixture::where('is_played',1)->get();

        $teamStanding = [];

        $point = 0;
        $played = 0;
        $win = 0;
        $draw = 0;
        $lost = 0;
        $goal_difference = 0;

        foreach ($teams as $team){
            foreach ($fixtures as $fixture){
                // At home check
                if ($fixture->home_team_id == $team->id){

                    $point += $fixture->home_team_point;
                    $played++;

                    if ($fixture->winner_id == $team->id){
                        $win += 1;
                    } else if ($fixture->winner_id == 0){
                        $draw += 1;
                    } else {
                        $lost += 1;
                    }

                    $goal_difference += $fixture->home_team_score - $fixture->away_team_score;
                }

                // At away check
                if ($fixture->away_team_id == $team->id){

                    $point += $fixture->away_team_point;
                    $played++;

                    if ($fixture->winner_id == $team->id){
                        $win += 1;
                    } else if ($fixture->winner_id == 0){
                        $draw += 1;
                    } else {
                        $lost += 1;
                    }

                    $goal_difference += $fixture->away_team_score - $fixture->away_team_score;
                }

                
            }

            array_push($teamStanding,[
                "id"=>$team->id,
                "name"=>$team->name,
                "played"=>$played,
                "point"=>$point,
                "win"=>$win,
                'draw'=>$draw,
                'lost'=>$lost,
                'goal_difference'=>$goal_difference
            ]);

            $point = 0;
            $played = 0;
            $win = 0;
            $draw = 0;
            $lost = 0;
            $goal_difference = 0;
        }

        return response()->json([
            'status' => 'success',
            'standing' => $teamStanding
        ]);
    }

}