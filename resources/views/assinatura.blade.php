@extends('includes.app')

@include('includes.form-pgto')

@section('content')
    <div class="mx-auto col-lg-12 col-12 pt-2" id="sectionConteudo">
        <div class="pt-5 text-center" id="divResumoCadastro">
            <div class="container" id="containerResumoCadastro">
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <h1>Resumo do cadastro</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 p-4">
                        <h4> <b>Dados Pessoais</b> </h4>
                        <p>
                            {{ $usuario['nome'] }} <br/>
                            {{ $usuario['email'] }} <br/>
                            {{ $usuario['cpf'] }} <br/>
                        </p>
                    </div>

                    <div class="col-lg-4 col-md-4 p-4">
                        <h4> <b>Endereço</b> </h4>
                        <p>
                            {{ $usuario['logradouro'] }}, {{ $usuario['cep'] }} <br/>
                            {{ $usuario['bairro'] }} - {{ $usuario['cidade'] }} / {{ $usuario['estado'] }} <br/>
                        </p>
                    </div>

                    <div class="col-lg-4 col-md-4 p-4">
                        <h4> <b>Contatos</b> </h4>
                        <p>
                            @foreach($usuario['telefones'] as $tel)
                                {{ $tel['numero'] }} <br/>
                            @endforeach
                        </p>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /#containerResumoCadastro -->
        </div> <!-- /#divResumoCadastro -->

        <div class="py-5" id="divPlanos">
            <div class="container" id="containerPlanos">
                <div class="row">
                    <div class="text-center col-md-12">
                        <h1>Escolha o plano da assinatura</h1>
                    </div>
                </div>

                <div class="row">
                    @foreach($plano as $key => $value)
                        <div class="col-lg-4 col-md-6 p-3" id="cardPlano{{ $key }}">
                            <div class="card bg-light">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-8">
                                            <h3 class="mb-0">{{ $value['nome'] }}</h3>
                                        </div>
                                        <div class="col-4 text-right">
                                            <h2 class="mb-0"> <b>${{ $value['valor'] }}</b> </h2>
                                        </div>
                                    </div>

                                    <p class="my-3">{{ $value['descricao'] }}</p>

                                    {!! $value['diferencial'] !!}

                                    <a class="btn btn-outline-primary mt-3 float-right btn-plano"
                                        data-toggle="modal"
                                        data-target="#modalPgto"
                                        data-usuario="{{ $usuario['id'] }}"
                                        data-plano="{{ $value['id'] }}"
                                        href="#">
                                        Selecionar Plano
                                    </a>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /#cardPlano{{ $key }} -->
                    @endforeach
                </div> <!-- /.row -->
            </div> <!-- /#containerPlanos -->
        </div> <!-- /#divPlanos -->
    </div> <!-- /#sectionConteudo -->

    <!-- JS -->
    <script type="text/javascript">
        $(function() {
            $('.dt-vcto').mask('00/0000');
            $('.cod-cartao').mask('000');

            if ($('#modalPgto').length > 0) {
                $('#modalPgto').on('hide.bs.modal', function(event) {
                    $(this).find('.modal-body input').val('');
                });
            }

            if ($('#formPgto').length > 0) {
                $('.btn-plano').click(function() {
                    $('#formPgto').find('#usuario').val($(this).data('usuario'));
                    $('#formPgto').find('#plano').val($(this).data('plano'));
                });

                $('#enviarModal').click(function() {
                    $('#formPgto').submit();
                });

                $('#gerarAutorizado, #gerarRecusado, #gerarAleatorio').click(function() {
                    var url = '';

                    if ($(this).prop('id') == 'gerarAutorizado') {
                        url = '/api-pagamento/gerar-autorizado';
                    }
                    else if ($(this).prop('id') == 'gerarRecusado') {
                        url = '/api-pagamento/gerar-recusado';
                    }
                    else if ($(this).prop('id') == 'gerarAleatorio') {
                        url = '/api-pagamento/gerar-aleatorio';
                    }

                    ajaxSend(url, 'GET', preencheFormPgto);
                });
            }
        });

        function ajaxSend(url, method, callback) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (callback) {
                        callback(this);
                    }
                }
            };

            xhttp.open(method, url, true);
            xhttp.send();
        }

        function preencheFormPgto(xhttp) {
            var data = JSON.parse(xhttp.responseText);

            if (data.success) {
                $('#formPgto').find('#cartaoNr').val(data.cartao.numero);
                $('#formPgto').find('#cartaoVcto').val(data.cartao.vencimento);
                $('#formPgto').find('#cartaoCod').val(data.cartao.codigo);

                return;
            }

            console.log(data);
            alert('Erro ao gerar o cartão.');
        }
    </script>
@endsection