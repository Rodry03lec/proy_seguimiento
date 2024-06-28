@extends('principal')
@section('titulo', '| USUARIOS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: USUARIOS :::::::: </h5>
            @can('usuario_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_usuario">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_listar_usuarios" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>CI</th>
                        <th>NOMBRES</th>
                        <th>ESTADO</th>
                        <th>ROL</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <!-- Add usuario Modal -->
    <div class="modal fade" id="modal_nuevo_usuario" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_usuario()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo usuario</h3>
                    </div>
                    <form id="formulario_nuevo_usuario" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_persona" name="id_persona">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="persona">Persona</label>
                            <select name="persona" id="persona" class="select2" onchange="validar_persona(this.value)">
                                <option disabled selected value="0"> [ SELECCIONE UNA PERSONA ]</option>
                                @foreach ($listar_persona as $lis)
                                    @if (!$lis->contrato->isEmpty())
                                        @foreach ($lis->contrato as $contrato)
                                            <option value="{{ $lis->id }}">{{ $lis->ci.'  '.$lis->nombres.' '.$lis->ap_paterno.' '.$lis->ap_materno }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <div id="_persona"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Rol</label>
                            <select name="rol" id="rol" class="select2">
                                <option disabled selected value="0">[ SELECCIONE UN ROL ]</option>
                                @foreach ($listar_roles as $lis)
                                    <option value="{{ $lis->id }}">{{ $lis->name }}</option>
                                @endforeach
                            </select>
                            <div id="_rol"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="usuario">Usuario</label>
                            <input type="text" id="usuario" name="usuario" class="form-control uppercase-input"
                                placeholder="Ingrese el usuario" autofocus />
                            <div id="_usuario"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="text" id="password" name="password" class="form-control uppercase-input"
                                placeholder="Ingrese la contraseña" autofocus />
                            <div id="_password"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_new_usuario" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_usuario()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add usuario Modal -->


    <!-- Modal -->
    <!-- Update usuario Modal -->
    <div class="modal fade" id="modal_editar_usuario" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Usuario</h3>
                    </div>
                    <form id="formulario_edit_usuario" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id_usuario_" name="id_usuario_">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="rol_">Rol</label>
                            <select name="rol_" id="rol_" class="select2">
                                <option disabled selected value="0">[ SELECCIONE UN ROL ]</option>
                                @foreach ($listar_roles as $lis)
                                    <option value="{{ $lis->id }}">{{ $lis->name }}</option>
                                @endforeach
                            </select>
                            <div id="_rol_"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="usuario">Usuario</label>
                            <input type="text" id="usuario_" name="usuario_" class="form-control"
                                placeholder="Ingrese el usuario" autofocus readonly />
                            <div id="_usuario_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="password_">Contraseña</label>
                            <input type="text" id="password_" name="password_" class="form-control"
                                placeholder="Ingrese la contraseña"  autofocus />
                            <div id="_password_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_edit_usuario" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_editar()" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update usuario Modal -->

@endsection
@section('scripts')
    <script>
        //para listar los datos de los usuarios
        async function listar_tiposcategoria() {
            let respuesta = await fetch("{{ route('user_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_listar_usuarios').DataTable({
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
                        data:'ci',
                        className: 'table-td',
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta){
                            return data.nombres+' '+data.apellidos;
                        }
                    },


                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('usuario_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_usuario('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                        data: 'roles', // Asumiendo que 'roles' es el nombre de la columna en tu conjunto de datos
                        className: 'table-td',
                        render: function(data, type, row, meta){
                            // Verifica si data es un array y tiene elementos
                            if (Array.isArray(data) && data.length > 0) {
                                // Utiliza map para obtener una cadena con los nombres de los roles
                                let rolesString = data.map(function(element){
                                    return element.name; // Asumiendo que 'name' es el atributo que contiene el nombre del rol
                                }).join(', '); // Unirá los nombres de los roles con una coma y un espacio
                                return rolesString;
                            } else {
                                return 'Sin roles'; // O algún otro mensaje predeterminado si el usuario no tiene roles
                            }
                        }
                    },



                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    @can('usuario_editar')
                                        <button type="button" onclick="editar_usuario('${row.id}')" class="btn btn-icon rounded-pill btn-outline-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('usuario_eliminar')
                                        <button type="button" onclick="eliminar_usuario( '${row.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-placement="top" title="ELIMINAR">
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

        //para actuzalizar la tabla
        function actulizar_tabla_usuario() {
            $('#tabla_listar_usuarios').DataTable().destroy();
            listar_tiposcategoria();
            $('#tabla_listar_usuarios').fadeIn(200);
        }


        //para validar la persona
        async function validar_persona(id){
            if(id.length > 0){
                let id_persona = document.getElementById('id_persona');
                let usuario_adm = document.getElementById('usuario');
                let password_adm = document.getElementById('password');
                vaciar_errores_usuario();
                try {
                    let respuesta = await fetch("{{ route('user_validar') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    if(dato.tipo == 'success'){
                        id_persona.value = dato.mensaje.id;
                        usuario_adm.value = dato.mensaje.ci+'_'+dato.nombre_us;
                        password_adm.value = dato.mensaje.ci;
                    }
                    if(dato.tipo == 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                } catch (error) {
                    console.log(error+ '=> Ocurrio un error');
                }
            }
        }

        //para cerrar el modal del usuario
        function cerrar_modal_usuario(){
            $('#modal_nuevo_usuario').modal('hide');
            vaciar_errores_usuario();
            vaciar_formulario(form_nuevo_usuario);
            select2_usuario_rest();
        }

        //para vaciar los errores cuando se cierre el modal
        function vaciar_errores_usuario(){
            let datos = ['_persona', '_rol', '_usuario', '_password', '_rol_', '_usuario_', '_password_'];
            datos.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //para la parte de los select
        function select2_usuario_rest(){
            $('#persona').val('0').trigger('change');
            $('#rol').val('0').trigger('change');
        }



        //variables para guardar el formularios
        let form_nuevo_usuario = document.getElementById('formulario_nuevo_usuario');
        let btn_nuevo_usuario = document.getElementById('btn_guardar_new_usuario');

        btn_nuevo_usuario.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_nuevo_usuario).entries());
            vaciar_errores_usuario();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_new_usuario');
            if(datos.rol && datos.persona){
                try {
                    let respuesta = await fetch("{{ route('user_crear') }}",{
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
                        validar_boton(false, 'Guardar', 'btn_guardar_new_usuario');
                    }
                    if(dato.tipo === 'success'){
                        alerta_top(dato.tipo, dato.mensaje);
                        validar_boton(false, 'Guardar', 'btn_guardar_new_usuario');
                        cerrar_modal_usuario();
                        actulizar_tabla_usuario();
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                        validar_boton(false, 'Guardar', 'btn_guardar_new_usuario');
                    }
                } catch (error) {
                    console.log(error);
                }
            }else{
                alerta_center('error', 'NOTA!', 'Falta seleccionar el Usuario o Rol');
                validar_boton(false, 'Guardar', 'btn_guardar_new_usuario');
            }
        });

        //para eliminar el registro de usuarios
        function eliminar_usuario(id){
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
                        let respuesta = await fetch("{{ route('user_eliminar') }}",{
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
                            actulizar_tabla_usuario();
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

        //PARA CAMBIAR EL ESTADO DEL USUARIO
        function estado_usuario(id){
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
                        let respuesta = await fetch("{{ route('user_estado') }}",{
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
                            actulizar_tabla_usuario();
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actulizar_tabla_usuario();
                }
            });
        }

        //PARA REALIZAR LA EDICION DEL REGISTRO
        async function editar_usuario(id){
            try {
                let respuesta = await fetch("{{ route('user_edit') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_usuario').modal('show');
                    document.getElementById('id_usuario_').value = dato.mensaje.id;
                    let rol_id = dato.mensaje.roles[0].id;
                    document.getElementById('usuario_').value = dato.mensaje.usuario;
                    $('#rol_').val(rol_id).trigger('change');
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('error : '+ error);
            }
        }

        //PARA GUARDAR EL USUARIO EDITADO
        let btn_update_usuario = document.getElementById('btn_guardar_edit_usuario');
        let form_update_usuario = document.getElementById('formulario_edit_usuario');
        btn_update_usuario.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_update_usuario).entries());
            vaciar_errores_usuario();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_edit_usuario');
            if(datos.rol_){
                try {
                    let respuesta = await fetch("{{ route('user_update') }}",{
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
                        validar_boton(false, 'Guardar', 'btn_guardar_edit_usuario');
                    }
                    if(dato.tipo === 'success'){
                        alerta_top(dato.tipo, dato.mensaje);
                        validar_boton(false, 'Guardar', 'btn_guardar_edit_usuario');
                        actulizar_tabla_usuario();
                        cerrar_modal_editar();
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                        validar_boton(false, 'Guardar', 'btn_guardar_edit_usuario');
                    }
                } catch (error) {
                    console.log(error);
                }
            }else{
                alerta_center('error', 'NOTA!', 'Falta seleccionar el Rol');
                validar_boton(false, 'Guardar', 'btn_guardar_edit_usuario');
            }
        });

        //para cerrar el modal
        function cerrar_modal_editar(){
            $('#modal_editar_usuario').modal('hide');
            vaciar_errores_usuario();
            vaciar_form_editar();
        }

        function vaciar_form_editar(){
            let datos = ['usuario_', 'password_'];
            datos.forEach(elem => {
                document.getElementById(elem).value = '';
            });
        }

    </script>
@endsection
