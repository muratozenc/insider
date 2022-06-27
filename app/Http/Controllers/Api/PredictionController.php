<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Fixture;

class PredictionController extends Controller
{
    public function index()
    {
        $teams = Team::where('selected',1)->get();
        $fixtures = Fixture::where('is_played',1)->get();

        $weekCount = Fixture::max('week_number');
        $currentWeek = Fixture::where('is_played',0)->min('week_number');
        $leftWeek = $weekCount - $currentWeek;

        $predictions = [];

        $point = 0;
        $played = 0;
        $totalDivider = 0;
        $overAllPredict = 0;
        $predict = 0;

        foreach ($teams as $team){
            foreach ($fixtures as $fixture){
                // At home check
                if ($fixture->home_team_id == $team->id){

                    $point += $fixture->home_team_point;
                    $played++;
                }

                // At away check
                if ($fixture->away_team_id == $team->id){

                    $point += $fixture->away_team_point;
                    $played++;
                }
            }

            //$predict = $point/$played;
            //$totalDivider += $predict;

            array_push($predictions,[
                "id"=>$team->id,
                "name"=>$team->name,
                "played"=>$played,
                "points"=>$point
            ]);

            //dump($predictions);

            $point = 0;
            $played = 0;
        }

        //dump($predictions);

        $biggestPoint = null;
        $biggestPointId = null;

        $secondBiggestPoint = null;
        $secondBiggestPointId = null;

        for ($i=0; $i< count($predictions); $i++){
            $overAllPredict += $predictions[$i]["points"] / $predictions[$i]["played"];

            // find two biggest points

            if (empty($biggestPoint)){
                $biggestPoint = $predictions[$i]["points"];
                $biggestPointId = $predictions[$i]["id"];
            } else {
                if($predictions[$i]["points"] > $biggestPoint){
                    $secondBiggestPoint = $biggestPoint;
                    $secondBiggestPointId = $biggestPointId;
    
                    $biggestPoint = $predictions[$i]["points"];
                    $biggestPointId = $predictions[$i]["id"];
                }
            }
        }

        // $carpim = $leftWeek * 3 + $secondBiggestPoint;

        // dump('Current Week:'.$weekCount);
        // dump('Current Week:'.$currentWeek);
        // dump('Left Week :'.$leftWeek);
        // dump('Çarpım : '.$carpim);
        // dump('Biggest point : '.$biggestPoint);

        if ($currentWeek >4  && ($biggestPoint-$secondBiggestPoint >= 9)){
            for ($i=0; $i< count($predictions); $i++){
                if ($predictions[$i]["id"] == $biggestPointId){
                    $predictions[$i]["predict"] = 100;
                } else {
                    $predictions[$i]["predict"] = 0;
                }
            }
        } else {
            for ($i=0; $i< count($predictions); $i++){
                $predictions[$i]["predict"]= number_format($predictions[$i]["points"] / $predictions[$i]["played"] / $overAllPredict,2)*100;
            }
        }

    
        // dump($biggestPoint);
        // dump($biggestPointId);

        // dump($secondBiggestPoint);
        // dump($secondBiggestPointId);
        

        return response()->json([
            'status' => 'success',
            'predictions' => $predictions
        ]);
    }
}
