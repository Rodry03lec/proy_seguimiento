@extends('principal')
@section('titulo', '| TIPO DE PERMISO')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: TIPOS DE PERMISO :::::::: </h5>
            @can('especial_permisos_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevo_tipo_permiso">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_permiso" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NOMBRE</th>
                        <th>ESTADO</th>
                        <th>DESGLOSE</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipos de permiso-->
    <div class="modal fade" id="nuevo_tipo_permiso" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_permiso()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo tipo permiso</h3>
                    </div>
                    <form id="form_nuevo_tipo_permiso" class="row" method="POST" autocomplete="off">
                        @csrf

                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_save_tipo_permiso" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_tipo_permiso()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipos de permiso -->

    <!-- Update tipos de permiso-->
    <div class="modal fade" id="modal_editar_tipo_permiso" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_permiso_edit()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar tipo permiso</h3>
                    </div>
                    <form id="form_editar_tipo_permiso" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipo_permiso" id="id_tipo_permiso">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_editar_tipo_permiso" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_tipo_permiso_edit()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update tipos de permiso -->



    <!-- Extra Large Modal -->
    <div class="modal fade" id="modal_listar_desglose_permiso" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">DESGLOSE - PERMISO </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_desglose_permiso()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_tipo_permiso" role="alert">
                    </div>
                    <form id="formulario_desglose_permiso" method="post" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipo_permiso_" id="id_tipo_permiso_">
                        <input type="hidden" name="id_desglose_permiso" id="id_desglose_permiso">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="nombre__" class="form-label">Descripción</label>
                                <input type="text" id="nombre__" name="nombre__" class="form-control uppercase-input" placeholder="Ingrese el nombre" onkeypress="return soloLetras(event)">
                                <div id="_nombre__" ></div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 mb-3">
                                <label for="descripcion" class="form-label">Descripcion</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="4" class="form-control uppercase-input" placeholder="Ingrese la descripción"></textarea>
                                <div id="_descripcion"></div>
                            </div>
                        </div>

                        <div class="col-12 mb-3 py-2s">
                            <label class="invisible"></label>
                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary btn-md" id="btn_guardar_desglose_permiso" type="button">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="descripcion_vista" ></div>

                <div class="table-responsive text-nowrap p-2">
                    <table class="table table-hover" id="tabla_lista_desglose_permiso" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">NOMBRE</th>
                                <th scope="col" class="table-th">ESTADO</th>
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
        //PARA LISTAR TODOS LOS TIPOS DE PERMISO QUE EXISTE
         //para listar los datos
        async function listar_tipo_permiso() {
            let respuesta = await fetch("{{ route('cper_per_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_permiso').DataTable({
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
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('especial_permisos_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_tipo_permiso('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                            if(data.estado==='activo'){
                                return `
                                    @can('especial_permisos_desglose')
                                        <div class="d-inline-block tex-nowrap">
                                            <button type="button" onclick="mostrar_desglose_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-primary" data-toggle="tooltip" data-placement="top" title="DESGLOSE">
                                                <i class="ti ti-settings" ></i>
                                            </button>
                                        </div>
                                    @endcan
                                `;
                            }else{
                                return ``;
                            }
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('especial_permisos_editar')
                                        <button type="button" onclick="editar_tipo_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('especial_permisos_eliminar')
                                        <button type="button" onclick="eliminar_tipo_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_tipo_permiso();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tipo_permiso').DataTable().destroy();
            listar_tipo_permiso();
            $('#tabla_tipo_permiso').fadeIn(200);
        }

        //para cambiar el estado del tipo de permiso
        async function estado_tipo_permiso(id) {
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
                        let respuesta = await fetch("{{ route('cper_per_estado') }}",{
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

        //para vaciar errores de los tipos de permisoss
        function vaciar_errores_tipo_permiso(){
            let datos = ['_nombre', '_nombre_'];
            datos.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //para cerrar el modal tipo de permiso
        function cerrar_modal_tipo_permiso(){
            $('#nuevo_tipo_permiso').modal('hide');
            vaciar_formulario(formulario_nuevo_tipo_permiso);
            vaciar_errores_tipo_permiso();
        }

        //PARA CREAR NUEVO TIPO DE PERMISO
        let btn_guardar_tipo_permiso         = document.getElementById('btn_save_tipo_permiso');
        let formulario_nuevo_tipo_permiso    = document.getElementById('form_nuevo_tipo_permiso');

        btn_guardar_tipo_permiso.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nuevo_tipo_permiso).entries());
            vaciar_errores_tipo_permiso();
            validar_boton(true, 'Verificando datos . . . ', 'btn_save_tipo_permiso');

            try {
                let respuesta = await fetch("{{ route('cper_per_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_save_tipo_permiso');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_tipo_permiso();
                    validar_boton(false, 'Guardar', 'btn_save_tipo_permiso');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_save_tipo_permiso');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_save_tipo_permiso');
            }

        });

        //para eliminar el tipo de permiso
        async function eliminar_tipo_permiso(id) {
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
                        let respuesta = await fetch("{{ route('cper_per_eliminar') }}",{
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
                }
            });
        }

        //PARA EDITAR EL REGISTRO
        async function editar_tipo_permiso (id) {
            try {
                let respuesta = await fetch("{{ route('cper_per_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_tipo_permiso').modal('show');
                    document.getElementById('id_tipo_permiso').value    = dato.mensaje.id;
                    document.getElementById('nombre_').value            = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }

        //para cerrar el modal editado
        function cerrar_modal_tipo_permiso_edit () {
            $('#modal_editar_tipo_permiso').modal('hide');
            vaciar_formulario(formulario_nuevo_tipo_permiso);
            vaciar_errores_tipo_permiso();
        }

        //PARA GUARDAR LOS DATOS EDITADOS
        let form_editar_tipo_permiso = document.getElementById('form_editar_tipo_permiso');
        let boton_editar_tipo_permiso = document.getElementById('btn_editar_tipo_permiso');

        boton_editar_tipo_permiso.addEventListener('click', async()=>{
            let datos = Object.fromEntries(new FormData(form_editar_tipo_permiso).entries());
            vaciar_errores_tipo_permiso();
            validar_boton(true, 'Verificando datos . . . ', 'btn_editar_tipo_permiso');
            try {
                let respuesta = await fetch("{{ route('cper_per_edit_save') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_editar_tipo_permiso');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_tipo_permiso_edit();
                    validar_boton(false, 'Guardar', 'btn_editar_tipo_permiso');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_editar_tipo_permiso');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_editar_tipo_permiso');
            }
        });


        /**@argument
         * DESDE AQUI SER EL DESGLOSE DE TIPOS DE PERMISO
         **/
        async function mostrar_desglose_permiso (id) {
            try {
                let respuesta = await fetch("{{ route('cper_per_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_listar_desglose_permiso').modal('show');
                    document.getElementById('id_tipo_permiso_').value     = dato.mensaje.id;
                    document.getElementById('detalle_tipo_permiso').innerHTML = `<strong class="ltr:mr-1 rtl:ml-1"> *`+dato.mensaje.nombre+`* </strong>`;
                    actulizar_tabla_desglose_permiso();
                    listar_desglose_permiso(dato.mensaje.id);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para cerrar el modal de desglose
        function cerrar_modal_desglose_permiso () {
            $('#modal_listar_desglose_permiso').modal('hide');
            vaciar_errores_desglose_permiso();
            document.getElementById('descripcion_vista').innerHTML='';
        }

        //para vaciar los errores del desglose
        function vaciar_errores_desglose_permiso () {
            let valores = ['_nombre__', '_descripcion'];
            valores.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_desglose_permiso() {
            $('#tabla_lista_desglose_permiso').DataTable().destroy();
            $('#tabla_lista_desglose_permiso').fadeIn(200);
        }

        //para listar el desglose de permiso
        async function listar_desglose_permiso (id) {
            let respuesta = await fetch("{{ route('dplis_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_lista_desglose_permiso').DataTable({
                responsive: true,
                data: dato,
                columns: [
                    {
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
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('especial_permisos_desglose_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_desglose_permiso('${row.id}',${row.id_tipo_permiso})" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('especial_permisos_desglose_editar')
                                        <button type="button" onclick="editar_desglose_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('especial_permisos_desglose_eliminar')
                                        <button type="button" onclick="eliminar_desglose_permiso('${row.id}',${row.id_tipo_permiso})" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                            <i class="ti ti-trash" ></i>
                                        </button>
                                    @endcan

                                    @can('especial_permisos_desglose_vizualizar')
                                        <button type="button" onclick="vizualizar_desglose_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR">
                                            <i class="ti ti-eye" ></i>
                                        </button>
                                    @endcan
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        //para guardar los registro del desglose de permisos
        let btn_guardar_desglose_permiso = document.getElementById('btn_guardar_desglose_permiso');
        let formulario_desglose_permiso = document.getElementById('formulario_desglose_permiso');
        btn_guardar_desglose_permiso.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_desglose_permiso).entries());
            vaciar_errores_desglose_permiso();

            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_desglose_permiso');
            try {
                let respuesta = await fetch("{{ route('dplis_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_desglose_permiso');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    vaciar_form_desglose_permiso();
                    validar_boton(false, 'Guardar', 'btn_guardar_desglose_permiso');
                    actulizar_tabla_desglose_permiso();
                    listar_desglose_permiso(dato.id_tipo_permiso);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_desglose_permiso');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_desglose_permiso');
            }

        });

        //para vaciar los errreos de deglose de permiso
        function vaciar_errores_desglose_permiso(){
            let valores = ['_nombre__', '_descripcion'];
            valores.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }
        //para vaciar el formulario
        function vaciar_form_desglose_permiso(){
            let valores = ['nombre__', 'descripcion', 'id_desglose_permiso'];
            valores.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            vaciar_errores_desglose_permiso();
        }

        //para eliminar el desglose-permiso
        async function eliminar_desglose_permiso(id, id_tipo_permiso) {
            vaciar_form_desglose_permiso();
            document.getElementById('descripcion_vista').innerHTML = '';
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
                        let respuesta = await fetch("{{ route('dplis_eliminar') }}",{
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
                            actulizar_tabla_desglose_permiso();
                            listar_desglose_permiso(id_tipo_permiso);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla_desglose_permiso();
                    listar_desglose_permiso(id_tipo_permiso);
                }
            });
        }

        //para editar el registro
        async function editar_desglose_permiso (id) {
            document.getElementById('descripcion_vista').innerHTML = '';
            try {
                let respuesta = await fetch("{{ route('dplis_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_desglose_permiso').value    = dato.mensaje.id;
                    document.getElementById('nombre__').value            = dato.mensaje.nombre;
                    document.getElementById('descripcion').value            = dato.mensaje.descripcion;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }

        //para cambiar ele stado  dela comision
        async function estado_desglose_permiso(id, id_tipo_permiso) {
            vaciar_form_desglose_permiso();
            document.getElementById('descripcion_vista').innerHTML = '';
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
                        let respuesta = await fetch("{{ route('dplis_estado') }}",{
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
                            actulizar_tabla_desglose_permiso();
                            listar_desglose_permiso(dato.id_tipo_permiso);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    actulizar_tabla_desglose_permiso();
                    listar_desglose_permiso(id_tipo_permiso);
                    alerta_top('error', 'Se cancelo');
                }
            });
        }


        //para visualizar la descripcion de cadadesglose
        async function vizualizar_desglose_permiso(id) {
            try {
                let respuesta = await fetch("{{ route('dplis_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('descripcion_vista').innerHTML            = `<div class="alert alert-danger alert-dismissible" role="alert">
                        `+dato.mensaje.descripcion+`
                    </div>`;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }
    </script>
@endsection
