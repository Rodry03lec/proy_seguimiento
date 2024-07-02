@extends('principal')
@section('titulo', '| ARCHIVADOS')
@section('contenido')
    @include('administrador.tramite.tipo_tramite')


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: {{ $titulo_menu }} :::::::: </h5>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_archivados" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ACCIÓN</th>
                        <th>Nº UNICO</th>
                        <th>CITE</th>
                        <th>DATOS ORIGEN</th>
                        <th>REMITE</th>
                        <th>DESTINATARIO</th>
                        <th>FECHA</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let id_user_cargo = {{ $cargo_enum->id }};

        async function listar_para_recivir() {

            let respuesta = await fetch("{{ route('tcar_archivados_listar') }}", {
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
            $('#tabla_archivados').DataTable({
                responsive: true,
                data: dato,
                columns: [{
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                    <div class="d-inline-block tex-nowrap">
                                        <div class="demo-inline-spacing">
                                            <button type="button" onclick="reanudar_tramite('${row.id}',${row.tramite_id})" class="btn btn-icon rounded-pill btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="REANUDAR TRAMITE">
                                                <i class="tf-icons ti ti-arrow-right"></i>
                                            </button>
                                            <button type="button" onclick="ver_tramite('${row.tramite_id}')" class="btn btn-icon rounded-pill btn-outline-vimeo" data-placement="top" title="VIZUALIZAR">
                                                <i class="tf-icons ti ti ti-eye"></i>
                                            </button>
                                            <button type="button" onclick="vertramite_pdf('${row.tramite.id}')" class="btn btn-icon rounded-pill btn-outline-danger" data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF">
                                            <i class="tf-icons ti ti-clipboard"></i>
                                        </button>
                                        </div>
                                    </div>
                                `;
                        }
                    },
                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            let tipo_prioridad = "";
                            switch (row.tramite.id_tipo_prioridad) {
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

                            if (data.ruta_archivado != null) {
                                return `
                                        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                            <div class="text-center">
                                                ${row.tramite.numero_unico}
                                            </div>
                                            <div class="demo-inline-spacing text-center mb-2">
                                                <span class="badge rounded-pill ${tipo_prioridad} bg-glow">${row.tramite.tipo_prioridad.nombre}</span>
                                            </div>
                                            <div class="demo-inline-spacing text-center mb-2">
                                                <span class="badge rounded-pill bg-danger bg-glow">ARCHIVADO</span>
                                            </div>
                                        </div>
                                    `;
                            } else {
                                return `
                                        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                            <div class="text-center">
                                                ${row.tramite.numero_unico}
                                            </div>
                                            <div class="demo-inline-spacing text-center mb-2">
                                                <span class="badge rounded-pill ${tipo_prioridad} bg-glow">${row.tramite.tipo_prioridad.nombre}</span>
                                            </div>
                                        </div>
                                    `;
                            }


                        },
                    },

                    {
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                        <div class="demo-inline-spacing text-center mb-2">
                                            <strong>${row.tramite.cite_texto}</strong>
                                        </div>
                                        <div class="text-center">
                                            ${row.tramite.tipo_tramite.nombre+' '+row.tramite.tipo_tramite.sigla}
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
                            if (row.tramite.remitente_nombre != null) {
                                nombre_remitente = row.tramite.remitente_nombre;
                            } else {
                                nombre_remitente =
                                    `${row.tramite.remitente_user.contrato.grado_academico.abreviatura} ${row.tramite.remitente_user.persona.nombres} ${row.tramite.remitente_user.persona.ap_paterno} ${row.tramite.remitente_user.persona.ap_materno}`;
                            }

                            let nombre_destinatario =
                                `${row.tramite.destinatario_user.contrato.grado_academico.abreviatura} ${row.tramite.destinatario_user.persona.nombres} ${row.tramite.destinatario_user.persona.ap_paterno} ${row.tramite.destinatario_user.persona.ap_materno}`;

                            return `
                                    <div class="d-flex flex-column" style="height: 100%;">
                                        <div class="demo-inline-spacing mb-2">
                                            <strong>Remitente: </strong>${nombre_remitente}
                                        </div>
                                        <div>
                                            <strong>Destinatario: </strong>${nombre_destinatario}
                                        </div>
                                        <div>
                                            <strong>Referencia: </strong>${row.tramite.referencia}
                                        </div>
                                        <div>
                                            <strong>Salida: </strong>${row.tramite.fecha_creada}
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

                            nombre_remitente =
                                `${row.remitente_user.contrato.grado_academico.abreviatura} ${row.remitente_user.persona.nombres} ${row.remitente_user.persona.ap_paterno} ${row.remitente_user.persona.ap_materno}`;

                            let cargo_remitente = '';
                            if (row.remitente_user.cargo_sm != null) {
                                cargo_remitente = row.remitente_user.cargo_sm.nombre;
                            } else {
                                cargo_remitente = row.remitente_user.cargo_mae.nombre;
                            }


                            return `
                                    <div class="d-flex flex-column" style="height: 100%;">
                                        <div class="demo-inline-spacing mb-2">
                                            <strong>Remitente: </strong>${nombre_remitente}
                                        </div>
                                        <div class="demo-inline-spacing mb-2">
                                            <strong>Remitente: </strong>${cargo_remitente}
                                        </div>
                                        <div>
                                            <strong>Salida: </strong>${row.tramite.fecha_creada}
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

                            nombre_destinatario =
                                `${row.destinatario_user.contrato.grado_academico.abreviatura} ${row.destinatario_user.persona.nombres} ${row.destinatario_user.persona.ap_paterno} ${row.destinatario_user.persona.ap_materno}`;

                            let cargo_destinatario = '';
                            if (row.destinatario_user.cargo_sm != null) {
                                cargo_destinatario = row.destinatario_user.cargo_sm.nombre;
                            } else {
                                cargo_destinatario = row.destinatario_user.cargo_mae.nombre;
                            }


                            return `
                                    <div class="d-flex flex-column" style="height: 100%;">

                                        <span class="badge bg-label-primary">${row.paso_txt}</span>

                                        <div class="demo-inline-spacing mb-2">
                                            <strong>Destinatario : </strong>${nombre_destinatario}
                                        </div>

                                        <div class="demo-inline-spacing mb-2">
                                            <strong>CARGO : </strong>${cargo_destinatario}
                                        </div>

                                        <div>
                                            <strong>INSTRUCTIVO:  </strong>${row.instructivo}
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
                                    <div class="d-flex flex-column" style="height: 100%;">
                                        <div>
                                            <strong>${row.tramite.fecha_creada}</strong>
                                        </div>
                                    </div>
                                `;
                        }
                    },

                ]
            });

        }
        listar_para_recivir();


        //funcion  de acctualizar tabla
        function actulizar_tabla() {
            $('#tabla_archivados').DataTable().destroy();
            listar_para_recivir();
            $('#tabla_archivados').fadeIn(200);
        }


        //PARA VER EL TRAMITE
        async function ver_tramite(id) {
            let detalles_correspondencia = document.getElementById('contenido_correspondencia');
            try {
                const response = await fetch("{{ route('corres_vizualizar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id
                    })
                });

                const data = await response.json();
                if (data.tipo === 'success') {
                    $('#modal_vizualizar').modal('show');

                    const remitente = data.tramite.remitente_nombre ||
                        `${data.tramite.remitente_user.contrato.grado_academico.abreviatura} ${data.tramite.remitente_user.persona.nombres} ${data.tramite.remitente_user.persona.ap_paterno} ${data.tramite.remitente_user.persona.ap_materno}`;

                    detalles_correspondencia.innerHTML = `
                <table>
                    <tr>
                        <th><strong>Nº </strong> </th>
                        <th>: ${data.tramite.numero_unico}/${new Date(data.tramite.fecha_creada).getFullYear()}</th>
                    </tr>
                    <tr>
                        <th><strong>REMITENTE </strong> </th>
                        <th>: ${remitente}</th>
                    </tr>
                    <tr>
                        <th><strong>DESTINATARIO </strong> </th>
                        <th>: ${data.tramite.destinatario_user.contrato.grado_academico.abreviatura} ${data.tramite.destinatario_user.persona.nombres} ${data.tramite.destinatario_user.persona.ap_paterno} ${data.tramite.destinatario_user.persona.ap_materno}</th>
                    </tr>
                    <tr>
                        <th><strong>REFERENCIA </strong> </th>
                        <th>: ${data.tramite.referencia}</th>
                    </tr>
                    <tr>
                        <th><strong>SALIDA </strong> </th>
                        <th>: ${data.tramite.fecha_hora_creada}</th>
                    </tr>
                    <tr>
                        <th><strong>US. CREADO </strong> </th>
                        <th>: ${data.tramite.user_cargo_tramite.contrato.grado_academico.abreviatura} ${data.tramite.user_cargo_tramite.persona.nombres} ${data.tramite.user_cargo_tramite.persona.ap_paterno} ${data.tramite.user_cargo_tramite.persona.ap_materno}</th>
                    </tr>
                </table>
            `;
                    listar_hojas_ruta(data.tramite.id);
                } else {
                    alerta_top(data.tipo, data.mensaje);
                    detalles_correspondencia.innerHTML = '';
                }
            } catch (error) {
                console.error('Error:', error);
                detalles_correspondencia.innerHTML = '';
            }
        }

        //PARA LISTAR LAS HOJAS DE RUTA
        async function listar_hojas_ruta(id_tramite) {
            try {
                const response = await fetch("{{ route('corres_lis_ruta') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id: id_tramite
                    })
                });

                const data = await response.json();
                const cuerpo = data.map((item, index) => {
                    const estado = item.estado_id === 2 ?
                        `<td class="font-size-10"><span class="${item.estado_tipo.color}">${item.estado_tipo.nombre}</span></td>` :
                        `<td class="font-size-10">${item.fecha_ingreso}</td>`;

                    const destinatario =
                        `${item.destinatario_user.contrato.grado_academico.abreviatura} ${item.destinatario_user.persona.nombres} ${item.destinatario_user.persona.ap_paterno} ${item.destinatario_user.persona.ap_materno}`;

                    const cargo = item.destinatario_user.cargo_sm ? item.destinatario_user.cargo_sm.nombre :
                        item.destinatario_user.cargo_mae.nombre;
                    const unidad = item.destinatario_user.cargo_sm ?
                        `${item.destinatario_user.cargo_sm.direccion.nombre}<br>${item.destinatario_user.cargo_sm.unidades_admnistrativas.nombre}` :
                        item.destinatario_user.cargo_mae.unidad_mae.descripcion;

                    return `
                <tr>
                    <td>${index + 1}</td>
                    ${estado}
                    <td class="font-size-10">${item.fecha_salida}</td>
                    <td class="font-size-10">${unidad}</td>
                    <td class="font-size-10">${cargo}</td>
                    <td class="font-size-10">${destinatario}</td>
                    <td class="font-size-10">${item.instructivo}</td>
                </tr>`;
                }).join('');

                document.getElementById('listar_hojas_ruta').innerHTML = cuerpo;

                const archivadoResp = data.find(item => item.ruta_archivado);
                document.getElementById('contenido_txt').innerHTML = archivadoResp ?
                    `<div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">${archivadoResp.ruta_archivado.descripcion}</div>` :
                    '';
            } catch (error) {
                console.error('Error:', error);
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
    </script>
@endsection
