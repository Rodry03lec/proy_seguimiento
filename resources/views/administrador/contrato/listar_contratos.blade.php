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
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
@endsection

@section('scripts')
    <script>

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
                                        <button class="btn btn-sm btn-icon" onclick="vizualizar_contrato('${row.id}')" type="button">
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
                                        <button class="btn btn-sm btn-icon" onclick="editar_contrato('${row.id}')" type="button">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('persona_listar_contratos_eliminar')
                                        <button class="btn btn-sm btn-icon" onclick="eliminar_contrato('${row.id}')" type="button">
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
            console.log(id);
            /* try { */
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
            /* } catch (error) {
                console.log('Ocurrio un error : ' + error);
                listado_html.innerHTML = '';
            } */
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

        //PARA LA EDICION DEL CONTRATO SE SE EQUIVOCO

    </script>

@endsection
