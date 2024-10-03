<form action="{{$action}}" method="post">
    <!-- O Laravel possui uma prote��o contra um ataque chamado (CSRF). 
    Todo formul�rio que n�s enviamos para o Laravel precisa ter uma informa��o extra: um token. 
    Esse token permite que o Laravel verifique que a requisi��o realmente foi enviada por um formul�rio do site. -->
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