@extends('principal')
@section('titulo', '| PROFESIONES')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: PROFESIÓN -- TIPO  :   {{ $ambito_profesional->nombre }} :::::::: </h5>
            @can('ambito_profesional_vizualizar_profesion_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_profesion_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_profesion" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">Nº</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add profesion Modal -->
    <div class="modal fade" id="modal_profesion_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_profesion()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nueva profesión</h3>
                    </div>
                    <form id="formulario_nuevo_profesion" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_ambito" id="id_ambito" value="{{ $id_ambito }}">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_profesion" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_profesion()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add profesion Modal -->

    <!-- Update profesion Modal -->
    <div class="modal fade" id="modal_profesion_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_profesion_edit()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar profesión</h3>
                    </div>
                    <form id="formulario_editar_profesion" class="row" method="POST" autocomplete="off" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_profesion" id="id_profesion">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_profesion_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_profesion_edit()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update profesion Modal -->
@endsection
@section('scripts')
    <script>
        let id_ambito = {{ $id_ambito }};
        //declarar variables
        let guardar_profesion_btn       = document.getElementById('btn_guardar_profesion');
        let formulario_nuevo_profesion  = document.getElementById('formulario_nuevo_profesion');

        //para cerrar el modal para la creacion de profesiones
        function cerrar_modal_profesion(){
            let nuevo_arr = ['nombre'];
            nuevo_arr.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_form_profesional();
            $('#modal_profesion_nuevo').modal('hide');
        }
        //para el vaciado de errores
        function vaciar_errores_form_profesional(){
            let nuevo_array = ['_nombre', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }


        //para guardar el nuevo resgistro de profesional
        guardar_profesion_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nuevo_profesion).entries());
            vaciar_errores_form_profesional();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_profesion');
            try {
                let respuesta = await fetch("{{ route('pfs_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_profesion();
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion');
                    actulizar_tabla();

                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_profesion');
            }
        });


        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_profesion').DataTable().destroy();
            listar_profesiones();
            $('#tabla_profesion').fadeIn(200);
        }

        //para listar las profesiones
        async function listar_profesiones() {
            let respuesta = await fetch("{{ route('pfs_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({id:id_ambito})
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_profesion').DataTable({
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
                                    @can('ambito_profesional_vizualizar_profesion_editar')
                                        <button type="button" onclick="editar_profesion('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('ambito_profesional_vizualizar_profesion_eliminar')
                                        <button type="button" onclick="eliminar_profesion('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_profesiones();


        //para eliminar la profesion
        async function eliminar_profesion(id){
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
                        let respuesta = await fetch("{{ route('pfs_eliminar') }}",{
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
                }else{
                    alerta_top('error', 'Se cancelo');
                }
            });
        }
        //fin para eliminar la profesion


        //para editar el registro
        let guardar_profesion_btn_edit      = document.getElementById('btn_guardar_profesion_editado');
        let formulario_edit_profesion       = document.getElementById('formulario_editar_profesion');

        //para cerrar el modal para la creacion de profesiones
        function cerrar_modal_profesion_edit(){
            let nuevo_arr = ['nombre_'];
            nuevo_arr.forEach(element => {
                document.getElementById(element).value = '';
            });
            vaciar_errores_form_profesional();
            $('#modal_profesion_editar').modal('hide');
        }

        //para editar la profesion
        async function editar_profesion(id){
            try {
                let respuesta = await fetch("{{ route('pfs_editar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_profesion_editar').modal('show');
                    document.getElementById('id_profesion').value = dato.mensaje.id;
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
        guardar_profesion_btn_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_edit_profesion).entries());
            vaciar_errores_form_profesional();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_profesion_editado');
            try {
                let respuesta = await fetch("{{ route('pfs_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion_editado');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_profesion_edit();
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion_editado');
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_profesion_editado');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_profesion_editado');
            }
        });
        //fin para editar el registro

    </script>
@endsection
