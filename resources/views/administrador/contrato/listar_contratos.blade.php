@extends('principal')
@section('titulo', '| LISTA CONTRATOS')
@section('estilos')

@endsection
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE CONTRATOS :::::::: </h5>
        </div>

        <div class="tab-content pb-0">
            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                <ul class="timeline mb-0 pb-0">
                    <li class="timeline-item ps-4 border-left-dashed">
                        <span class="timeline-indicator-advanced timeline-indicator-success">
                            <i class="ti ti-circle-check"></i>
                        </span>
                        <div class="timeline-event ps-0 pb-0">
                            <div class="timeline-header">
                                <small class="text-success text-uppercase fw-medium">CI</small>
                            </div>
                            <h5 class="mb-0">
                                @if ($persona->complemento != null)
                                    {{ $persona->ci.' '.$persona->complemento }}
                                @else
                                    {{ $persona->ci }}
                                @endif
                            </h5>
                        </div>
                    </li>
                    <li class="timeline-item ps-4 border-left-dashed">
                        <span class="timeline-indicator-advanced timeline-indicator-success">
                            <i class="ti ti-circle-check"></i>
                        </span>
                        <div class="timeline-event ps-0 pb-0">
                            <div class="timeline-header">
                                <small class="text-success text-uppercase fw-medium">NOMBRES</small>
                            </div>
                            <h5 class="mb-0">{{ $persona->nombres.' '.$persona->ap_paterno.' '.$persona->ap_materno }}</h5>
                        </div>
                    </li>
                    <li class="timeline-item ps-4 border-left-dashed">
                        <span class="timeline-indicator-advanced timeline-indicator-success">
                            <i class="ti ti-circle-check"></i>
                        </span>
                        <div class="timeline-event ps-0 pb-0">
                            <div class="timeline-header">
                                <small class="text-success text-uppercase fw-medium">Nº CELULAR</small>
                            </div>
                            <h5 class="mb-0">{{ $persona->celular }}</h5>
                        </div>
                    </li>
                </ul>
                <div class="border-bottom border-bottom-dashed mt-0 mb-4 p-0"></div>
            </div>
        </div>


        {{-- <div class="divider">
            <div class="divider-text">NOMBRE : {{ $persona->nombres }} </div>
        </div> --}}

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_listar_contratos" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>Nº CONTRATO</th>
                        <th>FECHA INICIO</th>
                        <th>FECHA CONCLUSIÓN</th>
                        <th>VIZUALIZAR DATOS</th>
                        <th>ESTADO</th>
                        <th>CONTRATOS MODIFICATORIOS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- MODAL PARA VIZUALIZAR LOS DETALLES DEL CONTRATO --}}
    <div class="modal fade" id="vizualizar_contrato_modal" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row" id="vizualizar_html_contrato">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PARA VIZUALIZAR LOS DETALLES DEL CONTRATO --}}


    <!-- Modal -->
    <!-- PARA GENERAR EL RETIRO -->
    <div class="modal fade" id="modal_generar_retiro" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_retiro()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4 class="mb-2">DAR DE BAJA</h4>
                    </div>
                    <div id="contrato_detalle" ></div>
                    <form id="formulario_dar_baja" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_persona" id="id_persona" value="{{ $id_persona }}">
                        <input type="hidden" name="id_contrato" id="id_contrato" >

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha">Fecha</label>
                            <input type="text" class="form-control" name="fecha" id="fecha" placeholder="YYYY-MM-DD | Ingrese la fecha" onchange="validarFecha()">
                            <div id="_fecha"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="tipo_baja">Tipo de Baja</label>
                            <select name="tipo_baja" id="tipo_baja" class="select2">
                                <option value="selected" disabled selected>[SELECCIONE EL TIPO DE BAJA]</option>
                                @foreach ($tipo_baja as $lis)
                                    <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                @endforeach
                            </select>
                            <div id="_tipo_baja"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion">INGRESE LA DESCRIPCIÓN</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="8" placeholder="Ingrese la razón por la cual esta tomando al desición"></textarea>
                            <div id="_descripcion" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_baja_detalle" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_retiro()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ PARA GENERAR EL RETIRO-->


    <!-- Modal -->
    <!-- PARA VIZUALIZAR EL RETIRO -->
    <div class="modal fade" id="modal_vizualizar_retiro" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_retiro()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4 class="mb-2">VIZUALIZAR O EDITAR LA BAJA</h4>
                    </div>
                    <div id="contrato_detalle" ></div>
                    <form id="formulario_dar_baja_editado" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_baja" id="id_baja" >

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha_">Fecha</label>
                            <input type="text" class="form-control" name="fecha_" id="fecha_" placeholder="YYYY-MM-DD | Ingrese la fecha"   max="{{ date('Y-m-d') }}" onchange="validarFecha()">
                            <div id="_fecha_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="tipo_baja_">Tipo de Baja</label>
                            <select name="tipo_baja_" id="tipo_baja_" class="select2">
                                <option value="selected" disabled selected>[SELECCIONE EL TIPO DE BAJA]</option>
                                @foreach ($tipo_baja as $lis)
                                    <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                @endforeach
                            </select>
                            <div id="_tipo_baja_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion_">INGRESE LA DESCRIPCIÓN</label>
                            <textarea class="form-control" name="descripcion_" id="descripcion_" cols="30" rows="8" placeholder="Ingrese la razón por la cual esta tomando al desición"></textarea>
                            <div id="_descripcion_" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_baja_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_retiro()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ PARA VIZUALIZAR EL RETIRO-->


    <!-- PARA EDITAR LOS CONTRATOS-->
    <div class="modal fade" id="modal_editar_contratos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">EDITAR CONTRATO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_contrato_editar()"></button>
                </div>
                <div class="modal-body">
                    <form id="formulario_editar_contrato" method="post" autocomplete="off">
                        <input type="hidden" name="id_contrato_" id="id_contrato_">
                        <fieldset>
                            <legend>INFORMACIÓN DEL CONTRATO</legend>
                            <div class="row" >
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="fecha_inicio">FECHA DE INICIO</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la fecha de inicio" class="form-control uppercase-input" onchange="validarFechas()" />
                                    <div id="_fecha_inicio"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="fecha_conclusion">FECHA DE CONCLUSIÓN</label>
                                    <input type="date" id="fecha_conclusion" name="fecha_conclusion" placeholder="Seleccione la fecha de inicio"  class="form-control uppercase-input" onchange="validarFechas()" />
                                    <div id="_fecha_conclusion"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="tipo_contrato">SELECCIONE TIPO DE CONTRATO</label>
                                    <select name="tipo_contrato" id="tipo_contrato" class="select2 with_100" onchange="tipo_contrato_select(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE TIPO DE CONTRATO ]</option>
                                        @foreach ($lis_tipo_contrato as $lis)
                                            <option value="{{ $lis->id }}">[{{ $lis->sigla }}] - {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo_contrato"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="numero_contrato">NÚMERO DE CONTRATO</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="contrato_tipo_sel">--------</span>
                                        <input type="text" id="numero_contrato" name="numero_contrato" placeholder="Ingrese el número de contrato" class="form-control uppercase-input "  aria-describedby="numero_contrato" />
                                    </div>
                                    <div id="_numero_contrato"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="haber_basico">HABER BÁSICO</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Bs</span>
                                        <input type="text" id="haber_basico" name="haber_basico" placeholder="Ingrese el haber basico" class="form-control monto_number" maxlength="15"/>
                                    </div>
                                    <div id="_haber_basico"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="categoria">SELECCIONE LA CATEGORÍA</label>
                                    <select name="categoria" id="categoria" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE LA CATEGORÍA ]</option>
                                        @foreach ($lis_categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria" ></div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="nivel">SELECCIONE EL NIVEL</label>
                                    <select name="nivel" id="nivel" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE EL NIVEL ]</option>
                                    </select>
                                    <div id="_nivel" ></div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="horario">SELECCIONE EL HORARIO</label>
                                    <select name="horario" id="horario" class="select2 with_100" onchange="mensaje_horario(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE EL HORARIO ]</option>
                                        @foreach ($lis_horario as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_horario" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3" id="mensaje_horario" ></div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INFORMACIÓN ACADEMICA</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="ambito_profesional">SELECCIONE AMBITO PROFESIONAL</label>
                                    <select name="ambito_profesional" id="ambito_profesional" class="select2 with_100" >
                                        <option disabled selected value="selected">[ SELECCIONE EL AMBITO PROFESIONAL ]</option>
                                        @foreach ($lis_ambito as $lis)
                                            <option value="{{ $lis->id }}"> {{ $lis->nombre }}  : [{{ $lis->descripcion }}]</option>
                                        @endforeach
                                    </select>
                                    <div id="_ambito_profesional"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="profesion">SELECCIONE PROFESIÓN</label>
                                    <select name="profesion" id="profesion" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE PROFESIÓN ]</option>
                                    </select>
                                    <div id="_profesion"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="grado_academico">SELECCIONE EL GRADO ACADÉMICO</label>
                                    <select name="grado_academico" id="grado_academico" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE EL GRADO ACADÉMICO ]</option>
                                        @foreach ($grado_academico as $lis)
                                            <option value="{{ $lis->id }}"> [{{ $lis->abreviatura }}] : {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_grado_academico"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>TRABAJO</legend>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="mae_sm">[SELECCIONE]</label>
                                    <select name="mae_sm" id="mae_sm" class="select2 with_100" onchange="seleccionar_mae_sm(this.value)">
                                    <option disabled selected value="selected"> [SELECCIONE] </option>
                                        <option value="1">MAE</option>
                                        <option value="2">POR SECRETARIAS MUNICIPALES</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>MAE</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="mae_mae">SELECCIONE MAE</label>
                                    <select name="mae_mae" id="mae_mae" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE MAE] </option>
                                        @foreach ($listar_mae as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_mae_mae" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="unidad_mae">SELECCIONE UNIDAD</label>
                                    <select name="unidad_mae" id="unidad_mae" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE UNIDAD] </option>
                                    </select>
                                    <div id="_unidad_mae" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_mae">SELECCIONE CARGO</label>
                                    <select name="cargo_mae" id="cargo_mae" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE CARGO] </option>
                                    </select>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_mae_descripcion">INGRESE SU CARGO</label>
                                    <input type="text" id="cargo_mae_descripcion" name="cargo_mae_descripcion" placeholder="Ingrese el cargo correspondiente" class="form-control uppercase-input" @disabled(true)/>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>SM</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="secretaria_sm">SELECCIONE SECRETARIA</label>
                                    <select name="secretaria_sm" id="secretaria_sm" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected">[SELECCIONE LA SECRETARIA MUNICIPAL]</option>
                                        @foreach ($secretaria_municipal as $lis)
                                            <option value="{{ $lis->id }}">[{{ $lis->sigla }}] : {{ $lis->nombre }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="direccion_sm">SELECCIONE LA DIRECCIÓN</label>
                                    <select name="direccion_sm" id="direccion_sm" class="select2 with_100"  @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE LA DIRECCIÓN ]</option>
                                    </select>
                                    <div id="_direccion_sm"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="unidad_administrativa_sm"> <span id="g_span" >*</span>SELECCIONE UNIDAD ADMINISTRATIVA O JEFATURA SI CORRESPONDE <span id="g_span" >*</span></label>
                                    <select name="unidad_administrativa_sm" id="unidad_administrativa_sm" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE UNIDAD ADMINISTRATIVA ]</option>
                                        @foreach ($unidad_administrativa as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_unidad_administrativa_sm"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_sm">SELECCIONE UN CARGO *</label>
                                    <select name="cargo_sm" id="cargo_sm" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE CARGO ]</option>
                                    </select>
                                    <div id="_cargo_sm"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_sm_descripcion">INGRESE SU CARGO</label>
                                    <input type="text" id="cargo_sm_descripcion" name="cargo_sm_descripcion" placeholder="Ingrese el cargo correspondiente" class="form-control uppercase-input" @disabled(true)/>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_contrato_edit" class="btn btn-primary me-sm-3 me-1">Guardar Contrato</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" onclick="cerrar_modal_contrato_editar()" aria-label="Close">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN PARA EDITAR LOS CONTRATOS-->


    <!-- PARA LOS CONTRATOS MODIFICATORIOS-->
    <div class="modal fade" id="modal_listar_modificatorios" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">AGREGAR CONTRADOS MODIFICATORIOS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_administracion_nivel()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_categoria" role="alert">
                    </div>
                    <form id="formulario_nuevo_nivel" method="post" autocomplete="off">
                        <input type="hidden" name="id_categoria" id="id_categoria">
                        <input type="hidden" name="id_nivel" id="id_nivel">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="nivel" class="form-label">Fecha Finalizacion contrato</label>
                                <input type="date" id="fecha_finalizacion__" name="fecha_finalizacion__" class="form-control" placeholder="Ingrese el nivel">
                                <div id="_nivel" ></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion__" id="descripcion___" class="form-control uppercase-input" rows="2" placeholder="Ingrese "></textarea>
                                <div id="_descripcion__" ></div>
                            </div>
                        </div>
                    </form>


                    <div class="row mt-3">
                        <div class="d-grid gap-2 col-lg-6 mx-auto">
                            <button class="btn btn-primary btn-md" id="btn_guardar_nivel" type="button">Guardar</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="tabla_listar_niveles" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">DESCRIPCIÓN</th>
                                <th scope="col" class="table-th">FECHA CULMINACIÓN ANTERIOR</th>
                                <th scope="col" class="table-th">GESTIÓN</th>
                                <th scope="col" class="table-th">FECHA DE FINALIZACIÓN</th>
                                <th scope="col" class="table-th">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN PARA LOS CONTRATOS MODIFICATORIOS-->
@endsection

@section('scripts')
    <script>

        fechas_flatpicker('fecha_inicio');
        fechas_flatpicker('fecha_conclusion');

        //para la validacion de las fechas
        function fechas_flatpicker(fecha){
            flatpickr("#"+fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                //allowInput: true
            });
        }


        let id_persona = {{ $id_persona }};

        fechas_flatpicker('fecha');
        fechas_flatpicker('fecha_');

        function fechas_flatpicker(fecha){
            flatpickr("#" + fecha, {
                dateFormat: "Y-m-d", // Formato de fecha deseado
                enableTime: false,    // Habilitar o deshabilitar el tiempo
                locale: {
                    firstDayOfWeek: 2, // Primer día de la semana (0 para domingo, 1 para lunes, etc.)
                },
                maxDate: "today", // Permitir seleccionar cualquier fecha anterior o igual a la fecha actual
            });
        }

        //PARA LISTAR CONTRATOS
        async function listar_contratos() {
            let respuesta = await fetch("{{ route('lis_lista_contrato_especifico') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    id: id_persona
                })
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_listar_contratos').DataTable({
                responsive: true,
                data: dato,
                columns: [{
                        data: null,
                        className: 'table-td',
                        render: function() {
                            return i++;
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row) {
                            return data.tipo_contrato.sigla + '  ' + data.numero_contrato
                        }
                    },
                    {
                        data: 'fecha_inicio',
                        className: 'table-td',
                        render: function(data, type, row) {
                            return fecha_literal(data, 4);
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row) {
                            if(data.fecha_conclusion != null && data.fecha_conclusion != ''){
                                return fecha_literal(data.fecha_conclusion, 4);
                            }else{
                                return '';
                            }
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('persona_listar_contratos_vizualizar')
                                    <div class="d-inline-block tex-nowrap">
                                        <button type="button"  onclick="vizualizar_contrato('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALZIZAR DATOS">
                                            <i class="ti ti-eye" ></i>
                                        </button>
                                    </div>
                                @endcan
                            `;
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if (data.id_baja != null) {
                                return `
                                    @can('persona_listar_contratos_vizualizar_retiro')
                                        <div class="demo-inline-spacing">
                                            <button onclick="vizualizar_retiro('${data.id}')" type="button" class="btn btn-outline-danger btn-xs">
                                                <span class="ti-xs ti ti-help me-1"></span>Vizualizar la Razón
                                            </button>
                                        </div>
                                    @endcan
                                `;
                            } else {
                                return `
                                    @can('persona_listar_contratos_generar_retiro')
                                        <div class="demo-inline-spacing">
                                            <button type="button" class="btn btn-outline-success btn-xs" onclick="generar_retiro('${data.id}')">
                                                <span class="ti-xs ti ti-wallet me-1"></span>Activo
                                            </button>
                                        </div>
                                    @endcan
                                `;
                            }

                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('persona_listar_contratos_modificatorio')
                                    <div class="d-inline-block tex-nowrap">
                                        <button class="btn btn-sm btn-primary" onclick="contratos_modificatorios('${row.id}')" type="button">
                                        Agregar Contrato Modificatorio
                                        </button>
                                    </div>
                                @endcan
                            `;
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('persona_listar_contratos_editar')
                                        <button type="button" onclick="editar_contrato('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('persona_listar_contratos_eliminar')
                                        <button type="button" onclick="eliminar_contrato('${row.id}')"  class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-trash" ></i>
                                        </button>
                                    @endcan

                                </div>
                            `;
                        }
                    }
                ]
            });
        }
        listar_contratos();
        //FIN PARA LISTAR CONTRATOS

        //PARA LA VIZUALIZACION DEL CONTRATO
        async function vizualizar_contrato(id) {
            try {
                let formData = new FormData();
                formData.append('id', id);
                formData.append('_token', token);
                let respuesta = await fetch("{{ route('viz_contrato') }}", {
                    method: 'POST',
                    body: formData
                });
                if (respuesta.ok) {
                    $('#vizualizar_contrato_modal').modal('show');
                    let data = await respuesta.text();
                    document.getElementById('vizualizar_html_contrato').innerHTML = data;
                } else {
                    console.log('Error en la solicitud', respuesta.status);
                    document.getElementById('vizualizar_html_contrato').innerHTML = '';
                }
            } catch (error) {
                console.log('Ocurrio un error : ' + error);
                listado_html.innerHTML = '';
            }
        }

        //declaramos las variables
        let btn_guardar_baja_detalle = document.getElementById('btn_guardar_baja_detalle');
        let form_dar_baja = document.getElementById('formulario_dar_baja');

        //PARA REALIZAR EL RETIRO POR X MOTIVO
        async function generar_retiro(id) {
            try {
                let respuesta = await fetch("{{ route('cont_datos') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_generar_retiro').modal('show');
                    document.getElementById('id_contrato').value = id;
                    document.getElementById('contrato_detalle').innerHTML = `<div class="alert alert-danger" role="alert">
                        TIPO : `+ dato.mensaje.tipo_contrato.nombre+`</br> CONTRATO Nº : ` +dato.mensaje.tipo_contrato.sigla+`  `+dato.mensaje.numero_contrato+`
                    </div>`;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        }

        //para vaciar los datos de dar de baja
        function cerrar_modal_retiro(id){
            let datos_array = ['id_contrato','fecha', 'tipo_baja', 'descripcion','fecha_', 'tipo_baja_', 'descripcion_'];
            datos_array.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            vaciar_errores_tipocontrato();
            $('#modal_generar_retiro').modal('hide');
        }
        //funcion para vaciar los errores que
        function vaciar_errores_tipocontrato(){
            let nuevo_array = ['_fecha','_tipo_baja', '_descripcion','_fecha_','_tipo_baja_', '_descripcion_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_contrato() {
            $('#tabla_listar_contratos').DataTable().destroy();
            listar_contratos();
            $('#tabla_listar_contratos').fadeIn(200);
        }

        //para guardar el genero
        btn_guardar_baja_detalle.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_dar_baja).entries());
            vaciar_errores_tipocontrato();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_baja_detalle');
            Swal.fire({
                title: "¿Estás seguro de dar de baja el contrato ?",
                text: "¡Nota!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, estoy seguro",
                cancelButtonText: "No, Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('bc_baja_contrato') }}",{
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(datos)
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'errores'){
                            let obj = dato.mensaje;
                            for (let key in obj) {
                                document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                            }
                            validar_boton(false, 'Guardar', 'btn_guardar_baja_detalle');
                        }
                        if(dato.tipo === 'success'){
                            alerta_top(dato.tipo, dato.mensaje);
                            cerrar_modal_retiro();
                            validar_boton(false, 'Guardar', 'btn_guardar_baja_detalle');
                            actulizar_tabla_contrato();
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                            validar_boton(false, 'Guardar', 'btn_guardar_baja_detalle');
                        }
                    } catch (error) {
                        console.log('Ocurrio un error :' + error );
                        validar_boton(false, 'Guardar', 'btn_guardar_baja_detalle');
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                }
            });
        });

        //para validar las fechas
        function validarFecha() {
            let fechaActual = new Date();
            let fechaSeleccionada = new Date(document.getElementById("fecha").value);
            if (fechaSeleccionada > fechaActual) {
                let mensaje="¡La fecha no puede ser del futuro! Por favor, selecciona una fecha válida.";
                document.getElementById('_fecha').innerHTML = `<p class="text-sm text-danger" >` + mensaje +`</p>`;
                document.getElementById("fecha").value = "";
            }else{
                document.getElementById('_fecha').innerHTML = ``;
            }
        }



        //para vizualizar el retiro
        async function vizualizar_retiro(id) {
            let datos = Object.fromEntries(new FormData(form_dar_baja).entries());
            vaciar_errores_tipocontrato();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_baja_detalle');
            try {
                let respuesta = await fetch("{{ route('viz_baja') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_vizualizar_retiro').modal('show');
                    document.getElementById('id_baja').value = dato.mensaje.baja.id;
                    document.getElementById('fecha_').value = dato.mensaje.baja.fecha;
                    document.getElementById('descripcion_').value = dato.mensaje.baja.descripcion;
                    $('#tipo_baja_').val(dato.mensaje.baja.id_tipo_baja).trigger('change');
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para guardar el editado un el vizualizado
        let form_dar_baja_editado = document.getElementById('formulario_dar_baja_editado');
        let btn_guardar_editado = document.getElementById('btn_guardar_baja_editado');

        btn_guardar_editado.addEventListener('click', async()=>{
            let datos = Object.fromEntries(new FormData(form_dar_baja_editado).entries());
            vaciar_errores_tipocontrato();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_baja_editado');
            try {
                let respuesta = await fetch("{{ route('viz_baja_edit') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_baja_editado');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    $('#modal_vizualizar_retiro').modal('hide');
                    validar_boton(false, 'Guardar', 'btn_guardar_baja_editado');
                    actulizar_tabla_contrato();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_baja_editado');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_baja_editado');
            }
        });

        //para la edicion de los datos
        function validarFechas() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaConclusion = document.getElementById('fecha_conclusion').value;


            let fechaInicioObj = new Date(fechaInicio);
            let fechaConclusion0bj = new Date(fechaConclusion);

            // Ajustar las fechas para ignorar las horas
            fechaInicioObj.setHours(0, 0, 0, 0);
            fechaConclusion0bj.setHours(0, 0, 0, 0);

            if (fechaConclusion0bj < fechaInicioObj) {
                alerta_top_end('error', 'La fecha final debe ser igual o después de la fecha de inicio. Por favor, selecciona una fecha válida.');
                document.getElementById('fecha_conclusion').value = '';
            }
        }

        //PARA EL TIPO DE CONTRATO
        async function tipo_contrato_select(id){
            let tipo_contato_seleccionado = document.getElementById('contrato_tipo_sel');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_tipo_contrato_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    tipo_contato_seleccionado.innerHTML = '---------';
                    if(dato.tipo === 'success'){
                        tipo_contato_seleccionado.innerHTML = dato.mensaje.sigla;
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                        tipo_contato_seleccionado.innerHTML = '---------';
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                tipo_contato_seleccionado.innerHTML = '---------';
            }
        }


        //PARA MOSTRAR EL MENSAJE DE HORAS QUE SE TRABAJARA
        async function mensaje_horario(id) {
            let mensaje_horario_html = document.getElementById('mensaje_horario');
            try {
                let respuesta = await fetch("{{ route('cco_horarios_select') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                mensaje_horario_html.innerHTML = '';
                if(dato.tipo === 'success'){
                    mensaje_horario_html.innerHTML = `
                    <label for=""></label>
                    <div class="alert alert-danger p-1" role="alert">
                        <span class="ltr:pr-1 rtl:pl-1 text-sm" style=' font-size: 11px;'><strong class="ltr:mr-1 rtl:ml-1">Nota ! </strong>`+dato.mensaje.descripcion+`</span>
                    </div>
                    `;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    mensaje_horario_html.innerHTML = '';
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                mensaje_horario_html.innerHTML = '';
            }
        }

        //AHORA REALIZAMOS POR MAE O SM
        function seleccionar_mae_sm(id) {
            if(id==='1'){
                form_mae(false);
                form_sm(true);
            }
            if(id==='2'){
                form_sm(false);
                form_mae(true);
            }
        }

        //PARA DESHACER O HABILITAR
        //para el mae
        function form_mae(valor){
            let mae = ['mae_mae', 'unidad_mae', 'cargo_mae', 'cargo_mae_descripcion'];
            mae.forEach(elem => {
                document.getElementById(elem).disabled = valor;
            });
            form_mae_selects();
        }

        //para los select esten como sin nada
        function form_mae_selects(){
            unidad_mae.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
            cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
            $('#mae_mae').val('selected').trigger('change');
            document.getElementById('cargo_mae_descripcion').value = '';
        }

        //para el sm
        function form_sm(valor){
            let sm = ['secretaria_sm', 'direccion_sm', 'unidad_administrativa_sm', 'cargo_sm', 'cargo_sm_descripcion'];
            sm.forEach(elem => {
                document.getElementById(elem).disabled = valor;
            });
            form_sm_selects();
        }

        //para los select esten como sin nada
        function form_sm_selects(){
            direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
            cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
            $('#secretaria_sm').val('selected').trigger('change');
            $('#unidad_administrativa_sm').val('selected').trigger('change');
            document.getElementById('cargo_sm_descripcion').value = '';
        }

        let cargo_mae = document.getElementById('cargo_mae');
        let unidad_mae = document.getElementById('unidad_mae');

        //secretaria municipal
        let cargos_sm = document.getElementById('cargo_sm');
        let direccion_sm = document.getElementById('direccion_sm');

        /**@argument
         * PARA LA PARTE DE LA EDICION DEL CONTRATO
         * */

        //PARA LA VALIDACION AMBITO PROFESIONAL
        let select2_categoria = $('#categoria');
        select2_categoria.on('select2:select', async (e)=> {
            let id = select2_categoria.val();
            let nivel = document.getElementById('nivel');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_nivel_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    nivel.innerHTML = '<option selected disabled>[ SELECCIONE EL NIVEL ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = '['+value.nivel+'] : '+value.descripcion;
                            nivel.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                nivel.innerHTML = '<option selected disabled>[ SELECCIONE EL NIVEL ]</option>';
            }
        });

        //PARA LA PARTE DE LA FORMACION ACADEMICO

        let select2_ambito_profesional = $('#ambito_profesional');
        select2_ambito_profesional.on('select2:select', async (e)=> {
            let id = select2_ambito_profesional.val();
            let listar_profesion = document.getElementById('profesion');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_listar_profesion') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    listar_profesion.innerHTML = '<option selected disabled>[ SELECCIONE PROFESIÓN ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            listar_profesion.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                listar_profesion.innerHTML = '<option selected disabled>[ SELECCIONE PROFESIÓN ]</option>';
            }
        });

        //PARA LA PARTE DEL MAE
        let select2_mae_mae = $('#mae_mae');
        select2_mae_mae.on('select2:select', async (e)=> {
            let id = select2_mae_mae.val();
            let unidad_mae = document.getElementById('unidad_mae');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_unidad_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    unidad_mae.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
                    cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.descripcion;
                            unidad_mae.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                unidad.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
            }
        });

        //PARA LA UNIDAD MAE
        let select2_unidad_mae = $('#unidad_mae');
        select2_unidad_mae.on('select2:select', async (e)=> {
            let id = select2_unidad_mae.val();
            let cargo_mae = document.getElementById('cargo_mae');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_cargo_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            cargo_mae.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
            }
        });


        //PARA LAS SECRETARIAS MUNICIPALES
        let select2_secretaria_sm = $('#secretaria_sm');
        select2_secretaria_sm.on('select2:select', async (e)=> {
            let id = select2_secretaria_sm.val();
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_direccion_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
                    cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            direccion_sm.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
            }
        });

        //PARA LISTAR LOS CARGOS SEGUN LA DIRECCION
        let select2_direccion_sm = $('#direccion_sm');
        select2_direccion_sm.on('select2:select', async (e)=> {
            let id = select2_direccion_sm.val();
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_cargo_select_sm') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            cargos_sm.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
            }
        });


        //PARA LA EDICION DEL CONTRATO SE SE EQUIVOCO
        async function editar_contrato(id) {
            //para recuperar los datos
            $('#modal_editar_contratos').modal('show');
            try {
                let respuesta = await fetch("{{ route('cct_editar_contrato') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){

                    document.getElementById('id_contrato_').value = dato.mensaje.id;

                    //para las fechas
                    document.getElementById('fecha_inicio').value = dato.mensaje.fecha_inicio;
                    document.getElementById('fecha_conclusion').value = dato.mensaje.fecha_conclusion;
                    fecha_editar_seleccionado('fecha_inicio', dato.mensaje.fecha_inicio);
                    fecha_editar_seleccionado('fecha_conclusion', dato.mensaje.fecha_conclusion);
                    //fin de las fechas

                    //para el tipo de contrato
                    tipo_contrato_select(dato.mensaje.id_tipo_contrato);
                    $('#tipo_contrato').val(dato.mensaje.id_tipo_contrato).trigger('change');
                    //para el numero de contrato
                    document.getElementById('numero_contrato').value = dato.mensaje.numero_contrato;
                    //fin de la parte del tipo de contrato

                    //del haber basico, o escala salarial
                    document.getElementById('haber_basico').value = conSeparadorComas_normal(dato.mensaje.haber_basico);


                    //primero para la categoria
                    $('#categoria').val(dato.mensaje.nivel.id_categoria).trigger('change');


                    // Listar todos los niveles
                    let listar_nivel = dato.mensaje.nivel.categoria.nivel;

                    // Para el nivel
                    let select_nivel = document.getElementById('nivel');
                    select_nivel.innerHTML = '<option selected disabled>[ SELECCIONE NIVEL ]</option>';

                    listar_nivel.forEach(elem => {
                        let option = document.createElement('option'); // Crear un nuevo elemento option
                        option.value = elem.id;
                        option.textContent = '[' + elem.nivel + '] : ' + elem.descripcion;
                        select_nivel.appendChild(option);
                    });

                    select_nivel.dispatchEvent(new Event('change'));

                    $('#nivel').val(dato.mensaje.id_nivel).trigger('change');
                    //fin de la parte de los niveles

                    //para la parte seleccion de los horarios
                    $('#horario').val(dato.mensaje.id_horario).trigger('change');

                    /**
                     * PARA LA PARTE DE INFORMACION ACADEMICA
                     * */
                    $('#ambito_profesional').val(dato.mensaje.profesion.ambito.id).trigger('change');

                    //para lisatr la profesion
                    let listar_profesion = dato.mensaje.profesion.ambito.profesion;

                    // Para el nivel
                    let select_profesion = document.getElementById('profesion');
                    select_profesion.innerHTML = '<option selected disabled>[ SELECCIONE PROFESIÓN ]</option>';

                    listar_profesion.forEach(elem => {
                        let option = document.createElement('option'); // Crear un nuevo elemento option
                        option.value = elem.id;
                        option.textContent =  elem.nombre;
                        select_profesion.appendChild(option);
                    });

                    select_profesion.dispatchEvent(new Event('change'));

                    $('#profesion').val(dato.mensaje.id_profesion).trigger('change');
                    /**
                     * FIN DE LA PARTE DE INFORMACION ACADAMICA
                     * */

                    //PARA LA PARTE DEL GRADO ACADEMICO
                    $('#grado_academico').val(dato.mensaje.id_grado_academico).trigger('change');

                    if(dato.mensaje.id_cargo_sm != null){
                        $('#mae_sm').val(2).trigger('change');
                        //PARA LA PARTE DE LAS SECRETARIAS MUNICIPALES
                        $('#secretaria_sm').val(dato.mensaje.cargo_sm.direccion.secretaria_municipal.id).trigger('change');

                        //AHORA SELECCIONAMOS A QUE DIRECCION PERTENECE
                        let listar_direcciones = dato.mensaje.cargo_sm.direccion.secretaria_municipal.direcciones;

                        // PARA LA SELECCION DE DIRECCION
                        let select_direccion = document.getElementById('direccion_sm');
                        select_direccion.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';

                        listar_direcciones.forEach(elem => {
                            let option = document.createElement('option'); // Crear un nuevo elemento option
                            option.value = elem.id;
                            option.textContent =  elem.nombre;
                            select_direccion.appendChild(option);
                        });

                        select_direccion.dispatchEvent(new Event('change'));

                        $('#direccion_sm').val(dato.mensaje.cargo_sm.id_direccion).trigger('change');

                        //PARA LA SELECCION DE LOS CARGOS
                        let listar_cargos = dato.mensaje.cargo_sm.direccion.cargos;

                        let select_cargos = document.getElementById('cargo_sm');

                        select_cargos.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';

                        listar_cargos.forEach(elem => {
                            let option = document.createElement('option'); // Crear un nuevo elemento option
                            option.value = elem.id;
                            option.textContent =  elem.nombre;
                            select_cargos.appendChild(option);
                        });

                        select_cargos.dispatchEvent(new Event('change'));
                        $('#cargo_sm').val(dato.mensaje.id_cargo_sm).trigger('change');
                        // PARA LA UNIDAD ADMINISTRATIVA
                        $('#unidad_administrativa_sm').val(dato.mensaje.cargo_sm.unidades_admnistrativas.id).trigger('change');

                    }else{
                        $('#mae_sm').val(1).trigger('change');
                        //PARA LA PARTE DE MAE
                        $('#mae_mae').val(dato.mensaje.cargo_mae.unidad_mae.id_mae).trigger('change');

                        //PARA LA PARTE LISTAR LA UNIDAD
                        let listar_unidades_mae = dato.mensaje.cargo_mae.unidad_mae.mae.unidades_mae;

                        let select_unidad_mae = document.getElementById('unidad_mae');
                        select_unidad_mae.innerHTML = '<option selected disabled>[ SELECCIONE UNIDAD ]</option>';

                        listar_unidades_mae.forEach(elem => {
                            let option = document.createElement('option'); // Crear un nuevo elemento option
                            option.value = elem.id;
                            option.textContent =  elem.descripcion;
                            select_unidad_mae.appendChild(option);
                        });

                        select_unidad_mae.dispatchEvent(new Event('change'));
                        $('#unidad_mae').val(dato.mensaje.cargo_mae.id_unidad).trigger('change');

                        //PARA LA PARTE DE LOS CARGOS
                        let listar_cargos_mae = dato.mensaje.cargo_mae.unidad_mae.cargos;

                        let select_cargos_mae = document.getElementById('cargo_mae');
                        select_cargos_mae.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';

                        listar_cargos_mae.forEach(elem => {
                            let option = document.createElement('option'); // Crear un nuevo elemento option
                            option.value = elem.id;
                            option.textContent =  elem.nombre;
                            select_cargos_mae.appendChild(option);
                        });

                        select_cargos_mae.dispatchEvent(new Event('change'));

                        $('#cargo_mae').val(dato.mensaje.id_cargo_mae).trigger('change');
                    }

                }
                if(dato.tipo === 'error'){

                }
            } catch (error) {
                console.log('error : ', error);
            }
        }

        //para vaciar los errores y cerrar modal
        function cerrar_modal_contrato_editar(){
            $('#modal_editar_contratos').modal('hide');
            vaciar_errores_form_editar();
        }
        //para vaciar los errores que se obtengan
        function vaciar_errores_form_editar(){
            let campos_inp = ['_fecha_inicio', '_fecha_conclusion', '_tipo_contrato', '_numero_contrato', '_haber_basico', '_categoria', '_nivel', '_horario', '_ambito_profesional', '_profesion', '_grado_academico'];
            campos_inp.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }



        //para la edicion de la hora de inicio seleccionado
        function fecha_editar_seleccionado(valor, fecha){
            //repetimos las funciones
            flatpickr("#"+valor, {
                dateFormat: "Y-m-d",
                enableTime: false,
                defaultDate: fecha,
                locale: {
                    firstDayOfWeek: 1,
                },
            });
        }

        //para guardar el contrado editado
        let btn_guardar_contrato_update = document.getElementById('btn_guardar_contrato_edit');
        let form_contrato_update = document.getElementById('formulario_editar_contrato');
        btn_guardar_contrato_update.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_contrato_update).entries());
            console.log(datos);
            vaciar_errores_form_editar();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_contrato_edit');
            try {
                let respuesta = await fetch("{{ route('cct_editar_contrato_save') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_contrato_edit');
                }
                if(dato.tipo === 'success'){
                    alerta_top_end(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_contrato_edit');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_contrato_edit');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_contrato_edit');
            }
        });
        /**
         * FIN DE LA PARTE DE EDICION DEL CONTRATO
         * */


        /**
         * - ADMINISTRACIÓN DE LOS CONTRATOS MODIFICATORIOS
         * */
        async function contratos_modificatorios(id){
            $('#modal_listar_modificatorios').modal('show');
        }
        /**
         * - FIN DE LA ADMINISTRACIÓN DE LOS CONTRATOS MODIFICATORIOS
         * */


    </script>

@endsection
