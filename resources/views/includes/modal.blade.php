<div class="modal fade" id="@yield('modal-id')" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">@yield('modal-title')</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @yield('modal-body')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="enviarModal">Enviar</button>
            </div>
        </div>
    </div>
</div>