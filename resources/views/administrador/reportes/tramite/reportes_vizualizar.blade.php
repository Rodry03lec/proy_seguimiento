<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vizualizar</title>
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
            <h3>GESTIÓN {{ $gestion }}</h3>
        </div>
    </div>


    <div class="card">


        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE TRAMITES REALIZADOS POR PERSONA :::::::: </h5>
        </div>

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
                            <td>{{ $lis->remitente_user->contrato->grado_academico->abreviatura.' '.$lis->remitente_user->persona->nombres.' '.$lis->remitente_user->persona->ap_paterno.' '.$lis->remitente_user->persona->ap_materno }}</td>
                            <td>
                                @if ($lis->remitente_user->cargo_sm != null)
                                    {{ $lis->remitente_user->cargo_sm->nombre  }}
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


        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: LISTADO DE HOJAS DE RUTAS RECIVIDAS Y REVISADAS POR TRAMITE :::::::: </h5>
        </div>


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
                    @foreach($tramitesRealizados as $tramite)
                        @if(isset($conteoRutasAgrupadas[$tramite->id]) && count($conteoRutasAgrupadas[$tramite->id]) > 0)
                            @foreach($conteoRutasAgrupadas[$tramite->id] as $destinatarioId => $count)
                                <tr>
                                    <td>{{ $tramite->cite_texto }}</td>
                                    <td>{{ $tramite->referencia }}</td>
                                    <td>{{ $tramite->fecha_creada }}</td>
                                    <td>
                                        @php
                                            $cargo = "";
                                            if($tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->cargo_sm != null){
                                                $cargo =  $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->cargo_sm->nombre;
                                            }else{
                                                $cargo =  $tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->cargo_mae->nombre;
                                            }
                                        @endphp

                                        {{  ' ( '.$cargo.' )   '.$tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->contrato->grado_academico->abreviatura.' '.$tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->nombres.' '.$tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->ap_paterno.' '.$tramite->hojas_ruta->firstWhere('destinatario_id', $destinatarioId)->destinatario_user->persona->ap_materno ?? 'N/A' }}
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

    </div>

</body>

</html>
