@extends('principal')
@section('titulo', '| SECRETARIAS MUNICIPALES')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE LAS SECRETARIAS MUNICIPALES :::::::: </h5>
            @can('secretaria_municipales_direccion_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nueva_secretaria_municipal_modal">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_secretaria_municipal" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">SIGLA</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">ESTADO</th>
                        <th scope="col" class="table-th">DIRECCIONES</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de categoria Modal -->
    <div class="modal fade" id="nueva_secretaria_municipal_modal" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_secretaria_municipal()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nueva Secretaria Municipal</h3>
                    </div>
                    <form id="formulario_nuevo_secretaria_municipal" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla">Sigla</label>
                            <input type="text" id="sigla" name="sigla" class="form-control uppercase-input"
                                placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre de la Secretaria Municipal</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_secretaria_municipal" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_secretaria_municipal()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de categoria Modal -->

    <!-- Add tipo de categoria Modal -->
    <div class="modal fade" id="editar_secretaria_municipal_modal" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_secretaria_municipal_edit()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Secretaria Municipal</h3>
                    </div>
                    <form id="formulario_editar_secretaria_municipal" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_secretaria_mun" id="id_secretaria_mun">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla_">Sigla</label>
                            <input type="text" id="sigla_" name="sigla_" class="form-control uppercase-input"
                                placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre de la Secretaria Municipal</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_secretaria_municipal_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_secretaria_municipal_edit()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de categoria Modal -->

    <!-- Extra Large Modal -->
    <div class="modal fade" id="modal_direcciones_listar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Listado de dirección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_direcciones()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_direccion" role="alert">
                    </div>
                    <form id="formulario_nuevo_direccion" method="post" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_secretaria_new" id="id_secretaria_new">
                        <input type="hidden" name="id_direccion" id="id_direccion">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                <label for="sigla__" class="form-label">Sigla</label>
                                <input type="text" id="sigla__" name="sigla__" class="form-control uppercase-input" placeholder="Ingrese la sigla" onkeypress="return soloLetras(event)">
                                <div id="_sigla__" ></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                <label for="nombre__" class="form-label">Nombre de la Dirección</label>
                                <input type="text" id="nombre__" name="nombre__" placeholder="Ingrese la direccion" class="form-control uppercase-input" onkeypress="return soloLetras(event)"/>
                                <div id="_nombre__"></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 py-2s">
                                <label class="invisible"></label>
                                <div class="d-grid gap-2 mx-auto">
                                    @can('secretaria_municipales_direccion_vizualizar_nuevo')
                                        <button class="btn btn-primary btn-md" id="btn_guardar_direccion_nuevo" type="button">Guardar</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive text-nowrap p-4 py-2">
                    <table class="table table-hover" id="tabla_lista_direccion" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">SIGLA</th>
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
        let guardar_secretaria_municipal_btn       = document.getElementById('btn_guardar_secretaria_municipal');
        let formulario_nuevo_secretaria_municipal  = document.getElementById('formulario_nuevo_secretaria_municipal');

        //para cerrar el modal para la creacion de las secretarias municipales
        function cerrar_modal_secretaria_municipal(){
            vaciar_formulario(formulario_nuevo_secretaria_municipal);
            vaciar_errores_form_secre_municipal();
            $('#nueva_secretaria_municipal_modal').modal('hide');
        }
        //para el vaciado de errores
        function vaciar_errores_form_secre_municipal(){
            let nuevo_array = ['_sigla', '_nombre', '_sigla_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_secretaria_municipal').DataTable().destroy();
            listar_secretaria_municipal();
            $('#tabla_secretaria_municipal').fadeIn(200);
        }

        //para listar la secretaria municipal
        async function listar_secretaria_municipal() {
            let respuesta = await fetch("{{ route('smun_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_secretaria_municipal').DataTable({
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
                        data: 'sigla',
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
                            @can('secretaria_municipales_direccion_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_secretaria_municipal('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('secretaria_municipales_direccion_vizualizar')
                                        <button type="button" onclick="vista_direccion('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR DIRECCIONES">
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
                                    @can('secretaria_municipales_direccion_editar')
                                        <button type="button" onclick="editar_secretaria_municipal('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('secretaria_municipales_direccion_eliminar')
                                        <button type="button" onclick="eliminar_secretaria_municipal('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_secretaria_municipal();

        //para guardar el registro de la secretaria municipal
        guardar_secretaria_municipal_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nuevo_secretaria_municipal).entries());
            vaciar_errores_form_secre_municipal();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_secretaria_municipal');
            try {
                let respuesta = await fetch("{{ route('smun_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_secretaria_municipal();
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal');
            }
        });

        //para eliminar la profesion
        async function eliminar_secretaria_municipal(id){
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
                        let respuesta = await fetch("{{ route('smun_eliminar') }}",{
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
        //fin para eliminar la profesion

        let guardar_edit_secretaria_municipal_btn       = document.getElementById('btn_guardar_secretaria_municipal_editado');
        let formulario_secretaria_municipal_edit        = document.getElementById('formulario_editar_secretaria_municipal');

        //para cerrar el modal para editar de las secretarias municipales
        function cerrar_modal_secretaria_municipal_edit(){
            vaciar_formulario(formulario_secretaria_municipal_edit);
            vaciar_errores_form_secre_municipal();
            $('#editar_secretaria_municipal_modal').modal('hide');
        }

        async function editar_secretaria_municipal(id){
            try {
                let respuesta = await fetch("{{ route('smun_editar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#editar_secretaria_municipal_modal').modal('show');
                    document.getElementById('id_secretaria_mun').value = dato.mensaje.id;
                    document.getElementById('sigla_').value = dato.mensaje.sigla;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        }

        //para guardar lo editado
        guardar_edit_secretaria_municipal_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_secretaria_municipal_edit).entries());
            vaciar_errores_form_secre_municipal();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_secretaria_municipal_editado');
            try {
                let respuesta = await fetch("{{ route('smun_edit_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal_editado');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_secretaria_municipal_edit();
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal_editado');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal_editado');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_secretaria_municipal_editado');
            }
        });

        //para el estado de las secretarias generales
        function estado_secretaria_municipal(id){
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
                        let respuesta = await fetch("{{ route('smun_estado') }}",{
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
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla();
                }
            });
        }
        //FIN PARA EDITAR LA SECRETARIA MUNICIPAL

        /**
         *  PARA REGISTRAR LAS DIRECCIONES
         */
        let guardar_nuevo_direccion_btn       = document.getElementById('btn_guardar_direccion_nuevo');
        let formulario_direccion_nuevo        = document.getElementById('formulario_nuevo_direccion');

        //para vizualizar la parte de la direccion
        async function vista_direccion(id){
            try {
                let respuesta = await fetch("{{ route('dir_vista') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_direcciones_listar').modal('show');
                    document.getElementById('id_secretaria_new').value = id;
                    document.getElementById('detalle_direccion').innerHTML = `<strong class="ltr:mr-1 rtl:ml-1">  *** `+dato.mensaje.nombre+` *** </strong>`;
                    listar_direccion(dato.mensaje.id);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }


        //para cerrar el modal para la creacion de las secretarias municipales
        function cerrar_modal_direcciones(){
            //vaciar_formulario(formulario_nuevo_secretaria_municipal);
            vaciar_formulario_direcciones();
            $('#modal_direcciones_listar').modal('hide');
            actulizar_tabla_direccion();
        }


        //funcion para vaciar los inputs
        function vaciar_formulario_direcciones(){
            let array = ['sigla__', 'nombre__', 'id_direccion'];
            array.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_form_direcciones();
        }

        //para el vaciado de errores
        function vaciar_errores_form_direcciones(){
            let nuevo_array = ['_sigla__', '_nombre__'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_direccion() {
            $('#tabla_lista_direccion').DataTable().destroy();
            $('#tabla_lista_direccion').fadeIn(200);
        }

        //para listar las direcciones
        async function listar_direccion(id) {
            let respuesta = await fetch("{{ route('dir_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_lista_direccion').DataTable({
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
                        data: 'sigla',
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
                            @can('secretaria_municipales_direccion_vizualizar_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_direcion('${row.id}','${row.id_secretaria}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('secretaria_municipales_direccion_vizualizar_editar')
                                        <button type="button" onclick="editar_direccion('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('secretaria_municipales_direccion_vizualizar_eliminar')
                                        <button type="button" onclick="eliminar_direccion('${row.id}',${row.id_secretaria})" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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

        //para guardar la parte de las direccion
        guardar_nuevo_direccion_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_direccion_nuevo).entries());
            vaciar_errores_form_direcciones();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_direccion_nuevo');
            try {
                let respuesta = await fetch("{{ route('dir_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_direccion_nuevo');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    vaciar_formulario_direcciones();
                    validar_boton(false, 'Guardar', 'btn_guardar_direccion_nuevo');
                    actulizar_tabla_direccion();
                    listar_direccion(dato.id_secretaria_nuevo);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_direccion_nuevo');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_direccion_nuevo');
            }
        });

        //para la edicion de los registro de la direccion
        async function editar_direccion(id){
            try {
                let respuesta = await fetch("{{ route('dir_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_direccion').value = id;
                    document.getElementById('sigla__').value = dato.mensaje.sigla;
                    document.getElementById('nombre__').value = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }


        //para la edicion de los registro de la direccion
        async function editar_direccion(id){
            try {
                let respuesta = await fetch("{{ route('dir_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_direccion').value = id;
                    document.getElementById('sigla__').value = dato.mensaje.sigla;
                    document.getElementById('nombre__').value = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }

        ///para el estado de la direccion
        async function estado_direcion(id, id_secre) {
            vaciar_formulario_direcciones();
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
                        let respuesta = await fetch("{{ route('dir_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actulizar_tabla_direccion();
                            alerta_top(dato.tipo, dato.mensaje);
                            listar_direccion(id_secre);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    actulizar_tabla_direccion();
                    alerta_top('error', 'Se cancelo');
                    listar_direccion(id_secre);
                }
            });
        }

        //para eliminar el registro de las secretarias municipales
        async function eliminar_direccion(id, id_secretaria) {
            vaciar_formulario_direcciones();
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
                        let respuesta = await fetch("{{ route('dir_eliminar') }}",{
                            method: "DELETE",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actulizar_tabla_direccion();
                            alerta_top(dato.tipo, dato.mensaje);
                            listar_direccion(id_secretaria);
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

    </script>
@endsection
