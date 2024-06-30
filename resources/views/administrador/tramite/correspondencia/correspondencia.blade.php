@extends('principal')
@section('titulo', '| CORRESPONDENCIA')
@section('estilos')
    <style>
        .table-td {
            font-size: 12px;
        }
    </style>
@endsection

@section('contenido')
    @include('administrador.tramite.tipo_tramite')


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: {{ $titulo_menu }} :::::::: </h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_tramite">
                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
            </button>
        </div>

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_tramite" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ACCIONES</th>
                        <th>Nº UNICO <br> ESTADO</th>
                        <th>CITE</th>
                        <th>DATOS ORIGEN</th>
                        <th>PRIMER DESTINATARIO</th>
                        <th>FECHA</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Add tipo de tramite -->
    <div class="modal fade" id="modal_nuevo_tramite" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cerrar_modal_correspondencia()"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Nueva Correspondencia</h3>
                    </div>
                    <form id="formulario_nuevo_tramite" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="tipo_tramite">Tipo trámite</label>
                                <select name="tipo_tramite" id="tipo_tramite" class="select2"
                                    onchange="tipo_tramite_validar(this.value)">
                                    <option disabled selected value="0">[SELECCIONE TIPO DE TRAMITE]</option>
                                    @foreach ($tipo_tramite as $lis)
                                        <option value="{{ $lis->id }}">{{ '[' . $lis->sigla . '] ' . $lis->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="_tipo_tramite"></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-3">
                                <label class="form-label" for="numero_hojas">Número de hojas</label>
                                <input type="text" class="form-control" name="numero_hojas" id="numero_hojas"
                                    placeholder="Ingrese la cantidad de hojas" onkeypress="return soloNumeros(event)">
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-3">
                                <label class="form-label" for="numero_anexos">Número de anexos</label>
                                <input type="text" class="form-control" name="numero_anexos" id="numero_anexos"
                                    placeholder="Ingrese el número de anexos" onkeypress="return soloNumeros(event)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="cite">Cite</label>
                                <input type="text" class="form-control" name="cite" id="cite"
                                    placeholder="Ingrese el cite">
                                <div id="_cite"></div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="cite_numero">Nº</label>
                                <input type="text" class="form-control" value="{{ date('m') }}" name="cite_numero"
                                    id="cite_numero" placeholder="Ingrese el cite">
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="gestion">Gestión</label>
                                <input type="text" class="form-control" readonly name="gestion" id="gestion"
                                    value="{{ date('Y') }}" placeholder="Ingrese la gestión">
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="prioridad">Prioridad</label>
                                <select name="prioridad" id="prioridad" class="select2">
                                    <option disabled selected value="0">[SELECCIONE PRIORIDAD]</option>
                                    @foreach ($tipo_prioridad as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                    @endforeach
                                </select>
                                <div id="_prioridad"></div>
                            </div>
                        </div>

                        <div class="row">
                            <input type="hidden" value="{{ $cargo_enum->id }}" name="id_remitente" id="id_remitente">
                            <div id="valor_general">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label" for="remitente">Remitente</label>
                                    <input type="text" class="form-control" name="remitente" readonly
                                        value="@if ($cargo_enum->cargo_sm != null) {{ ' [ ' . $cargo_enum->cargo_sm->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @else {{ ' [ ' . $cargo_enum->cargo_mae->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @endif"
                                        id="remitente" placeholder="Ingrese el nombre del remitente">
                                </div>
                            </div>

                            <div id="valor_dos"></div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <label class="form-label" for="referencia">Referencia</label>
                                <input type="text" class="form-control uppercase-input" name="referencia" id="referencia"
                                    placeholder="Ingrese la referencia">
                                <div id="_referencia"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <label class="form-label" for="destinatario">Destinatario</label>
                                <select name="destinatario" id="destinatario" class="select2">
                                    <option disabled selected value="0">[SELECCIONE DESTINATARIO]</option>
                                    @foreach ($destinatario_ti as $lis)
                                        <option value="{{ $lis->id }}">
                                            @if ($lis->cargo_sm != null)
                                                {{ ' [ ' . $lis->cargo_sm->nombre . ' ] ' . $lis->persona->nombres . ' ' . $lis->persona->ap_paterno . ' ' . $lis->persona->ap_materno }}
                                            @else
                                                {{ ' [ ' . $lis->cargo_mae->nombre . ' ] ' . $lis->persona->nombres . ' ' . $lis->persona->ap_paterno . ' ' . $lis->persona->ap_materno }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div id="_destinatario"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <label class="form-label" for="instructivo">Instructivo</label>
                                <input type="text" class="form-control uppercase-input" name="instructivo" id="instructivo"
                                    placeholder="Ingrese el instructivo">
                                <div id="_instructivo"></div>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button id="btn_guardar_tramite" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close" onclick="cerrar_modal_correspondencia()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add tipo de tramite -->



@endsection

@section('scripts')
    <script>


        // Función para actualizar el contenido del contenedor
        function actualizarTipoTramite(contenido) {
            document.getElementById('tipo_tramite_container').innerHTML = contenido;
        }

        //para el cargo con el cula esta
        let id_user_cargo = {{ $cargo_enum->id }};
        //para declarar variables
        let valor_general = document.getElementById('valor_general');
        let valor_dos = document.getElementById('valor_dos');
        let para_cite = document.getElementById('cite');
        // para la validación de los tipos de trámite
        async function tipo_tramite_validar(id) {
            if (id != 0) {
                if (id == 2) {
                    valor_dos.innerHTML = `
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label class="form-label" for="remitente_txt">Remitente</label>
                            <input type="text" class="form-control uppercase-input" name="remitente_txt" id="remitente_txt" placeholder="Ingrese el nombre del remitente">
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label class="form-label" for="cargo_txt">Cargo del Remitente</label>
                            <input type="text" class="form-control uppercase-input" name="cargo_txt" id="cargo_txt" placeholder="Ingrese el cargo del remitente">
                        </div>
                    `;
                    valor_general.innerHTML = ``;
                } else {
                    valor_general.innerHTML = `
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label class="form-label" for="remitente">Remitente</label>
                            <input type="text" class="form-control" name="remitente" readonly value="@if ($cargo_enum->cargo_sm != null) {{ ' [ ' . $cargo_enum->cargo_sm->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @else {{ ' [ ' . $cargo_enum->cargo_mae->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @endif" id="remitente" placeholder="Ingrese el nombre del remitente">
                        </div>
                    `;
                    valor_dos.innerHTML = ``;
                }

                try {
                    let respuesta = await fetch("{{ route('corres_tipo_sigla') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            id: id,
                            id_user_cargo: id_user_cargo
                        })
                    });
                    let dato = await respuesta.json();
                    if (dato.tipo === 'success') {
                        let para_cite_value;
                        if (dato.user_cargo_tram.cargo_sm != null) {
                            para_cite_value = 'GAMH/' + dato.cargo_normal + '/' + dato.tipo_tramite.sigla;
                        } else {
                            para_cite_value = 'GAMH/' + dato.cargo_normal + '/' + dato.tipo_tramite.sigla;
                        }
                        para_cite.value = para_cite_value;
                    }
                    if (dato.tipo === 'error') {
                        alerta_top(dato.tipo, dato.mensaje);
                    }
                } catch (error) {
                    console.log('Error de datos : ' + error);
                }
            } else {
                console.log('Ocurrio un error DXDIAG');
            }
        }



        //para cerrar el modal y vaciar los datos
        function cerrar_modal_correspondencia() {
            $('#modal_nuevo_tramite').modal('hide');
            vaciar_formulario_correspondencia_nuevo();
        }

        //funcion para vaciar los datos del formulario
        function vaciar_formulario_correspondencia_nuevo() {
            let valores = ['numero_hojas', 'numero_anexos', 'referencia', 'instructivo'];
            valores.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            vaciar_select2();
            vaciar_errores_formulario_tramite();
        }

        //para los select2
        function vaciar_select2() {
            $("#tipo_tramite").val(0).trigger('change');
            $("#prioridad").val(0).trigger('change');
            $("#destinatario").val(0).trigger('change');

            valor_general.innerHTML = `
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                    <label class="form-label" for="remitente">Remitente</label>
                    <input type="text" class="form-control" name="remitente" readonly value="@if ($cargo_enum->cargo_sm != null) {{ ' [ ' . $cargo_enum->cargo_sm->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @else {{ ' [ ' . $cargo_enum->cargo_mae->nombre . ' ] ' . $cargo_enum->persona->nombres . ' ' . $cargo_enum->persona->ap_paterno . ' ' . $cargo_enum->persona->ap_materno }} @endif" id="remitente" placeholder="Ingrese el nombre del remitente">
                </div>
            `;
            valor_dos.innerHTML = ``;

            //para vaciar los campos
            let remitente_txt_cm = document.getElementById('remitente_txt');
            let cargo_txt_cm = document.getElementById('cargo_txt');

            if (remitente_txt_cm) {
                remitente_txt_cm.value = '';
            }
            if (cargo_txt_cm) {
                cargo_txt_cm.value = '';
            }
        }

        //para vaciar los formularios
        function vaciar_errores_formulario_tramite() {
            let datos = ['_tipo_tramite', '_cite', '_prioridad', '_referencia', '_destinatario', '_instructivo'];
            datos.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }


        //PARA GUARDAR EL REGISTRO DE NUEVO TRAMITE
        let form_tramite_new = document.getElementById('formulario_nuevo_tramite');
        let btn_tramite_new = document.getElementById('btn_guardar_tramite');
        btn_tramite_new.addEventListener('click', async () => {
            let datos = Object.fromEntries(new FormData(form_tramite_new).entries());
            vaciar_errores_formulario_tramite();
            try {
                let respuesta = await fetch("{{ route('corres_nuevo') }}", {
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
                    actulizar_tabla();
                    cerrar_modal_correspondencia();
                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                }
            } catch (error) {
                console.log('error : ' + error);
            }
        });

        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_tramite').DataTable().destroy();
            listar_tramites();
            $('#tabla_tramite').fadeIn(200);
        }


        //PARA LISTAR TODOS LOS TRAMITES QUE REALIZO LA PERSONA
        async function listar_tramites() {
            let respuesta = await fetch("{{ route('corres_listar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    id: id_user_cargo
                })
            });
            let dato = await respuesta.json();
            let i = 1;
            $('#tabla_tramite').DataTable({
                responsive: true,
                data: dato,
                columns: [{
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            if(data.id_estado === 5){
                                /* return `
                                    <div class="d-inline-block tex-nowrap">
                                        <div class="demo-inline-spacing">
                                            <button type="button" onclick="reanudar_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-outline-primary" data-toggle="tooltip" data-placement="top" title="REANUDAR TRAMITE">
                                                <i class="tf-icons ti ti-help"></i>
                                            </button>
                                        </div>
                                    </div>
                                `; */
                                return `
                                    <div class="d-inline-block tex-nowrap">
                                        <div class="demo-inline-spacing">
                                            <span class="badge rounded-pill bg-danger bg-glow">ELIMINADO</span>
                                        </div>
                                    </div>
                                `;
                            }else{
                                if(data.hojas_ruta_count <= 1){
                                    return `
                                    <div class="d-inline-block tex-nowrap">
                                        <div class="demo-inline-spacing">
                                            <button type="button" onclick="editar_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-outline-success" data-toggle="tooltip" data-placement="top" title="EDITAR">
                                                <i class="tf-icons ti ti-edit"></i>
                                            </button>
                                            <button type="button" onclick="anular_envio('${row.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-toggle="tooltip" data-placement="top" title="ANULAR ENVIO">
                                                <i class="tf-icons ti ti-trash"></i>
                                            </button>
                                            <button type="button" onclick="ver_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-outline-vimeo" data-placement="top" title="VIZUALIZAR">
                                                <i class="tf-icons ti ti ti-eye"></i>
                                            </button>
                                            <button type="button" onclick="vertramite_pdf('${row.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF">
                                                <i class="tf-icons ti ti-clipboard"></i>
                                            </button>
                                        </div>
                                    </div>
                                    `;
                                }else{
                                    return `
                                        <div class="d-inline-block tex-nowrap">
                                            <div class="demo-inline-spacing">
                                                <button type="button" onclick="ver_tramite('${row.id}')" class="btn btn-icon rounded-pill btn-outline-vimeo" data-placement="top" title="VIZUALIZAR">
                                                    <i class="tf-icons ti ti ti-eye"></i>
                                                </button>
                                                <button type="button" onclick="vertramite_pdf('${row.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF">
                                                    <i class="tf-icons ti ti-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                    `;
                                }
                            }


                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            let tipo_prioridad = "";
                            switch (row.id_tipo_prioridad) {
                                case 1:
                                    tipo_prioridad = 'bg-danger';
                                    break;
                                case 2:
                                    tipo_prioridad = 'bg-warning';
                                    break;
                                case 3:
                                    tipo_prioridad = 'bg-info';
                                    break;
                                case 4:
                                    tipo_prioridad = 'bg-dark ';
                                    break;
                                default:
                                    tipo_prioridad = 'bg-primary';
                                    break;
                            }

                            return `
                                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                    <div class="demo-inline-spacing text-center mb-2">
                                        <span class="badge rounded-pill ${tipo_prioridad} bg-glow">${row.tipo_prioridad.nombre}</span>
                                    </div>
                                    <div class="text-center">
                                        ${row.numero_unico}
                                    </div>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                    <div class="demo-inline-spacing text-center mb-2">
                                        <strong>${row.cite_texto}</strong>
                                    </div>
                                    <div class="text-center">
                                        ${row.tipo_tramite.nombre+' '+row.tipo_tramite.sigla}
                                    </div>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            let nombre_remitente = '';
                            if (row.remitente_nombre != null) {
                                nombre_remitente = row.remitente_nombre;
                            } else {
                                nombre_remitente = row.remitente_user.contrato.grado_academico
                                    .abreviatura + ' ' + row.remitente_user.persona.nombres + ' ' + row
                                    .remitente_user.persona.ap_paterno + ' ' + row.remitente_user
                                    .persona.ap_materno;
                            }

                            let nombre_destinatario = row.destinatario_user.contrato.grado_academico
                                .abreviatura + ' ' + row.destinatario_user.persona.nombres + ' ' + row
                                .destinatario_user.persona.ap_paterno + ' ' +
                                row.destinatario_user.persona.ap_materno;

                            return `
                                <div class="d-flex flex-column " style="height: 100%;">
                                    <div class="demo-inline-spacing mb-2">
                                        <strong>Remitente : </strong>${nombre_remitente}
                                    </div>
                                    <div>
                                        <strong>Destinatario : </strong>${nombre_destinatario}
                                    </div>
                                    <div>
                                        <strong>Referencia : </strong> ${row.referencia}
                                    </div>
                                    <div>
                                        <strong>Salida : </strong> ${row.fecha_creada}
                                    </div>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            let nombre_destinatario = '';
                            if (row.destinatario_user && row.destinatario_user.contrato && row
                                .destinatario_user.contrato.grado_academico && row.destinatario_user
                                .persona) {
                                nombre_destinatario = row.destinatario_user.contrato.grado_academico
                                    .abreviatura + ' ' + row.destinatario_user.persona.nombres + ' ' +
                                    row.destinatario_user.persona.ap_paterno + ' ' + row
                                    .destinatario_user.persona.ap_materno;
                            }

                            let cargo_destinatario = '';
                            if (row.destinatario_user && row.destinatario_user.cargo_sm) {
                                cargo_destinatario = row.destinatario_user.cargo_sm.nombre;
                            } else if (row.destinatario_user && row.destinatario_user.cargo_mae) {
                                cargo_destinatario = row.destinatario_user.cargo_mae.nombre;
                            }

                            return `
                                <div class="d-flex flex-column" style="height: 100%;">
                                    <div>
                                        <strong>Destinatario : </strong>${nombre_destinatario}
                                    </div>
                                    <div style="font-size: 9px" >
                                        <strong>Cargo : </strong>${cargo_destinatario}
                                    </div>
                                </div>
                            `;
                        }
                    },


                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {

                            return `
                                <div class="d-flex flex-column " style="height: 100%;">
                                    <div>
                                        <strong>${row.fecha_hora_creada}</strong>
                                    </div>
                                </div>
                            `;
                        }
                    },
                ]
            });
        }
        listar_tramites();


        //para vizualizar un tramite en donde va con un modal solo ver
        async function ver_tramite(id) {
            let detalles_correspondencia = document.getElementById('contenido_correspondencia');
            try {
                let respuesta = await fetch("{{ route('corres_vizualizar') }}", {
                    method: 'POST',
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
                    $('#modal_vizualizar').modal('show');
                    let remitente_txt = "";
                    if(dato.tramite.remitente_nombre != null && dato.tramite.remitente_nombre != ""){
                        remitente_txt = dato.tramite.remitente_nombre;
                    }else{
                        remitente_txt = dato.tramite.remitente_user.contrato.grado_academico.abreviatura+' '+dato.tramite.remitente_user.persona.nombres+' '+dato.tramite.remitente_user.persona.ap_paterno+' '+dato.tramite.remitente_user.persona.ap_materno;
                    }
                    detalles_correspondencia.innerHTML = `
                        <table>
                            <tr>
                                <th><strong>Nº </strong> </th>
                                <th>: ${dato.tramite.numero_unico}/${new Date(dato.tramite.fecha_creada).getFullYear()}</th>
                            </tr>

                            <tr>
                                <th><strong>REMITENTE </strong> </th>
                                <th>: ${remitente_txt}</th>
                            </tr>

                            <tr>
                                <th><strong>DESTINATARIO </strong> </th>
                                <th>: ${dato.tramite.destinatario_user.contrato.grado_academico.abreviatura+' '+dato.tramite.destinatario_user.persona.nombres+' '+dato.tramite.destinatario_user.persona.ap_paterno+' '+dato.tramite.destinatario_user.persona.ap_materno}</th>
                            </tr>

                            <tr>
                                <th><strong>REFERENCIA </strong> </th>
                                <th>: ${dato.tramite.referencia}</th>
                            </tr>

                            <tr>
                                <th><strong>SALIDA </strong> </th>
                                <th>: ${dato.tramite.fecha_hora_creada}</th>
                            </tr>

                            <tr>
                                <th><strong>US. CREADO </strong> </th>
                                <th>:
                                    ${dato.tramite.user_cargo_tramite.contrato.grado_academico.abreviatura+' '+dato.tramite.user_cargo_tramite.persona.nombres+' '+dato.tramite.user_cargo_tramite.persona.ap_paterno+' '+dato.tramite.user_cargo_tramite.persona.ap_materno}
                                </th>
                            </tr>
                        </table>
                    `;

                    listar_hojas_ruta(dato.tramite.id);

                }
                if (dato.tipo === 'error') {
                    alerta_top(dato.tipo, dato.mensaje);
                    detalles_correspondencia.innerHTML = ``;
                }
            } catch (error) {
                console.log('error : ' + error);
                detalles_correspondencia.innerHTML = ``;
            }
        }

        //para imprimir la vista de las hojas de ruta
        async function listar_hojas_ruta(id_tramite) {
            try {
                let respuesta = await fetch("{{ route('corres_lis_ruta') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        id: id_tramite
                    })
                });
                let dato = await respuesta.json();
                let datos = dato;
                let cuerpo = "";
                let i = 1;

                let archivado_resp = '';

                for (let key in datos) {
                    cuerpo += '<tr>';
                    cuerpo += "<td>" + i++ + "</td>";
                    if (datos[key]['estado_id'] === 2) {
                        cuerpo += "<td class=\"font-size-10\">" + " </br><span class=\"" + datos[key]['estado_tipo'][
                            'color'
                        ] + "\">" + datos[key]['estado_tipo']['nombre'] + "</span> </td>";
                    } else {
                        cuerpo += "<td class=\"font-size-10\">" + datos[key]['fecha_ingreso'] + "</td>";
                    }

                    cuerpo += "<td class=\"font-size-10\">" + datos[key]['fecha_salida'] + "</td>";

                    let cargo_ajustar = '';
                    let unidad_direccion = '';
                    let destinatario_usuario = '';

                    if (datos[key]['destinatario_user']['cargo_sm'] != null) {
                        cargo_ajustar = datos[key]['destinatario_user']['cargo_sm']['nombre'];
                        unidad_direccion = datos[key]['destinatario_user']['cargo_sm']['direccion']['nombre'] +
                            '</br>' + datos[key]['destinatario_user']['cargo_sm']['unidades_admnistrativas']['nombre'];
                    } else {
                        cargo_ajustar = datos[key]['destinatario_user']['cargo_mae']['nombre'];
                        unidad_direccion = datos[key]['destinatario_user']['cargo_mae']['unidad_mae']['descripcion'];
                    }

                    destinatario_usuario = datos[key]['destinatario_user']['contrato']['grado_academico'][
                        'abreviatura'] + ' ' + datos[key]['destinatario_user']['persona']['nombres'] + ' ' + datos[key][
                            'destinatario_user'
                        ]['persona']['ap_paterno'] + ' ' + datos[key]['destinatario_user']['persona']['ap_materno'];

                    cuerpo += "<td class=\"font-size-10\">" + unidad_direccion + "</td>";
                    cuerpo += "<td class=\"font-size-10\">" + cargo_ajustar + "</td>";
                    cuerpo += "<td class=\"font-size-10\">" + destinatario_usuario + "</td>";
                    cuerpo += "<td class=\"font-size-10\">" + datos[key]['instructivo'] + "</td>";
                    cuerpo += '</tr>';

                    if (datos[key]['ruta_archivado'] != null) {
                        archivado_resp = datos[key]['ruta_archivado']['descripcion'];
                    }
                }


                document.getElementById('listar_hojas_ruta').innerHTML = cuerpo;

                if (archivado_resp != null && archivado_resp != '') {
                    document.getElementById('contenido_txt').innerHTML = `
                        <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
                            ` + archivado_resp + `
                        </div>
                    `;
                } else {
                    document.getElementById('contenido_txt').innerHTML = '';
                }


            } catch (error) {
                console.log('error : ' + error);
            }
        }

        //PARA LA IMPRESION DEL PDF DE LA HOJA DE RUTA
        async function vertramite_pdf(id_tramite) {
            try {
                let respuesta = await fetch("{{ route('enc_crypt') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id: id_tramite
                    })
                });
                let dato = await respuesta.json();
                alerta_top_end('success', 'Abriendo pdf con éxito, espere un momento!');
                setTimeout(() => {
                    let url_permiso = "{{ route('crt_reporte_tramite', ['id' => ':id']) }}";
                    url_permiso = url_permiso.replace(':id', dato.mensaje);
                    window.open(url_permiso, '_blank');
                }, 2000);
            } catch (error) {
                console.log('error : ' + error);
            }
        }


        //PARA CANCELAR ENVIO
        function anular_envio(id_tramite){
            Swal.fire({
                title: "¿Estás seguro de anular el tramite?",
                text: "¡NOTA!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, anular",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('corres_lis_anular') }}", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                id: id_tramite
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


    </script>
@endsection
