@extends('principal')
@section('titulo', '| TIPO DE ESTADOS')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: TIPOS DE ESTADO :::::::: </h5>
            @can('tipos_esado_submenu_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_estado_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_estado" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NOMBRE</th>
                        <th>COLOR</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de estado Modal -->
    <div class="modal fade" id="modal_tipo_estado_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_estado()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Tipo de estado</h3>
                    </div>
                    <form id="formulario_nuevo_tipoestado" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Ingrese el estado</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Seleccione el color</label>
                            <select name="color" id="color" class="select2">
                                <option value="0" selected disabled>[ SELECCIONE UNA OPCIÓN ]</option>
                                <option value="badge bg-primary bg-glow">Azul</option>
                                <option value="badge bg-secondary bg-glow">Plomo</option>
                                <option value="badge bg-success bg-glow">Verde</option>
                                <option value="badge bg-danger bg-glow">Rojo</option>
                                <option value="badge bg-warning bg-glow">Amarillo</option>
                                <option value="badge bg-info bg-glow">Celeste</option>
                                <option value="badge bg-dark bg-glow">Negro</option>
                            </select>
                            <div id="_color" ></div>
                        </div>

                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="buton_guardar_tipoestado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close" onclick="cerrar_modal_tipo_estado()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de estado Modal -->

    <!-- Modal -->
    <!-- UPDATE tipo de estado Modal -->
    <div class="modal fade" id="modal_tipo_estado_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_estado()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Tipo de estado</h3>
                    </div>
                    <form id="formulario_update_tipoestado" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipoestado" id="id_tipoestado">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Ingrese el estado</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Seleccione el color</label>
                            <select name="color_" id="color_" class="select2">
                                <option value="0" selected disabled>[ SELECCIONE UNA OPCIÓN ]</option>
                                <option value="badge bg-primary bg-glow">Azul</option>
                                <option value="badge bg-secondary bg-glow">Plomo</option>
                                <option value="badge bg-success bg-glow">Verde</option>
                                <option value="badge bg-danger bg-glow">Rojo</option>
                                <option value="badge bg-warning bg-glow">Amarillo</option>
                                <option value="badge bg-info bg-glow">Celeste</option>
                                <option value="badge bg-dark bg-glow">Negro</option>
                            </select>
                            <div id="_color_" ></div>
                        </div>

                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="buton_update_tipoestado" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close" onclick="cerrar_modal_tipo_estado()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ UPDATE tipo de estado Modal -->
@endsection

@section('scripts')
    <script>
        //para listar los datos
        async function listar_tipo_estado() {
            let respuesta = await fetch("{{ route('test_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tipo_estado').DataTable({
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
                                <div class="demo-inline-spacing">
                                    <span class="${row.color}">${row.nombre}</span>
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
                                    @can('tipos_esado_submenu_editar')
                                        <button type="button"  onclick="editar_tipo_estado('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('tipos_esado_submenu_eliminar')
                                        <button type="button"  onclick="eliminar_tipo_estado('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
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
        listar_tipo_estado();

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tipo_estado').DataTable().destroy();
            listar_tipo_estado();
            $('#tabla_tipo_estado').fadeIn(200);
        }

        //para cerrar el modal
        function cerrar_modal_tipo_estado(){
            $('#modal_tipo_estado_nuevo').modal('hide');
            $('#modal_tipo_estado_editar').modal('hide');
            vaciar_formulario(form_nuevo_tipoestado);
            vaciar_errores_tipoestado();
            select2_normal();
        }

        //para vaciar errores del tipo de tramite
        function vaciar_errores_tipoestado() {
            let nuevo_array = ['_color', '_nombre','_color_', '_nombre_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para que el select vuelva al normalidad
        function select2_normal(){
            $('#color').val(0).trigger('change');
        }


        //para guardar los datoss
        let btn_guardar_tipoestado = document.getElementById('buton_guardar_tipoestado');
        let form_nuevo_tipoestado = document.getElementById('formulario_nuevo_tipoestado');

        btn_guardar_tipoestado.addEventListener('click', async () => {
            let datos = Object.fromEntries(new FormData(form_nuevo_tipoestado).entries());
            vaciar_errores_tipoestado();
            try {
                let respuesta = await fetch("{{ route('test_nuevo') }}", {
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
                    vaciar_errores_tipoestado();
                    actulizar_tabla();
                    cerrar_modal_tipo_estado();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error);
            }
        });


        //para eliminar el registro
        function eliminar_tipo_estado(id){
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
                        let respuesta = await fetch("{{ route('test_eliminar') }}", {
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

        //para editar el registro
        async function editar_tipo_estado(id) {
            try {
                let respuesta = await fetch("{{ route('test_editar') }}", {
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
                    $('#modal_tipo_estado_editar').modal('show');
                    document.getElementById('id_tipoestado').value = dato.mensaje.id;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                    document.getElementById('color_').value = dato.mensaje.color;

                    $('#color_').val(dato.mensaje.color).trigger('change');
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : ' + error);
            }
        }


        //para guardar lo editado
        let form_update_tipoestado = document.getElementById('formulario_update_tipoestado');
        let btn_update_tipoestado = document.getElementById('buton_update_tipoestado');

        btn_update_tipoestado.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_update_tipoestado).entries());
            vaciar_errores_tipoestado();
            try {
                let respuesta = await fetch("{{ route('test_update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                console.log(dato);
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[
                            key] + `</p>`;
                    }
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    vaciar_errores_tipoestado();
                    actulizar_tabla();
                    cerrar_modal_tipo_estado();
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
