@section('modal-title', 'Dados do Pagamento')
@section('modal-id', 'modalPgto')

@section('modal-body')
<form action="/save-assinatura" method="POST" id="formPgto">
    @csrf

    <input type="hidden" name="usuario" id="usuario" value="">
    <input type="hidden" name="plano" id="plano" value="">

    <div class="form-row">
        <div class="form-group col-md-4">
            <button type="button" class="btn btn-sm btn-outline-primary" id="gerarAutorizado">Gerar Autorizado</button>
        </div>
        <div class="form-group col-md-4">
            <button type="button" class="btn btn-sm btn-outline-danger" id="gerarRecusado">Gerar Recusado</button>
        </div>
        <div class="form-group col-md-4">
            <button type="button" class="btn btn-sm btn-outline-warning" id="gerarAleatorio">Gerar Aleatorio</button>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="cartaoNr" class="col-form-label">Cartão:</label>
            <input type="text" class="form-control required" name="numero" id="cartaoNr" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="cartaoVcto" class="col-form-label">Vencimento:</label>
            <input type="text" class="form-control dt-vcto required" name="vencimento" id="cartaoVcto" required>
        </div>
        <div class="form-group col-md-6">
            <label for="cartaoCod" class="col-form-label">Cod Cartão:</label>
            <input type="text" class="form-control cod-cartao required" name="codigo" id="cartaoCod" required>
        </div>
    </div>
</form>
@endsection