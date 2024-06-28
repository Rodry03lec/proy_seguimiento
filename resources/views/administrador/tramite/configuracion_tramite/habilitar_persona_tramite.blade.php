@extends('principal')
@section('titulo', '| HABILITAR A TRAMITE')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: HABILITAR PARA TRAMITES :::::::: </h5>
        </div>

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_usuarios" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>CI</th>
                        <th>NOMBRES Y APELLIDOS</th>
                        <th>CARGOS</th>
                        <th></th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Extra Large Modal -->
    <div class="modal fade" id="modal_listar_habilitar_tramite" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Listado de cargos de usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_habilitar_tramite()"></button>
                </div>
                <div class="modal-body">
                    <form id="formulario_nuevo_cargo_tramite" method="post" autocomplete="off">
                        <input type="hidden" name="id_cargo_sm" id="id_cargo_sm">
                        <input type="hidden" name="id_cargo_mae" id="id_cargo_mae">
                        <input type="hidden" name="id_contrato" id="id_contrato">
                        <input type="hidden" name="id_persona" id="id_persona">
                        <input type="hidden" name="id_usuario" id="id_usuario">

                        <input type="hidden" name="id_usuario_cargo" id="id_usuario_cargo">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <label for="nombre" class="form-label">Descripción</label>
                                <input type="text" id="nombre" name="nombre" class="form-control uppercase-input" placeholder="Ingrese el nombre del cargo" >
                                <div id="_nombre" ></div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-3">
                        @can('habilitar_tramite_submenu_vizualizar_nuevo')
                            <div class="d-grid gap-2 col-lg-6 mx-auto">
                                <button class="btn btn-primary btn-md" id="btn_guardar_nuevo_cargo_tramite" type="button">Guardar</button>
                            </div>
                        @endcan

                    </div>
                </div>

                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="tabla_listar_cargos_usuario" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-th">Nº</th>
                                <th scope="col" class="table-th">CARGO</th>
                                <th scope="col" class="table-th">ESTADO</th>
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
        //para listar los datos
        async function listar_habilitar_tramite() {
            let respuesta = await fetch("{{ route('htram_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_usuarios').DataTable({
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
                        data: 'ci',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="demo-inline-spacing">
                                    <span class="">${row.nombres+' '+row.apellidos}</span>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            // Verifica si hay elementos en 'user_cargo_tramite'
                            if (data.user_cargo_tramite.length > 0) {
                                // Crea una variable para almacenar el HTML
                                let badges = '';
                                // Itera sobre cada elemento en 'user_cargo_tramite' y añade el HTML a 'badges'
                                data.user_cargo_tramite.forEach(elem => {
                                    if(elem.cargo_sm != null){
                                        badges += `<span class="badge bg-success">${elem.cargo_sm.nombre}</span> `;
                                    }else{

                                    }
                                    if(elem.cargo_mae != null){
                                        badges += `<span class="badge bg-success">${elem.cargo_mae.nombre}</span> `;
                                    }
                                });
                                // Devuelve el HTML generado
                                return badges;
                            }else {
                                // Devuelve el botón si no hay elementos en 'user_cargo_tramite'
                                return `
                                    <button type="button" class="btn btn-sm rounded-pill btn-danger">NO TIENE CARGOS PARA TRAMITES</button>
                                `;
                            }
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.user_cargo_tramite.length > 0){
                                return `
                                    <span class="badge bg-success">Habilitado</span>
                                `;
                            }else{
                                return `
                                    @can('habilitar_tramite_submenu_habilitar')
                                        <button onclick="habilitar_para_tramite('${row.id}')" type="button" class="btn btn-sm rounded-pill btn-danger">Habilitar</button>
                                    @endcan
                                `;
                            }
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.user_cargo_tramite.length > 0){
                                return `
                                    @can('habilitar_tramite_submenu_vizualizar')
                                        <div class="d-inline-block tex-nowrap">
                                            <button type="button"  onclick="vizualizar_para_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR">
                                                <i class="ti ti-eye" ></i>
                                            </button>
                                        </div>
                                    @endcan
                                `;
                            }else{
                                return `
                                    <span class="btn btn-sm rounded-pill btn-label-danger">No disponible</span>
                                `;
                            }

                        }
                    }
                ]
            });
        }
        listar_habilitar_tramite();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tipo_usuarios').DataTable().destroy();
            listar_habilitar_tramite();
            $('#tabla_tipo_usuarios').fadeIn(200);
        }



        //para habilitar la parte de habilitar los tramites
        async function habilitar_para_tramite(id) {
            try {
                let respuesta = await fetch("{{ route('htram_validar') }}", {
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
                if(dato.tipo==='success'){
                    Swal.fire({
                        title: "¿Estás seguro de habilitar a tramite?",
                        text: "¡ NOTA !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sí, seguro",
                        cancelButtonText: "No, Cancelar",
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-label-secondary waves-effect waves-light"
                        },
                        buttonsStyling: false
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            habilitar_tramite_usuario(dato.contrato.id_cargo_sm, dato.contrato.id_cargo_mae, dato.contrato.id, dato.contrato.id_persona, dato.usuario.id);
                        }else{
                            alerta_top('error', 'Se cancelo');
                        }
                    });

                }
                if(dato.tipo==='error'){
                    alerta_top_end(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('error : '+error);
            }
        }


        //para validar los datos e ingresar un cargo o el cargo que tiene
        async function habilitar_tramite_usuario(id_cargo_sm, id_cargo_mae, id_contrato, id_persona, id_usuario){
            try {
                let respuesta = await fetch("{{ route('htram_habilita') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id_cargo_sm : id_cargo_sm,
                        id_cargo_mae: id_cargo_mae,
                        id_contrato : id_contrato,
                        id_persona  : id_persona,
                        id_usuario  : id_usuario
                    })
                });
                let dato = await respuesta.json();

                if(dato.tipo === 'success'){
                    actulizar_tabla();
                    alerta_top(dato.tipo, dato.mensaje);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }


        //para vizualziar el traite
        async function vizualizar_para_tramite(id) {
            $('#modal_listar_habilitar_tramite').modal('show');
            document.getElementById('_nombre').innerHTML = '';
            try {
                let respuesta = await fetch("{{ route('htram_vizualizar') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                console.log(dato);
                document.getElementById('nombre').value = '';
                document.getElementById('id_usuario_cargo').value = '';
                if(dato.tipo==='success'){
                    document.getElementById('id_cargo_sm').value    = dato.usuario_tramite.id_cargo_sm;
                    document.getElementById('id_cargo_mae').value   = dato.usuario_tramite.id_cargo_mae;
                    document.getElementById('id_contrato').value    = dato.usuario_tramite.id_contrato;
                    document.getElementById('id_persona').value     = dato.usuario_tramite.id_persona;
                    document.getElementById('id_usuario').value     = dato.usuario_tramite.id_usuario;
                    actulizar_tabla_cargos();
                    listar_cargos_contrato(dato.usuario_tramite.id_contrato, dato.usuario_tramite.id_usuario);
                }
                if(dato.tipo==='error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('error : '+ error);
            }
        }

        function actulizar_tabla_cargos() {
            $('#tabla_listar_cargos_usuario').DataTable().destroy();
            $('#tabla_listar_cargos_usuario').fadeIn(200);
        }


        //para listar los cargos segun el contrato que tuvo se definira los contratos segun hay a trabajado
        async function listar_cargos_contrato (id_contrato, id_usuario) {
            //se realizar atodos los pasos

            let respuesta = await fetch("{{ route('htram_vizualizar_lis') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    id_contrato: id_contrato,
                    id_usuario: id_usuario,
                })
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_listar_cargos_usuario').DataTable({
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
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.cargo_mae != null){
                                return `
                                    <div class="demo-inline-spacing">
                                        <span class="">${row.cargo_mae.nombre}</span>
                                    </div>
                                `;
                            }

                            if(data.cargo_sm != null){
                                return `
                                    <div class="demo-inline-spacing">
                                        <span class="">${row.cargo_sm.nombre}</span>
                                    </div>
                                `;
                            }

                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('habilitar_tramite_submenu_vizualizar_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_user_tipo_tramite('${row.id}','${row.id_contrato}', '${row.id_usuario}')" type="checkbox" class="switch-input" ${row.estado === true ? 'checked' : ''} />
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
                                @can('habilitar_tramite_submenu_vizualizar_eliminar')
                                    <div class="d-inline-block tex-nowrap">
                                        <button type="button"  onclick="eliminar_user_cargo('${row.id}','${row.id_contrato}', '${row.id_usuario}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                            <i class="ti ti-trash" ></i>
                                        </button>
                                    </div>
                                @endcan
                            `;
                        }
                    }
                ]
            });
        }

        //PARA GUARDAR EL REGISTRO
        let btn_guardar_nuevo_cargo_tramite = document.getElementById('btn_guardar_nuevo_cargo_tramite');
        let formulario_nuevo_cargo_tramite = document.getElementById('formulario_nuevo_cargo_tramite');

        btn_guardar_nuevo_cargo_tramite.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(formulario_nuevo_cargo_tramite).entries());
            try {
                let respuesta = await fetch("{{ route('htram_vizualizar_nuevo') }}", {
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
                    actulizar_tabla_cargos();
                    listar_cargos_contrato(dato.id_contrato_lis, dato.id_usuario_lis);
                    document.getElementById('nombre').value = '';
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });


        //para cambiar el estado de
        function estado_user_tipo_tramite(id, id_contrato, id_usuario){
            console.log(id+' => '+id_contrato+' => '+id_usuario);
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
                        let respuesta = await fetch("{{ route('htram_vizualizar_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                id:id,
                                id_contrato:id_contrato,
                                id_usuario:id_usuario
                            })
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla_cargos();
                            listar_cargos_contrato(dato.id_contra, dato.id_usu);
                            actulizar_tabla();
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla_cargos();
                            listar_cargos_contrato(id_contrato, id_usuario);
                            actulizar_tabla();
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                        actulizar_tabla_cargos();
                        listar_cargos_contrato(id_contrato, id_usuario);
                        actulizar_tabla();
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla_cargos();
                    listar_cargos_contrato(id_contrato, id_usuario);
                    actulizar_tabla();
                }
            });
        }

        //PARA LA EDICION DEL CARGO
        async function eliminar_user_cargo(id, id_contrato, id_usuario) {
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
                        let respuesta = await fetch("{{ route('htram_vizualizar_eliminar') }}",{
                            method: "DELETE",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                id:id,
                            })
                        });
                        let dato = await respuesta.json();
                        if (dato.tipo === 'success') {
                            alerta_top(dato.tipo, dato.mensaje);
                            actulizar_tabla_cargos();
                            listar_cargos_contrato(id_contrato, id_usuario);
                            actulizar_tabla();
                        }
                        if (dato.tipo === 'error') {
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('error de : '+ error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                }
            });
        }

        //para cerrar el modal
        async function  cerrar_modal_habilitar_tramite() {
            $('#modal_listar_habilitar_tramite').modal('hide');
            document.getElementById('nombre').value         = '';
            document.getElementById('_nombre').innerHTML    = '';
        }
    </script>
@endsection
