<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BOLETA - LICENCIA</title>
    <style>

        @page {
            size: letter;
            margin-top: 3%;
            margin-footer: 3%;
            margin-right: 2%;
            margin-left: 7%;
        }

        .my-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 5px;
        }

        #thead tr {
            position: sticky;
            top: 0;
        }

        .table-container {
            position: relative;
            page: auto;
        }

        #borde_borrar_table {
            border: none;
        }


        .img_fondo {
            position: absolute;
            opacity: 0.8;
            top: 2%;
            left: 8%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 18%;
        }

        .seccion {
            position: relative;
            z-index: -1;
        }

        .text-primary {
            padding-top: 0px;
            margin: 2px;
        }

        .text-secundario {
            padding-top: 0px;
            margin-top: -2px;
        }

        .seccion_2 {
            position: relative;
            margin-top: 20px;
            z-index: -1;
        }


        .imagen_oficial_a {
            position: absolute;
            top: 0;
            left: 20%;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Enviar la imagen al fondo */
            opacity: 0.1;
            /* Ajustar la opacidad de la imagen */
        }

        .imagen_oficial_b {
            position: absolute;
            top: 55%;
            left: 20%;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Enviar la imagen al fondo */
            opacity: 0.1;
            /* Ajustar la opacidad de la imagen */
        }

        /*PARA DASHED*/

        #estilo_dashed {
            border: 1px dashed rgba(76, 76, 76, 0.468);
        }

        #estilo_dashed>p {
            transform: rotate(-35deg);
            font-size: 15px;
            color: rgba(0, 0, 0, 0.234);
        }


        #border_abajo {
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid rgb(0, 135, 32);
            background: rgba(69, 181, 108, 0.26);
        }

        /*** PARA LAS FIRMAS */
        #firmas_debajo {
            /*  */
            border-top: none;
            border-left: 1px dashed rgb(0, 135, 32);
            border-right: none;
            border-bottom: none;
            background: rgba(69, 181, 108, 0.028);

            padding-top: 50px;
        }

        /*para el primer elemento*/
        .alinear_elemento_arriba{
            position: absolute;
            top: 10px;
            right: 10px;
        }
        #primer_encabezado_usuario{
            text-align: right;
            font-size: 8px;
        }
        /*fin para el primer elemento*/

        /*elemento  abajo*/
        .alinear_elemento_abajo{
            position: absolute; bottom: -8px; right: 7px;
        }
        /*fin elemento  abajo*/


        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: right;
            line-height: 1.5cm;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            line-height: 1.5cm;
        }
    </style>
</head>

<body>
    @php
        $img_logo = public_path('rodry/img_logos/logo_oficialb.jpg');
        $imagen_logo = 'data:image/png;base64,' . base64_encode(file_get_contents($img_logo));

        $img_logo_gradiante = public_path('rodry/img_logos/gradiante.jpg');
        $imagen_logo_gradiante = 'data:image/png;base64,' . base64_encode(file_get_contents($img_logo_gradiante));

        $img_logo_caranavi = public_path('rodry/img_logos/logo_oficial.jpg');
        $imagen_logo_caranavi = 'data:image/png;base64,' . base64_encode(file_get_contents($img_logo_caranavi));

    @endphp


    {{-- <header>
        <div>cabecera</div>
    </header> --}}



    <div class="seccion">
        <img src="{{ $imagen_logo }}" class="img_fondo">
        <!-- Contenido de la primera sección -->
    </div>



    <div style="text-align: center; padding-top:-60% ">
        <h4 class="text-primary">UNIDAD DE RECURSOS HUMANOS (RRHH)</h4>
        <h3 class="text-primary">LICENCIA - BOLETA</h3>
    </div>

    <div class="alinear_elemento_arriba">
        <div id="primer_encabezado_usuario">
            Fecha Impreso:. {{ date('d-m-Y H:i:s') }}
            <br>
            Us:. {{ $licencia->usuario_creado->nombres.' '.$licencia->usuario_creado->apellidos }}
        </div>
    </div>

    <div class="my-table">
        <table style="width: 100%; font-size: 7px;">
            <thead>
                <tr>
                    <th style="width: 66.7%; margin: 10%" id="borde_borrar_table">
                        <table>
                            <tr>
                                <td id="borde_borrar_table"> CI</td>
                                <td id="borde_borrar_table"> :
                                    {{ $licencia->persona->ci . ' ' . $licencia->persona->complemento }}</td>
                            </tr>

                            <tr>
                                <td id="borde_borrar_table"> NOMBRES Y APELLIDOS</td>
                                <td id="borde_borrar_table"> :
                                    {{ $licencia->contrato->grado_academico->abreviatura . ' ' . $licencia->persona->nombres . ' ' . $licencia->persona->ap_paterno . ' ' . $licencia->persona->ap_materno }}
                                </td>
                            </tr>



                            @if ($licencia->contrato->id_cargo_mae != null)
                                <!-- para la administrcion del mae -->
                                <!-- NOMBRE MAE -->
                                <tr>
                                    <td id="borde_borrar_table" style="padding:8px"> MAE</td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->unidad_mae->mae->nombre }}
                                    </td>
                                </tr>
                                <!-- UNIDAD -->
                                <tr>
                                    <td id="borde_borrar_table"> CORESPONDE </td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->unidad_mae->descripcion }}
                                    </td>
                                </tr>
                                <!-- CARGO -->
                                <tr>
                                    <td id="borde_borrar_table"> CARGO</td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->nombre }}
                                    </td>
                                </tr>
                            @endif

                            @if ($licencia->contrato->id_cargo_sm != null)
                                <tr>
                                    <td id="borde_borrar_table"> SECRETARIA</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->direccion->secretaria_municipal->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->direccion->secretaria_municipal->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> DIRECCIÓN</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->direccion->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->direccion->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> UNIDAD / JEFATURA</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->unidades_admnistrativas->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->unidades_admnistrativas->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> CARGO</td>
                                    <td id="borde_borrar_table"> : {{ $licencia->contrato->cargo_sm->nombre }}</td>
                                </tr>
                            @endif




                            <tr>
                                <td id="borde_borrar_table"> TIPO</td>
                                <td id="borde_borrar_table"> : {{ $licencia->tipo_licencia->motivo }}
                                </td>
                            </tr>

                            <tr>
                                <td id="borde_borrar_table"> DESCRIPCIÓN</td>
                                <td id="borde_borrar_table"> : {{ $licencia->tipo_licencia->jornada_laboral }}
                                </td>
                            </tr>


                            <tr>
                                <td style="border: none;"> MOTIVO</td>
                                <td style="border: none; font-size: 6px; word-break: break-word;">: {{ $licencia->descripcion }} </td>
                            </tr>
                        </table>

                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th id="border_abajo">FECHA SOLICITADA</th>
                                    <th id="border_abajo">FECHA Y HORA DE INICIO</th>
                                    <th id="border_abajo">FECHA Y HORA DE RETORNO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha, 4) }}
                                    </th>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha_inicio, 4) }}
                                        {{ $licencia->hora_inicio . ' ' . determinar_am_pm($licencia->hora_inicio) }}
                                    </th>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha_final, 4) }}
                                        {{ $licencia->hora_final . ' ' . determinar_am_pm($licencia->hora_final) }}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </th>
                    <th id="estilo_dashed">
                        <p>
                            FIRMA Y SELLO (CONSTANCIA)
                        </p>
                    </th>
                </tr>
            </thead>

        </table>
        <table style="width: 100%; font-size: 7px">
            <tbody>
                <tr>
                    <th id="firmas_debajo">
                        -----------------------------------------------------------
                        <br>
                        {{ $licencia->contrato->grado_academico->abreviatura . ' ' . $licencia->persona->nombres . ' ' . $licencia->persona->ap_paterno . ' ' . $licencia->persona->ap_materno }}
                        <br>
                        FIRMA DEL SOLICITANTE
                    </th>
                    <th id="firmas_debajo">
                        -----------------------------------------------------------
                        <br>
                        FIRMA DEL INMEDIATO SUPERIOR
                    </th>
                    <th id="firmas_debajo">

                        -----------------------------------------------------------
                        <br>
                        FIRMA Y SELLO DE RECURSOS HUMANOS (RRHH)
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div  style="text-align: center; margin-top: 50px; padding: 30px;">
        <img src="{{ $imagen_logo_gradiante }}" style="width: 100%; height: 5px;" />
    </div>


    <div class="seccion_2">
        <img src="{{ $imagen_logo }}" class="img_fondo">
        <!-- Contenido de la primera sección -->
    </div>


    <div style="text-align: center;">
        <h4 class="text-primary">UNIDAD DE RECURSOS HUMANOS (RRHH)</h4>
        <h3 class="text-primary">LICENCIA - BOLETA</h3>
        <div class=" ms-auto position-relative">
        </div>
    </div>

    <div class="alinear_elemento_abajo" >
        <div id="primer_encabezado_usuario">
            Fecha Impreso:. {{ date('d-m-Y H:i:s') }}
            <br>
            Us:. {{ $licencia->usuario_creado->nombres.' '.$licencia->usuario_creado->apellidos }}
        </div>
    </div>


    <div class="my-table">
        <table style="width: 100%; font-size: 7px;">
            <thead>
                <tr>
                    <th style="width: 66.7%; margin: 10%" id="borde_borrar_table">
                        <table>
                            <tr>
                                <td id="borde_borrar_table"> CI</td>
                                <td id="borde_borrar_table"> :
                                    {{ $licencia->persona->ci . ' ' . $licencia->persona->complemento }}</td>
                            </tr>

                            <tr>
                                <td id="borde_borrar_table"> NOMBRES Y APELLIDOS</td>
                                <td id="borde_borrar_table"> :
                                    {{ $licencia->contrato->grado_academico->abreviatura . ' ' . $licencia->persona->nombres . ' ' . $licencia->persona->ap_paterno . ' ' . $licencia->persona->ap_materno }}
                                </td>
                            </tr>



                            @if ($licencia->contrato->id_cargo_mae != null)
                                <!-- para la administrcion del mae -->
                                <!-- NOMBRE MAE -->
                                <tr>
                                    <td id="borde_borrar_table" style="padding:8px"> MAE</td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->unidad_mae->mae->nombre }}
                                    </td>
                                </tr>
                                <!-- UNIDAD -->
                                <tr>
                                    <td id="borde_borrar_table"> CORESPONDE </td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->unidad_mae->descripcion }}
                                    </td>
                                </tr>
                                <!-- CARGO -->
                                <tr>
                                    <td id="borde_borrar_table"> CARGO</td>
                                    <td id="borde_borrar_table"> :
                                        {{  $licencia->contrato->cargo_mae->nombre }}
                                    </td>
                                </tr>
                            @endif

                            @if ($licencia->contrato->id_cargo_sm != null)
                                <tr>
                                    <td id="borde_borrar_table"> SECRETARIA</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->direccion->secretaria_municipal->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->direccion->secretaria_municipal->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> DIRECCIÓN</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->direccion->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->direccion->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> UNIDAD / JEFATURA</td>
                                    <td id="borde_borrar_table"> :
                                        {{ '(' . $licencia->contrato->cargo_sm->unidades_admnistrativas->sigla . ')' . ' ' . $licencia->contrato->cargo_sm->unidades_admnistrativas->nombre }}
                                    </td>
                                </tr>

                                <tr>
                                    <td id="borde_borrar_table"> CARGO</td>
                                    <td id="borde_borrar_table"> : {{ $licencia->contrato->cargo_sm->nombre }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td id="borde_borrar_table"> TIPO</td>
                                <td id="borde_borrar_table"> : {{ $licencia->tipo_licencia->motivo }}
                                </td>
                            </tr>

                            <tr>
                                <td id="borde_borrar_table"> DESCRIPCIÓN</td>
                                <td id="borde_borrar_table"> : {{ $licencia->tipo_licencia->jornada_laboral }}
                                </td>
                            </tr>

                            <tr>
                                <td style="border: none;"> MOTIVO</td>
                                <td style="border: none; font-size: 6px; word-break: break-word;">: {{ $licencia->descripcion }} </td>
                            </tr>
                        </table>

                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th id="border_abajo">FECHA SOLICITADA</th>
                                    <th id="border_abajo">FECHA Y HORA DE INICIO</th>
                                    <th id="border_abajo">FECHA Y HORA DE RETORNO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha, 4) }}
                                    </th>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha_inicio, 4) }}
                                        {{ $licencia->hora_inicio . ' ' . determinar_am_pm($licencia->hora_inicio) }}
                                    </th>
                                    <th id="border_abajo">
                                        {{ fecha_literal($licencia->fecha_final, 4) }}
                                        {{ $licencia->hora_final . ' ' . determinar_am_pm($licencia->hora_final) }}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </th>
                    <th id="estilo_dashed">
                        <p>
                            FIRMA Y SELLO (CONSTANCIA)
                        </p>
                    </th>
                </tr>
            </thead>

        </table>
        <table style="width: 100%; font-size: 7px">
            <tbody>
                <tr>
                    <th id="firmas_debajo">
                        -----------------------------------------------------------
                        <br>
                        {{ $licencia->contrato->grado_academico->abreviatura . ' ' . $licencia->persona->nombres . ' ' . $licencia->persona->ap_paterno . ' ' . $licencia->persona->ap_materno }}
                        <br>
                        FIRMA DEL SOLICITANTE
                    </th>
                    <th id="firmas_debajo">
                        -----------------------------------------------------------
                        <br>
                        FIRMA DEL INMEDIATO SUPERIOR
                    </th>
                    <th id="firmas_debajo">

                        -----------------------------------------------------------
                        <br>
                        FIRMA Y SELLO DE RECURSOS HUMANOS (RRHH)
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pie de página -->



    {{-- <footer>
        <div id="footer-content">Página {PAGENO} de {totalPages}</div>
    </footer> --}}


</body>

</html>
