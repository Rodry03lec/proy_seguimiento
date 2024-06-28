@extends('principal')
@section('titulo', '| OBSERVADOS')
@section('contenido')
    @include('administrador.tramite.tipo_tramite')


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: {{ $titulo_menu }} :::::::: </h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_categoria_nuevo">
                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
            </button>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_categoria" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NOMBRE</th>
                        <th>NIVEL</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de categoria Modal -->
    <div class="modal fade" id="modal_tipo_categoria_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipocategoria()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Tipo de Categoría</h3>
                    </div>
                    <form id="formulario_nuevo_tipocategoria" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipocategoria" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_tipocategoria()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de categoria Modal -->


@endsection

@section('scripts')
    <script>

    </script>
@endsection
