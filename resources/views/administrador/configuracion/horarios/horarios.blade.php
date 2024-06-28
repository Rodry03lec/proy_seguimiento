@extends('principal')
@section('titulo', '| HORARIOS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: HORARIOS ::::::::</h5>
            @can('horarios_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_hoarario">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_horarios" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">DESCRIPCIÓN</th>
                        <th scope="col" class="table-th">ESPECIFICACIÓN HORAS</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add horario Modal -->
    <div class="modal fade" id="modal_nuevo_hoarario" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_horario()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Horario</h3>
                    </div>
                    <form id="formulario_nuevo_horario" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control uppercase-input" placeholder="Ingrese la descripción"></textarea>
                            <div id="_descripcion"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_form_horario" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_horario()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add horario Modal -->

    <!-- Update horario Modal -->
    <div class="modal fade" id="modal_editar_horario" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_horario_edit()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Horario</h3>
                    </div>
                    <form id="formulario_editar_horario" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_horario" id="id_horario">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion_">Descripción</label>
                            <textarea name="descripcion_" id="descripcion_" cols="30" rows="5" class="form-control uppercase-input" placeholder="Ingrese la descripción"></textarea>
                            <div id="_descripcion_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_editar_form_horario" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_horario_edit()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update horario Modal -->


    <!-- Extra Large Modal -->
    <div class="modal fade" id="modal_listar_horarios_especificos" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Especificación de horas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_horario_vista()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_tipo" role="alert">
                    </div>
                    <form id="formulario_horarios_especificos" method="post" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_horario_esp" id="id_horario_esp">
                        <input type="hidden" name="id_especifico" id="id_especifico">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="nombre__" class="form-label">Descripción</label>
                                <input type="text" id="nombre__" name="nombre__" class="form-control uppercase-input" placeholder="Ingrese el nombre" onkeypress="return soloLetras(event)">
                                <div id="_nombre__" ></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="numero" class="form-label">Seleccione</label>
                                <select name="numero" id="numero" class="form-select select2">
                                    <option value="selected" disabled selected>[SELECCIONE UN NUMERO]</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" >{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id="_numero"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                <label for="hora_inicio" class="form-label">Seleccione hora de inicio</label>
                                <input type="text" id="hora_inicio" name="hora_inicio" class="form-control" value="00:00" />
                                <div id="_hora_inicio"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                <label for="hora_inicio" class="form-label">Seleccione hora de final</label>
                                <input type="text" id="hora_final" name="hora_final" class="form-control" value="00:00" />
                                <div id="_hora_final"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                <label for="hora_inicio" class="form-label">Seleccione tolerancia</label>
                                <input type="time" id="tolerancia" name="tolerancia" class="form-control"  value="00:00" />
                                <div id="_tolerancia"></div>
                            </div>
                        </div>

                        <div class="col-12 mb-3 py-2s">
                            <label class="invisible"></label>
                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary btn-md" id="btn_guardar_horarios_especificos" type="button">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="tabla_lista_horario_especifico" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">DESCRIPCIÓN</th>
                                <th scope="col" class="table-th">HORA INICIO</th>
                                <th scope="col" class="table-th">HORA FINAL</th>
                                <th scope="col" class="table-th">TOLERANCIA</th>
                                <th scope="col" class="table-th">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update mae Modal -->

@endsection

@section('scripts')
    <script>

        hora_flatpickr('hora_inicio');
        hora_flatpickr('hora_final');

        //para la validacion de las fechas
        function hora_flatpickr(hora) {
            flatpickr("#" + hora, {
                // Formato de hora. "H" representa la hora en formato 24 horas y "i" los minutos.
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                // Puedes agregar más opciones y configuraciones aquí según las necesidades de tu aplicación.
            });
        }



        let form_modal_nuevo         = document.getElementById('formulario_nuevo_horario');
        let guardar_form_btn_nuevo   = document.getElementById('btn_guardar_form_horario');

        //para cerrar el modal de mae
        function cerrar_modal_horario(){
            $('#modal_nuevo_hoarario').modal('hide');
            vaciar_formulario(form_modal_nuevo);
            vaciar_errores_horario();
        }
        //para vaciar los errores del formulario mae
        function vaciar_errores_horario(){
            let nuevo_array = ['_nombre', '_descripcion','_nombre_','_descripcion_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }
        //para guardar el nuevo registro de los horarios
        guardar_form_btn_nuevo.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_modal_nuevo).entries());
            vaciar_errores_horario();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_form_horario');
            try {
                let respuesta = await fetch("{{ route('hor_nuevo_save') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_form_horario');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_horario();
                    validar_boton(false, 'Guardar', 'btn_guardar_form_horario');
                    actulizar_tabla();

                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_form_horario');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_form_horario');
            }
        });
        //fin para listar los horarios
        async function listar_horarios() {
            let respuesta = await fetch("{{ route('hor_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_horarios').DataTable({
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
                        data: 'nombre',
                        className: 'table-td'
                    },
                    {
                        data: 'descripcion',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('horarios_vizualizar')
                                        <button type="button" onclick="vista_especicacion_horas('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR ESPECIFICACION DE HORAS">
                                            <i class="ti ti-eye" ></i>
                                        </button>
                                    @endcan
                                </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('horarios_editar')
                                        <button type="button" onclick="editar_horario('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('horarios_eliminar')
                                        <button type="button" onclick="eliminar_horario('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="EDITAR">
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
        listar_horarios();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_horarios').DataTable().destroy();
            listar_horarios();
            $('#tabla_horarios').fadeIn(200);
        }

        //para la eliminacion de los horarios
        async function eliminar_horario(id) {
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
                        let respuesta = await fetch("{{ route('hor_eliminar') }}",{
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
                            actulizar_tabla();
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
        //fin de la eliminacion de los horarios

        let form_modal_editar         = document.getElementById('formulario_editar_horario');
        let guardar_form_btn_editar   = document.getElementById('btn_guardar_editar_form_horario');

        //para cerrar el modal de mae
        function cerrar_modal_horario_edit(){
            $('#modal_editar_horario').modal('hide');
            vaciar_formulario(form_modal_editar);
            vaciar_errores_horario();
        }

        //para editar el horario
        async function editar_horario(id) {
            try {
                let respuesta = await fetch("{{ route('hor_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_horario').modal('show');
                    document.getElementById('id_horario').value     = dato.mensaje.id;
                    document.getElementById('nombre_').value        = dato.mensaje.nombre;
                    document.getElementById('descripcion_').value   = dato.mensaje.descripcion;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para guardar lo editado
        guardar_form_btn_editar.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_modal_editar).entries());
            vaciar_errores_horario();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_editar_form_horario');
            try {
                let respuesta = await fetch("{{ route('hor_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_form_horario');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_horario_edit();
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_form_horario');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_form_horario');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_editar_form_horario');
            }
        });


        /**@argument
         * PARA LA PARTE DE LA ESPECIFICACIÓN DE LOS HORARIOS
         * */
        let form_modal_horario_especifico        = document.getElementById('formulario_horarios_especificos');
        let guardar_btn_horario_especifico      = document.getElementById('btn_guardar_horarios_especificos');

        //para cerrar el modal de mae
        function cerrar_modal_horario_vista(){
            $('#modal_listar_horarios_especificos').modal('hide');
            actulizar_tabla_horas_especificas();
            formulario_especificos();
        }

        //para el vaciado de errores especificos
        function formulario_especificos(){
            let nuevo_array = ['nombre__', 'id_especifico'];
            nuevo_array.forEach(element => {
                document.getElementById(element).value = '';
            });
            document.getElementById('numero').value = 'selected';

            let array1 = ['hora_inicio','hora_final','tolerancia'];
            array1.forEach(element => {
                document.getElementById(element).value = '00:00';
            });
            vaciar_errores_especificos();
        }
        //funcion para el vaciado de los errores
        function vaciar_errores_especificos(){
            let nuevo_array = ['_nombre__','_numero','_hora_inicio','_hora_final','_tolerancia'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para guardar la especificacionde horas
        async function vista_especicacion_horas(id) {
            try {
                let respuesta = await fetch("{{ route('hor_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_listar_horarios_especificos').modal('show');
                    document.getElementById('id_horario_esp').value     = dato.mensaje.id;
                    document.getElementById('detalle_tipo').innerHTML = `<strong class="ltr:mr-1 rtl:ml-1"> *`+dato.mensaje.nombre+`* </strong>`+dato.mensaje.descripcion;
                    actulizar_tabla_horas_especificas();
                    listar_horas_especificas(dato.mensaje.id);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_horas_especificas() {
            $('#tabla_lista_horario_especifico').DataTable().destroy();
            $('#tabla_lista_horario_especifico').fadeIn(200);
        }

         //para listar las horas especificas
        async function listar_horas_especificas(id) {
            let respuesta = await fetch("{{ route('hes_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_lista_horario_especifico').DataTable({
                responsive: true,
                data: dato,
                columns: [
                    {
                        data: 'numero',
                        className: 'table-td'
                    },
                    {
                        data: 'nombre',
                        className: 'table-td'
                    },
                    {
                        data: 'hora_inicio',
                        className: 'table-td'
                    },
                    {
                        data: 'hora_final',
                        className: 'table-td'
                    },
                    {
                        data: 'tolerancia',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('horarios_vizualizar_especificacion_horas_editar')
                                        <button type="button"  onclick="editar_turno_hora('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('horarios_vizualizar_especificacion_horas_eliminar')
                                        <button type="button" onclick="eliminar_turno_hora('${row.id}',${row.id_horario})" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                            <i class="ti ti-trash" ></i>
                                        </button>
                                    @endcan

                                    @can('horarios_vizualizar_especificacion_horas_excepciones')
                                        <button type="button" onclick="asignar_especial('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="EXCEPCIONES - ESPECIALES">
                                            <i class="ti ti-settings" ></i>
                                        </button>
                                    @endcan

                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        //para guardar los horarios especificos
        guardar_btn_horario_especifico.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_modal_horario_especifico).entries());
            vaciar_errores_especificos();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_horarios_especificos');
            try {
                let respuesta = await fetch("{{ route('hes_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_horarios_especificos');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_horarios_especificos');
                    formulario_especificos();
                    actulizar_tabla_horas_especificas();
                    listar_horas_especificas(dato.id_horario);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_horarios_especificos');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_horarios_especificos');
            }
        });


        //para editar las horas especificas
        async function editar_turno_hora(id) {
            vaciar_errores_especificos();
            try {
                let respuesta = await fetch("{{ route('hes_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_especifico').value  = dato.mensaje.id;
                    document.getElementById('nombre__').value       = dato.mensaje.nombre;
                    document.getElementById('numero').value         = dato.mensaje.numero;
                    document.getElementById('hora_inicio').value    = dato.mensaje.hora_inicio;
                    document.getElementById('hora_final').value     = dato.mensaje.hora_final;
                    document.getElementById('tolerancia').value     = dato.mensaje.tolerancia;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para eliminar el registro de las horas especificas
        async function eliminar_turno_hora(id, id_horario) {
            formulario_especificos();
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
                        let respuesta = await fetch("{{ route('hes_eliminar') }}",{
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
                            actulizar_tabla_horas_especificas();
                            listar_horas_especificas(id_horario);
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                }else{
                    alerta_top('error', 'Se cancelo');
                }
            });
        }
        /**@argument
         * FIN DE LA PARTE DE LA ESPECIFICACIÓN DE LOS HORARIOS
         * */


        /*@ PARA LA ASIGNACION ESPECIAL DE HORARIOS*/
        async function asignar_especial(id) {
            try {
                let respuesta = await fetch("{{ route('enc_crypt') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    let url = "{{ route('exhor_index', ['id' => ':id']) }}";
                    url = url.replace(':id', dato.mensaje);
                    window.location.href = url;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('error de datos => '+error);
            }
        }
        /**@FIN DE LA PARTE DE ASIGNACION ESPECIAL DE HORARIOS*/
    </script>
@endsection
