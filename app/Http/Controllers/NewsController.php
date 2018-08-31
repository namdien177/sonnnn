<?php

namespace App\Http\Controllers;

use App\Map;
use App\Match;
use App\MatchTeam;
use App\News;
use App\Player;
use App\Team;
use App\mapsBombsite;
use App\mapsSpawn;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return News[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function indexNews()
    {
        $news = News::with('NewsContent')->get();
        return $news;
    }

    public function indexMaps(){
        $maps = Map::with('mapsBombsite')->with('mapsSpawn')->get();
        return $maps;
    }

    public function indexPlayers(){
        $players = Player::with('Team')->get();
        return $players;
    }

    public function indexTeams(){
        $teams = Team::with('Player')->get();
        return $teams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Team|Team[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showTeam($id)
    {
        $team = [];
        if ($id != null && value($id)> 0)
        $team = Team::with('Player')->find($id);
        return $team;
    }

    public function showTeamLeader($id)
    {
        if ($id != null && value($id)> 0){
            $team = Team::find($id);
            if ($team != null) {
                foreach ($team->player as $player) {
                    if ($player->leader == 1) return $player;
                }
            }
        }
        return null;
    }

    public function showTeamMatches($id){
        if ($id != null && value($id)> 0){
            $teamMatch = Match::with('MatchTeam')->whereHas('MatchTeam', function ($query) use ($id){
                $query->find($id);
            });
            if ($teamMatch != null) {
                return $teamMatch;
            }
        }
        return [];
    }

    public function showPlayer($id)
    {
        $player = [];
        if ($id != null && value($id)> 0)
        $player = Player::with('Team')->find($id);
        return $player;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
