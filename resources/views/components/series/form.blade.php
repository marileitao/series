<form action="{{$action}}" method="post">
    <!-- O Laravel possui uma proteção contra um ataque chamado (CSRF). 
    Todo formulário que nós enviamos para o Laravel precisa ter uma informação extra: um token. 
    Esse token permite que o Laravel verifique que a requisição realmente foi enviada por um formulário do site. -->
    @csrf

    @if($update)
    @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" 
                id="nome" 
                name="nome" 
                class="form-control"
                @isset($nome)value="{{$nome}}"@endisset>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar</button>
</form>