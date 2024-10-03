<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Season;

class EpisodesController
{
    public function index(Season $season)
    {
        return view('episodes.index', [
            'episodes' => $season->episodes,
            'mensagemSucesso' => session('mensagem.sucesso')
        ]);
    }


    public function update(Request $request, Season $season)
    {
        $watchedEpisodes = $request->episodes;
        $season->episodes->each(function (Episode $episode) use ($watchedEpisodes){
            $episode->watched = in_array($episode->id, $watchedEpisodes);
        });
        //salvando as alterações e seus relacionamentos (season e episodes)
        $season->push();

        // Essa bct não funciona
        // return to_route('episodes.index', $season->id);
        
        return redirect()->route('episodes.index', $season->id)->with('mensagem.sucesso', 'Episódios marcados como assistidos');

    }
}