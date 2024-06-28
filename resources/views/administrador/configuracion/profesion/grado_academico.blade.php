@extends('principal')
@section('titulo', '| GRADOS ACADÉMICOS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: GRADOS ACADÉMICOS :::::::: </h5>
            @can('grados_academicos_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_grado_academico_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan

        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_grados_academicos" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">ABREVIATURA</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">ESTADO</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
        <!-- Modal -->
    <!-- Add grado academico Modal -->
    <div class="modal fade" id="modal_grado_academico_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_grados_academicos()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Registro de nuevo grado Académico</h3>
                    </div>
                    <form id="form_nuevo_grado_academico" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="abreviatura">Abreviatura</label>
                            <input type="text" id="abreviatura" name="abreviatura" class="form-control uppercase-input"
                                placeholder="Ingrese la Abreviatura" autofocus />
                            <div id="_abreviatura"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre del Grado Académico</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_save_grado_academico" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_grados_academicos()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add grado academico Modal -->

    <!-- Update grado academico Modal -->
    <div class="modal fade" id="modal_grado_academico_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_grados_academicos_edit()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Registro de nuevo grado Académico</h3>
                    </div>
                    <form id="form_edit_grado_academico" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_grado_academico" name="id_grado_academico">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="abreviatura_">Abreviatura</label>
                            <input type="text" id="abreviatura_" name="abreviatura_" class="form-control uppercase-input"
                                placeholder="Ingrese la Abreviatura" autofocus />
                            <div id="_abreviatura_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre del Grado Académico</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_grado_academico_edit" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_grados_academicos_edit()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update grado academico Modal -->
@endsection
@section('scripts')
    <script>
        let btn_guardar_grado_academico         = document.getElementById('btn_save_grado_academico');
        let formulario_nuevo_grado_academico    = document.getElementById('form_nuevo_grado_academico');

        //para cerrar el modal para la creacion de los grados academicos
        function cerrar_modal_grados_academicos(){
            let nuevo_arr = ['nombre','abreviatura'];
            nuevo_arr.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_form_grados_academicos();
            $('#modal_grado_academico_nuevo').modal('hide');
        }
        //para el vaciado de errores
        function vaciar_errores_form_grados_academicos(){
            let nuevo_array = ['_abreviatura', '_nombre', '_abreviatura_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

         //para listar los datos
        async function listar_grado_academico() {
            let respuesta = await fetch("{{ route('gac_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_grados_academicos').DataTable({
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
                        data: 'abreviatura',
                        className: 'table-td'
                    },
                    {
                        data: 'nombre',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                            @can('grados_academicos_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_grado_academico('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('grados_academicos_editar')
                                        <button type="button" onclick="editar_grado_academico('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('grados_academicos_eliminar')
                                        <button type="button" onclick="eliminar_grado_academico('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_grado_academico();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_grados_academicos').DataTable().destroy();
            listar_grado_academico();
            $('#tabla_grados_academicos').fadeIn(200);
        }

        //para guardar el grado academico
        btn_guardar_grado_academico.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nuevo_grado_academico).entries());
            vaciar_errores_form_grados_academicos();
            validar_boton(true, 'Verificando datos . . . ', 'btn_save_grado_academico');
            try {
                let respuesta = await fetch("{{ route('gac_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_save_grado_academico');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_grados_academicos();
                    validar_boton(false, 'Guardar', 'btn_save_grado_academico');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_save_grado_academico');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_save_grado_academico');
            }
        });


        //para el estado de los grados academicos
        async function estado_grado_academico(id) {
            Swal.fire({
                title: "¿Estás seguro de cambiar el estado?",
                text: "¡NOTA!",
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
                        let respuesta = await fetch("{{ route('gac_estado') }}",{
                            method: "POST",
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
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    actulizar_tabla();
                    alerta_top('error', 'Se cancelo');
                }
            });
        }

        //para eliminar el grado academico
        async function eliminar_grado_academico(id) {
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
                        let respuesta = await fetch("{{ route('gac_eliminar') }}",{
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
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla();
                }
            });
        }

        /**@argument
         * PARA LA EDICION DEL REGISTRO DEL GRADO ACADEMICO
         * */

        let btn_guardar_grado_academico_edit   = document.getElementById('btn_guardar_grado_academico_edit');
        let formulario_edit_grado_academico    = document.getElementById('form_edit_grado_academico');

        //para cerrar el modal para la creacion de los grados academicos
        function cerrar_modal_grados_academicos_edit(){
            let nuevo_arr = ['nombre_','abreviatura_'];
            nuevo_arr.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_form_grados_academicos();
            $('#modal_grado_academico_editar').modal('hide');
        }

        //para editar el reghistro de los grados academicos
        async function editar_grado_academico(id) {
            try {
                let respuesta = await fetch("{{ route('gac_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_grado_academico_editar').modal('show');
                    document.getElementById('id_grado_academico').value = id;
                    document.getElementById('abreviatura_').value       = dato.mensaje.abreviatura;
                    document.getElementById('nombre_').value            = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }


        btn_guardar_grado_academico_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_edit_grado_academico).entries());
            vaciar_errores_form_grados_academicos();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_grado_academico_edit');
            try {
                let respuesta = await fetch("{{ route('gac_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_grado_academico_edit');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_grados_academicos();
                    validar_boton(false, 'Guardar', 'btn_guardar_grado_academico_edit');
                    actulizar_tabla();
                    cerrar_modal_grados_academicos_edit();

                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_grado_academico_edit');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_grado_academico_edit');
            }
        });

    </script>
@endsection
