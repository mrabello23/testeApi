<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">{{config('app.name', '')}}</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-4" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item mr-2 active">
                <a class="nav-link" href="/form-cadastro">Cadastro</a>
            </li>
            <li class="nav-item dropdown mr-2 active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    API
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" target="_blank" href="/api/gerar-autorizado">Gerar Cartão Aprovado</a>
                    <a class="dropdown-item" target="_blank" href="/api/gerar-recusado">Gerar Cartão Recusado</a>
                    <a class="dropdown-item" target="_blank" href="/api/gerar-aleatorio">Gerar Cartão Aleatório</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" target="_blank" href="/api/transacao">Log API</a>
                </div>
            </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" target="_blank" method="GET" action="/api/transacao">
            @csrf
            <input class="form-control form-control-sm mr-sm-2" type="text"
                placeholder="Buscar transação por ID" name="id" aria-label="Buscar transação por ID">
            <button class="btn btn-sm btn-outline-warning my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
</nav>