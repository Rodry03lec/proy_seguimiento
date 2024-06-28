@extends('principal')
@section('titulo', '| GENERO - ESTADO')
@section('contenido')
    <div class="col-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#genero" aria-controls="genero"
                        aria-selected="true"><i class="tf-icons ti ti-user ti-xs me-1"></i> ADMINISTRACIÓN DE GÉNERO</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#estado_civil" aria-controls="estado_civil"
                        aria-selected="false"><i class="tf-icons ti ti-user ti-xs me-1"></i> ADMINISTRACIÓN DE ESTADO CIVIL</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="genero" role="tabpanel">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">:::::::: TIPOS DE GÉNERO :::::::: </h5>
                        @can('genero_nuevo')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_genero">
                                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                            </button>
                        @endcan
                    </div>
                    <div class="table-responsive text-nowrap p-4">
                        <table class="table table-hover" id="tabla_genero" style="width: 100%">
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
                <div class="tab-pane fade" id="estado_civil" role="tabpanel">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">:::::::: TIPOS DE ESTADO CIVIL :::::::: </h5>
                        @can('estado_civil_nuevo')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_estado_civil">
                                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                            </button>
                        @endcan

                    </div>
                    <div class="table-responsive text-nowrap p-4">
                        <table class="table table-hover" id="tabla_estado_civil" style="width: 100%">
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
    </div>

    <!-- Modal -->
    <!-- Add tipo de genero Modal -->
    <div class="modal fade" id="modal_tipo_genero" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_nuevo_genero()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Genero</h3>
                    </div>
                    <form id="formulario_nuevo_genero" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Sigla</label>
                            <input type="text" id="sigla" name="sigla" class="form-control uppercase-input"
                                placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_genero_nuevo" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_nuevo_genero()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de genero Modal -->

    <!-- Modal -->
    <!-- Add tipo de genero Modal -->
    <div class="modal fade" id="modal_tipo_genero_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_editar_genero()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Genero</h3>
                    </div>
                    <form id="formulario_editar_genero" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_genero" name="id_genero">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla_">Sigla</label>
                            <input type="text" id="sigla_" name="sigla_" class="form-control uppercase-input"
                                placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_genero_editar" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_editar_genero()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de genero Modal -->


    <!-- Modal -->
    <!-- Add tipo de estado civil Modal -->
    <div class="modal fade" id="modal_estado_civil" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_nuevo_estado_civil()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Estado Civil</h3>
                    </div>
                    <form id="formulario_nuevo_estado_civil" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre__">Nombre</label>
                            <input type="text" id="nombre__" name="nombre__" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre__"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_estado_civil_nuevo" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_estado_civil()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de estado civil Modal -->

    <!-- Add tipo de estado civil Modal -->
    <div class="modal fade" id="modal_estado_civil_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_editar_estado_civil()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Estado Civil</h3>
                    </div>
                    <form id="formulario_edit_estado_civil" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_estado_civil" id="id_estado_civil">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre___">Nombre</label>
                            <input type="text" id="nombre___" name="nombre___" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre___"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_estado_civil_edit" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_editar_estado_civil()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de estado civil Modal -->


@endsection


@section('scripts')
    <script>
        //declaramos la varibles que se utilizara para la administracion de genero
        let form_genero_nuevo          = document.getElementById('formulario_nuevo_genero');
        let btn_genero_nuevo           = document.getElementById('btn_guardar_genero_nuevo');
        //para cerrar el modal de tipo de categoría
        function cerrar_modal_nuevo_genero(){
            $('#modal_tipo_genero').modal('hide');
            vaciar_formulario(form_genero_nuevo);
            vaciar_errores_genero();
        }
        //para vaciar errores del tipo de categoria
        function vaciar_errores_genero(){
            let nuevo_array = ['_sigla', '_nombre','_sigla_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_genero() {
            $('#tabla_genero').DataTable().destroy();
            listar_genero();
            $('#tabla_genero').fadeIn(200);
        }
        /**@argument
         * ADMINISTRACION DE GENERO
         * */
        //para guardar el genero
        btn_genero_nuevo.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_genero_nuevo).entries());
            vaciar_errores_genero();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_genero_nuevo');
            try {
                let respuesta = await fetch("{{ route('gen_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_nuevo');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_nuevo_genero();
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_nuevo');
                    actulizar_tabla_genero();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_nuevo');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_genero_nuevo');
            }
        });

        //PARA LISTAR GENEROS
        async function listar_genero() {
            let respuesta = await fetch("{{ route('gen_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_genero').DataTable({
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
                            @can('genero_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_genero('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('genero_editar')
                                        <button type="button"  onclick="editar_genero('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('genero_eliminar')
                                        <button type="button"  onclick="eliminar_genero('${row.id}')"class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_genero();
        //FIN PARA LISTAR GENEROS


        //para eliminar el genero
        function eliminar_genero(id){
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
                        let respuesta = await fetch("{{ route('gen_eliminar') }}",{
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
                            actulizar_tabla_genero();
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
        //para vcambiar el estado
        function estado_genero(id){
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
                        let respuesta = await fetch("{{ route('gen_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actulizar_tabla_genero();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                        actulizar_tabla_genero();
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla_genero();
                }
            });
        }

         //PARA EDITAR EL GENERO
        let form_genero_edit          = document.getElementById('formulario_editar_genero');
        let btn_genero_edit           = document.getElementById('btn_guardar_genero_editar');
        //para cerrar el modal de tipo de genero
        function cerrar_modal_editar_genero(){
            $('#modal_tipo_genero_editar').modal('hide');
            vaciar_formulario(form_genero_edit);
            vaciar_errores_genero();
        }
        //para editar
        async function editar_genero(id) {
            try {
                let respuesta = await fetch("{{ route('gen_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_tipo_genero_editar').modal('show');
                    document.getElementById('id_genero').value = dato.mensaje.id;
                    document.getElementById('sigla_').value = dato.mensaje.sigla;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para guardar lo editado
        btn_genero_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_genero_edit).entries());
            vaciar_errores_genero();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_genero_editar');
            try {
                let respuesta = await fetch("{{ route('gen_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_editar');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_editar_genero();
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_editar');
                    actulizar_tabla_genero();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_genero_editar');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_genero_editar');
            }
        });


        //PARA LISTAR ESTADO CIVIL
        async function listar_estado_civil() {
            let respuesta = await fetch("{{ route('eci_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_estado_civil').DataTable({
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
                                @can('estado_civil_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_civil_estado('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('estado_civil_editar')
                                        <button type="button" onclick="editar_estado_civil('${row.id}')"class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('estado_civil_eliminar')
                                        <button type="button" onclick="eliminar_estado_civil('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                </div>
                            `;
                        }
                    }
                ]
            });
        }
        listar_estado_civil();
        //FIN PARA LISTAR ESTADO CIVIL

        //funcion  de acctualizar tabla
        function actulizar_tabla_estado_civil() {
            $('#tabla_estado_civil').DataTable().destroy();
            listar_estado_civil();
            $('#tabla_estado_civil').fadeIn(200);
        }

        //declaramos la varibles que se utilizara para la administracion de estado civil
        let form_estado_civil_nuevo          = document.getElementById('formulario_nuevo_estado_civil');
        let btn_estado_civil_nuevo           = document.getElementById('btn_guardar_estado_civil_nuevo');

        //para cerrar el modal de estado civil
        function cerrar_modal_nuevo_estado_civil(){
            vaciar_formulario(form_estado_civil_nuevo);
            vaciar_errores_estado_civil();
            $('#modal_estado_civil').modal('hide');
        }
        //para vaciar errores de estado civil
        function vaciar_errores_estado_civil(){
            let nuevo_array = ['_nombre__', '_nombre___'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        /**@argument
         * ADMINISTRACION DE ESTADO CIVIL
         * */
        //para guardar el estado civil
        btn_estado_civil_nuevo.addEventListener('click', async()=>{
            let datos = Object.fromEntries(new FormData(form_estado_civil_nuevo).entries());
            vaciar_errores_estado_civil();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_estado_civil_nuevo');
            try {
                let respuesta = await fetch("{{ route('eci_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_nuevo');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_nuevo_estado_civil();
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_nuevo');
                    actulizar_tabla_estado_civil();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_nuevo');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_nuevo');
            }
        });

        //para eliminar el registro
        function eliminar_estado_civil(id){
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
                        let respuesta = await fetch("{{ route('eci_eliminar') }}",{
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
                            actulizar_tabla_estado_civil();
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

        //para cambiar el estado
        function estado_civil_estado(id){
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
                        let respuesta = await fetch("{{ route('eci_estado') }}",{
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
                            actulizar_tabla_estado_civil();
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
                    actulizar_tabla_estado_civil();
                }
            });
        }

        //PARA EDITAR REGISTROS DEL ESTADO CIVIL
        let form_estado_civil_editar          = document.getElementById('formulario_edit_estado_civil');
        let btn_estado_civil_editar           = document.getElementById('btn_guardar_estado_civil_edit');
        //para cerrar el modal estado civil
        function cerrar_modal_editar_estado_civil(){
            $('#modal_estado_civil_editar').modal('hide');
            vaciar_formulario(form_estado_civil_editar);
            vaciar_errores_estado_civil();
        }

        //para editar el estado civil
        async function editar_estado_civil(id){
            try {
                let respuesta = await fetch("{{ route('eci_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_estado_civil_editar').modal('show');
                    document.getElementById('id_estado_civil').value    = dato.mensaje.id;
                    document.getElementById('nombre___').value          = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para guardar el registro de estado civil
        btn_estado_civil_editar.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_estado_civil_editar).entries());
            vaciar_errores_estado_civil();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_estado_civil_edit');
            try {
                let respuesta = await fetch("{{ route('eci_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_edit');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_editar_estado_civil();
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_edit');
                    actulizar_tabla_estado_civil();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_edit');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_estado_civil_edit');
            }
        });
    /**@argument
     * FIN PARA LA ADMINISTRACION DE ESTADO CIVIL
     * */
    </script>
@endsection
