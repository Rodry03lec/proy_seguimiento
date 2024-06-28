<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Ruta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            font-size: 7px;
            /* Tamaño de letra reducido */
            color: #333;
        }

        h1,
        h2 {
            text-align: center;
            margin: 0;
            font-size: 12px;
        }

        .section {
            border: 1px solid #000;
            margin-bottom: 1px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            page-break-inside: avoid;
            /* Evitar que la sección se divida entre páginas */
        }

        .section-header {
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
            font-size: 10px;
            background-color: #eee;
            padding: 5px;
            border-radius: 3px;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .data-row span {
            flex: 1;
            text-align: center;
        }

        .data-row span.label {
            text-align: left;
            font-weight: bold;
        }

        .data-row span.value {
            text-align: center;
        }

        .instructions {
            font-style: italic;
            margin-top: 5px;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 41px;
            /* Más espacio para los sellos */
            text-align: right;
        }

        .signature .right {
            text-align: right;
            margin: 0 25px;
        }

        .footer {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .bottom-row {
            display: table;
            width: 100%;
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 5px;
        }

        .bottom-row div {
            display: table-cell;
            padding: 5px;
            text-align: center;
            border-right: 1px solid #ddd;
        }

        .bottom-row div:last-child {
            border-right: none;
        }

        .img_fondo {
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 7%;
        }

        header {
            top: 0cm;
            text-align: right;
            line-height: 1cm;
        }


        body {
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 7px;
            display: flex;
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        td {
            padding: 2px;
            border: 1px solid #ddd;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        $img_logo = public_path('rodry/img_logos/logo_lop.jpg');
        $imagen_logo = 'data:image/png;base64,' . base64_encode(file_get_contents($img_logo));
    @endphp


    <header>
        <img src="{{ $imagen_logo }}" class="img_fondo">
    </header>




    <div class="section">
        <div class="section-header">

            <h1>GOBIERNO AUTÓNOMO MUNICIPAL DE HUATAJATA</h1>
            <h2>TRAMITE</h2>
            {{ $tramite->tipo_tramite->nombre . ' (' . $tramite->tipo_tramite->sigla . ')' }}
        </div>

        <div class="data-row" style="font-size: 15px; text-align: center;">
            <span class="label">NRO. ÚNICO: {{ $tramite->numero_unico . '/' . date('Y', strtotime($tramite->fecha_creada)) }}</span>
        </div>

        <div class="container">
            <table>
                <tbody>
                    <tr>
                        <td><strong>RECEPCIÓN</strong></td>
                        <td>{{ $tramite->fecha_hora_creada }}</td>

                        <td><strong>Nº HOJAS</strong></td>
                        <td>{{ $tramite->numero_hojas }}</td>

                        <td><strong>Nº ANEXOS</strong></td>
                        <td>{{ $tramite->numero_anexos }}</td>

                        <td><strong>CITE</strong></td>
                        <td>{{ $tramite->cite_texto }} </td>
                    </tr>
                    <tr>
                        <td><strong>REMITENTE</strong></td>
                        <td>@if ($tramite->remitente_nombre != null)
                            <span class="value">{{ $tramite->remitente_nombre }}</span>
                        @else
                            <span
                                class="value">{{ $tramite->remitente_user->contrato->grado_academico->abreviatura . ' ' . $tramite->remitente_user->persona->nombres . ' ' . $tramite->remitente_user->persona->ap_paterno . ' ' . $tramite->remitente_user->persona->ap_materno }}</span>
                        @endif</td>
                        <td colspan="6" >

                            @if ($tramite->remitente_cargo != null)
                                <span class="value">{{ $tramite->remitente_cargo }}</span>
                            @else
                                <span class="value">
                                    @if ($tramite->remitente_user->cargo_sm != null)
                                        {{ $tramite->remitente_user->cargo_sm->nombre }}
                                    @else
                                    {{ $tramite->remitente_user->cargo_mae->nombre }}
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>DESTINATARIO</strong></td>
                        <td> {{ $tramite->destinatario_user->contrato->grado_academico->abreviatura . ' ' . $tramite->destinatario_user->persona->nombres . ' ' . $tramite->destinatario_user->persona->ap_paterno . ' ' . $tramite->destinatario_user->persona->ap_materno }}</td>
                        <td colspan="6" >{{ $tramite->destinatario_cargo }}</td>
                    </tr>

                    <tr>
                        <td><strong>CREADO POR</strong></td>
                        <td>{{ $tramite->user_cargo_tramite->contrato->grado_academico->abreviatura . ' ' . $tramite->user_cargo_tramite->persona->nombres . ' ' . $tramite->user_cargo_tramite->persona->ap_paterno . ' ' . $tramite->user_cargo_tramite->persona->ap_materno }}</td>

                        <td colspan="3"><strong>REFERENCIA</strong></td>
                        <td colspan="3">{{ $tramite->referencia }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @php
        $con = 1;
        $archivado = '';
    @endphp

    @foreach ($hoja_ruta as $lis)
        <div class="section">
            <img src="{{ $imagen_logo }}" class="img_fondo">
            <div class="section-header">{{ $lis->paso_txt }}</div>
            <div class="data-row">
                <span class="label">Destinatario:</span>
                @php
                    $cargo_unic =
                        $lis->destinatario_user->cargo_sm->nombre ?? $lis->destinatario_user->cargo_mae->nombre;
                    $nombre_completo =
                        $lis->destinatario_user->contrato->grado_academico->abreviatura .
                        ' ' .
                        $lis->destinatario_user->persona->nombres .
                        ' ' .
                        $lis->destinatario_user->persona->ap_paterno .
                        ' ' .
                        $lis->destinatario_user->persona->ap_materno;
                @endphp

                <span class="value">{{ $nombre_completo . ' - ' . abreviarCargo($cargo_unic) }}</span>
            </div>
            <div class="instructions">INSTRUCTIVO: {{ $lis->instructivo }}</div>
            <div class="signature">
                <div>_________________________</div>
                <div class="right">SELLO Y FIRMA</div>
            </div>
            <div class="bottom-row">
                <div>Fecha de ingreso: {{ $lis->fecha_ingreso }}</div>
                <div>Cantidad hojas: </div>
                <div>Fecha de salida: {{ $lis->fecha_salida }}</div>
                <div>Cantidad hojas: </div>
            </div>
        </div>
        @php
            if ($lis->ruta_archivado && $lis->ruta_archivado->descripcion) {
                $archivado = $lis->ruta_archivado->descripcion;
            }
            $con++;
        @endphp
    @endforeach

    @if ($archivado != null && $archivado != '')
        <h5>{{ $archivado }}</h5>
    @else
        @for ($i = $con; $i < $con + 10; $i++)
            <div class="section">
                <img src="{{ $imagen_logo }}" class="img_fondo">
                <div class="section-header">{{ numero_a_ordinal($i) }}</div>
                <div class="data-row">
                    <span class="label">DESTINATARIO:</span>
                    <span class="value"></span>
                </div>
                <div class="instructions"></div>
                <div class="signature">
                    <div>_________________________</div>
                    <div class="right">SELLO Y FIRMA</div>
                </div>
                <div class="bottom-row">
                    <div>Fecha de ingreso: </div>
                    <div>Cantidad hojas: </div>
                    <div>Fecha de salida: </div>
                    <div>Cantidad hojas: </div>
                </div>
            </div>
        @endfor
    @endif

</body>

</html>
