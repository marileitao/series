
@component('mail::message')
    
# {{$nomeSerie}} curl_multi_add_handle

A série {{$nomeSerie}} com {{$qtdTemporadas}} temporadas e {{$episodiosPorTemporada}} episódios por temporada foi criada.


Acesse aqui:

@component('mail::button', ['url' => route('seasons.index', $idSerie)])
    Ver série
@endcomponent

@endcomponent