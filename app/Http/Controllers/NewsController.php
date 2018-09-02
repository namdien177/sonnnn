<?php

namespace App\Http\Controllers;

use App\comments;
use App\Map;
use App\Match;
use App\MatchTeam;
use App\News;
use App\NewsContent;
use App\Player;
use App\Team;
use App\mapsBombsite;
use App\mapsSpawn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return News[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function indexNews()
    {
        $news = News::with('NewsContent')->with('comments')->get();
        return $news;
    }

    public function indexMaps(){
        $maps = Map::with('mapsBombsite')->with('mapsSpawn')->get();
        return $maps;
    }

    public function indexPlayers(Request $request){
        $strsearch = $request->input('name');
        if ($strsearch != null && strlen($strsearch) >2){
            return $this->showPlayerWithName($strsearch);
        }
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
    public function storeNews(Request $request)
    {
        $title = $request->input('title');
        $contents = $request->input('contents');
        $IDuser = $request->input('idUser');

        if ($title == null || $contents == null || $IDuser == null){
            return Response()->json([
                'boolean'=>false,
                'message'=>'Some of required fields is empty'
            ]);
        }

        $news = new News;
        $news->title = $title;
        $news->idUser = $IDuser;
        $news->save();
        $idNews = $news->id;

        foreach ($contents as $content){
            $cont = new NewsContent;
            $cont->idNews = $idNews;
            $cont->content = $content['content'];
            if ($content['img'] != null){
                $cont->img = $content['img'];
            }
            $cont->save();
        }
        return Response()->json([
            'boolean'=>true,
            'message'=>'Your content is uploaded successfully'
        ]);
    }

    public function storeNewsComment(Request $request){
        $email = $request->input('email');
        $idNews = $request->input('idNews');
        $comment = $request->input('comment');

        if ($email == null || $idNews == null || $comment == null){
            return Response()->json([
                'boolean'=>false,
                'message'=>'Comment cannot be posted!!!!!!!!!!'
            ]);
        }

        $comm = new comments;
        $comm->email = $email;
        $comm->idNews = $idNews;
        $comm->comment = $comment;

        if ($comm->save()){
            return Response()->json([
                'boolean'=>true,
                'message'=>'Comment was posted successfully'
            ]);
        }

        return Response()->json([
            'boolean'=>false,
            'message'=>'Comment cannot be posted!'
        ]);

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
            $teamMatch = Match::whereHas('MatchTeam', function ($query) use ($id){
                $query->where('idTeam','=',$id);
            })->with('MatchTeam')->get();
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
    public function showPlayerWithName($search){
        $result = null;
        if ($search != null && strlen(trim($search)) >1){
            $result = Player::with('Team')->where('name','like','%'.trim($search).'%')
                ->orWhere('real_name','=','%'.trim($search).'%')->get();
            return $result;
        }
        return $result;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNews(Request $request)
    {
        $idnews = $request->input('idNews');
        $title = $request->input('title');
        $contents = $request->input('contents');

        if ($idnews == null || $title == null || $contents == null || !is_array($contents)){
            return Response()->json([
                'boolean'=>false,
                'message'=>'Update news failed, some of required content cannot be found'
            ]);
        }
        $findNewsUpdate = News::find($idnews);

        if ($findNewsUpdate == null ){
            return Response()->json([
                'boolean'=>false,
                'message'=>'Update news failed, that news doesn\'t exist'
            ]);
        }

        $findNewsUpdate->title = $title;
        $findNewsUpdate->save();

        foreach ($contents as $content)
        {
            if (is_string($content['content'])){
                $cont = NewsContent::where('idNews','=', $idnews)->where('id','=', $content['id'])->first();
                if ($cont == null) continue;
                if ( strlen($content['content']) == 0 && ($content['img'] == null || strlen($content['img']) == 0) ){
                    $cont->delete();
                }
                else{
                    $cont->content = $content['content'];
                    $cont->img = $content['img'];
                    $cont->save();
                }
            }
        }
        return Response()->json([
            'boolean'=>true,
            'message'=>'Update news succeed'
        ]);
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
