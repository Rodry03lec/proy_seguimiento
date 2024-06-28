@extends('principal')
@section('titulo', 'BUSCAR TRAMITE')

@section('estilos')
    <style>
        .table-td {
            font-size: 9px;
        }
        table, tr, td {
            font-size: 12px; /* Ajusta el tamaño de la fuente */
        }
    </style>
@endsection
@section('contenido')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">::::::::  Búsqueda de Trámites ::::::::  </h5>
        </div>
    </div>

    <div class="row g-4 py-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form_buscar_tramite" class="row" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3">
                                <label class="form-label" for="numero_tramite">Nº Trámite</label>
                                <input type="text" id="numero_tramite" name="numero_tramite" placeholder="Ingrese el número de trámite" class="form-control uppercase-input" onkeypress="return soloNumeros(event)" autofocus />
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 d-flex justify-content-center">
                                <label class="form-label" for="chek_tramite"></label>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="chek_tramite" onclick="check_tramite()" />
                                    <label class="form-check-label" for="chek_tramite">
                                        Trámite Externo
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-3" id="remitente_interno_txt">
                                <label class="form-label" for="remitente_interno">Seleccione Remitente</label>
                                <select name="remitente_interno" id="remitente_interno" class="select2">
                                    <option value="0" disabled selected>[ SELECCIONE UNA PERSONA ]</option>
                                    @foreach ($cargo_persona as $lis)
                                        @php
                                            $cargo_persona = $lis->cargo_sm ? $lis->cargo_sm->nombre : $lis->cargo_mae->nombre;
                                        @endphp
                                        <option value="{{ $lis->id }}">{{ $lis->contrato->grado_academico->abreviatura . ' ' . $lis->persona->nombres . ' ' . $lis->persona->ap_paterno . ' ' . $lis->persona->ap_materno . ' [' . $cargo_persona . ']' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-3" id="remitente_externo_txt" style="display: none;">
                                <label class="form-label" for="remitente_externo">Ingrese el Remitente</label>
                                <input type="text" id="remitente_externo" name="remitente_externo" class="form-control uppercase-input" placeholder="Ingrese el remitente" autofocus />
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <label class="form-label" for="referencia">Referencia</label>
                                <input type="text" id="referencia" name="referencia" class="form-control uppercase-input" placeholder="Ingrese la referencia" autofocus />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 col-lg-6 mx-auto">
                        <button class="btn btn-primary btn-md" id="btn_buscar_tramite" type="button">Buscar Trámite</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4" id="listar_tramites_solicitados"></div>


    <!-- vizualizar de tramite -->
    <div class="modal fade" id="modal_vizualizar" aria-hidden="true" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content modal-xl">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">VIZUALIZAR RUTA</h3>
                    </div>

                    <div class="alert alert-primary alert-dismissible d-flex align-items-baseline" role="alert">
                        <span class="alert-icon alert-icon-lg text-primary me-2">
                            <i class="ti ti-layout ti-sm"></i>
                        </span>
                        <div id="contenido_correspondencia">

                        </div>
                    </div>

                    <div class="table-responsive text-nowrap p-3">
                        <table class="table table-hover" style="width: 100%">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nº</th>
                                    <th>FECHA<br>INGRESO</th>
                                    <th>FECHA<br>SALIDA</th>
                                    <th>UNIDAD</th>
                                    <th>CARGO</th>
                                    <th>FUNCIONARIO</th>
                                    <th>INSTRUCTIVO</th>
                                </tr>
                            </thead>
                            <tbody id="listar_hojas_ruta">

                            </tbody>
                        </table>
                    </div>

                    <div id="contenido_txt" class="py-2">

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ vizualizar tramite -->

@endsection
@section('scripts')
    <script>
        document.getElementById('btn_buscar_tramite').addEventListener('click', async () => {
            let formData = new FormData();
            let numero_tramite = document.getElementById('numero_tramite').value;
            let remitente_interno = document.getElementById('remitente_interno').value;
            let remitente_externo = document.getElementById('remitente_externo').value;
            let referencia = document.getElementById('referencia').value;

            if (numero_tramite !== '' || remitente_interno !== '' || referencia !== '') {
                formData.append('numero_tramite', numero_tramite);
                formData.append('remitente_interno', remitente_interno);
                formData.append('remitente_externo', remitente_externo);
                formData.append('referencia', referencia);

                let respuesta = await fetch("{{ route('cobus_vizualizar_tramite') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                if (respuesta.ok) {
                    let data = await respuesta.text();
                    document.getElementById('listar_tramites_solicitados').innerHTML = data;
                } else {
                    console.error('Error en la solicitud', respuesta.status);
                    document.getElementById('listar_tramites_solicitados').innerHTML = '';
                }
            }
        });

        function check_tramite() {
            let checkbox = document.getElementById("chek_tramite");
            let remitente_interno_txt = document.getElementById('remitente_interno_txt');
            let remitente_externo_txt = document.getElementById('remitente_externo_txt');

            if (checkbox.checked) {
                remitente_interno_txt.style.display     = 'none';
                remitente_externo_txt.style.display     = 'block';
                $('#remitente_interno').val('0').trigger('change');
            } else {
                remitente_interno_txt.style.display                 = 'block';
                remitente_externo_txt.style.display                 = 'none';
                document.getElementById('remitente_externo').value  = '';
            }
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
                    if(dato.tramite.remitente_nombre != null){
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
                console.log(dato);
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


    </script>
@endsection
