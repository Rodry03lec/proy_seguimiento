@extends('principal')
@section('titulo', ' | FERIADO')
@section('contenido')

    <div class="card p-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: FERIADOS  ::::::::</h5>
        </div>
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
            <div class="app-academy-md-25 card-body py-0">
                <img src="{{ asset('admin_template/img/illustrations/bulb-light.png') }}"
                    class="img-fluid app-academy-img-height scaleX-n1-rtl"
                    height="90" />
            </div>
            <div class=" col-12 card-body d-flex align-items-md-center flex-column text-md-center">
                <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                    Busqueda por gestion
                </h3>
                <form method="post" id="form_mostrar_fechas" class="col-12">
                    <div class="col-12">
                        <select name="gestion" id="gestion"  class="me-2 select2" >
                            <option selected disabled>[ SELECCIONE UNA GESTIÓN ]</option>
                            @foreach ($gestion as $lis)
                                <option value="{{ $lis->id }}">{{ $lis->gestion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 py-2">
                        <select name="mes" id="mes"  class="me-2 select2">
                            <option selected disabled>[ SELECCIONE MES ]</option>
                            @foreach ($mes as $lis)
                                <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="d-grid gap-2 col-lg-6 mx-auto py-2">
                    <button type="button" class="btn btn-outline-primary" id="mostrar_fechas">MOSTRAR</button>
                </div>
            </div>
            <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                <img src="{{ asset('admin_template/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="188"
                    class="scaleX-n1-rtl" />
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="divider" >
            <div class="divider-text" id="html_gestion">GESTIÓN : </div>
        </div>
        <div class="divider">
            <div class="divider-text" id="html_mes">MES : </div>
        </div>

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_listar_fechas" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>FECHA</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <!-- Nuevo la feriado Modal -->
    <div class="modal fade" id="modal_feriado_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-1">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_feriado()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">ASIGNAR FERIADO</h3>
                        <div class="alert alert-danger alert-dismissible" id="detalle_fecha" role="alert">
                        </div>
                    </div>
                    <form id="formulario_feriado_nuevo" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_fecha_principal" id="id_fecha_principal">
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">Ingrese la descripción del feriado</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="2" class="form-control" placeholder="Ingrese la descripción del feriado!" ></textarea>
                                <div id="_descripcion"></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_feriado_nuevo" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_feriado()" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Nuevo la feriado Modal -->

    <!-- Editar la feriado Modal -->
    <div class="modal fade" id="modal_feriado_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-1 p-md-1">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_feriado()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">EDITAR FERIADO</h3>
                        <div class="alert alert-danger alert-dismissible" id="detalle_fecha_edit" role="alert">
                        </div>
                    </div>
                    <form id="formulario_feriado_editar" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_fecha_princ_edit" id="id_fecha_princ_edit">
                        <input type="hidden" name="id_feriado" id="id_feriado">
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">Ingrese la descripción del feriado</label>
                                <textarea name="descripcion_" id="descripcion_" cols="30" rows="2" class="form-control" placeholder="Ingrese la descripción del feriado!" ></textarea>
                                <div id="_descripcion_"></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_feriado_editar" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_feriado()" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Editar la feriado Modal -->

@endsection
@section('scripts')
    <script>
        //para mostrar las fechas pero esto sera en htmls ojo
        let btn_mostrar_fechas = document.getElementById('mostrar_fechas');
        let form_mostrar_fechas = document.getElementById('form_mostrar_fechas');
        btn_mostrar_fechas.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_mostrar_fechas).entries());
            if ((datos.gestion ?? '') !== '' && (datos.mes ?? '') !== '') {
                try {
                    actulizar_tabla_fechas();
                    listar_fechas(datos.gestion, datos.mes);
                } catch (error) {
                    console.log('Ocurrio un error :' + error );
                }
            } else {
                //alertify.alert("No se selecciono la gestion o el mes!");
                alerta_center("error", "Oops...", "No se selecciono la gestion o el mes!");
            }
        });


        //funcion  de acctualizar tabla
        function actulizar_tabla_fechas() {
            $('#tabla_listar_fechas').DataTable().destroy();
            $('#tabla_listar_fechas').fadeIn(200);
        }

        //funcion para listar las fechas
        async function listar_fechas(id_gestion, id_mes){
            let respuesta = await fetch("{{ route('cfer_lisfechas') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    id_gestion  :   id_gestion,
                    id_mes  :   id_mes
                })
            });
            let dato = await respuesta.json();
            document.getElementById('html_gestion').innerHTML = 'GESTIÓN : '+dato.gestion.gestion;
            document.getElementById('html_mes').innerHTML = 'MES : '+dato.mes.nombre;
            let i = 1;
            $('#tabla_listar_fechas').DataTable({
                responsive: true,
                data: dato.listar_fechas,
                columns: [{
                        data: null,
                        className: 'table-td',
                        render: function() {
                            return i++;
                        }
                    },
                    {
                        data: 'fecha',
                        className: 'table-td',
                        render: function(data, type, row) {
                            return fecha_literal(data, 5);
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row) {
                            if(data.feriado !== null){
                                return data.feriado.descripcion;
                            }else{
                                return '';
                            }
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.feriado !== null){
                                return `
                                    <div class="d-inline-block tex-nowrap">
                                        @can('especial_feriado_editar')
                                            <button type="button" onclick="editar_feriado('${row.id}')" class="btn btn-icon rounded-pill btn-warning" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                                <i class="ti ti-edit" ></i>
                                            </button>
                                        @endcan

                                        @can('especial_feriado_eliminar')
                                            <button type="button" onclick="eliminar_feriado('${row.id}')" class="btn btn-icon rounded-pill btn-danger" data-toggle="tooltip" data-placement="top" title="ELIMINAR">
                                                <i class="ti ti-trash" ></i>
                                            </button>
                                        @endcan

                                    </div>
                                `;
                            }else{
                                return `
                                    @can('especial_feriado_nuevo')
                                        <div class="d-inline-block tex-nowrap">
                                            <button type="button" onclick="nuevo_feriado('${row.id}')" class="btn btn-icon rounded-pill btn-info" data-toggle="tooltip" data-placement="top" title="VIZUALIZAR">
                                                <i class="ti ti-plus" ></i>
                                            </button>
                                        </div>
                                    @endcan

                                `;
                            }
                        }
                    }
                ]
            });
        }

        //para vizualizar los feriados
        async function nuevo_feriado(id){
            try {
                let respuesta = await fetch("{{ route('cfer_mostrar_fecha') }}", {
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo==='success'){
                    $('#modal_feriado_nuevo').modal('show');
                    document.getElementById('detalle_fecha').innerHTML = `<strong class="ltr:mr-1 rtl:ml-1">`+obtener_fecha_literal(dato.mensaje.fecha)+`</strong>`;
                    document.getElementById('id_fecha_principal').value = dato.mensaje.id;
                    document.getElementById('descripcion').value = '';
                }
                if(dato.tipo==='error'){
                    alerta_top_end(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :'+ error);
            }
        }


        //para guardar el feriado
        let btn_feriado_new = document.getElementById('btn_feriado_nuevo');
        let form_new_feriado = document.getElementById('formulario_feriado_nuevo');
        btn_feriado_new.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_new_feriado).entries());
            validar_boton(true, 'Guardando', 'btn_feriado_nuevo');
            vaciar_errores_feriado();
            try {
                let respuesta = await fetch("{{ route('cfer_feriado_guardar') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_feriado_nuevo');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_feriado_nuevo');
                    actulizar_tabla_fechas();
                    listar_fechas(dato.fecha_principal.id_gestion, dato.fecha_principal.id_mes);
                    $('#modal_feriado_nuevo').modal('hide');
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_feriado_nuevo');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_feriado_nuevo');
            }
        });

        //para cerrar el modal
        function cerrar_modal_feriado(){
            vaciar_formulario(form_new_feriado);
            //vaciar_formulario(form_new_feriado);
            vaciar_errores_feriado();
        }

        //para vaciar los errores de asiganaicon de feriado
        function vaciar_errores_feriado(){
            let array = ['_descripcion', '_descripcion_'];
            array.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }


        //PARA EDITAR EL REGISTRO DE FERIADO
        async function editar_feriado(id){
            try {
                let respuesta = await fetch("{{ route('cfer_feriado_edit') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'success') {
                    $('#modal_feriado_editar').modal('show');
                    document.getElementById('detalle_fecha_edit').innerHTML = `<strong class="ltr:mr-1 rtl:ml-1">`+obtener_fecha_literal(dato.mensaje.fecha)+`</strong>`;
                    document.getElementById('id_feriado').value = dato.mensaje.feriado.id;
                    document.getElementById('id_fecha_princ_edit').value = dato.mensaje.id;
                    document.getElementById('descripcion_').value = dato.mensaje.feriado.descripcion;
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
            }
        }
        //para guardar los datos de lo que se edito
        let form_edit_feriado = document.getElementById('formulario_feriado_editar');
        let btn_edit_feriado = document.getElementById('btn_feriado_editar');
        btn_edit_feriado.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_edit_feriado).entries());
            validar_boton(true, 'Guardando', 'btn_feriado_editar');
            vaciar_errores_feriado();
            try {
                let respuesta = await fetch("{{ route('cfer_feriado_edit_guardar') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(datos)
                });
                let dato = await respuesta.json();
                if (dato.tipo === 'errores') {
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_feriado_editar');
                }
                if (dato.tipo === 'success') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_feriado_editar');
                    actulizar_tabla_fechas();
                    listar_fechas(dato.fecha_principal.id_gestion, dato.fecha_principal.id_mes);
                    $('#modal_feriado_editar').modal('hide');
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_feriado_editar');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_feriado_editar');
            }
        });


        //PARA ELIMINAR EL REGISTRO DE FERIADO
        function eliminar_feriado(id){
            Swal.fire({
                title: "¿Estás seguro de eliminar?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('cfer_eliminar') }}",{
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
                            actulizar_tabla_fechas();
                            listar_fechas(dato.fecha_principal.id_gestion, dato.fecha_principal.id_mes);
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
