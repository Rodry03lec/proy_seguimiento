<div class="col-12">
    <div class="card g-4 py-4">
        <div class="card-body">
            <div class="table-responsive text-nowrap p-4">
                <table class="table table-hover" id="tabla_tramite" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ACCIONES</th>
                            <th>Nº UNICO <br> ESTADO</th>
                            <th>CITE</th>
                            <th>DATOS ORIGEN</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listar_correspondencia as $tramite)
                            <tr>
                                <td>
                                    @if ($tramite->id_estado === 5)
                                        <div class="d-inline-block tex-nowrap">
                                            <div class="demo-inline-spacing">
                                                <span class="badge rounded-pill bg-danger bg-glow">ELIMINADO</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-inline-block tex-nowrap">
                                            <div class="demo-inline-spacing">
                                                <button type="button" onclick="ver_tramite('{{ $tramite->id }}')" class="btn btn-icon rounded-pill btn-outline-vimeo" data-placement="top" title="VIZUALIZAR">
                                                    <i class="tf-icons ti ti ti-eye"></i>
                                                </button>
                                                <button type="button" onclick="vertramite_pdf('{{ $tramite->id }}')" class="btn btn-icon rounded-pill btn-outline-danger" data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF">
                                                    <i class="tf-icons ti ti-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $tipo_prioridad = "";
                                        switch ($tramite->id_tipo_prioridad) {
                                            case 1:
                                                $tipo_prioridad = 'bg-danger';
                                                break;
                                            case 2:
                                                $tipo_prioridad = 'bg-warning';
                                                break;
                                            case 3:
                                                $tipo_prioridad = 'bg-info';
                                                break;
                                            case 4:
                                                $tipo_prioridad = 'bg-dark ';
                                                break;
                                            default:
                                                $tipo_prioridad = 'bg-primary';
                                                break;
                                        }
                                    @endphp

                                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                        <div class="demo-inline-spacing text-center mb-2">
                                            <span class="badge rounded-pill {{ $tipo_prioridad }} bg-glow">{{ $tramite->tipo_prioridad->nombre }}</span>
                                        </div>
                                        <div class="text-center">
                                            {{ $tramite->numero_unico }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                                        <div class="demo-inline-spacing text-center mb-2">
                                            <strong>{{ $tramite->cite_texto }}</strong>
                                        </div>
                                        <div class="text-center">
                                            {{ $tramite->tipo_tramite->nombre.' '.$tramite->tipo_tramite->sigla }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $nombre_remitente = '';
                                        if ($tramite->remitente_nombre != null) {
                                            $nombre_remitente = $tramite->remitente_nombre;
                                        } else {
                                            $nombre_remitente = $tramite->remitente_user->contrato->grado_academico->abreviatura .' '.$tramite->remitente_user->persona->nombres. ' '.$tramite->remitente_user->persona->ap_paterno. ' '.$tramite->remitente_user->persona->ap_materno;
                                        }

                                        $nombre_destinatario = $tramite->destinatario_user->contrato->grado_academico->abreviatura .' '.$tramite->destinatario_user->persona->nombres.' '.$tramite->destinatario_user->persona->ap_paterno.' '.$tramite->destinatario_user->persona->ap_materno;
                                    @endphp

                                    <div class="d-flex flex-column " style="height: 100%;">
                                        <div class="demo-inline-spacing mb-2">
                                            <strong>Remitente : </strong>{{ $nombre_remitente }}
                                        </div>
                                        <div>
                                            <strong>Destinatario : </strong>{{ $nombre_destinatario }}
                                        </div>
                                        <div>
                                            <strong>Referencia : </strong> {{ $tramite->referencia }}
                                        </div>
                                        <div>
                                            <strong>Salida : </strong> {{ $tramite->fecha_creada }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $tramite->fecha_hora_creada }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
