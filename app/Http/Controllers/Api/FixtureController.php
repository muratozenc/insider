<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fixture;

class FixtureController extends Controller
{
    public function index()
    {
        $fixtures = Fixture::orderby('id', 'desc')->get();
        $weekCount = Fixture::max('week_number');
        $currentWeek = Fixture::where('is_played',0)->min('week_number');

        if (empty($currentWeek)){
            $currentWeek = 6;
        }

        $leftWeek = $weekCount - $currentWeek;

        foreach ($fixtures as $fixture){
            $fixture->home_team_name = $fixture->homeTeam->name;
            $fixture->away_team_name = $fixture->awayTeam->name;
            
            if ($fixture->winner_id == 0 || empty($fixture->winner_id)){
                $fixture->winner_team_name = "-";
            } else {
                $fixture->winner_team_name = $fixture->winnerTeam->name;
            }

            if ($fixture->is_played == 0){
                $fixture->played = "No";
            } else {
                $fixture->played = 'Yes';
            }
        }

        return response()->json(['fixtures'=>$fixtures, 'week_count'=>$weekCount, 'left_week'=>$leftWeek, 'current_week'=>$currentWeek]);
    }

    public function store(Request $request)
    {
        $teamIds = $request->all();

        $fixture = [
            ['home_team_id'=>$teamIds['first'], 'away_team_id'=> $teamIds['second'], 'week_number'=>1], ['home_team_id'=>$teamIds['third'], 'away_team_id'=> $teamIds['fourth'], 'week_number'=>1],
            ['home_team_id'=>$teamIds['third'], 'away_team_id'=> $teamIds['first'], 'week_number'=>2], ['home_team_id'=>$teamIds['fourth'], 'away_team_id'=> $teamIds['second'], 'week_number'=>2],
            ['home_team_id'=>$teamIds['first'], 'away_team_id'=> $teamIds['fourth'], 'week_number'=>3], ['home_team_id'=>$teamIds['second'], 'away_team_id'=> $teamIds['third'], 'week_number'=>3],
            ['home_team_id'=>$teamIds['second'], 'away_team_id'=> $teamIds['first'], 'week_number'=>4], ['home_team_id'=>$teamIds['fourth'], 'away_team_id'=> $teamIds['third'], 'week_number'=>4],
            ['home_team_id'=>$teamIds['first'], 'away_team_id'=> $teamIds['third'], 'week_number'=>5], ['home_team_id'=>$teamIds['second'], 'away_team_id'=> $teamIds['fourth'], 'week_number'=>5],
            ['home_team_id'=>$teamIds['fourth'], 'away_team_id'=> $teamIds['first'], 'week_number'=>6], ['home_team_id'=>$teamIds['third'], 'away_team_id'=> $teamIds['second'], 'week_number'=>6]
        ];

        // /* Code below is working but commented because it generates team pairing not the same what you gave! */

        // $teams = [];
        // $matches = [];
        // $fixture = [];

        // foreach ($teamIds as $teamId){
        //     array_push($teams, $teamId);
        // }

        // foreach($teams as $team1){
        //     foreach($teams as $team2){
        //         if($team1 !== $team2){
        //             if (!in_array([$team2, $team1],$matches)){
        //                 array_push($matches, [$team1, $team2]);
        //             }
        //         }
        //     }
        // }

        // foreach ($matches as $match1){
        //     $i=1;
        //     foreach ($matches as $match2){
        //         if($match1 !== $match2){
        //             if (!in_array($match1[0],$match2) && !in_array($match1[1],$match2)){
        //                 if (!in_array([[$match1[0],$match1[1]], $match2],$fixture) && !in_array([[$match1[1],$match1[0]], $match2],$fixture)){
        //                     array_push($fixture,['home_team_id'=>$match1[1], 'away_team_id'=> $match1[0], 'week_number'=>$i], ['home_team_id'=>$match2[0], 'away_team_id'=> $match2[1], 'week_number'=>$i]);
        //                 }
        //             }
        //         }
        //         $i++;
        //     }
        // }

        $fixture = Fixture::insert($fixture);
        
        return response()->json([
            'status' => 'success',
            'fixture'   => $fixture
        ]);
        
    }

    public function show($id)
    {
        $fixture = Fixture::find($id);

        return response()->json($fixture);
    }

    public function update(Request $request, $id)
    {

        $fixtureUpdateData = $request->all();

        if ($fixtureUpdateData['home_team_score'] == $fixtureUpdateData['away_team_score'] ){

            $fixtureUpdateData['home_team_point'] = 1;
            $fixtureUpdateData['away_team_point'] = 1;
            $fixtureUpdateData['winner_id'] = 0;

        } else if ($fixtureUpdateData['home_team_score'] > $fixtureUpdateData['away_team_score'] ){

            $fixtureUpdateData['home_team_point'] = 3;
            $fixtureUpdateData['away_team_point'] = 0;
            $fixtureUpdateData['winner_id'] = $fixtureUpdateData['home_team_id'];

        } else if ($fixtureUpdateData['home_team_score'] < $fixtureUpdateData['away_team_score'] ){

            $fixtureUpdateData['home_team_point'] = 0;
            $fixtureUpdateData['away_team_point'] = 3;
            $fixtureUpdateData['winner_id'] = $fixtureUpdateData['away_team_id'];

        }

        $test = $fixtureUpdateData;

        $fixture = Fixture::find($id)->update($test);

        return response()->json([
            'status' => 'success',
            'post'   => $fixture
        ]);
    }

    public function destroy($id)
     {
         $fixture = Fixture::find($id);
         $fixture->delete();

         return response()->json('Fixture successfully deleted!');
     }
}