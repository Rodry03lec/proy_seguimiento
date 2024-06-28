@extends('principal')
@section('titulo', '| ROLES')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ROLES</h5>
            @can('roles_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevo_rol">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo Rol</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- Role cards -->
    <div class="row g-4 py-4">
        @foreach ($listar_roles as $lis)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ $lis->name }}</h4>
                                <div class="d-inline-block tex-nowrap">
                                    @can('roles_editar')
                                        <button class="btn btn-sm btn-icon" type="button" onclick="editar_rol('{{ $lis->id }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    @endcan

                                    @can('roles_eliminar')
                                        <button class="btn btn-sm btn-icon" onclick="eliminar_rol('{{ $lis->id }}')" type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </div>
                            @can('roles_vizualizar')
                                <button class="btn btn-sm btn-icon" type="button" onclick="vizualizar_rol('{{ $lis->id }}')">
                                    <i class="ti ti-eye ti-md"></i>
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!--/ Role cards -->


    <!-- PARA CREAR UN NUEVO ROL-->
    <div class="modal fade" id="nuevo_rol" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Rol</h5>
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add role form -->
                    <form id="formulario_nuevo_rol" class="row g-3">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="nombre_rol">Rol</label>
                            <input type="text" id="nombre_rol" name="nombre_rol" class="form-control"
                                placeholder="Ingrese el nombre del rol" tabindex="-1" />
                            <div id="_nombre_rol" ></div>
                        </div>
                        <div class="col-12">
                            <h5>Permisos</h5>
                            <!-- Permission table -->
                            <div class="table-responsive">
                                <table class="table table-flush-spacing">
                                    <tbody>

                                        @if ($permisos->isEmpty())
                                            <hr>
                                            No hay ningun permiso registrado
                                        @else
                                            <tr>
                                                <td class="text-nowrap fw-medium">Seleccionar todos<i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Seleccionar todos los permisos disponibles solo para superadministrador"></i></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="marcar_des"  onchange="marcar_desmarcar(this);" />
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach ($permisos as $key => $value)
                                                <tr>
                                                    <td class="text-nowrap fw-medium">{{ $value->name }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input" type="checkbox" name="permisos[]" id="{{ $value->id }}" value="{{ $value->name }}"/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- Permission table -->
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_guardar_nuevo_rol">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PARA EDITAR UN NUEVO ROL-->
    <div class="modal fade" id="modal_editar_rol" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Rol</h5>
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="html_editar_rol">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_guardar_editado_rol">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PARA VIZUALIZAR LOS PERMISOS DEL ROL-->
    <div class="modal fade" id="modal_vizualizar_rol" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vizualizar los permisos del Rol</h5>
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div id="html_vizualizar_permisos_del_rol" ></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        let form_rol_nuevo = document.getElementById('formulario_nuevo_rol');
        let boton_rol_guardar = document.getElementById('btn_guardar_nuevo_rol');

        //para marcar o desmarcar nuevos permisos
        function marcar_desmarcar(source){
            let checkboxes = form_rol_nuevo.getElementsByTagName('input');
            for(i=0;i<checkboxes.length;i++){
                if(checkboxes[i].type == "checkbox"){
                    checkboxes[i].checked=source.checked;
                }
            }
        }


        //para el vaciado de los roles
        function vaciar_errores_rol_nuevo(){
            let datos = ['_nombre_rol'];
            datos.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }


        //para guardar el rol con los permisos
        boton_rol_guardar.addEventListener('click', async ()=>{
            let nombre_rol = document.getElementById('nombre_rol').value;
            let permisos = [];
            let chexbox = document.querySelectorAll('input[name="permisos[]"]:checked');
            chexbox.forEach(function (checkbox) {
                permisos.push(checkbox.value);
            });
            validar_boton(true, 'Guardando', 'btn_guardar_nuevo_rol');
            vaciar_errores_rol_nuevo();
            try {
                let respuesta = await fetch("{{ route('rol_guardar') }}",{
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        nombre_rol : nombre_rol,
                        permisos : permisos
                    })
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_nuevo_rol');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    setTimeout(() => {
                        location.reload();
                    }, 1600);
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_nuevo_rol');
                }
            } catch (error) {
                console.log('Ocurrio un error :'+ error);
            }
        });


        //para eliminar el rol
        function eliminar_rol(id){

            Swal.fire({
                title: "¿Estás seguro?",
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
                        let respuesta = await fetch("{{ route('rol_eliminar') }}",{
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
                            setTimeout(() => {
                                location.reload();
                            }, 1600);
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


        //para editar el rol
        async function editar_rol(id){
            try {
                let formData = new FormData();
                formData.append('id', id);
                formData.append('_token', token);
                let respuesta = await fetch("{{ route('rol_editar') }}", {
                    method: 'POST',
                    body: formData
                });
                if (respuesta.ok) {
                    $('#modal_editar_rol').modal('show');
                    let data = await respuesta.text();
                    document.getElementById('html_editar_rol').innerHTML = data;
                } else {
                    console.log('Error en la solicitud', respuesta.status);
                    document.getElementById('html_editar_rol').innerHTML = '';
                }
            } catch (error) {
                console.log('Ocurrio un error : ' + error);
                listado_html.innerHTML = '';
            }
        }

        //para marcar y desmarcar lo que es editado
        function marcar_desmarcar_edi(checkBox) {
            let checkboxes = document.querySelectorAll('input[name="permisos_edi[]"]');
            checkboxes.forEach(function(cb) {
                cb.checked = checkBox.checked;
            });
        }

        //para guardar lo editado de la parte de los roles
        let form_rol_editar = document.getElementById('formulario_editar_rol');
        let btn_rol_editar  = document.getElementById('btn_guardar_editado_rol');

        btn_rol_editar.addEventListener('click', async ()=>{
            let id_rol          = document.getElementById('id_rol_editar').value;
            let nombre_rol_     = document.getElementById('nombre_rol_').value;
            let permisos        = [];
            let chexbox         = document.querySelectorAll('input[name="permisos_edi[]"]:checked');
            chexbox.forEach(function (checkbox) {
                permisos.push(checkbox.value);
            });
            validar_boton(true, 'Guardando', 'btn_guardar_editado_rol');
            try {
                let respuesta = await fetch("{{ route('rol_editar_guardar') }}",{
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id_rol      : id_rol,
                        nombre_rol_  : nombre_rol_,
                        permisos    : permisos
                    })
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_guardar_editado_rol');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    setTimeout(() => {
                        location.reload();
                    }, 1600);

                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_editado_rol');
                }
            } catch (error) {
                console.log('Ocurrio un error :'+ error);
            }
        });


        //para vizualizar el listado de permisos que tiene un rol
        async function vizualizar_rol(id) {
            try {
                let respuesta = await fetch("{{ route('rol_vizualizar') }}",{
                    method: "DELETE",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                let html = '';
                if(dato.tipo === 'success'){
                    $('#modal_vizualizar_rol').modal('show');
                    let listar_datos = dato.mensaje;
                        if(listar_datos.length > 0){
                            listar_datos.forEach((elem, index) => {
                            // Agregar el elemento al HTML acumulado
                            html += ` <span class="badge rounded-pill bg-success m-1">${elem.name}</span>`;

                            // Si no es el último elemento, agregar un espacio
                            if (index !== listar_datos.length - 1) {
                                html += ' ';
                            }
                        });
                        document.getElementById('html_vizualizar_permisos_del_rol').innerHTML = html;
                    }else{
                        document.getElementById('html_vizualizar_permisos_del_rol').innerHTML = `<span class="badge rounded-pill bg-danger m-1">El Rol no tiene permisos</span>`;
                    }

                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }
    </script>
@endsection
