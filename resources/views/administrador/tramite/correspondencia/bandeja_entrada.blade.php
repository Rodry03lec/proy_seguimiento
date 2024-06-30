@extends('principal')
@section('titulo', '| BANDEJA DE ENTRADA')
@section('estilos')
<style>
    .table-td {/* Evita el ajuste de línea */
        font-size: 9px;
    }
</style>
@endsection
@section('contenido')
    @include('administrador.tramite.tipo_tramite')


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: {{ $titulo_menu }} :::::::: </h5>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_bandeja_entrada" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th class="text-nowrap" >ACCIÓN</th>
                        <th class="text-nowrap" >Nº UNICO</th>
                        <th class="text-nowrap" >CITE</th>
                        <th class="text-nowrap" >DATOS ORIGEN</th>
                        <th class="text-nowrap" >REMITE</th>
                        <th class="text-nowrap" >DESTINATARIO</th>
                        <th class="text-nowrap" >FECHA</th>
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

            let respuesta = await fetch("{{ route('tcar_bandeja_entrada_listar') }}", {
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
            $('#tabla_bandeja_entrada').DataTable({
                responsive: true,
                data: dato,
                columns: [{
                        data: null,
                        className: 'table-td',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-inline-block tex-nowrap">
                                    <div class="demo-inline-spacing">
                                        <button type="button" onclick="recibir_tramite('${row.id}',${row.tramite_id})" class="btn btn-icon rounded-pill btn-outline-warning" data-toggle="tooltip" data-placement="top" title="RECIBIR">
                                            <i class="tf-icons ti ti-arrow-down"></i>
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
                                nombre_remitente = `${row.tramite.remitente_user.contrato.grado_academico.abreviatura} ${row.tramite.remitente_user.persona.nombres} ${row.tramite.remitente_user.persona.ap_paterno} ${row.tramite.remitente_user.persona.ap_materno}`;
                            }

                            let nombre_destinatario = `${row.tramite.destinatario_user.contrato.grado_academico.abreviatura} ${row.tramite.destinatario_user.persona.nombres} ${row.tramite.destinatario_user.persona.ap_paterno} ${row.tramite.destinatario_user.persona.ap_materno}`;

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

                            nombre_remitente = `${row.remitente_user.contrato.grado_academico.abreviatura} ${row.remitente_user.persona.nombres} ${row.remitente_user.persona.ap_paterno} ${row.remitente_user.persona.ap_materno}`;

                            let cargo_remitente = '';
                            if(row.remitente_user.cargo_sm != null){
                                cargo_remitente = row.remitente_user.cargo_sm.nombre;
                            }else{
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

                            nombre_destinatario = `${row.destinatario_user.contrato.grado_academico.abreviatura} ${row.destinatario_user.persona.nombres} ${row.destinatario_user.persona.ap_paterno} ${row.destinatario_user.persona.ap_materno}`;

                            let cargo_destinatario = '';
                            if(row.destinatario_user.cargo_sm != null){
                                cargo_destinatario = row.destinatario_user.cargo_sm.nombre;
                            }else{
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
            $('#tabla_bandeja_entrada').DataTable().destroy();
            listar_para_recivir();
            $('#tabla_bandeja_entrada').fadeIn(200);
        }


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
                        if(datos[key]['estado_id'] === 2){
                            cuerpo += "<td class=\"font-size-10\">" + " </br><span class=\"" + datos[key]['estado_tipo']['color'] + "\">" + datos[key]['estado_tipo']['nombre'] + "</span> </td>";
                        } else {
                            cuerpo += "<td class=\"font-size-10\">" + datos[key]['fecha_ingreso'] + "</td>";
                        }

                        cuerpo += "<td class=\"font-size-10\">" + datos[key]['fecha_salida'] + "</td>";

                        let cargo_ajustar = '';
                        let unidad_direccion = '';
                        let destinatario_usuario = '';

                        if(datos[key]['destinatario_user']['cargo_sm'] != null){
                            cargo_ajustar = datos[key]['destinatario_user']['cargo_sm']['nombre'];
                            unidad_direccion = datos[key]['destinatario_user']['cargo_sm']['direccion']['nombre'] + '</br>' + datos[key]['destinatario_user']['cargo_sm']['unidades_admnistrativas']['nombre'];
                        } else {
                            cargo_ajustar = datos[key]['destinatario_user']['cargo_mae']['nombre'];
                            unidad_direccion = datos[key]['destinatario_user']['cargo_mae']['unidad_mae']['descripcion'];
                        }

                        destinatario_usuario = datos[key]['destinatario_user']['contrato']['grado_academico']['abreviatura'] + ' ' + datos[key]['destinatario_user']['persona']['nombres'] + ' ' + datos[key]['destinatario_user']['persona']['ap_paterno'] + ' ' + datos[key]['destinatario_user']['persona']['ap_materno'];

                        cuerpo += "<td class=\"font-size-10\">" + unidad_direccion + "</td>";
                        cuerpo += "<td class=\"font-size-10\">" + cargo_ajustar + "</td>";
                        cuerpo += "<td class=\"font-size-10\">" + destinatario_usuario + "</td>";
                        cuerpo += "<td class=\"font-size-10\">" + datos[key]['instructivo'] + "</td>";
                        cuerpo += '</tr>';

                        if(datos[key]['ruta_archivado'] != null){
                            archivado_resp = datos[key]['ruta_archivado']['descripcion'];
                        }
                    }


                    document.getElementById('listar_hojas_ruta').innerHTML = cuerpo;

                    if(archivado_resp != null && archivado_resp != ''){
                        document.getElementById('contenido_txt').innerHTML = `
                            <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
                                `+archivado_resp+`
                            </div>
                        `;
                    }


            } catch (error) {
                console.log('error : '+error);
            }
        }

        //PARA RECIBIR EL TRAMITE
        async function recibir_tramite(id_ruta, id_tramite) {
            Swal.fire({
                title: "¿Estás seguro de recibir?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, recibir",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let respuesta = await fetch("{{ route('tcar_bandeja_entrada_recibir') }}",{
                            method: "POST",
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                id_ruta     : id_ruta,
                                id_tramite  : id_tramite,
                            })
                        });
                        let dato = await respuesta.json();
                        if(dato.tipo === 'success'){
                            //destruimos la tabla
                            actulizar_tabla();
                            //mostrando la alerta
                            alerta_top(dato.tipo, dato.mensaje);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
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


        //PARA LA IMPRESION DEL PDF DE LA HOJA DE RUTA
        async function vertramite_pdf(id_tramite){
            try {
                let respuesta = await fetch("{{ route('enc_crypt') }}",{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id_tramite})
                });
                let dato = await respuesta.json();
                alerta_top_end('success', 'Abriendo pdf con éxito, espere un momento!');
                setTimeout(() => {
                    let url_permiso = "{{ route('crt_reporte_tramite', ['id' => ':id']) }}";
                    url_permiso     = url_permiso.replace(':id', dato.mensaje);
                    window.open(url_permiso, '_blank');
                }, 2000);
            } catch (error) {
                console.log('error : ' +error);
            }
        }

    </script>
@endsection
