<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fixture;
use App\Models\Team;

class MatchController extends Controller
{
    public function playSelectedWeek($weekNumber = null) 
    {
        if (empty($weekNumber)){
            $weekNumber = Fixture::where('is_played',0)->min('week_number');
        }

        $matches = Fixture::where('is_played',0)->where('week_number',$weekNumber)->get();

        $results = [];
        $tempResults = [];

        foreach ($matches as $match){

            $homeTeamTotalPower = 0;
            $awayTeamTotalPower = 0;
            $homeTeamAttackPower = 0;
            $homeTeamDefencePower = 0;
            $awayTeamAttackPower = 0;
            $awayTeamDefencePower = 0;

            $homeTeam = Team::where('id', $match->home_team_id)->first();
            $awayTeam = Team::where('id', $match->away_team_id)->first();

            // calculate the total power of the teams
            $homeTeamTotalPower = $homeTeam->gk_ability + $homeTeam->defence_ability + $homeTeam->midfield_ability + $homeTeam->forward_ability;
            $awayTeamTotalPower = $awayTeam->gk_ability + $awayTeam->defence_ability + $awayTeam->midfield_ability + $awayTeam->forward_ability;

            // calculate home team attack and defence powers
            $homeTeamAttackPower = ($homeTeam->forward_ability + $homeTeam->midfield_ability * 0.7 + $homeTeam->defence_ability * 0.3) + $homeTeam->supporter_strenght * 0.05 + $homeTeam->home_power * 0.05;
            $homeTeamDefencePower = ($homeTeam->gk_ability + $homeTeam->defence_ability * 0.4 + $homeTeam->midfield_ability * 0.2 + $homeTeam->forward_ability * 0.1);


            // calculate away team attack and defence powers
            $awayTeamAttackPower = ($awayTeam->forward_ability + $awayTeam->midfield_ability * 0.7 + $awayTeam->defence_ability * 0.3);
            $awayTeamDefencePower = ($awayTeam->gk_ability + $awayTeam->defence_ability * 0.4 + $awayTeam->midfield_ability * 0.2 + $awayTeam->forward_ability * 0.1);


            $homeTeamScore = ($homeTeamAttackPower - $awayTeamDefencePower) / 16;
            $homeTeamScore < 0 ? $homeTeamScore = 0 : $homeTeamScore = round($homeTeamScore);

            $awayTeamScore = ($awayTeamAttackPower - $homeTeamDefencePower) / 16;
            $awayTeamScore < 0 ? $awayTeamScore = 0 : $awayTeamScore = round($awayTeamScore);

            if ($homeTeamScore == $awayTeamScore){
                $homeTeamPoint = 1;
                $awayTeamPoint = 1;
                $winnerId = 0;
            } else if($homeTeamScore > $awayTeamScore){
                $homeTeamPoint = 3;
                $awayTeamPoint = 0;
                $winnerId = $match->home_team_id;
            } else if($homeTeamScore < $awayTeamScore){
                $homeTeamPoint = 0;
                $awayTeamPoint = 3;
                $winnerId = $match->away_team_id;
            } else {
                //
            }

            $update = Fixture::where('id',$match->id)->update([
                'home_team_score'=>$homeTeamScore, 
                'away_team_score'=>$awayTeamScore,
                'home_team_point'=>$homeTeamPoint,
                'away_team_point'=>$awayTeamPoint,
                'winner_id'=>$winnerId,
                'is_played' => 1
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function playAllWeeks() 
    {
        $weekCount = Fixture::max('week_number');
        $currentWeek = Fixture::where('is_played',0)->min('week_number');

        for ($i=$currentWeek; $i<$weekCount+1; $i++){
            $this->playSelectedWeek($i);
        }

        return response()->json(['status' => 'success']);
    }

    public function resetData()
    {
        $fixtures = Fixture::truncate();

        if ($fixtures){
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }
}
