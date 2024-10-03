<x-layout title="Nova Série">
    <form action="{{route('series.store')}}" method="post" enctype="multipart/form-data">
        <!-- O Laravel possui uma proteção contra um ataque chamado (CSRF). 
        Todo formulário que nós enviamos para o Laravel precisa ter uma informação extra: um token. 
        Esse token permite que o Laravel verifique que a requisição realmente foi enviada por um formulário do site. -->
        @csrf
        <div class="row mb-3">
            <div class="col-8">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" 
                        id="nome"
                        autofocus
                        name="nome" 
                        class="form-control"
                        value="{{old('nome')}}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">N° de Temporadas:</label>
                <input type="text" 
                        id="seasonsQty" 
                        name="seasonsQty" 
                        class="form-control"
                        value="{{old('seasonsQty')}}">
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Eps / Temporada:</label>
                <input type="text" 
                        id="episodesPerSeason" 
                        name="episodesPerSeason" 
                        class="form-control"
                        value="{{old('episodesPerSeason')}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="cover" class="form-label">Capa</label>
                <input type="file" id="cover" name="cover" classe="form-control" accept="image/gif, image/jpeg, image/png">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>

</x-layout>