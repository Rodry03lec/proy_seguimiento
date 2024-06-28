@extends('principal')
@section('titulo', ' | HORARIO CONTINUO')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE HORARIOS CONTINUOS PROGRAMADOS :::::::: </h5>
            @can('especial_horario_continuo_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevo_registro_horario_continuo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_horario_continuo" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">DESCRIPCIÓN</th>
                        <th scope="col" class="table-th">FECHA INICIO</th>
                        <th scope="col" class="table-th">FECHA FINAL</th>
                        <th scope="col" class="table-th">HORA FINAL</th>
                        <th scope="col" class="table-th">ESTADO</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

        <!-- Modal -->
    <!-- Add horario continuo Modal -->
    <div class="modal fade" id="nuevo_registro_horario_continuo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 ">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_horario_continuo()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">NUEVO HORARIO CONTINUO</h3>
                    </div>
                    <form id="formulario_nuevo_horario_continuo" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control" placeholder="Ingrese la descripción del horario continuo"></textarea>
                            <div id="_descripcion" ></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha_inicial">Seleccione la Fecha inicial</label>
                            <input type="text" id="fecha_inicial" name="fecha_inicial" class="form-control uppercase-input"
                                placeholder="Seleccione la fecha inicial" autofocus />
                            <div id="_fecha_inicial"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha_final">Seleccione la Fecha final</label>
                            <input type="text" id="fecha_final" name="fecha_final" class="form-control uppercase-input"
                                placeholder="Seleccione la fecha final" autofocus />
                            <div id="_fecha_final"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="hora_salida">Seleccione la hora de salida</label>
                            <input type="text" id="hora_salida" name="hora_salida" class="form-control uppercase-input"
                                placeholder="Seleccione la hora de salida" autofocus />
                            <div id="_hora_salida"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_horario_continuo" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_horario_continuo()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add horario continuo Modal -->


    <!-- Editar horario continuo Modal -->
    <div class="modal fade" id="editar_registro_horario_continuo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 ">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_horario_continuo()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">EDITAR HORARIO CONTINUO</h3>
                    </div>
                    <form id="formulario_editar_horario_continuo" class="row" method="POST" autocomplete="off">
                        <input type="hidden" name="id_horario_con" id="id_horario_con">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="form-label">Descripción</label>
                            <textarea name="descripcion_" id="descripcion_" cols="30" rows="3" class="form-control" placeholder="Ingrese la descripción del horario continuo"></textarea>
                            <div id="_descripcion_" ></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha_inicial_">Seleccione la Fecha inicial</label>
                            <input type="text" id="fecha_inicial_" name="fecha_inicial_" class="form-control uppercase-input"
                                placeholder="Seleccione la fecha inicial" autofocus />
                            <div id="_fecha_inicial_"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="fecha_final_">Seleccione la Fecha final</label>
                            <input type="text" id="fecha_final_" name="fecha_final_" class="form-control uppercase-input"
                                placeholder="Seleccione la fecha final" autofocus />
                            <div id="_fecha_final_"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="hora_salida">Seleccione la hora de salida</label>
                            <input type="text" id="hora_salida_" name="hora_salida_" class="form-control uppercase-input"
                                placeholder="Seleccione la hora de salida" autofocus />
                            <div id="_hora_salida_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_editar_horario_continuo" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_horario_continuo()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Editar horario continuo Modal -->


@endsection
@section('scripts')
    <script>
        fechas_flatpicker('fecha_inicial');
        fechas_flatpicker('fecha_final');

        //para la validacion de las fechas
        function fechas_flatpicker(fecha){
            flatpickr("#"+fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                // Otras opciones y configuraciones aquí
            });
        }

        hora_flatpicker('hora_salida');

        function hora_flatpicker(hora){
            flatpickr("#"+hora, {
                noCalendar: true, // Deshabilitar el calendario
                enableTime: true, // Habilitar selección de tiempo
                dateFormat: "H:i", // Formato de hora
                time_24hr: true, // Usar formato de 24 horas
                minuteIncrement: 30,
                //allowInput: true, //permite entradas por teclado
            });
        }

        //para cerrar el modal
        function cerrar_modal_horario_continuo(){
            $('#nuevo_registro_horario_continuo').modal('hide');
            vaciar_formulario(form_horario_continuo);
            vaciar_errores_horario_continuo();
        }

        //para vaciar los errores
        function vaciar_errores_horario_continuo(){
            let valores = ['_descripcion', '_fecha_inicial', '_fecha_final', '_hora_salida','_descripcion_', '_fecha_inicial_', '_fecha_final_', '_hora_salida_'];
            valores.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //VARIABLES PARA EL GUARDADO DE HORAIO CONTINUO
        let btn_guardar_horario_continuo = document.getElementById('btn_guardar_horario_continuo');
        let form_horario_continuo = document.getElementById('formulario_nuevo_horario_continuo');

        //para guardar el horario continuo
        btn_guardar_horario_continuo.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_horario_continuo).entries());
            vaciar_errores_horario_continuo();
            validar_boton(true, 'Guardar', 'btn_guardar_horario_continuo');
            try {
                let respuesta = await fetch("{{ route('chcon_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_horario_continuo');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_horario_continuo();
                    validar_boton(false, 'Guardar', 'btn_guardar_horario_continuo');
                    actualizar_horario_continuo();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_horario_continuo');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_horario_continuo');
            }
        });

        //funcion  de acctualizar tabla
        function actualizar_horario_continuo() {
            $('#tabla_horario_continuo').DataTable().destroy();
            listar_horario_continuo();
            $('#tabla_horario_continuo').fadeIn(200);
        }

        //PARA LISTAR LOS HORARIO CONTINUOS
        async function listar_horario_continuo() {
            let respuesta = await fetch("{{ route('chcon_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_horario_continuo').DataTable({
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
                        data: 'descripcion',
                        className: 'table-td'
                    },
                    {
                        data: 'fecha_inicio',
                        className: 'table-td'
                    },
                    {
                        data: 'fecha_final',
                        className: 'table-td'
                    },
                    {
                        data: 'hora_salida',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                            @can('especial_horario_continuo_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_horario_continuo('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                <div class="d-inline-block tex-nowrap">
                                    @can('especial_horario_continuo_editar')
                                        <button type="button" onclick="editar_horario_continuo('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('especial_horario_continuo_eliminar')
                                        <button type="button" onclick="eliminar_horario_continuo('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_horario_continuo();
        //FIN PARA LISTAR LOS HORARIO CONTINUOS

        //PARA EDITAR EL REGISTRO DE LOS HORARIOS PROGRAMADOS
        async function editar_horario_continuo(id){
            try {
                let respuesta = await fetch("{{ route('chcon_editar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#editar_registro_horario_continuo').modal('show');
                    document.getElementById('id_horario_con').value     = dato.mensaje.id;
                    document.getElementById('descripcion_').value       = dato.mensaje.descripcion;
                    document.getElementById('fecha_inicial_').value     = dato.mensaje.fecha_inicio;
                    document.getElementById('fecha_final_').value       = dato.mensaje.fecha_final;
                    document.getElementById('hora_salida_').value       = dato.mensaje.hora_salida;

                    //de las fechas para que este seleccionado
                    fecha_editar_seleccionado('fecha_inicial_', dato.mensaje.fecha_inicio);
                    fecha_editar_seleccionado('fecha_final_', dato.mensaje.fecha_final);
                    hora_editar_seleccionado('hora_salida_', dato.mensaje.hora_salida);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        }
        //FIN PARA EDITAR LOS REGISTRO DE LOS HORARIOS PROGRAMDOS


        //PARA EDITAR LAS FECHAS
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

        //PARA EDITAR LAS HORAS
        function hora_editar_seleccionado(valor, hora){
            flatpickr("#"+valor, {
                noCalendar: true, // Deshabilitar el calendario
                enableTime: true, // Habilitar selección de tiempo
                dateFormat: "H:i", // Formato de hora
                time_24hr: true, // Usar formato de 24 horas
                minuteIncrement: 30,
                defaultDate: hora,
                //allowInput: true, //permite entradas por teclado
            });
        }

        //PARA GUARDAR LO EDITADO
    let btn_editar_hor_continuo = document.getElementById('btn_editar_horario_continuo');
    let form_editar_hor_continuo = document.getElementById('formulario_editar_horario_continuo');

    btn_editar_hor_continuo.addEventListener('click', async ()=>{
        let datos = Object.fromEntries(new FormData(form_editar_hor_continuo).entries());
        vaciar_errores_horario_continuo();
        validar_boton(true, 'Guardar', 'btn_editar_horario_continuo');
        try {
            let respuesta = await fetch("{{ route('chcon_editar_guardar') }}",{
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
                validar_boton(false, 'Guardar', 'btn_editar_horario_continuo');
            }
            if(dato.tipo === 'success'){
                alerta_top(dato.tipo, dato.mensaje);
                cerrar_modal_horario_continuo_edit();
                validar_boton(false, 'Guardar', 'btn_editar_horario_continuo');
                actualizar_horario_continuo();
            }
            if(dato.tipo === 'error'){
                alerta_top(dato.tipo, dato.mensaje);
                validar_boton(false, 'Guardar', 'btn_editar_horario_continuo');
            }
        } catch (error) {
            console.log('Ocurrio un error :' + error );
            validar_boton(false, 'Guardar', 'btn_editar_horario_continuo');
        }
    });

    //cerra modal editar el registro
    function cerrar_modal_horario_continuo_edit(){
        $('#editar_registro_horario_continuo').modal('hide');
        vaciar_formulario(form_editar_hor_continuo);
        vaciar_errores_horario_continuo();
    }

    //para eliminar el registros
    function eliminar_horario_continuo(id){
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
                    let respuesta = await fetch("{{ route('chcon_eliminar') }}",{
                        method: "DELETE",
                        headers:{
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    if(dato.tipo === 'success'){
                        //destruimos la tabla
                        actualizar_horario_continuo();
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
            }
        });
    }

    //para el estado de los registros
    function estado_horario_continuo(id){
        Swal.fire({
                title: "¿Estás seguro de cambiar el estado?",
                text: "¡Nota!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, cambiar",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('chcon_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actualizar_horario_continuo();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                        actualizar_horario_continuo();
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actualizar_horario_continuo();
                }
            });
    }
    </script>
@endsection
