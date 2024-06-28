<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ASISTENCIA - GAMC</title>
    <style>
        @page {
            size: letter;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        header, footer {
            position: fixed;
            left: 0cm;
            right: 0cm;
            height: 1cm;
        }

        header {
            top: 0cm;
            text-align: right;
            line-height: 1cm;
        }

        footer {
            bottom: 0cm;
            text-align: center;
            line-height: 1cm;
        }

        .img_fondo {
            position: absolute;
            opacity: 0.1;
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 50%;
        }

        .seccion {
            text-align: center;
            margin-bottom: 5px;
            margin-top: -29px;
        }

        .header-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
            color: #2E86C1;
        }

        .sub-header-title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2E86C1;
        }

        .info-section {
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            border: 1px solid black;
            padding: 3px;
        }

        .info-section div {
            flex: 1;
            padding-right: 5px;
        }

        .info-section div:last-child {
            padding-right: 0;
        }

        .info-section h6 {
            margin: 0;
            font-size: 9px;
            color: #2E4053;
        }

        .table-container {
            margin-top: 5px;
        }

        .my-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 7px;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }

        .table-header {
            background-color: #f2f2f2;
        }

        .alert {
            padding: 1px;
            margin-bottom: 2px;
            border-radius: 5px;
            font-size: 10px;
            text-align: center;
        }

        .alert-danger {
            color: #000000;
            background-color: #e7e5e5;
            border-color: #e7e7e7;
        }

        .alert-success {
            color: #000000;
            background-color: #e8e8e8;
            border-color: #e9e9e9;
        }

        #falta_estilo {
            color: red;
            margin: 0px;
        }

        #estilo_permiso {
            color: #0099ff;
            margin: 0px;
        }

        #estilo_licencia {
            color: #ffae00;
            margin: 0px;
        }

        #estilo_minutos_segundos {
            color: red;
            font-size: 5px;
            margin: 0px;
        }

        #descripcion_per_lic {
            font-size: 5px;
            margin: 0px;
        }

        #estilo_faltas_minutos {
            color: red;
            font-size: 10px;
            margin: 0px;
        }
    </style>
</head>
<body>
    @php
        $img_logo = public_path('rodry/img_logos/logo_oficialb.jpg');
        $imagen_logo = 'data:image/png;base64,' . base64_encode(file_get_contents($img_logo));
    @endphp

    <header>
        <img src="{{ $imagen_logo }}" class="img_fondo">
    </header>

    <div class="seccion">
        <div class="header-title">REPORTE DE ASISTENCIA - GAMC</div>
    </div>

    <div class="info-section">
        <div>
            <h6>NOMBRES Y APELLIDOS: <span>{{ $persona->nombres.' '.$persona->ap_paterno.' '.$persona->ap_materno }}</span></h6>
            <h6>CI: <span>{{ $persona->ci }}</span></h6>
        </div>
        <div>
            @if ($persona->contrato[0]->cargo_sm)
                <h6 class="mb-2">CARGO :
                    {{ $persona->contrato[0]->cargo_sm->nombre }}
                </h6>
                <h6 class="mb-2">SECRETARIA MUNICIPAL :
                    {{ '('.$persona->contrato[0]->cargo_sm->direccion->secretaria_municipal->sigla.') '.$persona->contrato[0]->cargo_sm->direccion->secretaria_municipal->nombre }}
                </h6>
            @else
                <h6 class="mb-2">CARGO :
                    {{ $persona->contrato[0]->cargo_mae->nombre }}
                </h6>
                <h6 class="mb-2">MAE :
                    {{ $persona->contrato[0]->cargo_mae->unidad_mae->mae->nombre }}
                </h6>
            @endif
        </div>

        <div>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong> FECHA INICIAL: {{ mb_strtoupper(fecha_literal($fecha_inicial->fecha, 5), 'UTF-8') }}</strong>
            </div>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong> FECHA FINAL: {{ mb_strtoupper(fecha_literal($fecha_final->fecha, 5), 'UTF-8') }}</strong>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="my-table">
            <thead class="table-header">
                <tr>
                    <th>DIA</th>
                    <th>FECHA</th>
                    <th>ENTRADA MAÑANA</th>
                    <th>SALIDA MAÑANA</th>
                    <th>ENTRADA TARDE</th>
                    <th>SALIDA TARDE</th>
                    <th>OBSERVACIÓN</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $minutos = 0;
                    $faltas = 0;
                @endphp
                @foreach ($listar_biometrico as $biometricos)
                    @foreach ($biometricos as $lis)
                        @php
                            $permiso_descripcion = '';
                            $licencia_descripcion = '';
                            $es_permiso = false;
                            $es_licencia = false;
                            $permiso_hora_inicio = '';
                            $permiso_hora_final = '';
                            $licencia_hora_inicio = '';
                            $licencia_hora_final = '';

                            foreach ($permisos_lis as $permiso) {
                                if ($permiso->fecha_inicio <= $lis->fecha_principal->fecha && $permiso->fecha_final >= $lis->fecha_principal->fecha) {
                                    $permiso_descripcion = $permiso->descripcion;
                                    $permiso_hora_inicio = $permiso->hora_inicio;
                                    $permiso_hora_final = $permiso->hora_final;
                                    $es_permiso = true;
                                    break;
                                }
                            }

                            foreach ($licencia_lis as $licencia) {
                                if ($licencia->fecha_inicio <= $lis->fecha_principal->fecha && $licencia->fecha_final >= $lis->fecha_principal->fecha) {
                                    $licencia_descripcion = $licencia->descripcion;
                                    $licencia_hora_inicio = $licencia->hora_inicio;
                                    $licencia_hora_final = $licencia->hora_final;
                                    $es_licencia = true;
                                    break;
                                }
                            }

                            $horario_primero = $lis->contrato->horario->rango_hora[0];
                            $tolerancia_primero = $horario_primero->tolerancia;
                            $hora_final_primero = $horario_primero->hora_final;
                            $sumado_primero = sumar_horas($hora_final_primero, $tolerancia_primero);

                            if (!$horario_primero->excepcion_horario->isEmpty()) {
                                $fecha_ini = $horario_primero->excepcion_horario[0]->fecha_inicio;
                                $fecha_fin = $horario_primero->excepcion_horario[0]->fecha_final;

                                if ($lis->fecha_principal->fecha >= $fecha_ini && $lis->fecha_principal->fecha <= $fecha_fin) {
                                    $valor_arr = [];
                                    foreach ($horario_primero->excepcion_horario as $lis1) {
                                        foreach ($lis1->dias_semana_excepcion as $lxi) {
                                            $valor_arr[] = $lxi->pivot->id_dias_sem;
                                        }
                                    }
                                    if (in_array($lis->fecha_principal->dias_semana->id, $valor_arr)) {
                                        $hora_final_primero = $horario_primero->excepcion_horario[0]->hora;
                                        $sumado_primero = sumar_horas($hora_final_primero, $tolerancia_primero);
                                    }
                                }
                            }

                            $horario_segundo = $lis->contrato->horario->rango_hora[2];
                            $tolerancia_segundo = $horario_segundo->tolerancia;
                            $hora_final_segundo = $horario_segundo->hora_final;
                            $sumado_segundo = sumar_horas($hora_final_segundo, $tolerancia_segundo);

                            if (!$horario_segundo->excepcion_horario->isEmpty()) {
                                $fecha_ini_segundo = $horario_segundo->excepcion_horario[0]->fecha_inicio;
                                $fecha_fin_segundo = $horario_segundo->excepcion_horario[0]->fecha_final;

                                if ($lis->fecha_principal->fecha >= $fecha_ini_segundo && $lis->fecha_principal->fecha <= $fecha_fin_segundo) {
                                    $valor_arr_segundo = [];
                                    foreach ($horario_segundo->excepcion_horario as $lis1) {
                                        foreach ($lis1->dias_semana_excepcion as $lxi) {
                                            $valor_arr_segundo[] = $lxi->pivot->id_dias_sem;
                                        }
                                    }
                                    if (in_array($lis->fecha_principal->dias_semana->id, $valor_arr_segundo)) {
                                        $hora_final_segundo = $horario_segundo->excepcion_horario[0]->hora;
                                        $sumado_segundo = sumar_horas($hora_final_segundo, $tolerancia_segundo);
                                    }
                                }
                            }

                            $faltas_diarias = 0;
                        @endphp

                        <tr class="{{ $es_permiso ? 'table-warning' : '' }} {{ $es_licencia ? 'table-info' : '' }}">
                            <td>{{ $lis->fecha_principal->dias_semana->nombre }}</td>
                            <td>{{ fecha_literal($lis->fecha_principal->fecha, 2) }}</td>
                            @if ($lis->fecha_principal->feriado == '')
                                <td>
                                    @if ($lis->hora_ingreso_ma != '' && $lis->hora_ingreso_ma != null)
                                        @if ($es_permiso && $permiso_hora_inicio <= $lis->hora_ingreso_ma && $permiso_hora_final >= $lis->hora_ingreso_ma)
                                            {{ $lis->hora_ingreso_ma }} <p id="estilo_permiso">(Permiso)</p>
                                        @elseif ($es_licencia && $licencia_hora_inicio <= $lis->hora_ingreso_ma && $licencia_hora_final >= $lis->hora_ingreso_ma)
                                            {{ $lis->hora_ingreso_ma }} <p id="estilo_licencia">(Licencia)</p>
                                        @else
                                            @if ($lis->hora_ingreso_ma > $sumado_primero)
                                                {{ $lis->hora_ingreso_ma }}
                                                @php
                                                    $minutos = sumar_tiempo($minutos, contar_minutos_segundos($lis->hora_ingreso_ma, $sumado_primero));
                                                @endphp
                                                <p id="estilo_minutos_segundos">
                                                    {{ horaen_palabras(contar_minutos_segundos($lis->hora_ingreso_ma, $sumado_primero)) }}
                                                </p>
                                            @else
                                                {{ $lis->hora_ingreso_ma }}
                                            @endif
                                        @endif
                                    @else
                                        @if ($es_permiso || $es_licencia)
                                            -
                                        @else
                                            <p id="falta_estilo">FALTA</p>
                                            @php
                                                $faltas_diarias += 1;
                                            @endphp
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($lis->hora_salida_ma != '' && $lis->hora_salida_ma != null)
                                        @if ($es_permiso && $permiso_hora_inicio <= $lis->hora_salida_ma && $permiso_hora_final >= $lis->hora_salida_ma)
                                            {{ $lis->hora_salida_ma }} <p id="estilo_permiso">(Permiso)</p>
                                        @elseif ($es_licencia && $licencia_hora_inicio <= $lis->hora_salida_ma && $licencia_hora_final >= $lis->hora_salida_ma)
                                            {{ $lis->hora_salida_ma }} <p id="estilo_licencia">(Licencia)</p>
                                        @else
                                            @if ($lis->hora_salida_ma != '00:00:00')
                                                {{ $lis->hora_salida_ma }}
                                            @endif
                                        @endif
                                    @else
                                        @if ($es_permiso || $es_licencia)
                                            -
                                        @else
                                            <p id="falta_estilo">FALTA</p>
                                            @php
                                                $faltas_diarias += 0.5;
                                            @endphp
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($lis->hora_entrada_ta != '' && $lis->hora_entrada_ta != null)
                                        @if ($es_permiso && $permiso_hora_inicio <= $lis->hora_entrada_ta && $permiso_hora_final >= $lis->hora_entrada_ta)
                                            {{ $lis->hora_entrada_ta }} <p id="estilo_permiso">(Permiso)</p>
                                        @elseif ($es_licencia && $licencia_hora_inicio <= $lis->hora_entrada_ta && $licencia_hora_final >= $lis->hora_entrada_ta)
                                            {{ $lis->hora_entrada_ta }} <p id="estilo_licencia">(Licencia)</p>
                                        @else
                                            @if ($lis->hora_entrada_ta > $sumado_segundo)
                                                {{ $lis->hora_entrada_ta }}
                                                @php
                                                    $minutos = sumar_tiempo($minutos, contar_minutos_segundos($lis->hora_entrada_ta, $sumado_segundo));
                                                @endphp
                                                <p id="estilo_minutos_segundos">
                                                    {{ horaen_palabras(contar_minutos_segundos($lis->hora_entrada_ta, $sumado_segundo)) }}
                                                </p>
                                            @else
                                                {{ $lis->hora_entrada_ta }}
                                            @endif
                                        @endif
                                    @else
                                        @if ($es_permiso || $es_licencia)
                                            -
                                        @else
                                            <p id="falta_estilo">FALTA</p>
                                            @php
                                                $faltas_diarias += 1;
                                            @endphp
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($lis->hora_salida_ta != '' && $lis->hora_salida_ta != null)
                                        @if ($es_permiso && $permiso_hora_inicio <= $lis->hora_salida_ta && $permiso_hora_final >= $lis->hora_salida_ta)
                                            {{ $lis->hora_salida_ta }} <p id="estilo_permiso">(Permiso)</p>
                                        @elseif ($es_licencia && $licencia_hora_inicio <= $lis->hora_salida_ta && $licencia_hora_final >= $lis->hora_salida_ta)
                                            {{ $lis->hora_salida_ta }} <p id="estilo_licencia">(Licencia)</p>
                                        @else
                                            {{ $lis->hora_salida_ta }}
                                        @endif
                                    @else
                                        @if ($es_permiso || $es_licencia)
                                            -
                                        @else
                                            <p id="falta_estilo">FALTA</p>
                                            @php
                                                $faltas_diarias += 0.5;
                                            @endphp
                                        @endif
                                    @endif
                                </td>
                            @else
                                <td colspan="4">{{ $lis->fecha_principal->feriado->descripcion }}</td>
                            @endif
                            <td>
                                @if ($lis->hora_entrada_ta == '00:00:00' && $lis->hora_salida_ma == '00:00:00')
                                    HORARIO CONTINUO
                                @elseif ($es_permiso)
                                    <p id="descripcion_per_lic"> PERMISO: {{ mostrarprimeras50letras($permiso_descripcion) }} </p>
                                @elseif ($es_licencia)
                                    <p id="descripcion_per_lic"> LICENCIA: {{ mostrarprimeras50letras($licencia_descripcion) }} </p>
                                @endif
                            </td>
                        </tr>

                        @php
                            // Ajuste en la lógica para el conteo correcto de faltas
                            if($faltas_diarias >= 3){
                                $faltas += 2;
                            }else {
                                $faltas += $faltas_diarias;
                            }
                        @endphp
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"> <p id="estilo_faltas_minutos"> FALTAS : {{ $faltas }}</p> </th>
                    <th colspan="3"> <p id="estilo_faltas_minutos"> MINUTOS : {{ $minutos }}</p> </th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
