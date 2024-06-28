@extends('principal')
@section('titulo', '| UNIDADES ADMINISTRATIVAS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: UNIDADES ADMINISTRATIVAS :::::::: </h5>
            @can('unidades_administrativas_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_unidades_administrativas">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_unidades_administrativas" style="width: 100%">
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

    <!-- Modal -->
    <!-- Add grado academico Modal -->
    <div class="modal fade" id="modal_nuevo_unidades_administrativas" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_unidades_admin()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nueva Unidad Administrativa</h3>
                    </div>
                    <form id="formulario_nuevo_unidades_admin" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla">Sigla</label>
                            <input type="text" id="sigla" name="sigla" class="form-control uppercase-input"
                                placeholder="Ingrese la Sigla" autofocus />
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
                        <button id="btn_guardar_unidades_admin" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_unidades_admin()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add grado academico Modal -->

    <!-- Update grado academico Modal -->
    <div class="modal fade" id="modal_editar_unidades_administrativas" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_unidades_admin_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Registro de nuevo grado Académico</h3>
                    </div>
                    <form id="formulario_editar_unidad_admin" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_unidad_admin" name="id_unidad_admin">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla_">Sigla</label>
                            <input type="text" id="sigla_" name="sigla_" class="form-control uppercase-input"
                                placeholder="Ingrese la Sigla" autofocus />
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
                        <button id="btn_guardar_unidades_admin_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_unidades_admin_editar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update grado academico Modal -->
@endsection

@section('scripts')
    <script>
        let unidad_admin_form          = document.getElementById('formulario_nuevo_unidades_admin');
        let guardar_unidades_admin_btn = document.getElementById('btn_guardar_unidades_admin');

        function cerrar_modal_unidades_admin(){
            $('#modal_nuevo_unidades_administrativas').modal('hide');
            vaciar_formulario(unidad_admin_form);
            vaciar_errores_unidades_administrativas();
        }

        //function para vaciar los errores
        function vaciar_errores_unidades_administrativas(){
            let nuevo_array = ['_nombre', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para listar las unidades adminstrativas
        async function  listar_unidades_administrativas() {
            let respuesta = await fetch("{{ route('uadm_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_unidades_administrativas').DataTable({
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
                            @can('unidades_administrativas_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_unidades_admin('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('unidades_administrativas_editar')
                                        <button type="button" onclick="editar_unidad_admin('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('unidades_administrativas_eliminar')
                                        <button type="button" onclick="eliminar_unidad_admin('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_unidades_administrativas();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_unidades_administrativas').DataTable().destroy();
            listar_unidades_administrativas();
            $('#tabla_unidades_administrativas').fadeIn(200);
        }

        //para guardar el registro de unidades administrativas
        guardar_unidades_admin_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(unidad_admin_form).entries());
            vaciar_errores_unidades_administrativas();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_unidades_admin');
            try {
                let respuesta = await fetch("{{ route('uadm_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_unidades_admin();
                    vaciar_errores_unidades_administrativas();
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin');
            }
        });

        //PARA CAMBIAR EL ESTADO DE LAS UNIDADES ADMINISTRATTIVAS
        function estado_unidades_admin(id){
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
                        let respuesta = await fetch("{{ route('uadm_estado') }}",{
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

        //para eliminar la unidad administrativa
        async function  eliminar_unidad_admin(id) {
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
                        let respuesta = await fetch("{{ route('uadm_eliminar') }}",{
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

        //para editar el registro
        let form_unidades_admin_editar = document.getElementById('formulario_editar_unidad_admin');
        let btn_gua_unidades_admin_edit = document.getElementById('btn_guardar_unidades_admin_editado');
        //PARA EDITAR LAS UNIDADES ADMINISTRATIVAS


        //para cerrar el modal para el tipo de contrato para editar
        function cerrar_modal_unidades_admin_editar(){
            $('#modal_editar_unidades_administrativas').modal('hide');
            vaciar_formulario(form_unidades_admin_editar);
            vaciar_errores_unidades_administrativas();
        }

        //para editar el registro de unidades administrativas
        async function editar_unidad_admin(id) {
            try {
                let respuesta = await fetch("{{ route('uadm_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_unidades_administrativas').modal('show');
                    document.getElementById('id_unidad_admin').value = dato.mensaje.id;
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

        //para guardar lo editado de las unidades administrativas
        btn_gua_unidades_admin_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_unidades_admin_editar).entries());
            vaciar_errores_unidades_administrativas();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_unidades_admin_editado');
            console.log(datos);
            try {
                let respuesta = await fetch("{{ route('uadm_editar_guardar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                console.log(dato);
                if(dato.tipo === 'errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin_editado');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_unidades_admin_editar();
                    vaciar_errores_unidades_administrativas();
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin_editado');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin_editado');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_unidades_admin_editado');
            }
        });
    </script>
@endsection
