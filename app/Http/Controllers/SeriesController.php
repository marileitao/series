<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Series;
use App\Mail\SeriesCreated;
use Illuminate\Http\Request;
use App\Jobs\DeleteSeriesCover;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\Autenticador;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;
use App\Events\SeriesCreated as SeriesCreatedEvent;


class SeriesController extends Controller
{
    
    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth')->except('index');
    }

    
    //action metodo de um controller
    public function index(Request $request){

        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, SeriesRepository $repository)
    {
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover', 'public')
            : null;
        $request->coverPath = $coverPath;
        $serie = $this->repository->add($request);

        SeriesCreatedEvent::dispatch(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason,
        );
        // event($seriesCreatedEvent);
        // SeriesCreatedEvent::dispatch();

        return redirect()->route('series.index')->with('mensagem.sucesso' ,"Serie '{$serie->nome}' adicionada com sucesso!");
        // return to_route('series.index'); não funcionou

    }

    public function destroy(Series $series)// mesma coisa de $serie = Series::find($request->series);
    {
        // dd($request->serie);

        $series->delete();

        // flash = esquece a mensagem após atualizar a página
        // $request->session()->flash('mensagem.sucesso', "Serie '{$series->nome}' removida com sucesso!");

        return redirect()->route('series.index')->with('mensagem.sucesso', "Serie '{$series->nome}' removida com sucesso!");
    }
    
    public function edit(Series $series)
    {
        // dd($series);
        return view('series.edit')->with('serie', $series);
    }
    
    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return redirect()->route('series.index')->with('mensagem.sucesso', "Serie '{$series->nome}' atualizada com sucesso!");
    }
}
