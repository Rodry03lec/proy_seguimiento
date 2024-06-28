@extends('principal')
@section('titulo', ' | EXCEPCION HORARIO')

@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: EXCEPCIÓN HORARIO  :::::::: </h5>
            @can('horarios_vizualizar_especificacion_horas_excepciones_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#excepcion_horario_modal">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan

        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_excepcion_horario" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA INCIAL</th>
                        <th>FECHA FINAL</th>
                        <th>HORA DE ENTRADA</th>
                        <th>ESTADO</th>
                        <th>DIAS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <!-- Add excepción Modal -->
    <div class="modal fade" id="excepcion_horario_modal" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-1">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_excepcion()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">NUEVA EXCEPCIÓN</h3>
                    </div>
                    <form id="formulario_nueva_excepcion" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden"  name="id_rango_hora" id="id_rango_hora" value="{{ $id_rango_hora }}"  >
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">Ingrese la descripción por la cual esta realizando esto!</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="2" class="form-control" placeholder="Ingrse la descripción por la cual esta realizando esto!" ></textarea>
                                <div id="_descripcion"></div>
                            </div>
                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="hora">Seleccione Hora de Entrada</label>
                                @php
                                    $time_hora_inicial = strtotime($rango_hora->hora_final) - 3600;
                                    $time_hora_final = strtotime($rango_hora->hora_final) + 3600;
                                @endphp
                                <!-- Crea el menú desplegable con opciones de horas -->
                                <select name="hora" id="hora" class="select2">
                                    <option value="selected" selected disabled>[SELECCIONE HORA DE ENTRADA]</option>
                                    @for ($i = $time_hora_inicial; $i <= $time_hora_final; $i += 900)
                                        <option value="{{ date('H:i:s', $i) }}">{{ date('H:i:s', $i) }}</option>
                                    @endfor
                                </select>
                                <div id="_hora"></div>
                            </div>

                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="fecha_inicial">Seleccione fecha de Inicio</label>
                                <input type="text" id="fecha_inicial" name="fecha_inicial" class="form-control" placeholder="Seleccione una fecha inicial" onchange="validar_fechas()">
                                <div id="_fecha_inicial"></div>
                            </div>

                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="fecha_final">Seleccione fecha de Inicio</label>
                                <input type="text" id="fecha_final" name="fecha_final" class="form-control" placeholder="Seleccione una fecha final" onchange="validar_fechas()">
                                <div id="_fecha_final"></div>
                            </div>

                        </div>

                        <div class="row row-bordered g-0 py-2">
                            <small class="text-light fw-medium">Seleccione dias de la semana</small>
                                @foreach ($dias_semana as $lis)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 p-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $lis->sigla }}" name="dias_semana[]" value="{{ $lis->id }}" />
                                            <label class="form-check-label" for="{{ $lis->sigla }}">
                                                [{{ $lis->sigla }}] : {{ $lis->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_excepcion" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_excepcion()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add excepción Modal -->


    <!-- Modal -->
    <!-- Editar la excepcion Modal -->
    <div class="modal fade" id="excepcion_editar_modal" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-1">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">EDITAR EXCEPCIÓN</h3>
                    </div>
                    <form id="formulario_editar_excepcion" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_excepcion" id="id_excepcion">
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">Ingrese la descripción por la cual esta realizando esto!</label>
                                <textarea name="descripcion_" id="descripcion_" cols="30" rows="2" class="form-control" placeholder="Ingrse la descripción por la cual esta realizando esto!" ></textarea>
                                <div id="_descripcion_"></div>
                            </div>
                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="hora">Seleccione Hora de Entrada</label>
                                @php
                                    $time_hora_inicial = strtotime($rango_hora->hora_final) - 3600;
                                    $time_hora_final = strtotime($rango_hora->hora_final) + 3600;
                                @endphp
                                <!-- Crea el menú desplegable con opciones de horas -->
                                <select name="hora_" id="hora_" class="select2">
                                    <option value="selected" selected disabled>[SELECCIONE HORA DE ENTRADA]</option>
                                    @for ($i = $time_hora_inicial; $i <= $time_hora_final; $i += 900)
                                        <option value="{{ date('H:i:s', $i) }}">{{ date('H:i:s', $i) }}</option>
                                    @endfor
                                </select>
                                <div id="_hora_"></div>
                            </div>

                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="fecha_inicial_">Seleccione fecha de Inicio</label>
                                <input type="text" id="fecha_inicial_" name="fecha_inicial_" class="form-control" placeholder="Seleccione una fecha inicial" onchange="validar_fechas_edit()">
                                <div id="_fecha_inicial_"></div>
                            </div>

                            <div class="col-12 mb-3 py-2">
                                <label class="form-label" for="fecha_final_">Seleccione fecha de Inicio</label>
                                <input type="text" id="fecha_final_" name="fecha_final_" class="form-control" placeholder="Seleccione una fecha final" onchange="validar_fechas_edit()">
                                <div id="_fecha_final_"></div>
                            </div>

                        </div>

                        <div class="row row-bordered g-0 py-2">
                            <small class="text-light fw-medium">Seleccione dias de la semana</small>
                                @foreach ($dias_semana as $lis)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 p-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $lis->sigla.'_' }}" name="dias_semana_[]" value="{{ $lis->id }}" />
                                            <label class="form-check-label" for="{{ $lis->sigla }}">
                                                [{{ $lis->sigla }}] : {{ $lis->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_editar_excepcion" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Editar la excepcion Modal -->
@endsection
@section('scripts')
    <script>
        let id_rang_hora = {{ $id_rango_hora }};

        function desmarcarTodo() {
            let checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }

        //cerrar_modal_excepcion
        function cerrar_modal_excepcion() {
            $('#excepcion_horario_modal').modal('hide');
            vaciar_formulario(document.getElementById('formulario_nueva_excepcion'));
            desmarcarTodo();
            vaciar_errores();
        }

        flatpickr("#fecha_inicial", {
            dateFormat: "Y-m-d",
            enableTime: false,
            minDate: new Date().fp_incr(-365),  // Resta 365 días a la fecha actual
            maxDate: new Date().fp_incr(365),  // Añade 365 días (un años) a la fecha actual
            disable: [
                function(date) {
                    // Devuelve true para deshabilitar días específicos, si es necesario
                    return (date.getDay() === 0 || date.getDay() === 7);
                }
            ],
            locale: {
                firstDayOfWeek: 1,
            },
            // Otras opciones y configuraciones aquí
        });


        flatpickr("#fecha_final", {
            dateFormat: "Y-m-d",
            enableTime: false,
            minDate: new Date().fp_incr(-365),  // Resta 365 días a la fecha actual
            maxDate: new Date().fp_incr(365),  // Añade 365 días (un años) a la fecha actual
            disable: [
                function(date) {
                    // Devuelve true para deshabilitar días específicos, si es necesario
                    return (date.getDay() === 0 || date.getDay() === 7);
                }
            ],
            locale: {
                firstDayOfWeek: 1,
            },
            // Otras opciones y configuraciones aquí
        });


        //para la validacion de la fechasss
        function validar_fechas(){
            let fecha_inicio    = new Date(document.getElementById('fecha_inicial').value);
            let fecha_final     = new Date(document.getElementById('fecha_final').value);
            if(fecha_inicio > fecha_final){
                alerta_top('error', 'la fecha final debe ser mayor a la fecha final');
                document.getElementById('fecha_final').value = '';
            }
        }

        //para la parte de vaciar errores
        function vaciar_errores(){
            let input_errors = ['_descripcion', '_hora', '_fecha_inicial', '_fecha_final','_descripcion_', '_hora_', '_fecha_inicial_', '_fecha_final_'];
            input_errors.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
            //para el select
            $('#hora').val('selected').trigger('change');
        }

        //PAR AEL GUARDADO DEL FORMULARIO
        let btn_guardar_excepcion = document.getElementById('btn_guardar_excepcion');
        let form_excepcion = document.getElementById('formulario_nueva_excepcion');
        btn_guardar_excepcion.addEventListener('click',  async ()=>{
            let datos = Object.fromEntries(new FormData(form_excepcion).entries());
            let dia_semana = [];
            let chexbox = document.querySelectorAll('input[name="dias_semana[]"]:checked');
            chexbox.forEach(function (checkbox) {
                dia_semana.push(checkbox.value);
            });
            validar_boton(true, 'Guardando', 'btn_guardar_excepcion');
            try {
                let respuesta = await fetch("{{ route('exept_guardar') }}", {
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id_rango_hora   : datos.id_rango_hora,
                        dia_semana      : dia_semana,
                        descripcion     : datos.descripcion,
                        hora            : datos.hora,
                        fecha_inicial   : datos.fecha_inicial,
                        fecha_final     : datos.fecha_final,
                    })
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_excepcion');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    actulizar_tabla_excepcion();
                    cerrar_modal_excepcion();
                    validar_boton(false, 'Guardar', 'btn_guardar_excepcion');
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_excepcion');
                }
            } catch (error) {
                console.log('Ocurrio un error :'+ error);
            }
        });

        //funcion  de acctualizar tabla
        function actulizar_tabla_excepcion() {
            $('#tabla_excepcion_horario').DataTable().destroy();
            listar_excepcion();
            $('#tabla_excepcion_horario').fadeIn(200);
        }

        //para listar la excepcion de horario
        async function listar_excepcion() {
            let respuesta = await fetch("{{ route('exept_listar') }}",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({id_rang_hora:id_rang_hora})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_excepcion_horario').DataTable({
                responsive: true,
                data: dato,
                columns: [
                    {
                        data: null,
                        className: 'table-td',
                        render: function(){
                            return i++;
                        }
                    },
                    {
                        data: 'descripcion',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row) {
                            return `<div class="alert alert-success p-2" role="alert">
                                    `+fecha_literal(data.fecha_inicio, 4)+`
                                </div>
                                `;
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row) {
                            return `<div class="alert alert-danger p-2" role="alert">
                                    `+fecha_literal(data.fecha_final, 4)+`
                                </div>
                                `;
                        }
                    },

                    {
                        data: 'hora',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta){
                            if(data.estado=='activo'){
                                return `
                                @can('horarios_vizualizar_especificacion_horas_excepciones_estado')
                                    <label class="switch switch-success">
                                        <input onclick="estado_excepcion_horario('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                            }else{
                                return `<div class="demo-inline-spacing">
                                    <span class="badge bg-danger">${data.estado}</span>
                                </div>`
                            }
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, typsse, row, meta) {
                            let array1 = data.dias_semana_excepcion;
                            return array1.map(element =>
                                `<div class="py-1">
                                    <span class="badge bg-label-warning">${element.nombre}</span>
                                </div>`
                            ).join('');
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.estado==='activo'){
                                return `
                                    @can('horarios_vizualizar_especificacion_horas_excepciones_editar')
                                        <div class="d-inline-block tex-nowrap">
                                            <button type="button" onclick="editar_excepcion('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                                <i class="ti ti-edit" ></i>
                                            </button>
                                        </div>
                                    @endcan

                                `;
                            }else{
                                return '';
                            }

                        }
                    }
                ]
            });
        }
        listar_excepcion();


        //para la parte de la excepcion del horario
        function estado_excepcion_horario(id){
            Swal.fire({
                title: "¿Estás seguro de desabilitar la excepción?",
                text: "¡Nota: recuerde que no podra cambiar !",
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
                        let respuesta = await fetch("{{ route('exept_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            //destruimos la tabla
                            actulizar_tabla_excepcion();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla_excepcion();
                }
            });
        }


        //para editar la parte de la excepcion
        async function editar_excepcion(id){
            $('#excepcion_editar_modal').modal('show');
            try {
                let respuesta = await fetch("{{ route('exept_edit') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo=='success'){
                    //requerimos el ID
                    document.getElementById('id_excepcion').value = dato.mensaje.id;

                    //para la descripcion
                    document.getElementById('descripcion_').value = dato.mensaje.descripcion;

                    //para la hora
                    $('#hora_').val(dato.mensaje.hora).trigger('change');

                    //para las fechas
                    document.getElementById('fecha_inicial_').value = dato.mensaje.fecha_inicio;

                    document.getElementById('fecha_final_').value = dato.mensaje.fecha_final;

                    fecha_editar_seleccionado('fecha_inicial_', dato.mensaje.fecha_inicio);

                    fecha_editar_seleccionado('fecha_final_', dato.mensaje.fecha_final);

                    //aqui llenamos los chexbox
                    dato.mensaje.dias_semana_excepcion.forEach(dia_sem => {
                        let checkbox = document.getElementById(dia_sem.sigla + '_');
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
                if(dato.tipo=='error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error : '+ error);
            }
        }

        function fecha_editar_seleccionado(valor, fecha){
            //repetimos las funciones
            flatpickr("#"+valor, {
                dateFormat: "Y-m-d",
                enableTime: false,
                defaultDate: fecha,
                minDate: new Date().fp_incr(-365),
                maxDate: new Date().fp_incr(365),
                disable: [
                    function(date) {
                        return (date.getDay() === 0 || date.getDay() === 7);
                    }
                ],
                locale: {
                    firstDayOfWeek: 1,
                },
            });
        }

        //para cerar el modal
        function cerrar_modal_edita_exception(){
            //para cerrar el modal de editar el modal
            $('#excepcion_editar_modal').modal('hide');
            //llamo a la funcion vaciar errores
            vaciar_errores();
        }

        //para el guardado de lo etitado
        let form_editar_excepcion = document.getElementById('formulario_editar_excepcion');
        let btn_edit_excepcion = document.getElementById('btn_editar_excepcion');

        //aqui guardamos
        btn_edit_excepcion.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_editar_excepcion).entries());
            let dia_semana = [];
            let chexbox = document.querySelectorAll('input[name="dias_semana_[]"]:checked');
            chexbox.forEach(function (checkbox) {
                dia_semana.push(checkbox.value);
            });
            validar_boton(true, 'Guardando', 'btn_editar_excepcion');
            try {
                let respuesta = await fetch("{{ route('exept_edit_save') }}", {
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id_excepcion     : datos.id_excepcion,
                        dia_semana       : dia_semana,
                        descripcion_     : datos.descripcion_,
                        hora_            : datos.hora_,
                        fecha_inicial_   : datos.fecha_inicial_,
                        fecha_final_     : datos.fecha_final_,
                    })
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_editar_excepcion');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    actulizar_tabla_excepcion();
                    cerrar_modal_edita_exception();
                    validar_boton(false, 'Guardar', 'btn_editar_excepcion');
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_editar_excepcion');
                }
            } catch (error) {
                console.log('Ocurrio un error :'+ error);
            }
        });

        //aqui es para validaciones de las fechas
        function validar_fechas_edit(){
            let fecha_inicio    = new Date(document.getElementById('fecha_inicial_').value);
            let fecha_final     = new Date(document.getElementById('fecha_final_').value);
            if(fecha_inicio > fecha_final){
                alerta_top('error', 'la fecha final debe ser mayor a la fecha final');
                document.getElementById('fecha_final_').value = '';
            }
        }
    </script>
@endsection
