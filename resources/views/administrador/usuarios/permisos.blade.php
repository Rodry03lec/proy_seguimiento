@extends('principal')
@section('titulo', '| PERMISOS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">PERMISOS</h5>
            @can('permisos_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_permiso_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo Permiso</span>
                </button>
            @endcan

        </div>
        <div class="table-responsive text-nowrap p-4" >
            <table class="table" id="table_permiso" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NOMBRE</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tabla-permiso">

                </tbody>
            </table>
        </div>
    </div>



    <!-- Modal -->
    <!-- Add Permission Modal -->
    <div class="modal fade" id="modal_permiso_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_permiso()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Permiso</h3>
                    </div>
                    <form id="formulario_nuevo_permiso" class="row" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Permiso</label>
                            <input type="text" id="nombre" name="nombre" class="form-control"
                                placeholder="Ingrese el permiso" autofocus />
                            <div id="_nombre" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_nuevo_permiso" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_permiso()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Permission Modal -->

    <!-- Modal -->
    <!-- Update Permission Modal -->
    <div class="modal fade" id="modal_permiso_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_permiso()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Permiso</h3>
                    </div>
                    <form id="formulario_editar_permiso" class="row" method="POST">
                        @csrf
                        <input type="hidden" name="id_permiso" id="id_permiso">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Permiso</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control"
                                placeholder="Ingrese el permiso" autofocus />
                            <div id="_nombre_" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_editado_permiso" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_permiso()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update Permission Modal -->
@endsection


@section('scripts')
    <script>
        //para listar los datos
        async function listar_permiso() {
            let respuesta = await fetch("{{ route('per_listar') }}");
            let dato = await respuesta.json();
            let i = 1;
            $('#table_permiso').DataTable({
                responsive: true,
                data: dato,
                columns: [
                    {
                        data: null,
                        className: 'table-td',
                        render: function(){
                            return i++;
                        }
                    },
                    {
                        data: 'name',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('permisos_editar')
                                        <button type="button" onclick="editar_permiso('${row.id}')" class="btn btn-icon rounded-pill btn-outline-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('permisos_editar')
                                        <button type="button" onclick="eliminar_permiso( '${row.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-placement="top" title="ELIMINAR">
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
        listar_permiso();

        let form_np = document.getElementById('formulario_nuevo_permiso');
        let btn_gnp = document.getElementById('btn_guardar_nuevo_permiso');
        //para cerrar el modal
        function cerrar_modal_nuevo_permiso(){
            vaciar_formulario(form_np);
            vaciar_errores_permiso();
            $('#modal_permiso_nuevo').modal('hide');
        }
        //function para vaciar los errores
        function vaciar_errores_permiso(){
            let nuevo_array = ['_nombre', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }
        //para guardar el nuevo permiso
        btn_gnp.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_np).entries());
            try {
                let respuesta = await fetch("{{ route('per_guardar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if(dato.tipo==='errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciaremos formulario
                    vaciar_formulario(form_np);
                    //vaciamos los errores
                    vaciar_errores_permiso();
                    actulizar_tabla();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        });

        //para eliminar el permiso
        async function eliminar_permiso(id){
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
                        let respuesta = await fetch("{{ route('per_eliminar') }}",{
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

        //funcion  de acctualizar tabla
        function actulizar_tabla(){
            $('#table_permiso').DataTable().destroy();
            listar_permiso();
            $('#table_permiso').fadeIn(200);
        }

        let form_ep = document.getElementById('formulario_editar_permiso');


        //para editar el permiso
        async function editar_permiso(id){
            try {
                let respuesta = await fetch("{{ route('permis_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    vaciar_formulario(form_ep);
                    $('#modal_permiso_editar').modal('show');
                    document.getElementById('id_permiso').value = dato.mensaje.id;
                    document.getElementById('nombre_').value = dato.mensaje.name;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para guardar lo editado
        let guardar_editado_permiso_btn = document.getElementById('btn_guardar_editado_permiso');
        guardar_editado_permiso_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_ep).entries());
            try {
                let respuesta = await fetch("{{ route('pergu_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if(dato.tipo==='errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                }
                if(dato.tipo === 'success'){
                    //mostrando la alerta
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciaremos formulario
                    vaciar_formulario(form_ep);
                    //vaciamos los errores
                    vaciar_errores_permiso();
                    actulizar_tabla();
                    //cerramos el modal
                    setTimeout(() => {
                        $('#modal_permiso_editar').modal('hide')
                    }, 500);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        });


    </script>
@endsection
