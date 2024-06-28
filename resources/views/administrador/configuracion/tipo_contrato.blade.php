@extends('principal')
@section('titulo', '| TIPO DE CONTRATO')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> :::::::: TIPOS DE CONTRATO :::::::: </h5>
            @can('tipo_contrato_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_contrato_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan



        </div>
        <div class="table-responsive text-nowrap p-4" >
            <table class="table" id="tabla_tipo_contrato" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>SIGLA</th>
                        <th>NOMBRE</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de contrato Modal -->
    <div class="modal fade" id="modal_tipo_contrato_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_tipo_contrato()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Tipo de Contrato</h3>
                    </div>
                    <form id="formulario_nuevo_tipocontrato" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Sigla</label>
                            <input type="text" id="sigla" name="sigla" class="form-control uppercase-input" placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla" ></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input" placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipocontrato" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_tipo_contrato()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de contrato Modal -->

    <!-- Update tipo de contrato Modal -->
    <div class="modal fade" id="modal_tipo_contrato_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_tipo_contrato()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Tipo de Contrato</h3>
                    </div>
                    <form id="formulario_editar_tipocontrato" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipocontrato" id="id_tipocontrato">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="sigla_">Sigla</label>
                            <input type="text" id="sigla_" name="sigla_" class="form-control uppercase-input" placeholder="Ingrese la sigla" autofocus />
                            <div id="_sigla_" ></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input" placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_" ></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipocontrato_editado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_nuevo_tipo_contrato()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update tipo de contrato Modal -->
@endsection
@section('scripts')
    <script>
        let form_tipocontrato = document.getElementById('formulario_nuevo_tipocontrato');
        let guardar_tipocontrato_btn = document.getElementById('btn_guardar_tipocontrato');
        //para cerrar el modal para el tipo de contrato
        function cerrar_modal_nuevo_tipo_contrato(){
            vaciar_formulario(form_tipocontrato);
            vaciar_errores_tipocontrato();
            $('#modal_tipo_contrato_nuevo').modal('hide');
        }
        //function para vaciar los errores
        function vaciar_errores_tipocontrato(){
            let nuevo_array = ['_sigla', '_nombre', '_sigla_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }
        //PARA GUARDAR EL TIPO DE CONTRATO
        guardar_tipocontrato_btn.addEventListener('click', async()=>{
            let datos = Object.fromEntries(new FormData(form_tipocontrato).entries());
            try {
                let respuesta = await fetch("{{ route('tcg_guardar') }}",{
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
                    //vaciaremos formulario
                    vaciar_formulario(form_tipocontrato);
                    //vaciamos los errores
                    vaciar_errores_tipocontrato();
                    actulizar_tabla();
                    cerrar_modal_nuevo_tipo_contrato();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });

        //funcion  de acctualizar tabla
        function actulizar_tabla(){
            $('#tabla_tipo_contrato').DataTable().destroy();
            listar_tiposcontrato();
            $('#tabla_tipo_contrato').fadeIn(200);
        }

        //para listar los datos
        async function listar_tiposcontrato() {
            let respuesta = await fetch("{{ route('tcg_listar') }}",{
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_contrato').DataTable({
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
                                <div class="d-inline-block tex-nowrap">
                                    @can('tipo_contrato_editar')
                                        <button type="button" onclick="editar_tipocontrato('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('tipo_contrato_eliminar')
                                        <button type="button" onclick="eliminar_tipocontrato('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_tiposcontrato();


        //para eliminar el registro
        function eliminar_tipocontrato(id){
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
                        let respuesta = await fetch("{{ route('tcg_eliminar') }}",{
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
                }else{
                    alerta_top('error', 'Se cancelo');
                }
            });
        }
        //para eliminar el registro

        let form_tipocontrato_editar = document.getElementById('formulario_editar_tipocontrato');
        let btn_gua_tipocontrato_edit = document.getElementById('btn_guardar_tipocontrato_editado');

        //para cerrar el modal para el tipo de contrato para editar
        function cerrar_modal_tipocontrato_editar(){
            $('#modal_tipo_contrato_editar').modal('hide');
            vaciar_formulario(form_tipocontrato_editar);
            vaciar_errores_tipocontrato();
        }

        async function editar_tipocontrato(id){
            try {
                let respuesta = await fetch("{{ route('tcg_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_tipo_contrato_editar').modal('show');
                    document.getElementById('id_tipocontrato').value = dato.mensaje.id;
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
        btn_gua_tipocontrato_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_tipocontrato_editar).entries());
            try {
                let respuesta = await fetch("{{ route('tcg_edit_guardar') }}",{
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
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    //vaciaremos formulario
                    vaciar_formulario(form_tipocontrato_editar);
                    //vaciamos los errores
                    vaciar_errores_tipocontrato();
                    actulizar_tabla();
                    cerrar_modal_tipocontrato_editar();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        });

    </script>
@endsection
