@extends('principal')
@section('titulo', '| TIPO TRAMITE')
@section('contenido')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">:::::::: TIPOS DE TRAMITE :::::::: </h5>
        @can('tipos_tramite_submenu_nuevo')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_tramite_nuevo">
                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
            </button>
        @endcan

    </div>
    <div class="table-responsive text-nowrap p-4">
        <table class="table table-hover" id="tabla_tipo_tramite" style="width: 100%">
            <thead class="table-dark">
                <tr>
                    <th>Nº</th>
                    <th>NOMBRE</th>
                    <th>SIGLA</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<!-- Add tipo de tramite Modal -->
<div class="modal fade" id="modal_tipo_tramite_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                onclick="cerrar_modal_tipo_tramite()"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">Nuevo Tipo de tramite</h3>
                </div>
                <form id="formulario_nuevo_tipotramite" class="row" method="POST" autocomplete="off">
                    @csrf
                    <div class="col-12 mb-3">
                        <label class="form-label" for="sigla">Sigla</label>
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
                    <button id="buton_guardar_tipotramite" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrar_modal_tipo_tramite()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add tipo de tramite Modal -->

<!-- Update tipo de tramite Modal -->
<div class="modal fade" id="modal_tipo_tramite_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                onclick="cerrar_modal_tipo_tramite()"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar Tipo de Contrato</h3>
                </div>
                <form id="formulario_editar_tipotramite" class="row" method="POST" autocomplete="off">
                    <input type="hidden" name="id_tipotramite" id="id_tipotramite">
                    @csrf
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
                    <button id="buton_guardar_tipotramite_editar" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrar_modal_tipo_tramite()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Update tipo de tramite Modal -->

@endsection

@section('scripts')
    <script>
        //para listar los datos
        async function listar_tipo_tramite() {
            let respuesta = await fetch("{{ route('ttram_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_tramite').DataTable({
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
                        data: 'sigla',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                            @can('tipos_tramite_submenu_estado')
                                <label class="switch switch-primary">
                                    <input onclick="estado_tipo_tramite('${row.id}')" type="checkbox" class="switch-input" ${row.estado === true || row.estado === 1 ? 'checked' : ''} />
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
                                    @can('tipos_tramite_submenu_editar')
                                        <button type="button" onclick="editar_tipo_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('tipos_tramite_submenu_eliminar')
                                        <button type="button" onclick="eliminar_tipo_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_tipo_tramite();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tipo_tramite').DataTable().destroy();
            listar_tipo_tramite();
            $('#tabla_tipo_tramite').fadeIn(200);
        }

        //para cerrar el modal
        function cerrar_modal_tipo_tramite(){
            $('#modal_tipo_tramite_nuevo').modal('hide');
            $('#modal_tipo_tramite_editar').modal('hide');
            vaciar_formulario(form_nuevo_tipotramite);
            vaciar_errores_tipotramite();
        }

        //para vaciar errores del tipo de tramite
        function vaciar_errores_tipotramite() {
            let nuevo_array = ['_sigla', '_nombre', '_sigla_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para guardar el formularios
        let form_nuevo_tipotramite = document.getElementById('formulario_nuevo_tipotramite');
        let btn_guardar_tipotramite = document.getElementById('buton_guardar_tipotramite');

        btn_guardar_tipotramite.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_nuevo_tipotramite).entries());
            vaciar_errores_tipotramite();
            try {
                let respuesta = await fetch("{{ route('ttram_nuevo') }}", {
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
                    vaciar_errores_tipotramite();
                    actulizar_tabla();
                    cerrar_modal_tipo_tramite();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });

        //para cambiar el estado del tramite
        function estado_tipo_tramite(id){
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
                        let respuesta = await fetch("{{ route('ttram_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actulizar_tabla();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                        actulizar_tabla();
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla();
                }
            });
        }

        //para eliminar el estado del tramite
        function eliminar_tipo_tramite(id){
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
                        let respuesta = await fetch("{{ route('ttram_eliminar') }}", {
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

        //para editar el registro del tramite
        async function editar_tipo_tramite(id){
            try {
                let respuesta = await fetch("{{ route('ttram_editar') }}", {
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
                    $('#modal_tipo_tramite_editar').modal('show');
                    document.getElementById('id_tipotramite').value = dato.mensaje.id;
                    document.getElementById('sigla_').value = dato.mensaje.sigla;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : ' + error);
            }
        }

        //para guardar el tipo de tramite editado
        let form_update_tipotramite = document.getElementById('formulario_editar_tipotramite');
        let btn_update_tipotramite = document.getElementById('buton_guardar_tipotramite_editar');

        btn_update_tipotramite.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_update_tipotramite).entries());
            try {
                let respuesta = await fetch("{{ route('ttram_update') }}", {
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
                    vaciar_errores_tipotramite();
                    actulizar_tabla();
                    cerrar_modal_tipo_tramite();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });
    </script>
@endsection
