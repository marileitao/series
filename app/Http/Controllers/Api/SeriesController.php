<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;


class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {

    }

    public function index(Request $request)
    {
        $query = Series::query();
        if ($request->has('nome')){
            $query->where('nome', $request->nome);
        }

        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request)
    {
        // $this->seriesRepository->add($request)
        // $serie = Series::create($request->all());
        return response()->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $series) // recebendo o id da série
    // public function show(Series $series)
    {
        // usando o first pois o where me retorna um array de um só elemento.
        // $series = Series::whereId($series)->with('seasons.episodes')->first();
        
        $seriesModel = Series::with('seasons.episodes')->find($series);
        if($seriesModel === null){
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request)
    // public function update(int $series, SeriesFormRequest $request)
    {
        Series::where(‘id’, $series)->update($request->all());
        // retorno de uma resposta que não contenha a série, já que não fizemos um `SELECT` 
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series)
    {
        Series::destroy($series);
        return response()->noContent();
    }
}