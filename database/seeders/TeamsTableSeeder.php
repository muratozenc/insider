<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('teams')->insert([
            ["name" => "Arsenal", "nationality_id" => "55", "gk_ability" => 85, "defence_ability" => 87, "midfield_ability" => 85, "forward_ability" => 90, "supporter_strenght" => 11, "home_power" => 10, "selected" => 1, "created_at" => "2022-06-25 18:07:05", "updated_at" => "2022-06-25 18:07:05"],
            ["name" => "Liverpool", "nationality_id" => "54", "gk_ability" => 84, "defence_ability" => 85, "midfield_ability" => 80, "forward_ability" => 85, "supporter_strenght" => 11, "home_power" => 10, "selected" => 1, "created_at" => "2022-06-25 18:07:21", "updated_at" => "2022-06-25 18:07:21"],
            ["name" => "Manchester City", "nationality_id" => "53", "gk_ability" => 75, "defence_ability" => 82, "midfield_ability" => 88, "forward_ability" => 85, "supporter_strenght" => 15, "home_power" => 12, "selected" => 1, "created_at" => "2022-06-25 18:07:35", "updated_at" => "2022-06-25 18:07:35"],
            ["name" => "Chelsea", "nationality_id" => "52", "gk_ability" => 90, "defence_ability" => 90, "midfield_ability" => 90, "forward_ability" => 90, "supporter_strenght" => 9, "home_power" => 20, "selected" => 1, "created_at" => "2022-06-25 18:07:50", "updated_at" => "2022-06-25 18:07:50"]
        ]);
    }
}
