@extends('principal')
@section('titulo', '| PERSONA')
@section('contenido')


    <div class="card p-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: PERSONAS :::::::: </h5>
            @can('persona_nuevo')
                <button type="button" class="btn btn-primary" onclick="modal_registro_persona()">
                    <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
                </button>
            @endcan

        </div>
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
            <div class="app-academy-md-25 card-body py-0">
                <img src="{{ asset('admin_template/img/illustrations/bulb-light.png') }}"
                    class="img-fluid app-academy-img-height scaleX-n1-rtl"
                    height="90" />
            </div>
            <div class=" col-12 card-body d-flex align-items-md-center flex-column text-md-center">
                <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                    Busqueda por CI
                </h3>
                <div class="d-flex col-12">
                    <input type="search" placeholder="Buscar por CI . . . . . . . . "  class="form-control me-2" onkeyup="buscar_ci(this.value)" id="ci_buscar" minlength="5" maxlength="15" autocomplete="off"/>
                </div>
            </div>
            <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                <img src="{{ asset('admin_template/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="188"
                    class="scaleX-n1-rtl" />
            </div>
        </div>
    </div>

    <div class="card mb-4" id="listado_html_persona">

    </div>


    <!-- Modal -->
    <!-- Add tipo de categoria Modal -->
    <div class="modal fade" id="modal_nueva_persona" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_registro_persona()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Registro nueva Persona</h3>
                    </div>
                    <form id="form_nueva_persona" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="row" >
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="ci">CI</label>
                                <input type="text" id="ci" name="ci" placeholder="Ingrese el CI" onkeyup="validar_ci(this.value)"  class="form-control uppercase-input" onkeypress="return soloNumeros(event)" autofocus />
                                <div id="_ci"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="complemento">Complemento</label>
                                <input type="text" id="complemento" name="complemento" class="form-control uppercase-input" placeholder="Ingrese complemento" autofocus @disabled(true) />
                                <div id="_complemento"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="nit">NIT</label>
                                <input type="text" id="nit" name="nit" class="form-control uppercase-input" placeholder="Ingrese NIT" autofocus  onkeypress="return soloNumeros(event)" @disabled(true)/>
                                <div id="_nit"></div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento</label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control uppercase-input" placeholder="Ingrese la fecha de nacimiento" autofocus max="{{ date('Y-m-d') }}"  onkeypress="return soloNumeros(event)" @disabled(true)/>
                                <div id="_fecha_nacimiento"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="genero">Seleccione Género</label>
                                <select name="genero" id="genero" class="select2 form-select" @disabled(true) >
                                    <option disabled selected value="selected">[ SELECCIONE GÉNERO ]</option>
                                    @foreach ($lis_genero as $lis)
                                        <option value="{{ $lis->id }}">[{{ $lis->sigla }}] - [{{ $lis->nombre }}]</option>
                                    @endforeach
                                </select>
                                <div id="_genero" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="estado_civil">Seleccione Estado Civil</label>
                                <select name="estado_civil" id="estado_civil" class="select2 form-select" @disabled(true) >
                                    <option disabled selected value="selected">[ SELECCIONE ESTADO CIVIL ]</option>
                                    @foreach ($lis_estado_civil as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                </select>
                                <div id="_estado_civil" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="nombres">Nombres</label>
                                <input type="text" id="nombres" name="nombres" class="form-control uppercase-input" placeholder="Ingrese nombres" onkeypress="return soloLetras(event)" @disabled(true) />
                                <div id="_nombres"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="apellido_paterno">Apellido Paterno</label>
                                <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control uppercase-input" placeholder="Ingrese apellido paterno" onkeypress="return soloLetras(event)" @disabled(true) />
                                <div id="_apellido_paterno"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="apellido_materno">Apellido Materno</label>
                                <input type="text" id="apellido_materno" name="apellido_materno" class="form-control uppercase-input" placeholder="Ingrese apellido materno" onkeypress="return soloLetras(event)" @disabled(true) />
                                <div id="_apellido_materno"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="gmail">Gmail</label>
                                <input type="gmail" id="gmail" name="gmail" placeholder="Ingrese su correo electronico" class="form-control" @disabled(true)/>
                                <div id="_gmail"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="numero_celular">Nº de celular</label>
                                <input type="text" id="numero_celular" name="numero_celular" placeholder="Ingrese su numero de celular" class="form-control uppercase-input" onkeypress="return soloNumeros(event)" @disabled(true)/>
                                <div id="_numero_celular"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="direccion">Dirección</label>
                                <textarea class="form-control" name="direccion" id="direccion" placeholder="Ingrese la dirección" cols="30" rows="2" @disabled(true)></textarea>
                                <div id="_direccion"></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_registro_persona" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_registro_persona()">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de categoria Modal -->

    <!-- Modal -->
    <!-- Editar tipo de categoria Modal -->
    <div class="modal fade" id="modal_editar_persona" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content p-1 p-md-2">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_registro_persona()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Registro Editar Persona</h3>
                    </div>
                    <form id="form_editar_persona" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_persona" id="id_persona">
                        <div class="row" >
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="nit_">NIT</label>
                                <input type="text" id="nit_" name="nit_" class="form-control uppercase-input" placeholder="Ingrese NIT" autofocus  onkeypress="return soloNumeros(event)"/>
                                <div id="_nit_"></div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="fecha_nacimiento_">Fecha de nacimiento</label>
                                <input type="date" id="fecha_nacimiento_" name="fecha_nacimiento_" class="form-control uppercase-input" placeholder="Ingrese la fecha de nacimiento" autofocus max="{{ date('Y-m-d') }}"  onkeypress="return soloNumeros(event)" />
                                <div id="_fecha_nacimiento_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="genero_">Seleccione Género</label>
                                <select name="genero_" id="genero_" class="select2 form-select"  >
                                    <option disabled selected value="selected">[ SELECCIONE GÉNERO ]</option>
                                    @foreach ($lis_genero as $lis)
                                        <option value="{{ $lis->id }}">[{{ $lis->sigla }}] - [{{ $lis->nombre }}]</option>
                                    @endforeach
                                </select>
                                <div id="_genero_" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="estado_civil_">Seleccione Estado Civil</label>
                                <select name="estado_civil_" id="estado_civil_" class="select2 form-select"  >
                                    <option disabled selected value="selected">[ SELECCIONE ESTADO CIVIL ]</option>
                                    @foreach ($lis_estado_civil as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                </select>
                                <div id="_estado_civil_" ></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="nombres_">Nombres</label>
                                <input type="text" id="nombres_" name="nombres_" class="form-control uppercase-input" placeholder="Ingrese nombres" onkeypress="return soloLetras(event)" />
                                <div id="_nombres_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="apellido_paterno_">Apellido Paterno</label>
                                <input type="text" id="apellido_paterno_" name="apellido_paterno_" class="form-control uppercase-input" placeholder="Ingrese apellido paterno" onkeypress="return soloLetras(event)" />
                                <div id="_apellido_paterno_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="apellido_materno_">Apellido Materno</label>
                                <input type="text" id="apellido_materno_" name="apellido_materno_" class="form-control uppercase-input" placeholder="Ingrese apellido materno" onkeypress="return soloLetras(event)" />
                                <div id="_apellido_materno_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="gmail_">Gmail</label>
                                <input type="gmail" id="gmail_" name="gmail_" placeholder="Ingrese su correo electronico" class="form-control" />
                                <div id="_gmail_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="numero_celular_">Nº de celular</label>
                                <input type="text" id="numero_celular_" name="numero_celular_" placeholder="Ingrese su numero de celular" class="form-control uppercase-input" onkeypress="return soloNumeros(event)" />
                                <div id="_numero_celular_"></div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="direccion_">Dirección</label>
                                <textarea class="form-control" name="direccion_" id="direccion_" placeholder="Ingrese la dirección" cols="30" rows="2" ></textarea>
                                <div id="_direccion_"></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_editar_persona" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="cerrar_modal_editar_persona_cerrar()">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ Editar tipo de categoria Modal -->

@endsection
@section('scripts')
    <script>
        //listar la persona
        async function buscar_ci(ci) {
            let listado_html = document.getElementById('listado_html_persona');
            if(ci.length >= 5){
                try {
                    let formData = new FormData();
                    formData.append('ci', ci);
                    formData.append('_token', token);
                    let respuesta = await fetch("{{ route('per_buscar') }}",{
                        method: 'POST',
                        body:formData
                    });
                    if(respuesta.ok){
                        let data = await respuesta.text();
                        document.getElementById('listado_html_persona').innerHTML = data;
                    }else{
                        console.log('Error en la solicitud', respuesta.status);
                        listado_html.innerHTML = '';
                    }
                } catch (error) {
                    console.log('Ocurrio un error : '+error);
                    listado_html.innerHTML = '';
                }
            }else{
                listado_html.innerHTML = '';
            }
        }

        /**@argument
         * PARA LA ADMINISTRACION DE LA PERSONA
         * */
        let form_persona_nuevo  = document.getElementById('form_nueva_persona');
        let btn_persona_nuevo   = document.getElementById('btn_guardar_registro_persona');


        //para guardar nueva persona
        function modal_registro_persona(){
            document.getElementById('listado_html_persona').innerHTML = '';
            document.getElementById('ci_buscar').value = '';
            $('#modal_nueva_persona').modal('show');
        }
        //para cerar el modal de la persona
        function cerrar_modal_registro_persona(){
            $('#modal_nueva_persona').modal('hide');
            vaciar_input();
            vaciar_errores_registro_persona();
        }
        //para vaciar los inputs
        function vaciar_input(){
            let persona1 = ['complemento', 'nit', 'fecha_nacimiento', 'nombres', 'apellido_paterno', 'apellido_materno', 'gmail', 'numero_celular', 'direccion'];
            persona1.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            let persona2 = ['genero', 'estado_civil'];
            persona2.forEach(elem => {
                $('#'+elem).val('selected').trigger('change');
            });
        }
        //para la administracion limpiar los errores
        function vaciar_errores_registro_persona(){
            let persona = ['_ci', '_fecha_nacimiento', '_nombres', '_apellido_paterno', '_gmail', '_estado_civil', '_numero_celular', '_direccion'];
            persona.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //para guardar el registro de la nueva persona
        btn_persona_nuevo.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_persona_nuevo).entries());
            vaciar_errores_registro_persona();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_registro_persona');
            try {
                let respuesta = await fetch("{{ route('per_nuevo') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_registro_persona');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_registro_persona();
                    validar_boton(false, 'Guardar', 'btn_guardar_registro_persona');
                    habilitar_deshabiltar(true);
                    vaciar_input();
                    vaciar_errores_registro_persona();
                    document.getElementById('ci').value = '';
                    buscar_ci(dato.ci_rec);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_registro_persona');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_registro_persona');
            }
        });

        //para validar por CI
        async function  validar_ci(ci) {
            if(ci.length >= 5){
                try {
                    let respuesta = await fetch("{{ route('per_validar') }}",{
                        method: "POST",
                        headers:{
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ci:ci})
                    });
                    let dato = await respuesta.json();
                    if(dato.tipo === 'success'){
                        habilitar_deshabiltar(false);
                        vaciar_input();
                        vaciar_errores_registro_persona();
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                        habilitar_deshabiltar(true);
                        vaciar_input();
                        vaciar_errores_registro_persona();
                    }
                } catch (error) {
                    console.log('Error :>> ', error);
                }
            }else{
                habilitar_deshabiltar(true);
                vaciar_input();
                vaciar_errores_registro_persona();
            }
        }

        //para bloquear los inputs o no
        function habilitar_deshabiltar(valor){
            let valores = ['complemento', 'nit', 'fecha_nacimiento', 'nombres', 'apellido_paterno', 'apellido_materno', 'gmail', 'numero_celular', 'direccion', 'genero', 'estado_civil'];
            valores.forEach(elem => {
                if(valor === true){
                    document.getElementById(elem).disabled = valor;
                }else{
                    document.getElementById(elem).disabled = valor;
                }
            });
        }

        //para validar fecha de nacimiento
        let fechaNacimientoInput = document.getElementById('fecha_nacimiento');
        fechaNacimientoInput.addEventListener('change', function() {
            let fechaNacimiento = new Date(this.value);
            let fechaActual = new Date();
            if (fechaNacimiento > fechaActual) {
                document.getElementById('_fecha_nacimiento').innerHTML = '<p style="color:red; font-size: 12px" >La fecha de nacimiento no puede ser en el futuro.</p>';
            } else {
                document.getElementById('_fecha_nacimiento').innerHTML = '';
            }
        });


        //PARA EDITAR LA PERSONA
        let form_persona_editar  = document.getElementById('form_editar_persona');
        let btn_persona_editar   = document.getElementById('btn_guardar_editar_persona');

        //para cerar el modal de la persona
        function cerrar_modal_editar_persona_cerrar(){
            $('#modal_editar_persona').modal('hide');
            vaciar_errores_persona_editar();
        }

        function vaciar_errores_persona_editar(){
            let persona = ['_fecha_nacimiento_', '_nombres_', '_apellido_paterno_', '_gmail_', '_estado_civil_', '_numero_celular_', '_direccion_'];
            persona.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        async function  editar_persona(id) {
            try {
                let respuesta = await fetch("{{ route('per_editar') }}",{
                    method: "POST",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                if(dato.tipo === 'success'){
                    $('#modal_editar_persona').modal('show');
                    document.getElementById('id_persona').value             = dato.mensaje.id;
                    document.getElementById('nit_').value                   = dato.mensaje.nit;
                    document.getElementById('fecha_nacimiento_').value      = dato.mensaje.fecha_nacimiento;
                    document.getElementById('nombres_').value               = dato.mensaje.nombres;
                    document.getElementById('apellido_paterno_').value      = dato.mensaje.ap_paterno;
                    document.getElementById('apellido_materno_').value      = dato.mensaje.ap_materno;
                    document.getElementById('gmail_').value                 = dato.mensaje.gmail;
                    document.getElementById('numero_celular_').value        = dato.mensaje.celular;
                    document.getElementById('direccion_').value             = dato.mensaje.direccion;

                    // Seleccionar la opción deseada para el campo con id 'genero_'
                    let generoSelect = document.getElementById('genero_');
                    generoSelect.value = dato.mensaje.id_genero;
                    generoSelect.dispatchEvent(new Event('change'));

                    // Seleccionar la opción deseada para el campo con id 'estado_civil_'
                    let estadoCivilSelect = document.getElementById('estado_civil_');
                    estadoCivilSelect.value = dato.mensaje.id_estado_civil;
                    estadoCivilSelect.dispatchEvent(new Event('change'));
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('Error de datos : '+error);
            }
        }

        //para validar fecha de nacimiento
        let fechaNacimientoInputEditar = document.getElementById('fecha_nacimiento_');
        fechaNacimientoInputEditar.addEventListener('change', function() {
            let fechaNacimiento = new Date(this.value);
            let fechaActual = new Date();
            if (fechaNacimiento > fechaActual) {
                document.getElementById('_fecha_nacimiento_').innerHTML = '<p style="color:red; font-size: 12px" >La fecha de nacimiento no puede ser en el futuro.</p>';
            } else {
                document.getElementById('_fecha_nacimiento_').innerHTML = '';
            }
        });
        //para guardar lo edtiado
        btn_persona_editar.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_persona_editar).entries());
            vaciar_errores_persona_editar();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_editar_persona');
            try {
                let respuesta = await fetch("{{ route('per_editar_guardar') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_persona');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, dato.mensaje);
                    cerrar_modal_editar_persona_cerrar();
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_persona');
                    buscar_ci(dato.ci_rec1);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_editar_persona');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_editar_persona');
            }
        });
        //FIN DE LA PARTE DE EDITAR LA PERSONA

        //paa elimina el egistro de la persona
        async function eliminar_persona(id) {
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
                            alerta_top(dato.tipo, dato.mensaje);
                            document.getElementById('listado_html_persona').innerHTML  = '';
                            document.getElementById('ci_buscar').value      = '';
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

    </script>
@endsection
