
<div class="card  mb-2">
    {{-- USUARIO : {{ $cargo_enum->id_usuario }}
    <br>
    ID CARGO :
    @if ($cargo_enum->cargo_sm != null)
        {{ 'CARGO SM : '.$cargo_enum->id_cargo_sm }}
    @endif

    @if ($cargo_enum->cargo_mae != null)
        {{ 'CARGO MAE : '.$cargo_enum->id_cargo_mae }}
    @endif --}}

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">:::::::: CARGO ::
            {{ $cargo_enum->cargo_sm->nombre ?? ($cargo_enum->cargo_mae->nombre ?? 'NOMBRE NO DISPONIBLE') }}
        :::::::: </h5>
    </div>
</div>


<div class="row">
    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-4">
        <div class="card card-border-shadow-secondary h-100">
            <a href="{{ route('tcar_cargos', ['id' => encriptar($id_user_cargo_tram)]) }}" type="button">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-secondary">
                                <i class="ti ti-layout ti-md"></i>
                            </span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $contar_num_tramite }} </h4>
                    </div>
                    <p class="mb-1">CORRESPONDENCIA</p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-4">
        <div class="card card-border-shadow-success h-100">
            <a href="{{ route('tcar_bandeja_entrada', ['id' => encriptar($id_user_cargo_tram)]) }}" type="button"  >
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class='ti ti-alert-triangle ti-md'></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $contar_bandeja_entrada }}</h4>
                    </div>
                    <p class="mb-1">BANDEJA DE ENTRADA</p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-4">
        <div class="card card-border-shadow-primary h-100">
            <a href="{{ route('tcar_recibidos', ['id' => encriptar($id_user_cargo_tram)]) }}" type="button"  >
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class='ti ti-cloud-down ti-md'></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $contar_bandeja_recibido }}</h4>
                    </div>
                    <p class="mb-1">RECIBIDOS</p>
                </div>
            </a>
        </div>
    </div>


    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-4">
        <div class="card card-border-shadow-danger h-100">
            <a href="{{ route('tcar_observados', ['id' => encriptar($id_user_cargo_tram)]) }}" type="button"  >
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class='ti ti-thumb-down ti-md'></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $contar_bandeja_observado }}</h4>
                    </div>
                    <p class="mb-1">OBSERVADOS</p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-4">
        <div class="card card-border-shadow-warning h-100">
            <a href="{{ route('tcar_archivados', ['id' => encriptar($id_user_cargo_tram)]) }}" type="button"  >
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class='ti ti-server ti-md'></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">0</h4>
                    </div>
                    <p class="mb-1">ARCHIVADOS</p>
                </div>
            </a>
        </div>
    </div>
</div>


<!-- vizualizar de tramite -->
<div class="modal fade" id="modal_vizualizar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-xl">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">VIZUALIZAR RUTA</h3>
                </div>

                <div class="alert alert-primary alert-dismissible d-flex align-items-baseline" role="alert">
                    <span class="alert-icon alert-icon-lg text-primary me-2">
                        <i class="ti ti-layout ti-sm"></i>
                    </span>
                    <div id="contenido_correspondencia">

                    </div>
                </div>

                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Nº</th>
                                <th>FECHA<br>INGRESO</th>
                                <th>FECHA<br>SALIDA</th>
                                <th>UNIDAD</th>
                                <th>CARGO</th>
                                <th>FUNCIONARIO</th>
                                <th>INSTRUCTIVO</th>
                            </tr>
                        </thead>
                        <tbody id="listar_hojas_ruta">

                        </tbody>
                    </table>
                </div>

                <div id="contenido_txt" class="py-2">

                </div>

            </div>
        </div>
    </div>
</div>
<!--/ vizualizar tramite -->
