@extends('principal')
@section('titulo', ' | LICENCIA BOLETA')
@section('contenido')

    <div class="card p-0 mb-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: BOLETA - LICENCIA :::::::: </h5>
        </div>
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
            <div class="app-academy-md-25 card-body py-0">
                <img src="{{ asset('admin_template/img/illustrations/bulb-light.png') }}"
                    class="img-fluid app-academy-img-height scaleX-n1-rtl" height="90" />
            </div>
            <div class=" col-12 card-body d-flex align-items-md-center flex-column">
                <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                    Busqueda por CI
                </h3>
                <div class="select2-container">
                    <select id="buscar_ci_persona" class="select2 " style="width: 100%" onchange="buscar_ci(this.value)">
                        <option selected disabled>[ BUSQUEDA DE PERSONA ]</option>
                        @foreach ($personas as $lis)
                            <option value="{{ $lis->ci }}">{{ $lis->ci.' '.$lis->nombres.' '.$lis->ap_paterno.' '.$lis->ap_materno }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                <img src="{{ asset('admin_template/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket"
                    height="188" class="scaleX-n1-rtl" />
            </div>
        </div>
    </div>

    <div class="card mb-1">
        <h5 class="card-header">FORMULARIO BOLETA - LICENCIA</h5>
        <div class="card-body">
            <div id="mensaje_persona"></div>
            <div id="datos_persona"></div>
            <form id="form_boleta_licencia" method="post">
                <input type="hidden" name="id_persona" id="id_persona">
                <input type="hidden" name="id_contrato" id="id_contrato">
                <div class="mb-2 row">
                    <label for="licencia" class=" col-4 col-form-label">SELECCIONE LA LICENCIA</label>
                    <div class="col-8" >
                        <select  name="licencia" id="licencia" class="select2 with_100" @disabled(true)>
                            <option value="0" selected disabled>[ SELECCIONE LICENCIA ]</option>
                            @foreach ($licencias as $lis)
                                <option value="{{ $lis->id }}">{{ ' [ '.$lis->motivo.' ] : '.$lis->jornada_laboral }}</option>
                            @endforeach
                        </select>
                        <div id="_licencia" ></div>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="fecha_inicio" class="col-md-4 col-form-label">SELECCIONE LA FECHA Y HORA DE INICIO</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Ingrese la fecha inicio" id="fecha_inicio" name="fecha_inicio" onchange="validar_fechas(event)" @disabled(true)/>
                        <div id="_fecha_inicio"></div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Ingrese la hora de inicio" value="00:00" id="hora_inicio" name="hora_inicio" onchange="validar_horas()" @disabled(true) />
                        <div id="_hora_inicio" ></div>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="fecha_final" class="col-md-4 col-form-label">SELECCIONE LA FECHA Y HORA DE FINALIZACIÓN</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Ingrese la fecha final" id="fecha_final" name="fecha_final" onchange="validar_fechas(event)" @disabled(true)/>
                        <div id="_fecha_final" ></div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Ingrese la hora de final" value="00:00" id="hora_final" name="hora_final" onchange="validar_horas()" @disabled(true)/>
                        <div id="_hora_final" ></div>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="descripcion" class="col-md-4 col-form-label">INGRESE LA RAZÓN (No es obligatorio)</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2" placeholder="Ingrese la descripción" @disabled(true)></textarea>
                        <div id="_descripcion" ></div>
                    </div>
                </div>
            </form>

            <div class="card-footer">
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    @can('boletas_generar_licencia_nuevo')
                        <button class="btn btn-primary btn-md"  id="btn_guardar_datos_licencia" @disabled(true) type="button">Guardar</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-1" id="listado_boletas_licencia">
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_boleta_licencia" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>ACCIONES</th>
                        <th>FECHA GENERADA</th>
                        <th>FECHA Y HORA INICIO</th>
                        <th>FECHA Y HORA FINAL</th>
                        {{-- <th>DESCRIPCIÓN</th> --}}
                        <th>APROBADO</th>
                        <th>CONSTANCIA</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>




    <!-- Update editar licencia -->
    <div class="modal fade" id="modal_editar_licencia" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3 p-md-1">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Boleta - Licencia</h3>
                    </div>
                    <form id="formulario_edit_boleta_licencia" method="post">
                        <input type="hidden" name="id_licencia" id="id_licencia">
                        <input type="hidden" name="id_persona_" id="id_persona_">
                        <div class="mb-2 row">
                            <label for="licencia" class=" col-4 col-form-label">SELECCIONE LA LICENCIA</label>
                            <div class="col-8" >
                                <select  name="licencia_" id="licencia_" class="select2 with_100">
                                    <option value="0" selected disabled>[ SELECCIONE LICENCIA ]</option>
                                    @foreach ($licencias as $lis)
                                        <option value="{{ $lis->id }}">{{ ' [ '.$lis->motivo.' ] : '.$lis->jornada_laboral }}</option>
                                    @endforeach
                                </select>
                                <div id="_licencia" ></div>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="fecha_inicio_" class="col-md-4 col-form-label">SELECCIONE LA FECHA Y HORA DE INICIO</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Ingrese la fecha inicio" id="fecha_inicio_" name="fecha_inicio_" onchange="validar_fechas(event)"/>
                                <div id="_fecha_inicio_" ></div>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Ingrese la hora de inicio" value="00:00" id="hora_inicio_" name="hora_inicio_" onchange="validar_horas()" />
                                <div id="_hora_inicio_" ></div>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="fecha_final_" class="col-md-4 col-form-label">SELECCIONE LA FECHA Y HORA DE FINALIZACIÓN</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Ingrese la fecha final" id="fecha_final_" name="fecha_final_" onchange="validar_fechas(event)" />
                                <div id="_fecha_final_" ></div>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Ingrese la hora de final" value="00:00" id="hora_final_" name="hora_final_" onchange="validar_horas()" />
                                <div id="_hora_final_" ></div>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="descripcion_" class="col-md-4 col-form-label">INGRESE LA RAZÓN (No es obligatorio)</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="descripcion_" id="descripcion_" cols="30" rows="2" placeholder="Ingrese la descripción" ></textarea>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_edit_boleta_licencia" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update editar licencia -->



    <!-- VIZUALIZAR PERMISO DETALLES -->
    <div class="modal fade" id="modal_vizualizar_detalles" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-1 p-md-2">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4" id="vizualizar_detalles_licencia_html">
                        <h3 class="mb-2">Vizualizar detalles</h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ VIZUALIZAR PERMISO DETALLES -->

@endsection
@section('scripts')
    <script>
        hora_flatpickr('hora_inicio');
        hora_flatpickr('hora_final');

        //para la validacion de las fechas
        function hora_flatpickr(hora) {
            flatpickr("#" + hora, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "08:00",
                minTime: "08:00",
                maxTime: "19:00"
            });
        }

        fechas_flatpicker('fecha_inicio');
        fechas_flatpicker('fecha_final');

        //para la validacion de las fechas
        function fechas_flatpicker(fecha){
            // Obtener la fecha de hace 30 días
            let fechaInicio = new Date();
            fechaInicio.setDate(fechaInicio.getDate() - 10);

            flatpickr("#"+fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                // Establecer la fecha mínima como hace 30 días
                minDate: fechaInicio,
            });
        }

        //para las fechas flatpicker
        function reset_fecha(){
            fechas_flatpicker('fecha_inicio');
            fechas_flatpicker('fecha_final');
        }

        //funcion para las horas de flatpicker
        function reset_hora(){
            hora_flatpickr('hora_inicio');
            hora_flatpickr('hora_final');
        }

        //PARA LA VALIDACION DE LAS FECHAS
        function validar_fechas() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaConclusion = document.getElementById('fecha_final').value;
            let horaFinal = document.getElementById('hora_final').value;

            let fechaInicioObj = new Date(fechaInicio);
            let fechaConclusion0bj = new Date(fechaConclusion);

            // Ajustar las fechas para ignorar las horas
            fechaInicioObj.setHours(0, 0, 0, 0);
            fechaConclusion0bj.setHours(0, 0, 0, 0);

            if (fechaConclusion0bj < fechaInicioObj) {
                alerta_top('error', 'La fecha final debe ser igual o después de la fecha de inicio. Por favor, selecciona una fecha válida.');
                document.getElementById('fecha_final').value = '';
                document.getElementById('hora_final').value = '08:00';
            }else{
                validar_horas();
            }
        }
        //PARA LA VALIDACION DE LAS HORAS
        function validar_horas() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaFinal = document.getElementById('fecha_final').value;
            let horaInicio = document.getElementById('hora_inicio').value;
            let horaFinal = document.getElementById('hora_final').value;

            let fechaInicioObj = new Date(fechaInicio + 'T' + horaInicio);
            let fechaFinalObj = new Date(fechaFinal + 'T' + horaFinal);

            if (fechaFinalObj < fechaInicioObj) {
                alertify.error("La hora final debe ser igual o después de la hora de inicio. Por favor, selecciona una hora válida.");
                document.getElementById('hora_final').value = '08:00';
                reset_hora();
            }
        }


        let mensaje_persona     = document.getElementById('mensaje_persona');
        let datos_persona       = document.getElementById('datos_persona');
        let persona_id          = document.getElementById('id_persona');
        let contrato_id         = document.getElementById('id_contrato');

        let regex = /^[0-9]+$/;

        //PARA LA VALIDACION DE LA PERSONA SI ES QUE TIENE CONTRATO ESTABLECIDO O NO
        async function buscar_ci(ci){
            vaciar_errores_form_boleta_licencia();
            if(ci.length >= 5 && regex.test(ci)){
                try {
                    let respuesta = await fetch("{{ route('cbol_persona_ci') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ci:ci})
                    });
                    let dato = await respuesta.json();
                    if(dato.tipo === 'success'){
                        mensaje_persona.innerHTML = `<div class="alert alert-success alert-dismissible" role="alert"> <strong>Persona resgistrada y con contrato vigente</strong> </div>`;
                        datos_persona.innerHTML = `
                            <div class="alert alert-primary alert-dismissible" role="alert">
                                <table>
                                    <tr>
                                        <th><strong> CI </strong></th>
                                        <th> : `+dato.mensaje[0].persona.ci+`</th>
                                    </tr>
                                    <tr>
                                        <th><strong>NOMBRE</strong></th>
                                        <th> : `+dato.mensaje[0].persona.nombres+` `+dato.mensaje[0].persona.ap_paterno+` `+dato.mensaje[0].persona.ap_materno+`</th>
                                    </tr>

                                </table>
                            </div>
                        `;
                        persona_id.value    = dato.mensaje[0].id_persona;
                        contrato_id.value   = dato.mensaje[0].id_contrato;
                        desabilitar_habilitar(false);
                        actulizar_tabla();
                        listar_bolestas_licencias(dato.mensaje[0].persona.id);
                    }
                    if(dato.tipo === 'error'){
                        mensaje_persona.innerHTML = `<div class="alert alert-danger alert-dismissible" role="alert"> <strong>`+dato.mensaje+` </strong> </div>`;
                        if(dato.persona_per){
                            datos_persona.innerHTML = `
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <table>
                                    <tr>
                                        <th><strong> CI </strong></th>
                                        <th> : `+dato.persona_per.ci+`</th>
                                    </tr>
                                    <tr>
                                        <th><strong>NOMBRE</strong></th>
                                        <th> : `+dato.persona_per.nombres+` `+dato.persona_per.ap_materno+` `+dato.persona_per.ap_paterno+`</th>
                                    </tr>
                                </table>
                            </div>`;
                        }else{
                            datos_persona.innerHTML = ``;
                        }
                        persona_id.value    = '';
                        contrato_id.value   = '';
                        desabilitar_habilitar(true);
                        vaciar_datos();
                        actulizar_tabla();
                        listar_bolestas_licencias(0);
                    }
                } catch (error) {
                    console.log('Ocurrio un error :' + error );
                    mensaje_persona.innerHTML   = ``;
                    datos_persona.innerHTML     = ``;
                    persona_id.value            = '';
                    contrato_id.value           = '';
                    desabilitar_habilitar(true);
                    vaciar_datos();
                    actulizar_tabla();
                    listar_bolestas_licencias(0);
                }
            }else{
                mensaje_persona.innerHTML   = ``;
                datos_persona.innerHTML     = ``;
                persona_id.value            = '';
                contrato_id.value           = '';
                desabilitar_habilitar(true);
                vaciar_datos();
                /*  actulizar_tabla();
                listar_bolestas_licencias(0); */
            }
        }

        //para vaciar los errores de boleta - licencia
        function vaciar_errores_form_boleta_licencia() {
            let datos = ['_licencia', '_fecha_inicio', '_hora_inicio', '_fecha_final', '_hora_final'];
            datos.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }
        //para desabilitar o habilitar los input del formulario
        function desabilitar_habilitar(valor){
            let datos = ['licencia', 'fecha_inicio', 'hora_inicio', 'fecha_final', 'hora_final', 'descripcion', 'btn_guardar_datos_licencia'];
            datos.forEach(elem => {
                document.getElementById(elem).disabled = valor;
            });
            form_select2();
        }

        //para los select 2
        function form_select2(){
            $('#licencia').val('0').trigger('change');
        }

        //para el vaciado de los datos
        function vaciar_datos(){
            let valores = ['fecha_inicio','fecha_final', 'descripcion'];
            valores.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            reset_hora();
            reset_fecha();
        }

        //para actualizar la tabla
        function actulizar_tabla(){
            $('#tabla_boleta_licencia').DataTable().destroy();
            $('#tabla_boleta_licencia').fadeIn(200);
        }

        //para listar las licencias - boletas
        async function listar_bolestas_licencias(id) {
            if(id != 0){
                let respuesta = await fetch("{{ route('licen_boleta_listar') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                let i = 1;
                if(dato.tipo == 'success'){
                    $('#tabla_boleta_licencia').DataTable({
                        responsive: true,
                        data: dato.mensaje,
                        columns: [
                            {
                                data: null,
                                className: 'table-td',
                                render: function() {
                                    return i++;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row, meta) {
                                    return `
                                        <div class="d-inline-block tex-nowrap">

                                            @can('boletas_generar_licencia_pdf')
                                                <button type="button" onclick="imprimir_boleta_licencia('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF">
                                                    <i class="ti ti-cloud-down" ></i>
                                                </button>
                                            @endcan

                                            @can('boletas_generar_licencia_editar')
                                                <button type="button" onclick="editar_licencia_boleta('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                                    <i class="ti ti-edit" ></i>
                                                </button>
                                            @endcan

                                            @can('boletas_generar_licencia_vizualizar')
                                                <button type="button" onclick="vizualizar_detalles_licencia('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                                    <i class="ti ti-eye" ></i>
                                                </button>
                                            @endcan

                                            @can('boletas_generar_licencia_eliminar')
                                                <button type="button" onclick="eliminar_licencia_boleta('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR">
                                                    <i class="ti ti-trash" ></i>
                                                </button>
                                            @endcan

                                        </div>
                                    `;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row) {
                                    return `<div class="text-danger">`+fecha_literal(data.fecha, 4)+` </div>`;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row, meta) {
                                    return `<div class="text-primary">`
                                        +fecha_literal(data.fecha_inicio, 4)+` `+data.hora_inicio+` </div>`;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row, meta) {
                                    return `<div class="text-primary">`
                                        +fecha_literal(data.fecha_final, 4)+` `+data.hora_final+` </div>`;
                                }
                            },
                            /* {
                                data: 'descripcion',
                                className: 'table-td'
                            }, */
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row, meta) {
                                    return `
                                        @can('boletas_generar_licencia_aprobado')
                                            <label class="switch switch-primary">
                                                <input onclick="licencia_aprobado('${row.id}', '${row.id_persona}')" type="checkbox" class="switch-input" ${row.aprobado === 1 || row.aprobado === true ? 'checked' : ''} />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>
                                            </label>
                                        @endcan
                                    `;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row, meta) {
                                    return `
                                        @can('boletas_generar_licencia_constancia')
                                            <label class="switch switch-primary">
                                                <input onclick="licencia_constancia('${row.id}', '${row.id_persona}')" type="checkbox" class="switch-input" ${row.constancia === 1 || row.constancia === true ? 'checked' : ''} />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>
                                            </label>
                                        @endcan
                                    `;
                                }
                            },
                        ]
                    });
                }
                if(dato.tipo == 'error'){
                    $('#tabla_boleta_licencia').DataTable().clear().draw();
                }
            }else{
                $('#tabla_boleta_licencia').DataTable().clear().draw();
            }
        }

        //PARA GUARDAR EL REGISTRO DE LA LICENCIA
        let boton_guardar_datos_licencia = document.getElementById('btn_guardar_datos_licencia');
        let form_datos_licencia = document.getElementById('form_boleta_licencia');
        boton_guardar_datos_licencia.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_datos_licencia).entries());
            vaciar_errores_form_boleta_licencia();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_datos_licencia');
            try {
                let respuesta = await fetch("{{ route('licen_boleta_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_datos_licencia');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_datos_licencia');
                    vaciar_datos();
                    desabilitar_habilitar(false);
                    actulizar_tabla();
                    listar_bolestas_licencias(dato.id_persona);
                    setTimeout(() => {
                        imprimir_boleta_licencia(dato.id_licencia_id);
                    }, 1500);

                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_datos_licencia');
                    actulizar_tabla();
                    listar_bolestas_licencias(dato.id_persona_edi);
                }
            } catch (error) {
                console.log('Error '+ error);
                validar_boton(false, 'Guardar', 'btn_guardar_datos_licencia');
                actulizar_tabla();
            }
        });


        //para cambiar estado = aprobado
        async function licencia_aprobado(id, id_persona) {
            Swal.fire({
                title: "¿Estás seguro cambiar de estado la Licencia?",
                text: "¡Nota!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, seguro",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('licen_boleta_aprobado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla();
                            listar_bolestas_licencias(dato.id_persona);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla();
                            listar_bolestas_licencias(id_persona);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla();
                    listar_bolestas_licencias(id_persona);
                }
            });
        }


        //para cambiar el estado = constancia
        async function licencia_constancia(id, id_persona) {
            Swal.fire({
                title: "¿Estás seguro de aprobar la constancia?",
                text: "¡Nota!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, aprobar",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('licen_boleta_constancia') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla();
                            listar_bolestas_licencias(dato.id_persona);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla();
                            listar_bolestas_licencias(id_persona);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla();
                    listar_bolestas_licencias(id_persona);
                }
            });
        }


        //PARA LA VIZUALIZACION DE LA LICENCIA
        async function vizualizar_detalles_licencia(id) {
            try {
                let formData = new FormData();
                formData.append('id', id);
                formData.append('_token', token);
                let respuesta = await fetch("{{ route('licen_boleta_vizualizar') }}", {
                    method: 'POST',
                    body: formData
                });
                if (respuesta.ok) {
                    $('#modal_vizualizar_detalles').modal('show');
                    let data = await respuesta.text();
                    document.getElementById('vizualizar_detalles_licencia_html').innerHTML = data;
                } else {
                    console.log('Error en la solicitud', respuesta.status);
                    document.getElementById('vizualizar_detalles_licencia_html').innerHTML = '';
                }
            } catch (error) {
                console.log('Ocurrio un error : ' + error);
                listado_html.innerHTML = '';
            }
        }

        //PARA ELIMINAR LA LICENCIA
        async function eliminar_licencia_boleta(id) {
            Swal.fire({
                title: "¿Estás seguro de eliminar?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminarlo",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('licen_boleta_eliminar') }}",{
                            method: "DELETE",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla();
                            listar_bolestas_licencias(dato.id_persona);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                }
            });
        }


        //PARA REALZIAR LA EDICIÓN DE LA LICENCIA
        async function editar_licencia_boleta(id) {
            vaciar_datos();
            form_select2();
            vaciar_errores_form_boleta_licencia();
            try {
                let respuesta = await fetch("{{ route('licen_boleta_edit') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo==='success'){
                    $('#modal_editar_licencia').modal('show');

                    document.getElementById('id_persona_').value = dato.mensaje.id_persona;

                    document.getElementById('id_licencia').value = dato.mensaje.id;
                    $('#licencia_').val(dato.mensaje.id_tipo_licencia).trigger('change');

                    //PARA LA FECHAS
                    //para que se muestre las fechas de la fecha de inicio
                    document.getElementById('fecha_inicio_').value = dato.mensaje.fecha_inicio;

                    //para que se muestra las fechas de fecha final
                    document.getElementById('fecha_final_').value = dato.mensaje.fecha_final;

                    //para mostrar la fecha inici
                    fecha_editar_seleccionado('fecha_inicio_', dato.mensaje.fecha_inicio);

                    //para mostrar la fecha final
                    fecha_editar_seleccionado('fecha_final_', dato.mensaje.fecha_final);

                    //AHORA PARA LA HORA
                    //para la hora de inicio
                    document.getElementById('hora_inicio_').value = dato.mensaje.hora_inicio;
                    //para la hora final
                    document.getElementById('hora_final_').value = dato.mensaje.hora_final;

                    hora_editar_seleccionado('hora_inicio_', dato.mensaje.hora_inicio);

                    hora_editar_seleccionado('hora_final_', dato.mensaje.hora_final);

                    //para la descripcion

                    document.getElementById('descripcion_').value = dato.mensaje.descripcion;

                }
                if(dato.tipo==='error'){

                }
            } catch (error) {
                console.log('error : '+ error);
            }
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

        //para la edicion de la hora final seleccionada
        function hora_editar_seleccionado(valor, hora){
            flatpickr("#" + valor, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: hora,
            });
        }

        //para guardar lo editado
        let btn_save_edit_boleta_licencia = document.getElementById('btn_guardar_edit_boleta_licencia');
        let form_edit_boleta_licencia     = document.getElementById('formulario_edit_boleta_licencia');


        //para guardar lo editados
        btn_save_edit_boleta_licencia.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_edit_boleta_licencia).entries());
            vaciar_errores_form_boleta_licencia();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_edit_boleta_licencia');
            try {
                let respuesta = await fetch("{{ route('licen_boleta_editar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_edit_boleta_licencia');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_edit_boleta_licencia');
                    actulizar_tabla();
                    listar_bolestas_licencias(dato.id_persona);
                    $('#modal_editar_licencia').modal('hide');



                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_edit_boleta_licencia');
                    actulizar_tabla();
                    listar_bolestas_licencias(dato.id_persona_edi);
                }

            } catch (error) {
                console.log('Error '+ error);
                validar_boton(false, 'Guardar', 'btn_guardar_edit_boleta_licencia');
                actulizar_tabla();
            }
        });

        //Para generar la boleta de la licencia
        //para redireccionar el pdf
        async function imprimir_boleta_licencia(id){
            try {
                let respuesta = await fetch("{{ route('enc_crypt') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                alerta_top_end('success', 'Abriendo pdf con éxito, espere un momento!');
                setTimeout(() => {
                    let url_boleta_licencia = "{{ route('cra_licencia_boleta_pdf', ['id' => ':id']) }}";
                    url_boleta_licencia     = url_boleta_licencia.replace(':id', dato.mensaje);
                    window.open(url_boleta_licencia, '_blank');
                }, 2000);
            } catch (error) {
                console.log('error : ' +error);
            }
        }

    </script>
@endsection
