@extends('principal')
@section('titulo', 'VISTA REPORTES')
@section('contenido')
    <div class="card">

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: `
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        `
                    });
                });
            </script>
        @endif




        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE HOJAS DE RUTAS RECIVIDAS Y REVISADAS POR TRAMITE :::::::: </h5>

            <form id="gestionForm" action="{{ route('crt_vizualizar_index') }}" method="GET" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label" for="gestion">GESTIÓN</label>
                        <select name="gestion" id="gestion" class="select2">
                            <option value="0" selected disabled>[SELECCIONE GESTIÓN]</option>
                            @foreach ($gestion as $lis)
                                <option value="{{ $lis->gestion }}">{{ $lis->gestion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 py-4">
                        <button class="btn btn-primary" type="submit" id="btn_gestion">IMP PDF</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="lineChart"></div>


        <div class="table-responsive text-nowrap p-4">

            <table class="table table-hover" id="tabla_recividos_hojas_ruta" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">CITE</th>
                        <th scope="col" class="table-th">REFERENCIA</th>
                        <th scope="col" class="table-th">FECHA RECIVIDA</th>
                        <th scope="col" class="table-th">NOMBRE</th>
                        <th scope="col" class="table-th">Nº (Recividos)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tramitesRealizados as $tramite)
                        @if (isset($conteoRutasAgrupadas[$tramite->id]) && count($conteoRutasAgrupadas[$tramite->id]) > 0)
                            @foreach ($conteoRutasAgrupadas[$tramite->id] as $destinatarioId => $count)
                                <tr>
                                    <td>{{ $tramite->cite_texto }}</td>
                                    <td>{{ $tramite->referencia }}</td>
                                    <td>{{ $tramite->fecha_creada }}</td>
                                    <td>
                                        @php
                                            $cargo = '';
                                            if (
                                                $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)
                                                    ->destinatario_user->cargo_sm != null
                                            ) {
                                                $cargo = $tramite->hojas_ruta->firstWhere(
                                                    'destinatario_id',
                                                    $destinatarioId,
                                                )->destinatario_user->cargo_sm->nombre;
                                            } else {
                                                $cargo = $tramite->hojas_ruta->firstWhere(
                                                    'destinatario_id',
                                                    $destinatarioId,
                                                )->destinatario_user->cargo_mae->nombre;
                                            }
                                        @endphp

                                        {{ ' ( ' . $cargo . ' )   ' . $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->contrato->grado_academico->abreviatura . ' ' . $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->nombres . ' ' . $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->ap_paterno . ' ' . $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->ap_materno ?? 'N/A' }}
                                    </td>
                                    <td>{{ $count }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $tramite->cite_texto }}</td>
                                <td>{{ $tramite->referencia }}</td>
                                <td>{{ $tramite->fecha_creada }}</td>
                                <td>No hay hojas de ruta para este trámite.</td>
                                <td>0</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>


        <hr>

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE TRAMITES REALIZADOS POR PERSONA :::::::: </h5>
        </div>

        <div class="py-8" id="horizontalBarChart"></div>

        <div class="table-responsive text-nowrap p-4">

            <table class="table table-hover" id="tabla_conteo_tramite" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="table-th">REMITENTE USUARIO</th>
                        <th scope="col" class="table-th">CARGO</th>
                        <th scope="col" class="table-th">Nº TRAMITES REALIZADOS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tramites_hojas_ruta as $lis)
                        <tr>
                            <td>{{ $lis->remitente_user->contrato->grado_academico->abreviatura . ' ' . $lis->remitente_user->persona->nombres . ' ' . $lis->remitente_user->persona->ap_paterno . ' ' . $lis->remitente_user->persona->ap_materno }}
                            </td>
                            <td>
                                @if ($lis->remitente_user->cargo_sm != null)
                                    {{ $lis->remitente_user->cargo_sm->nombre }}
                                @else
                                    {{ $lis->remitente_user->cargo_mae->nombre }}
                                @endif
                            </td>
                            <td>{{ $lis->total_tramites }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>



@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabla_recividos_hojas_ruta').DataTable({
                responsive: true
            });
        });

        $(document).ready(function() {
            $('#tabla_conteo_tramite').DataTable({
                responsive: true
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            let tramitesRealizados = @json($tramitesRealizados);
            let conteoRutasAgrupadas = @json($conteoRutasAgrupadas);

            let tramitesData = [];

            tramitesRealizados.forEach(tramite => {
                if (conteoRutasAgrupadas[tramite.id] && Object.keys(conteoRutasAgrupadas[tramite.id])
                    .length > 0) {
                    Object.keys(conteoRutasAgrupadas[tramite.id]).forEach(destinatarioId => {
                        let count = conteoRutasAgrupadas[tramite.id][destinatarioId];
                        let destinatario = tramite.hojas_ruta.find(hoja => hoja.destinatario_id ==
                            destinatarioId).destinatario_user;
                        let cargo = destinatario.cargo_sm ? destinatario.cargo_sm.nombre :
                            destinatario.cargo_mae.nombre;
                        let nombreCompleto =
                            `${destinatario.contrato.grado_academico.abreviatura} ${destinatario.persona.nombres} ${destinatario.persona.ap_paterno} ${destinatario.persona.ap_materno || 'N/A'}`;
                        tramitesData.push({
                            cite: tramite.cite_texto,
                            referencia: tramite.referencia,
                            fecha: tramite.fecha_creada,
                            nombre: `( ${cargo} ) ${nombreCompleto}`,
                            recibidos: count
                        });
                    });
                } else {
                    tramitesData.push({
                        cite: tramite.cite_texto,
                        referencia: tramite.referencia,
                        fecha: tramite.fecha_creada,
                        nombre: 'No hay hojas de ruta para este trámite.',
                        recibidos: 0
                    });
                }
            });

            let categorias = tramitesData.map(tramite => `${tramite.cite} - ${tramite.referencia}`);
            let recibidos = tramitesData.map(tramite => tramite.recibidos);

            var opcionesLine = {
                chart: {
                    height: 450,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Nº (Recividos)',
                    data: recibidos
                }],
                markers: {
                    size: 5,
                    colors: ["#FFA41B"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    borderColor: '#f1f1f1',
                },
                xaxis: {
                    categories: categorias,
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true
                    },
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '10px'
                        }
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '10px'
                        }
                    }
                },
            };

            let chart_segundo = new ApexCharts(document.querySelector("#lineChart"), opcionesLine);
            chart_segundo.render();
        });


        document.addEventListener('DOMContentLoaded', function() {
            let tramitesHojasRuta = @json($tramites_hojas_ruta);
            let usuarios = [];
            let cargos = [];
            let totalTramites = [];

            tramitesHojasRuta.forEach(tramite => {
                let remitente =
                    `${tramite.remitente_user.contrato.grado_academico.abreviatura} ${tramite.remitente_user.persona.nombres} ${tramite.remitente_user.persona.ap_paterno} ${tramite.remitente_user.persona.ap_materno}`;
                usuarios.push(remitente);

                let cargo = tramite.remitente_user.cargo_sm ? tramite.remitente_user.cargo_sm.nombre :
                    tramite.remitente_user.cargo_mae.nombre;
                cargos.push(cargo);

                totalTramites.push(tramite.total_tramites);
            });

            let opcionesBar = {
                chart: {
                    height: 450,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '30%',
                        startingShape: 'rounded',
                        borderRadius: 8,
                    },
                },
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: -20,
                        bottom: -12
                    },
                },
                colors: ['#0C77FF'], // Ajusta el color según tu configuración
                dataLabels: {
                    enabled: true
                },
                series: [{
                    name: 'Trámites Realizados',
                    data: totalTramites
                }],
                xaxis: {
                    categories: usuarios,
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '8px'
                        }
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '8px'
                        }
                    }
                },
            };

            let chart_primero = new ApexCharts(document.querySelector("#horizontalBarChart"), opcionesBar);
            chart_primero.render();
        });

        document.getElementById('gestionForm').addEventListener('submit', function(event) {
            let hasErrors = @json($errors->any());

            if (!hasErrors) {
                this.setAttribute('target', '_blank');
            }
        });
    </script>
@endsection
