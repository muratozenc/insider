<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "nationality_id",
        "gk_ability",
        "defence_ability",
        "midfield_ability",
        "forward_ability",
        "supporter_strenght",
        "home_power",
        "selected"
    ];

    public function nationality()
    {
        return $this->belongsTo(Nation::class, 'nationality_id');
    }

    public function fixture()
    {
        return $this->hasMany(Fixture::class, 'id');
    }

}
