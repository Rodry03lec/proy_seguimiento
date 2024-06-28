@extends('principal')
@section('titulo', ' | LICENCIA CONFIGURACIÓN')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: TIPOS DE LICENCIAS :::::::: </h5>
            @can('especial_licencias_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_licencia">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tipo_licencia" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>NORMATIVA</th>
                        <th>MOTIVO</th>
                        <th>JORNADA LABORAL</th>
                        <th>REQUISITOS</th>
                        <th>PLAZOS</th>
                        <th>OBSERVACIONES</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <!-- Add tipo de licencia -->
    <div class="modal fade" id="modal_tipo_licencia" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_licencia()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo tipo de Licencia</h3>
                    </div>
                    <form id="formulario_nuevo_tipo_licencia" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3">
                            <label class="form-label" for="numero">Numero</label>
                            <input type="text" id="numero" name="numero" class="form-control uppercase-input"
                                placeholder="Ingrese el numero" autofocus />
                            <div id="_numero"></div>
                        </div>
                        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10 mb-3">
                            <label class="form-label" for="normativa">Normativa</label>
                            <input type="text" id="normativa" name="normativa" class="form-control uppercase-input"
                                placeholder="Ingrese la normativa" autofocus />
                            <div id="_normativa"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="motivo">Motivo</label>
                            <textarea name="motivo" id="motivo" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese el motivo"></textarea>
                            <div id="_motivo"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="jornada_laboral">Jornada laboral</label>
                            <textarea name="jornada_laboral" id="jornada_laboral" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese la jornada laboral"></textarea>
                            <div id="_jornada_laboral"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="requisitos">Requsitos</label>
                            <textarea name="requisitos" id="requisitos" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese los requisitos" autofocus ></textarea>
                            <div id="_requisitos"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="plazos">Pazos</label>
                            <textarea id="plazos" name="plazos" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese los plazos" autofocus></textarea>
                            <div id="_plazos"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea id="observaciones" name="observaciones" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese las observaciones" autofocus></textarea>
                            <div id="_observaciones"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipo_licencia" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_tipo_licencia()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de licencia -->


    <!-- Update tipo de licencia -->
    <div class="modal fade" id="modal_tipo_licencia_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_tipo_licencia_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Tipo de Licencia</h3>
                    </div>
                    <form id="formulario_editar_tipo_licencia" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_tipo_licencia" id="id_tipo_licencia">
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3">
                            <label class="form-label" for="numero_">Numero</label>
                            <input type="text" id="numero_" name="numero_" class="form-control uppercase-input"
                                placeholder="Ingrese el numero" autofocus />
                            <div id="_numero_"></div>
                        </div>
                        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10 mb-3">
                            <label class="form-label" for="normativa_">Normativa</label>
                            <input type="text" id="normativa_" name="normativa_" class="form-control uppercase-input"
                                placeholder="Ingrese la normativa" autofocus />
                            <div id="_normativa_"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="motivo_">Motivo</label>
                            <textarea name="motivo_" id="motivo_" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese el motivo"></textarea>
                            <div id="_motivo_"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="jornada_laboral_">Jornada laboral</label>
                            <textarea name="jornada_laboral_" id="jornada_laboral_" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese la jornada laboral"></textarea>
                            <div id="_jornada_laboral_"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="requisitos_">Requsitos</label>
                            <textarea name="requisitos_" id="requisitos_" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese los requisitos" autofocus ></textarea>
                            <div id="_requisitos_"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="plazos_">Pazos</label>
                            <textarea id="plazos_" name="plazos_" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese los plazos" autofocus></textarea>
                            <div id="_plazos_"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="form-label" for="observaciones_">Observaciones</label>
                            <textarea id="observaciones_" name="observaciones_" cols="30" rows="2" class="form-control uppercase-input" placeholder="Ingrese las observaciones" autofocus></textarea>
                            <div id="_observaciones_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tipo_licencia_editar" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_tipo_licencia_editar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update tipo de licencia -->


@endsection
@section('scripts')
    <script>
        //para listar los tipos de licencia
        async function listar_tipos_licencia() {
            let respuesta = await fetch("{{ route('clic_listar_tiplicencia') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                }
            });
            let dato = await respuesta.json();
            $('#tabla_tipo_licencia').DataTable({
                responsive: true,
                data: dato,
                columns: [
                    {
                        data: 'numero',
                        className: 'table-td'
                    },
                    {
                        data: 'normativa',
                        className: 'table-td'
                    },
                    {
                        data: 'motivo',
                        className: 'table-td'
                    },
                    {
                        data: 'jornada_laboral',
                        className: 'table-td'
                    },
                    {
                        data: 'requisitos',
                        className: 'table-td'
                    },
                    {
                        data: 'plazos',
                        className: 'table-td'
                    },
                    {
                        data: 'observaciones',
                        className: 'table-td'
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                @can('especial_licencias_estado')
                                    <label class="switch switch-primary">
                                        <input onclick="estado_tipo_licencia('${row.id}')" type="checkbox" class="switch-input" ${row.estado === 'activo' ? 'checked' : ''} />
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
                                    @can('especial_licencias_editar')
                                        <button type="button" onclick="editar_tipo_licencia('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                            <i class="ti ti-edit" ></i>
                                        </button>
                                    @endcan

                                    @can('especial_licencias_eliminar')
                                        <button type="button" onclick="eliminar_tipo_licencia('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="EDITAR">
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
        listar_tipos_licencia();

        //funcion  de acctualizar tabla
        function actualizar_tabla_tipo_licencia() {
            $('#tabla_tipo_licencia').DataTable().destroy();
            listar_tipos_licencia();
            $('#tabla_tipo_licencia').fadeIn(200);
        }

        //para cambiar el estado del tipo de licencia
        function estado_tipo_licencia(id){
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
                        let respuesta = await fetch("{{ route('clic_tipolicecnia_estado') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actualizar_tabla_tipo_licencia();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                        actualizar_tabla_tipo_licencia();
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                    actualizar_tabla_tipo_licencia();
                }
            });
        }

        //para guardar nuevo registro de tipo de licencias
        let form_nuevo_tipo_licencia = document.getElementById('formulario_nuevo_tipo_licencia');
        let btn_guardar_tipo_licencia = document.getElementById('btn_guardar_tipo_licencia');

        btn_guardar_tipo_licencia.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_nuevo_tipo_licencia).entries());
            vaciar_errores_tipo_licencia();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_tipo_licencia');
            try {
                let respuesta = await fetch("{{ route('clic_tipolicecnia_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_tipo_licencia();
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia');
                    actualizar_tabla_tipo_licencia();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia');
            }
        });

        //par vaciar los errores
        function vaciar_errores_tipo_licencia(){
            let valor = ['_numero', '_normativa', '_motivo', '_jornada_laboral', '_requisitos', '_plazos', '_observaciones', '_numero_', '_normativa_', '_motivo_', '_jornada_laboral_', '_requisitos_', '_plazos_', '_observaciones_'];
            valor.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //para cerrar el modal
        function cerrar_modal_tipo_licencia(){
            $('#modal_tipo_licencia').modal('hide');
            vaciar_errores_tipo_licencia();
            vaciar_formulario(form_nuevo_tipo_licencia);
        }

        //para cerar el modal de editar
        function cerrar_modal_tipo_licencia_editar(){
            $('#modal_tipo_licencia_editar').modal('hide');
            vaciar_errores_tipo_licencia();
        }

        /**@argument
         * PARA EDITR EL TIPO DE LICENCIA */
        async function editar_tipo_licencia(id){
            try {
                let respuesta = await fetch("{{ route('clic_tipolicecnia_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_tipo_licencia_editar').modal('show');
                    document.getElementById('id_tipo_licencia').value = dato.mensaje.id;
                    document.getElementById('numero_').value = dato.mensaje.numero;
                    document.getElementById('normativa_').value = dato.mensaje.normativa;
                    document.getElementById('motivo_').value = dato.mensaje.motivo;
                    document.getElementById('jornada_laboral_').value = dato.mensaje.jornada_laboral;
                    document.getElementById('requisitos_').value = dato.mensaje.requisitos;
                    document.getElementById('plazos_').value = dato.mensaje.plazos;
                    document.getElementById('observaciones_').value = dato.mensaje.observaciones;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }


        //para guardar el registro
        let form_editar_tipo_licencia = document.getElementById('formulario_editar_tipo_licencia');
        let btn_guardar_tipo_licencia_editar = document.getElementById('btn_guardar_tipo_licencia_editar');

        btn_guardar_tipo_licencia_editar.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_editar_tipo_licencia).entries());
            vaciar_errores_tipo_licencia();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_tipo_licencia_editar');
            try {
                let respuesta = await fetch("{{ route('clic_tipolicecnia_edi_save') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia_editar');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_tipo_licencia_editar();
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia_editar');
                    actualizar_tabla_tipo_licencia();
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia_editar');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_tipo_licencia_editar');
            }
        });


        //para eliminar el registro
        function eliminar_tipo_licencia(id){
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
                        let respuesta = await fetch("{{ route('clic_tipolicecnia_eliminar') }}",{
                            method: "DELETE",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({id:id})
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            actualizar_tabla_tipo_licencia();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                        if(dato.tipo === 'error'){
                            alerta_top(dato.tipo, dato.mensaje);
                        }
                    } catch (error) {
                        console.log('Error de datos : '+error);
                    }
                } else {
                    alerta_top('error', 'Se cancelo');
                }
            });
        }
    </script>
@endsection
