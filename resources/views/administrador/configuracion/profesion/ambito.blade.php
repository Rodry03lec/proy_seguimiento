@extends('principal')
@section('titulo', '| TIPOS DE AMBITO')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: ÁMBITOS PROFESIONALES ::::::::</h5>
            @can('ambito_profesional_nuevo')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_ambitos_profesionales_nuevo">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- Role cards -->
    <div class="row g-4 py-4">
        @foreach ($lisambito_profesional as $lis)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                                <h6 class="mb-1">{{ $lis->nombre }}</h6>
                                <div class="d-inline-block tex-nowrap">
                                    @can('ambito_profesional_editar')
                                        <button class="btn btn-sm btn-icon" onclick="editar_ambito('{{ $lis->id }}')" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    @endcan

                                    @can('ambito_profesional_eliminar')
                                        <button class="btn btn-sm btn-icon" onclick="eliminar_ambito('{{ $lis->id }}')" type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @endcan

                                </div>
                            </div>
                            @can('ambito_profesional_vizualizar')
                                <a href="{{ route('pfs_index', ['id'=> encriptar($lis->id)]) }}" class="btn btn-sm btn-icon"  type="button">
                                    <i class="ti ti-eye"></i>
                                </a>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!--/ Role cards -->


    <!-- Add Ambitos profesionales Modal -->
    <div class="modal fade" id="modal_ambitos_profesionales_nuevo" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_ambito()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nuevo Ámbito Profesional</h3>
                    </div>
                    <form id="formulario_nuevo_ambitoprofesional" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion">Nombre del Grado Académico</label>
                            <textarea cols="30" rows="5" id="descripcion" name="descripcion" class="form-control uppercase-input"></textarea>
                            <div id="_descripcion"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_ambito"class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_ambito()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add ambitos profesionales Modal -->


    <!-- Update Ambitos profesionales Modal -->
    <div class="modal fade" id="modal_ambitos_profesionales_editar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_ambitoprofesional_editar()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Editar Ámbito Profesional</h3>
                    </div>
                    <form id="formulario_editar_ambitoprofesional" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_ambitoprofesional" id="id_ambitoprofesional">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="nombre_">Nombre</label>
                            <input type="text" id="nombre_" name="nombre_" class="form-control uppercase-input"
                                placeholder="Ingrese el nombre" autofocus />
                            <div id="_nombre_"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="descripcion_">Descripción del ambito profesional</label>
                            <textarea cols="30" rows="5" id="descripcion_" name="descripcion_" class="form-control " placeholder="Ingrese la descipcion del grado academico"></textarea>
                            <div id="_descripcion_"></div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_ambito_editar"class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_ambitoprofesional_editar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Update ambitos profesionales Modal -->

@endsection

@section('scripts')
    <script>
        //declaramos las variables que utilizaremos
        let guardar_ambito_btn      = document.getElementById('btn_guardar_ambito');
        let form_ambitoprofesional  = document.getElementById('formulario_nuevo_ambitoprofesional');

        //para cerrar el modal de ambito profesional
        function cerrar_modal_ambito(){
            $('#modal_ambitos_profesionales_nuevo').modal('hide');
            vaciar_formulario(form_ambitoprofesional);
            vaciar_errores_ambito_profesional();
        }

        //para vaciar los errores de formulario de ambito
        function vaciar_errores_ambito_profesional(){
            let nuevo_array = ['_nombre', '_descripcion', '_nombre_', '_descripcion_'];
            nuevo_array.forEach(element => {
                document.getElementById(element).innerHTML = '';
            });
        }

        //para guardar nuevo ambito profesional
        guardar_ambito_btn.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_ambitoprofesional).entries());
            vaciar_errores_ambito_profesional();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_ambito');
            try {
                let respuesta = await fetch("{{ route('apg_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_ambito');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    setTimeout(() => {
                        cerrar_modal_ambito();
                        location.reload();
                        validar_boton(true, 'Guardando datos con éxito', 'btn_guardar_ambito');
                    }, 500);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, '', 'btn_guardar_ambito');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, '', 'btn_guardar_ambito');
            }
        });

        //PARA ELIMINAR EL REGISTRO DE AMBITOS PROFESIONALES
        function eliminar_ambito(id){
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
                        let respuesta = await fetch("{{ route('apg_eliminar') }}",{
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
                            }, 500);
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

        //PARA REALIZAR LA EDICIÓN DEL AMBITO PROFESIONAL
        let form_ambitoprofesional_edit  = document.getElementById('formulario_editar_ambitoprofesional');
        let guardar_ambito_btn_edit      = document.getElementById('btn_guardar_ambito_editar');

        //para cerrar editar el modal del ambito profesional
        function cerrar_modal_ambitoprofesional_editar(){
            $('#modal_ambitos_profesionales_editar').modal('hide');
            vaciar_formulario(form_ambitoprofesional_edit);
            vaciar_errores_ambito_profesional();
        }

        //editar el registro
        async function editar_ambito(id){
            try {
                let respuesta = await fetch("{{ route('apg_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_ambitos_profesionales_editar').modal('show');
                    document.getElementById('id_ambitoprofesional').value = dato.mensaje.id;
                    document.getElementById('nombre_').value = dato.mensaje.nombre;
                    document.getElementById('descripcion_').value = dato.mensaje.descripcion;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //PARA GUARDAR EL EDITADO DEL AMBITO PROFESIONAL
        guardar_ambito_btn_edit.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_ambitoprofesional_edit).entries());
            vaciar_errores_ambito_profesional();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_ambito_editar');
            try {
                let respuesta = await fetch("{{ route('apg_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_ambito_editar');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    setTimeout(() => {
                        cerrar_modal_ambitoprofesional_editar();
                        location.reload();
                        validar_boton(true, 'Guardando datos con éxito', 'btn_guardar_ambito_editar');
                    }, 1000);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, '', 'btn_guardar_ambito_editar');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, '', 'btn_guardar_ambito_editar');
            }
        });
    </script>
@endsection
