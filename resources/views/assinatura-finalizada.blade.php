@extends('includes.app')

@section('content')
    @if($success == false)
        <div class="py-5" id="divAssinaturaErro">
            <div class="container">
                <div class="row">
                    <div class="px-5 col-md-8 text-center mx-auto">
                        <h3 class="text-primary display-4"> <b>Erro na transação</b> </h3>
                        <h2 class="my-3">I am so happy, my dear friend.</h2>
                        <p class="mb-3">
                            I throw myself down among the tall grass by the trickling stream;
                            and, as I lie close to the earth, a thousand unknown plants are noticed
                            by me: when I hear the buzz of the little world among the stalks, and grow
                            familiar with the countless indescribable.
                        </p>

                        <form action="/save-assinatura" method="POST">
                            @csrf

                            <input type="hidden" name="usuario" value="{{ $usuario }}">
                            <input type="hidden" name="plano" value="{{ $plano }}">
                            <input type="hidden" name="transacao" value="{{ $transacao }}">
                            <input type="hidden" name="numero" value="{{ $numero }}">
                            <input type="hidden" name="vencimento" value="{{ $vencimento }}">
                            <input type="hidden" name="codigo" value="{{ $codigo }}">

                            <input type="submit" class="btn btn-primary" value="Tentar novamente">
                        </form>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#divAssinaturaErro -->
    @else
        <div class="py-3" id="divAssinaturaSucesso">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex flex-column justify-content-center">
                        <h1 class="mb-3">Assinatura efetivada com sucesso!</h1>
                        <p class="lead mb-4">
                            A wonderful serenity has taken possession of my entire soul,
                            like these sweet mornings of spring which I enjoy with my whole heart.
                            I am alone, and feel the charm of existence in this spot, which was created for
                            the bliss of souls like mine. I am so happy, my dear friend.
                        </p>
                    </div>
                    <div class="col-md-6 p-lg-5 p-3">
                        <img class="img-fluid d-block" src="https://via.placeholder.com/500x450">
                    </div>
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-md-3 col-6 p-3">
                        <h4 class="my-3"> <b>Dados Pessoais</b> </h4>
                        <p>
                            A wonderful serenity has taken possession of my entire soul,
                            like these sweet mornings of spring which I enjoy with my whole heart.
                        </p>
                    </div>
                    <div class="col-md-3 col-6 p-3">
                        <h4 class="my-3"> <b>Endereço</b> </h4>
                        <p>
                            I am alone, and feel the charm of existence in this spot, which was
                            created for the bliss of souls like mine. I am so happy, my dear friend.
                        </p>
                    </div>
                    <div class="col-md-3 col-6 p-3">
                        <h4 class="my-3"> <b>Contatos</b> </h4>
                        <p>
                            So absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.
                            I should be incapable of drawing a single stroke.
                        </p>
                    </div>
                    <div class="col-md-3 col-6 p-3">
                        <h4 class="my-3"> <b>Assinatura</b> </h4>
                        <p>
                            At the present moment and yet I feel that I never was a greater artist than now.
                            When, while the lovely valley teems with vapour around me.
                        </p>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#divAssinaturaSucesso -->
    @endif
@endsection