@extends('principal')
@section('titulo', '| TIPO DE CONTRATO')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: TIPOS DE CATEGORÍA :::::::: </h5>
            @can('tipo_categoria_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_categoria_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_categoria" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NOMBRE</th>
                        <th>NIVEL</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de categoria Modal -->
    <div class="modal fade" id="modal_tipo_categoria_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipocategoria()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Tipo de Categoría</h3>
                    </div>
                    <form id="formulario_nuevo_tipocategoria" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipocategoria" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_tipocategoria()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de categoria Modal -->

    <!-- Update tipo de categoria Modal -->
    <div class="modal fade" id="modal_tipo_categoria_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipocategoria_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Tipo de Contrato</h3>
                    </div>
                    <form id="formulario_editar_tipocategoria" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipocategoria" id="id_tipocategoria">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipocategoria_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_tipocategoria_editar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update tipo de categoria Modal -->


    <!-- Extra Large Modal -->
    <div class="modal fade" id="modal_listar_niveles" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Listado de niveles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_administracion_nivel()"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible" id="detalle_categoria" role="alert">
                    </div>
                    <form id="formulario_nuevo_nivel" method="post" autocomplete="off">
                        <input type="hidden" name="id_categoria" id="id_categoria">
                        <input type="hidden" name="id_nivel" id="id_nivel">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="nivel" class="form-label">Nivel</label>
                                <input type="text" id="nivel" name="nivel" class="form-control" placeholder="Ingrese el nivel" onkeypress="return filterFloat(event, this)">
                                <div id="_nivel" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" id="descripcion" name="descripcion" class="form-control uppercase-input" placeholder="Ingrese la descripción" onkeypress="return soloLetras(event)">
                                <div id="_descripcion" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="haber_basico" class="form-label">Haber basico (Bs)</label>
                                <input type="text" id="haber_basico" name="haber_basico" class="form-control monto_number" placeholder="Ingrese el haber básico">
                                <div id="_haber_basico" ></div>
                            </div>
                        </div>
                    </form>


                    <div class="row mt-3">
                        <div class="d-grid gap-2 col-lg-6 mx-auto">
                            @can('tipo_categoria_vizualizar_nivel_nuevo')
                                <button class="btn btn-primary btn-md" id="btn_guardar_nivel" type="button">Guardar</button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="tabla_listar_niveles" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">NIVEL</th>
                                <th scope="col" class="table-th">DESCRIPCIÓN</th>
                                <th scope="col" class="table-th">HABER BASICO</th>
                                <th scope="col" class="table-th">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let form_tipocategoria = document.getElementById('formulario_nuevo_tipocategoria');
        let guardar_tipocategoria_btn = document.getElementById('btn_guardar_tipocategoria');

        //para cerrar el modal de tipo de categoría
        function cerrar_modal_tipocategoria() {
            $('#modal_tipo_categoria_nuevo').modal('hide');
            vaciar_formulario(form_tipocategoria);
            vaciar_errores_tipocategoria();
        }
        //para vaciar errores del tipo de categoria
        function vaciar_errores_tipocategoria() {
            let nuevo_array = ['_nombre', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tipo_categoria').DataTable().destroy();
            listar_tiposcategoria();
            $('#tabla_tipo_categoria').fadeIn(200);
        }

        //PARA GUARDAR EL TIPO DE CONTRATO
        guardar_tipocategoria_btn.addEventListener('click', async () => {
            let datos = Object.fromEntries(new FormData(form_tipocategoria).entries());
            try {
                let respuesta = await fetch("{{ route('xtc_guardar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[
                            key] + `</p>`;
                    }
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciamos los errores
                    vaciar_errores_tipocategoria();
                    actulizar_tabla();
                    cerrar_modal_tipocategoria();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });


        //para listar los datos
        async function listar_tiposcategoria() {
            let respuesta = await fetch("{{ route('xtc_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_categoria').DataTable({
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
                                    @can('tipo_categoria_vizualizar')
                                        <button type="button" onclick="vista_niveles('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR">
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
                                    @can('tipo_categoria_editar')
                                        <button type="button" onclick="editar_tipocategoria('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('tipo_categoria_eliminar')
                                        <button type="button" onclick="eliminar_tipocategoria('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_tiposcategoria();

        //PARA ELIMINAR EL TIPO DE CATEGORIA
        function eliminar_tipocategoria(id) {
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
                        let respuesta = await fetch("{{ route('xtc_eliminar') }}", {
                            method: "DELETE",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                id: id
                            })
                        });
                        let dato = await respuesta.json();
                        if (dato.tipo === 'success') {
                            //destruimos la tabla
                            actulizar_tabla();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if (dato.tipo === 'error') {
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : ' + error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                }
            });
        }
        //FIN PARA ELIMINAR EL TIPO DE CATEGORIA

        //PARA EDITAR EL TIPO DE CATEGORIA
        let form_tipocategoria_editar = document.getElementById('formulario_editar_tipocategoria');
        let btn_gua_tipocategoria_edit = document.getElementById('btn_guardar_tipocategoria_editado');

        //para cerrar el modal para el tipo de categoria para editar
        function cerrar_modal_tipocategoria_editar() {
            $('#modal_tipo_categoria_editar').modal('hide');
            vaciar_formulario(form_tipocategoria_editar);
            vaciar_errores_tipocategoria();
        }
        //para editar la categoria
        async function editar_tipocategoria(id) {
            try {
                let respuesta = await fetch("{{ route('xtc_editar') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id: id
                    })
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'success') {
                    $('#modal_tipo_categoria_editar').modal('show');
                    document.getElementById('id_tipocategoria').value = dato.mensaje.id;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : ' + error);
            }
        }

        //para guardar lo editado del tipo de categoria
        btn_gua_tipocategoria_edit.addEventListener('click', async () => {
            let datos = Object.fromEntries(new FormData(form_tipocategoria_editar).entries());
            try {
                let respuesta = await fetch("{{ route('xtc_edit_guardar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[
                            key] + `</p>`;
                    }
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    actulizar_tabla();
                    cerrar_modal_tipocategoria_editar();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });
        //FIN PARA EDITAR EL TIPO DE CATEGORIA


        //PARA LA ADMINISTRACIÓN DE NIVEL
        //para cerrar el modal para la administracion de niveles
        function cerrar_modal_administracion_nivel() {
            actulizar_tabla_nivel();
            vaciar_formulario_nivel();
        }


        //funcion  de acctualizar tabla
        function actulizar_tabla_nivel() {
            $('#tabla_listar_niveles').DataTable().destroy();
            $('#tabla_listar_niveles').fadeIn(200);
        }

        //para listar niveles
        async function vista_niveles(id){

            try {
                let respuesta = await fetch("{{ route('xtn_tiponivel_abrir') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $("#modal_listar_niveles").modal('show');
                    document.getElementById('id_categoria').value = dato.mensaje.id;
                    document.getElementById('detalle_categoria').innerHTML = `<h5 class="alert-heading mb-2">CATEGORÍA :  `+dato.mensaje.nombre+` </h5>`;
                    listar_niveles(dato.mensaje.id);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos: ' + error);
            }
        }

        async function  listar_niveles(id) {
            let respuesta = await fetch("{{ route('xtn_nivellista') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_listar_niveles').DataTable({
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
                        data: 'nivel',
                        className: 'table-td'
                    },
                    {
                        data: 'descripcion',
                        className: 'table-td'
                    },
                    {
                        data: 'haber_basico',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('tipo_categoria_vizualizar_nivel_editar')
                                        <button type="button" onclick="editar_nivel('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('tipo_categoria_vizualizar_nivel_eliminar')
                                        <button type="button" onclick="eliminar_nivel('${row.id}', '${row.id_categoria}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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

        //para el formulario
        let formulario_nivel  = document.getElementById('formulario_nuevo_nivel');
        let guardar_nivel_btn = document.getElementById('btn_guardar_nivel');


        //funcion para vaciar los inputs
        function vaciar_formulario_nivel(){
            let array = ['id_nivel','nivel', 'descripcion', 'haber_basico'];
            array.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_nivel();
        }
        //para vaciar los errores del nivel
        function vaciar_errores_nivel(){
            let nuevo_array = ['_nivel', '_descripcion', '_haber_basico'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para crear nuevo y editar registro del nivel
        guardar_nivel_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nivel).entries());
            let id_categoria = document.getElementById('id_categoria').value;
            vaciar_errores_nivel();
            try {
                let respuesta = await fetch("{{ route('xtn_nivelnuevo') }}",{
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
                    actulizar_tabla_nivel();
                    listar_niveles(id_categoria);
                    vaciar_formulario_nivel();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });

        //para la eiyar del registro del nivel
        async function editar_nivel(id){
            try {
                let respuesta = await fetch("{{ route('xtn_niveleditar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    document.getElementById('id_nivel').value = dato.id_nivel_edi;
                    document.getElementById('nivel').value = dato.nivel_edi;
                    document.getElementById('descripcion').value = dato.descripcion_edi;
                    document.getElementById('haber_basico').value = dato.haber_basico_edi;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        }

        //para eliminar el registro del nivel
        async function eliminar_nivel(id, id_categoria){
            vaciar_formulario_nivel();
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
                        let respuesta = await fetch("{{ route('xtn_niveleliminar') }}",{
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
                            actulizar_tabla_nivel();
                            listar_niveles(id_categoria);
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
        //FIN PARA LA ADMINISTRACION DEL NIVEL

    </script>
@endsection
