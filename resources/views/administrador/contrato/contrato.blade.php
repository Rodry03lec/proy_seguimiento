@extends('principal')
@section('titulo', '| CONTRATO')
@section('contenido')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">::::::::  CONTRATOS ::::::::  </h5>
        </div>
    </div>
    <div class="row g-4 py-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form_nuevo_contrato" class="row" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_persona" id="id_persona">
                        <fieldset>
                            <legend class="mb-3">INFORMACIÓN PERSONAL</legend>
                            <div class="row" >
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="ci">CI</label>
                                    <input type="text" id="ci" name="ci" placeholder="Ingrese el CI" onkeyup="buscar_ci(this.value)"  class="form-control uppercase-input" onkeypress="return soloNumeros(event)" autofocus />
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="complemento">Complemento</label>
                                    <input type="text" id="complemento" name="complemento" class="form-control uppercase-input" placeholder="Ingrese complemento" autofocus/>
                                    <div id="_complemento"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="nit">NIT</label>
                                    <input type="text" id="nit" name="nit" class="form-control uppercase-input" placeholder="Ingrese NIT" autofocus  onkeypress="return soloNumeros(event)"/>
                                    <div id="_nit"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento</label>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control uppercase-input" placeholder="1999-10-25 Ingrese la fecha de nacimiento"  autofocus max="{{ date('Y-m-d') }}"  onkeypress="return soloNumeros(event)" />
                                    <div id="_fecha_nacimiento"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="genero">Seleccione Género</label>
                                    <select name="genero" id="genero" class="select2 form-select with_100">
                                        <option disabled selected value="selected">[ SELECCIONE GÉNERO ]</option>
                                        @foreach ($lis_genero as $lis)
                                            <option value="{{ $lis->id }}">[{{ $lis->sigla }}] - [{{ $lis->nombre }}]</option>
                                        @endforeach
                                    </select>
                                    <div id="_genero" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="estado_civil">Seleccione Estado Civil</label>
                                    <select name="estado_civil" id="estado_civil" class="select2 form-select with_100">
                                        <option disabled selected value="selected">[ SELECCIONE ESTADO CIVIL ]</option>
                                        @foreach ($lis_estado_civil as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                            @endforeach
                                    </select>
                                    <div id="_estado_civil" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="nombres">Nombres</label>
                                    <input type="text" id="nombres" name="nombres" class="form-control uppercase-input" placeholder="Ingrese nombres" onkeypress="return soloLetras(event)" />
                                    <div id="_nombres"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="apellido_paterno">Apellido Paterno</label>
                                    <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control uppercase-input" placeholder="Ingrese apellido paterno" onkeypress="return soloLetras(event)" />
                                    <div id="_apellido_paterno"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="apellido_materno">Apellido Materno</label>
                                    <input type="text" id="apellido_materno" name="apellido_materno" class="form-control uppercase-input" placeholder="Ingrese apellido materno" onkeypress="return soloLetras(event)"/>
                                    <div id="_apellido_materno"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="gmail">Gmail</label>
                                    <input type="gmail" id="gmail" name="gmail" placeholder="Ingrese su correo electronico" class="form-control"/>
                                    <div id="_gmail"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="numero_celular">Nº de celular</label>
                                    <input type="text" id="numero_celular" name="numero_celular" placeholder="Ingrese su numero de celular" class="form-control uppercase-input" onkeypress="return soloNumeros(event)"/>
                                    <div id="_numero_celular"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label for="direccion">Dirección</label>
                                    <textarea class="form-control" name="direccion" id="direccion" placeholder="Ingrese la dirección" cols="30" rows="2" ></textarea>
                                    <div id="_direccion"></div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>INFORMACIÓN DEL CONTRATO</legend>
                            <div class="row" >
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="fecha_inicio">FECHA DE INICIO</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la fecha de inicio" class="form-control uppercase-input" onchange="validarFechas()" />
                                    <div id="_fecha_inicio"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="fecha_conclusion">FECHA DE CONCLUSIÓN</label>
                                    <input type="date" id="fecha_conclusion" name="fecha_conclusion" placeholder="Seleccione la fecha de inicio"  class="form-control uppercase-input" onchange="validarFechas()" />
                                    <div id="_fecha_conclusion"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="tipo_contrato">SELECCIONE TIPO DE CONTRATO</label>
                                    <select name="tipo_contrato" id="tipo_contrato" class="select2 with_100" onchange="tipo_contrato_select(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE TIPO DE CONTRATO ]</option>
                                        @foreach ($lis_tipo_contrato as $lis)
                                            <option value="{{ $lis->id }}">[{{ $lis->sigla }}] - {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo_contrato"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="numero_contrato">NÚMERO DE CONTRATO</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="contrato_tipo_sel">--------</span>
                                        <input type="text" id="numero_contrato" name="numero_contrato" placeholder="Ingrese el número de contrato" class="form-control uppercase-input "  aria-describedby="numero_contrato" />
                                    </div>
                                    <div id="_numero_contrato"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="haber_basico">HABER BÁSICO</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="haber_basico">Bs</span>
                                        <input type="text" id="haber_basico" name="haber_basico" placeholder="Ingrese el haber basico" class="form-control monto_number"  aria-describedby="haber_basico" />
                                    </div>
                                    <div id="_haber_basico"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="categoria">SELECCIONE LA CATEGORÍA</label>
                                    <select name="categoria" id="categoria" class="select2 with_100"  onchange="categoria_select(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE LA CATEGORÍA ]</option>
                                        @foreach ($lis_categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria" ></div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="nivel">SELECCIONE EL NIVEL</label>
                                    <select name="nivel" id="nivel" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE EL NIVEL ]</option>
                                    </select>
                                    <div id="_nivel" ></div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="horario">SELECCIONE EL HORARIO</label>
                                    <select name="horario" id="horario" class="select2 with_100" onchange="mensaje_horario(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE EL HORARIO ]</option>
                                        @foreach ($lis_horario as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_horario" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3" id="mensaje_horario" ></div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INFORMACIÓN ACADEMICA</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="ambito_profesional">SELECCIONE AMBITO PROFESIONAL</label>
                                    <select name="ambito_profesional" id="ambito_profesional" class="select2 with_100" onchange="profesional_ambito(this.value)">
                                        <option disabled selected value="selected">[ SELECCIONE EL AMBITO PROFESIONAL ]</option>
                                        @foreach ($lis_ambito as $lis)
                                            <option value="{{ $lis->id }}"> {{ $lis->nombre }}  : [{{ $lis->descripcion }}]</option>
                                        @endforeach
                                    </select>
                                    <div id="_ambito_profesional"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="profesion">SELECCIONE PROFESIÓN</label>
                                    <select name="profesion" id="profesion" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE PROFESIÓN ]</option>
                                    </select>
                                    <div id="_profesion"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="grado_academico">SELECCIONE EL GRADO ACADÉMICO</label>
                                    <select name="grado_academico" id="grado_academico" class="select2 with_100">
                                        <option disabled selected value="selected">[ SELECCIONE EL GRADO ACADÉMICO ]</option>
                                        @foreach ($grado_academico as $lis)
                                            <option value="{{ $lis->id }}"> [{{ $lis->abreviatura }}] : {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_grado_academico"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>TRABAJO</legend>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="mae_sm">[SELECCIONE]</label>
                                    <select name="mae_sm" id="mae_sm" class="select2 with_100" onchange="seleccionar_mae_sm(this.value)">
                                    <option disabled selected value="selected"> [SELECCIONE] </option>
                                        <option value="1">MAE</option>
                                        <option value="2">POR SECRETARIAS MUNICIPALES</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>MAE</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="mae_mae">SELECCIONE MAE</label>
                                    <select name="mae_mae" id="mae_mae" class="select2 with_100" onchange="listar_unidad_mae(this.value)" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE MAE] </option>
                                        @foreach ($listar_mae as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_mae_mae" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="unidad_mae">SELECCIONE UNIDAD</label>
                                    <select name="unidad_mae" id="unidad_mae" class="select2 with_100" onchange="listar_cargo_mae(this.value)" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE UNIDAD] </option>
                                    </select>
                                    <div id="_unidad_mae" ></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_mae">SELECCIONE CARGO</label>
                                    <select name="cargo_mae" id="cargo_mae" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected"> [SELECCIONE CARGO] </option>
                                    </select>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_mae_descripcion">INGRESE SU CARGO</label>
                                    <input type="text" id="cargo_mae_descripcion" name="cargo_mae_descripcion" placeholder="Ingrese el cargo correspondiente" class="form-control uppercase-input" @disabled(true)/>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>SM</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="secretaria_sm">SELECCIONE SECRETARIA</label>
                                    <select name="secretaria_sm" id="secretaria_sm" class="select2 with_100" onchange="seleccionar_direccion(this.value)" @disabled(true)>
                                        <option disabled selected value="selected">[SELECCIONE LA SECRETARIA MUNICIPAL]</option>
                                        @foreach ($secretaria_municipal as $lis)
                                            <option value="{{ $lis->id }}">[{{ $lis->sigla }}] : {{ $lis->nombre }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="direccion_sm">SELECCIONE LA DIRECCIÓN</label>
                                    <select name="direccion_sm" id="direccion_sm" class="select2 with_100" onchange="seleccione_cargos_sm(this.value)" @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE LA DIRECCIÓN ]</option>
                                    </select>
                                    <div id="_direccion_sm"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="unidad_administrativa_sm"> <span id="g_span" >*</span>SELECCIONE UNIDAD ADMINISTRATIVA O JEFATURA SI CORRESPONDE <span id="g_span" >*</span></label>
                                    <select name="unidad_administrativa_sm" id="unidad_administrativa_sm" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE UNIDAD ADMINISTRATIVA ]</option>
                                        @foreach ($unidad_administrativa as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_unidad_administrativa_sm"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_sm">SELECCIONE UN CARGO *</label>
                                    <select name="cargo_sm" id="cargo_sm" class="select2 with_100" @disabled(true)>
                                        <option disabled selected value="selected">[ SELECCIONE CARGO ]</option>
                                    </select>
                                    <div id="_cargo_sm"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="cargo_sm_descripcion">INGRESE SU CARGO</label>
                                    <input type="text" id="cargo_sm_descripcion" name="cargo_sm_descripcion" placeholder="Ingrese el cargo correspondiente" class="form-control uppercase-input" @disabled(true)/>
                                </div>
                            </div>
                        </fieldset>

                    </form>
                </div>
                <div class="card-footer">
                    @can('contrato_nuevo')
                        <div class="d-grid gap-2 col-lg-6 mx-auto">
                            <button class="btn btn-primary btn-md"  id="btn_guardar_form_contrato" type="button">Registrar datos!!</button>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>

        fechas_flatpicker('fecha_inicio');
        fechas_flatpicker('fecha_conclusion');
        fecha_nacimiento_flatpicker('fecha_nacimiento');

        //para la validacion de las fechas
        function fechas_flatpicker(fecha){
            flatpickr("#"+fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                //allowInput: true
            });
        }

        //para la fecha de nacimiento
        function fecha_nacimiento_flatpicker(fecha) {
            flatpickr("#" + fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                maxDate: "today", // Esto limita la fecha mínima a hoy
                allowInput: false
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


        function validarFechas() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaConclusion = document.getElementById('fecha_conclusion').value;


            let fechaInicioObj = new Date(fechaInicio);
            let fechaConclusion0bj = new Date(fechaConclusion);

            // Ajustar las fechas para ignorar las horas
            fechaInicioObj.setHours(0, 0, 0, 0);
            fechaConclusion0bj.setHours(0, 0, 0, 0);

            if (fechaConclusion0bj < fechaInicioObj) {
                alerta_top_end('error', 'La fecha final debe ser igual o después de la fecha de inicio. Por favor, selecciona una fecha válida.');
                document.getElementById('fecha_conclusion').value = '';
            }
        }


        //PARA EL TIPO DE CONTRATO
        async function tipo_contrato_select(id){
            let tipo_contato_seleccionado = document.getElementById('contrato_tipo_sel');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_tipo_contrato_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    tipo_contato_seleccionado.innerHTML = '---------';
                    if(dato.tipo === 'success'){
                        tipo_contato_seleccionado.innerHTML = dato.mensaje.sigla;
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                        tipo_contato_seleccionado.innerHTML = '---------';
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                tipo_contato_seleccionado.innerHTML = '---------';
            }
        }

        //UNA VEZ SELECCIONADO LA CATEGORIA
        async function categoria_select (id) {
            let nivel = document.getElementById('nivel');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_nivel_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    nivel.innerHTML = '<option selected disabled>[ SELECCIONE EL NIVEL ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = '['+value.nivel+'] : '+value.descripcion;
                            nivel.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                nivel.innerHTML = '<option selected disabled>[ SELECCIONE EL NIVEL ]</option>';
            }
        }

        //PARA MOSTRAR EL MENSAJE DE HORAS QUE SE TRABAJARA
        async function mensaje_horario(id) {
            let mensaje_horario_html = document.getElementById('mensaje_horario');
            try {
                let respuesta = await fetch("{{ route('cco_horarios_select') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id})
                });
                let dato = await respuesta.json();
                mensaje_horario_html.innerHTML = '';
                if(dato.tipo === 'success'){
                    mensaje_horario_html.innerHTML = `
                    <label for=""></label>
                    <div class="alert alert-danger p-1" role="alert">
                        <span class="ltr:pr-1 rtl:pl-1 text-sm" style=' font-size: 11px;'><strong class="ltr:mr-1 rtl:ml-1">Nota ! </strong>`+dato.mensaje.descripcion+`</span>
                    </div>
                    `;
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    mensaje_horario_html.innerHTML = '';
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                mensaje_horario_html.innerHTML = '';
            }
        }

        //PARA LA PARTE DE LA PROFESIÓN
        async function profesional_ambito(id) {
            let listar_profesion = document.getElementById('profesion');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_listar_profesion') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    listar_profesion.innerHTML = '<option selected disabled>[ SELECCIONE PROFESIÓN ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            listar_profesion.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                listar_profesion.innerHTML = '<option selected disabled>[ SELECCIONE PROFESIÓN ]</option>';
            }
        }

        //ADMINISTRACIÓN DEL MAE

        //AHORA REALIZAMOS POR MAE O SM
        function seleccionar_mae_sm(id) {
            if(id==='1'){
                form_mae(false);
                form_sm(true);
            }
            if(id==='2'){
                form_sm(false);
                form_mae(true);
            }
        }

        //PARA DESHACER O HABILITAR
        //para el mae
        function form_mae(valor){
            let mae = ['mae_mae', 'unidad_mae', 'cargo_mae', 'cargo_mae_descripcion'];
            mae.forEach(elem => {
                document.getElementById(elem).disabled = valor;
            });
            form_mae_selects();
        }

        //para los select esten como sin nada
        function form_mae_selects(){
            unidad_mae.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
            cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
            $('#mae_mae').val('selected').trigger('change');
            document.getElementById('cargo_mae_descripcion').value = '';
        }

        //para el sm
        function form_sm(valor){
            let sm = ['secretaria_sm', 'direccion_sm', 'unidad_administrativa_sm', 'cargo_sm', 'cargo_sm_descripcion'];
            sm.forEach(elem => {
                document.getElementById(elem).disabled = valor;
            });
            form_sm_selects();
        }
        //para los select esten como sin nada
        function form_sm_selects(){
            direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
            cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
            $('#secretaria_sm').val('selected').trigger('change');
            $('#unidad_administrativa_sm').val('selected').trigger('change');
            document.getElementById('cargo_sm_descripcion').value = '';
        }


        let cargo_mae = document.getElementById('cargo_mae');
        let unidad_mae = document.getElementById('unidad_mae');
        //listar la unidad de mae
        async function  listar_unidad_mae(id) {
            let unidad_mae = document.getElementById('unidad_mae');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_unidad_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    unidad_mae.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
                    cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.descripcion;
                            unidad_mae.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                unidad.innerHTML = '<option selected disabled>[SELECCIONE UNIDAD]</option>';
            }
        }
        //listar el cargo de mae
        async function  listar_cargo_mae(id) {
            let cargo_mae = document.getElementById('cargo_mae');
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_cargo_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            cargo_mae.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                cargo_mae.innerHTML = '<option selected disabled>[SELECCIONE CARGO]</option>';
            }
        }

        //secretaria municipal
        let cargos_sm = document.getElementById('cargo_sm');
        let direccion_sm = document.getElementById('direccion_sm');


        //para seleccionar direccion
        async function seleccionar_direccion(id) {
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_direccion_select') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
                    cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            direccion_sm.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                direccion_sm.innerHTML = '<option selected disabled>[ SELECCIONE LA DIRECCIÓN ]</option>';
            }
        }

        //para seleccionar los cargos municipales
        async function seleccione_cargos_sm(id) {
            try {
                if(id != 'selected'){
                    let respuesta = await fetch("{{ route('cco_cargo_select_sm') }}",{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id})
                    });
                    let dato = await respuesta.json();
                    cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
                    if(dato.tipo === 'success'){
                        let ls_datos = dato.mensaje;
                        ls_datos.forEach(function(value) {
                            let option      = document.createElement('option');
                            option.value    = value.id;
                            option.text     = value.nombre;
                            cargos_sm.appendChild(option);
                        });
                    }
                    if(dato.tipo === 'error'){
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                cargos_sm.innerHTML = '<option selected disabled>[ SELECCIONE CARGO ]</option>';
            }
        }


        /**@argument
         * PARA LAS VALIDACIONES DE LA PERSONA x
         * */
        async function buscar_ci(ci){
            document.getElementById('_fecha_nacimiento').innerHTML = '';
            vaciar_errores_registro_persona();
            let complemento         = document.getElementById('complemento');
            let nit                 = document.getElementById('nit');
            let fecha_nacimiento    = document.getElementById('fecha_nacimiento');
            let genero              = document.getElementById('genero');
            let estado_civil        = document.getElementById('estado_civil');
            let nombres             = document.getElementById('nombres');
            let apellido_paterno    = document.getElementById('apellido_paterno');
            let apellido_materno    = document.getElementById('apellido_materno');
            let gmail               = document.getElementById('gmail');
            let numero_celular      = document.getElementById('numero_celular');
            let direccion           = document.getElementById('direccion');
            let id_persona           = document.getElementById('id_persona');

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
                        //habilitar todo para llenar
                        //persona_hab_deshab(false);
                        complemento.value           = '';
                        nit.value                   = '';
                        fecha_nacimiento.value      = '';
                        nombres.value               = '';
                        apellido_paterno.value      = '';
                        apellido_materno.value      = '';
                        gmail.value                 = '';
                        numero_celular.value        = '';
                        direccion.value             = '';
                        $('#genero').val('selected').trigger('change');
                        $('#estado_civil').val('selected').trigger('change');
                        id_persona.value            ='';

                    }
                    if(dato.tipo === 'error'){
                        //mostrar todos los datos y desabilitar
                        //persona_hab_deshab(true);
                        id_persona.value            = dato.persona.id;
                        complemento.value           = dato.persona.complemento;
                        nit.value                   = dato.persona.nit;
                        fecha_nacimiento.value      = dato.persona.fecha_nacimiento;
                        nombres.value               = dato.persona.nombres;
                        apellido_paterno.value      = dato.persona.ap_paterno;
                        apellido_materno.value      = dato.persona.ap_materno;
                        gmail.value                 = dato.persona.gmail;
                        numero_celular.value        = dato.persona.celular;
                        direccion.value             = dato.persona.direccion;
                        $('#genero').val(dato.persona.id_genero).trigger('change');
                        $('#estado_civil').val(dato.persona.id_estado_civil).trigger('change');
                        if(dato.contar_contratos > 0){
                            alertify.alert(dato.mensaje_persona, function(){
                                let urlListarContrato = "{{ route('lc_listar_contratos', ['id' => ':id']) }}";
                                urlListarContrato = urlListarContrato.replace(':id', dato.id_encript_per);
                                window.location.href = urlListarContrato;
                            });
                        }else{
                            alertify.success("Persona verificada . . . . . ");
                        }
                    }
                } catch (error) {
                    console.log('Error :>> ', error);
                }
            }else{
            }
        }

        //para habilitar o desabilitar
        function persona_hab_deshab(valor){
            let valores = ['complemento', 'fecha_nacimiento', 'nombres', 'apellido_paterno', 'apellido_materno'];
            valores.forEach(elem => {
                if(valor === true){
                    document.getElementById(elem).disabled = valor;
                }else{
                    document.getElementById(elem).disabled = valor;
                }
            });
        }

        /*@argument
        *FINDE LA PARTE DE LAS VALIDACIONES
        */


        //PARA REGISTRAR LOS DATOS DE TODO EL CONTRATO
        let btn_guardar_form_contrato   = document.getElementById('btn_guardar_form_contrato');
        let form_new_contrato           = document.getElementById('form_nuevo_contrato');

        //para guardar el registro de la nueva persona
        btn_guardar_form_contrato.addEventListener('click', async ()=>{
            let datos = Object.fromEntries(new FormData(form_new_contrato).entries());
            vaciar_errores_registro_persona();
            validar_boton(true, 'Verificando datos . . . ', 'btn_guardar_form_contrato');
            try {
                let respuesta = await fetch("{{ route('gco_guardar_contrato') }}",{
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
                    validar_boton(false, 'Guardar', 'btn_guardar_form_contrato');
                }
                if(dato.tipo === 'success'){
                    alerta_top_end(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_form_contrato');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if(dato.tipo === 'error'){
                    alerta_top(dato.tipo, dato.mensaje);
                    validar_boton(false, 'Guardar', 'btn_guardar_form_contrato');
                }
            } catch (error) {
                console.log('Ocurrio un error :' + error );
                validar_boton(false, 'Guardar', 'btn_guardar_form_contrato');
            }
        });

        function vaciar_errores_registro_persona(){
            let campos_inp = ['_fecha_nacimiento', '_genero', '_estado_civil', '_nombres', '_apellido_paterno', '_apellido_materno', '_gmail', '_numero_celular', '_direccion', '_fecha_inicio', '_fecha_conclusion', '_tipo_contrato', '_numero_contrato', '_haber_basico', '_categoria', '_nivel', '_horario', '_ambito_profesional', '_profesion', '_grado_academico'];
            campos_inp.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }
    </script>
@endsection
