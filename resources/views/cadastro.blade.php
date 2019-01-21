@extends('includes.app')

@section('cadastro-page', 'active')

@section('content')
    <div class="mx-auto col-lg-8 col-10 pt-5" id="sectionConteudo">
        <h1>Cadastro de Usuários</h1>

        <p class="mb-3 pt-2">
            Resumo da página de cadastro de usuários
        </p>

        <form class="text-left pt-3" method="POST" action="/save-usuario" id="formUsuario">
            @csrf

            <div class="form-group">
                <label for="form1">Nome Completo</label>
                <input type="text" class="form-control required" name="nome" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-7">
                    <label for="form2">E-mail</label>
                    <input type="email" class="form-control required" name="email" required>
                </div>

                <div class="form-group col-md-5">
                    <label for="form3">CPF</label>
                    <input type="text" class="form-control required cpf" name="cpf" required>
                </div>
            </div> <!-- /.form-row -->

            <fieldset class="mt-3" id="fieldsetEndereco">
                <legend>Endereço <hr/></legend>

                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="form3">Logradouro</label>
                        <input type="text" class="form-control required" name="logradouro" required>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="form3">Bairro</label>
                        <input type="text" class="form-control required" name="bairro" required>
                    </div>
                </div> <!-- /.form-row -->

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="form3">CEP</label>
                        <input type="text" class="form-control required cep" name="cep" required>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="form3">Cidade</label>
                        <input type="text" class="form-control required" name="cidade" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="form3">Estado</label>
                        <select class="form-control required" name="estado" required>
                            <option value="">Selecione</option>
                            @foreach ($estados as $uf)
                                <option value="{{ $uf }}">{{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> <!-- /.form-row -->
            </fieldset> <!-- /#fieldsetEndereco -->

            <fieldset class="mt-3" id="fieldsetContatos">
                <legend>Contatos <hr/></legend>

                <div class="form-row contatos">
                    <div class="form-group col-md-4 template">
                        <label>Telefone</label>
                        <input type="text" class="form-control telefone required" name="telefone[]" required>
                    </div>

                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-link float-right" id="add_telefone">+ Adicionar Telefone</button>
                    </div>
                </div>
            </fieldset> <!-- /#fieldsetContatos -->

            <button type="submit" class="btn btn-primary mb-3">Salvar</button>
        </form> <!-- /#formUsuario -->
    </div> <!-- /#sectionConteudo -->

    <!-- JS -->
    <script type="text/javascript">
        $(function() {
            // https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html
            var telMaskBehavior = function (val) {
                var masks = ['(00) 00000-0000','(00) 0000-00009'];
                return val.replace(/\D/g, '').length === 11 ? masks[0] : masks[1];
            },
            telMaskoptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(telMaskBehavior.apply({}, arguments), options);
                }
            };

            $('.telefone').mask(telMaskBehavior, telMaskoptions);
            $('.cep').mask('00000-000');
            $('.cpf').mask('000.000.000-00', {reverse: true});

            $('#add_telefone').click(function(event) {
                event.preventDefault();

                var $elemento = $(this);
                var $template = $elemento.parents('.contatos').find('.template');
                var clone = $template.clone().removeClass('template');
                clone.find('input[type="text"]').val('');

                $(clone).insertBefore($elemento.parent('div'));
                $('.telefone').mask(telMaskBehavior, telMaskoptions);
            });

            $('form').submit(function(event) {
                $('.cpf').css('border-color', '#ced4da');
                var erro = 0;

                $('.required').each(function(index, el) {
                    if ($(el).val() == '') {
                        erro++;
                    }
                });

                if (erro > 0) {
                    event.preventDefault();
                    alert('Atenção: todos os campos são obrigatórios!');

                    return false;
                }

                var $cpf = $('.cpf');

                if (!validaCPF($cpf.val())) {
                    event.preventDefault();
                    $cpf.css('border-color', '#ff0000');
                    alert('Atenção: CPF inválido!');

                    return false;
                }

                return true;
            });
        });

        // https://www.devmedia.com.br/validar-cpf-com-javascript/23916
        function validaCPF(strCPF) {
            var Soma;
            var Resto;
            Soma = 0;

            strCPF = strCPF.replace(/[^0-9]/g, '');

            var valoresNegados = [
                '00000000000','11111111111','22222222222',
                '33333333333','44444444444','55555555555',
                '66666666666','77777777777','88888888888',
                '99999999999'
            ];

            if (valoresNegados.indexOf(strCPF) >= 0) {
                return false;
            }

            if (strCPF.length < 11) {
                strCPF = strPad(strCPF, 11, '0', 'left');
            }

            for (i=1; i<=9; i++) {
                Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            }

            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11)) {
                Resto = 0;
            }

            if (Resto != parseInt(strCPF.substring(9, 10)) ) {
                return false;
            }

            Soma = 0;
            for (i = 1; i <= 10; i++) {
                Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            }

            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11)) {
                Resto = 0;
            }

            if (Resto != parseInt(strCPF.substring(10, 11) ) ) {
                return false;
            }

            return true;
        }

        function strPad(str, pad_size, pad_str, pad_mode) {
            if (str.length == pad_size) {
                return str;
            }

            var returnValue = str;

            while(returnValue.length < pad_size) {
                if (pad_mode == 'left') {
                    returnValue = pad_str + '' + returnValue;
                }
                else if (pad_mode == 'right') {
                    returnValue = returnValue + '' + pad_str;
                }
                else {
                    break;
                }
            }

            return returnValue;
        }
    </script>
@endsection