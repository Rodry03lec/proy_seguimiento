@extends('principal')
@section('titulo', '| MAE')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: MAE ::::::::  </h5>
            @can('mae_unidad_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_mae">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan

        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_mae" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">UNIDADES</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo mae Modal -->
    <div class="modal fade" id="modal_nuevo_mae" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_mae()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo MAE</h3>
                    </div>
                    <form id="formulario_nuevo_mae" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_form_mae" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_mae()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add mae Modal -->

    <!-- Update mae Modal -->
    <div class="modal fade" id="modal_editar_mae" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_mae_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar MAE</h3>
                    </div>
                    <form id="formulario_editar_mae" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_mae" name="id_mae">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_mae_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_mae_editar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update mae Modal -->

    <!-- Extra Large Modal -->
    <div class="modal fade" id="listar_cargos_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Listado de dirección - unidades</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_administracion_unidad()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_tipo" role="alert">
                    </div>
                    <form id="formulario_nuevo_unidad" method="post">
                        @csrf
                        <input type="hidden" name="id_mae_new" id="id_mae_new">
                        <input type="hidden" name="id_cargo" id="id_cargo">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" id="descripcion" name="descripcion" class="form-control uppercase-input" placeholder="Ingrese el descripcion" onkeypress="return soloLetras(event)">
                                <div id="_descripcion" ></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 py-2s">
                                <label class="invisible"></label>
                                <div class="d-grid gap-2 mx-auto">
                                    @can('mae_unidad_vizualizar_unidades_nuevo')
                                        <button class="btn btn-primary btn-md" id="btn_guardar_unidad" type="button">Guardar</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="tabla_lista_unidad" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">DESCRIPCIÓN</th>
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
        let form_mae                = document.getElementById('formulario_nuevo_mae');
        let guardar_form_mae_btn    = document.getElementById('btn_guardar_form_mae');

        //para cerrar el modal de mae
        function cerrar_modal_mae(){
            $('#modal_nuevo_mae').modal('hide');
            vaciar_formulario(form_mae);
            vaciar_errores_mae();
        }
        //para vaciar los errores del formulario mae
        function vaciar_errores_mae(){
            let nuevo_array = ['_nombre','_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }
        //para guardar el registro de mae
        guardar_form_mae_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_mae).entries());
            try {
                let respuesta = await fetch("{{ route('mae_guardar') }}",{
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
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciamos los errores
                    vaciar_errores_mae();
                    actulizar_tabla();
                    cerrar_modal_mae();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_mae').DataTable().destroy();
            listar_mae();
            $('#tabla_mae').fadeIn(200);
        }

         //para listar los datos
        async function listar_mae() {
            let respuesta = await fetch("{{ route('mae_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_mae').DataTable({
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
                                <div class="d-inline-block tex-nowrap">
                                    @can('mae_unidad_vizualizar')
                                        <button type="button" onclick="vista_unidad('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR UNIDADES">
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
                                    @can('mae_unidad_editar')
                                        <button type="button" onclick="editar_mae('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('mae_unidad_eliminar')
                                        <button type="button" onclick="eliminar_mae('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_mae();

        //PARA LA ELIMINACION DEL REGISTRO
        async function eliminar_mae(id) {
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
                        let respuesta = await fetch("{{ route('mae_eliminar') }}",{
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
        //PARA LA ELIMINACION DEL REGISTRO

        //PARA EDITAR EL REGISTRO
        let form_mae_edit               = document.getElementById('formulario_editar_mae');
        let guardar_form_mae_edit_btn   = document.getElementById('btn_guardar_mae_editado');

        //para cerrar el modal de editar
        function cerrar_modal_mae_editar(){
            $('#modal_editar_mae').modal('hide');
            vaciar_formulario(form_mae_edit);
            vaciar_errores_mae();
        }
        //para editar el mae
        async function editar_mae(id) {
            try {
                let respuesta = await fetch("{{ route('mae_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_mae').modal('show');
                    document.getElementById('id_mae').value     = dato.mensaje.id;
                    document.getElementById('nombre_').value    = dato.mensaje.nombre;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }
        //FIN PARA EDITAR EL REGISTRO

        //  PARA GUARDAR LO EDITADO
        guardar_form_mae_edit_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_mae_edit).entries());
            try {
                let respuesta = await fetch("{{ route('mae_editar_guardar') }}",{
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
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciamos los errores
                    vaciar_errores_mae();
                    actulizar_tabla();
                    cerrar_modal_mae_editar();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });
        //FIN PARA GUARDAR LO EDITADO


        //AHORA NOS PASAMOS A LA PARTE DE LOS CARGOS QUE TIENE CADA UNO
        //para cerrar el modal para la administracion de cargos
        function cerrar_modal_administracion_unidad(){
            $('#listar_cargos_modal').modal('hide');
            actulizar_tabla_unidad();
            vaciar_formulario_unidad();
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla_unidad() {
            $('#tabla_lista_unidad').DataTable().destroy();
            $('#tabla_lista_unidad').fadeIn(200);
        }

        //para abrirl el mdal de vista de cargos
        async function vista_unidad(id){
            try {
                let respuesta = await fetch("{{ route('mae_unidad') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#listar_cargos_modal').modal('show');
                    document.getElementById('id_mae_new').value = id;
                    document.getElementById('detalle_tipo').innerHTML = `<h5 class="alert-heading mb-2">CATEGORÍA :  `+dato.mensaje.nombre+` </h5>`;
                    actulizar_tabla_unidad();
                    listar_unidad(dato.mensaje.id);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }

        //para el formulario
        let formulario_unidad  = document.getElementById('formulario_nuevo_unidad');
        let guardar_unidad_btn = document.getElementById('btn_guardar_unidad');

        //funcion para vaciar los inputs
        function vaciar_formulario_unidad(){
            let array = ['descripcion', 'id_cargo'];
            array.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_unidad();
        }
        //para vaciar los errores del nivel
        function vaciar_errores_unidad(){
            let nuevo_array = ['_descripcion'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }



        //para listar los cargos
        async function listar_unidad(id){
            let respuesta = await fetch("{{ route('mae_unidad_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_lista_unidad').DataTable({
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
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('mae_unidad_vizualizar_unidades_editar')
                                        <button type="button" onclick="editar_mae_unidad('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('mae_unidad_vizualizar_unidades_eliminar')
                                        <button type="button" onclick="eliminar_mae_unidad('${row.id}',${row.id_mae})" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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


        //para guardar el registro del cargo
        guardar_unidad_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_unidad).entries());
            vaciar_errores_unidad();
            try {
                let respuesta = await fetch("{{ route('mae_unidad_nuevo') }}",{
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
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciamos los errores
                    vaciar_errores_unidad();
                    vaciar_formulario_unidad();
                    actulizar_tabla_unidad();
                    listar_unidad(dato.id_mae_registro);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });

        //para editar el cargo del mae
        async function editar_mae_unidad(id){
            try {
                let respuesta = await fetch("{{ route('mag_unidad_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_cargo').value     = dato.mensaje.id;
                    document.getElementById('descripcion').value    = dato.mensaje.descripcion;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }


        //para eliminar el registro
        async function eliminar_mae_unidad(id, id_mae) {
            vaciar_formulario_unidad();
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
                        let respuesta = await fetch("{{ route('mag_unidad_eliminar') }}",{
                            method: "DELETE",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actulizar_tabla_unidad();
                            listar_unidad(id_mae);
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
