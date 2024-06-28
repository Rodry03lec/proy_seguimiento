<div class="table-responsive text-nowrap p-4">
    @if ($contrato != null)
        <table class="table table-hover" id="tabla_tipo_categoria" style="width: 100%">
            <thead >
                <tr class="table-primary reduced-font">
                    <th >CI</th>
                    <th> : @if ($contrato->persona->complemento)
                            {{ $contrato->persona->ci.' '.$contrato->persona->complemento }}
                        @else
                            {{ $contrato->persona->ci }}
                        @endif
                    </th>
                </tr>
                <tr class="table-primary reduced-font ">
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>: {{ $contrato->persona->nombres.' '.$contrato->persona->ap_paterno.' '.$contrato->persona->ap_materno }}</th>
                </tr>

                <tr class="table-success reduced-font">
                    <th>FECHA DE INICIO</th>
                    <th>: {{ fecha_literal($contrato->fecha_inicio, 5) }}</th>
                </tr>
                <tr class="table-success reduced-font">
                    <th>FECHA DE DE FINALIZACIÓN</th>
                    <th>:
                        @if ($contrato->fecha_conclusion != null)
                            {{ fecha_literal($contrato->fecha_conclusion, 5) }}
                        @else
                            No tiene la fecha de finalización
                        @endif

                    </th>
                </tr>
                <tr class="table-success reduced-font">
                    <th>TIPO DE CONTRATO</th>
                    <th>: {{ $contrato->tipo_contrato->nombre }}</th>
                </tr>
                <tr class="table-success reduced-font">
                    <th>NÚMERO DE CONTRATO</th>
                    <th>: {{ $contrato->tipo_contrato->sigla.' '.$contrato->numero_contrato }}</th>
                </tr>
                <tr class="table-success reduced-font">
                    <th>HABER BÁSICO</th>
                    <th>: {{ con_separador_comas($contrato->haber_basico) }} || {{ convertir($contrato->haber_basico) }}</th>
                </tr>
                <tr class="table-secondary reduced-font" >
                    <th>CATEGORÍA</th>
                    <th>: {{ $contrato->nivel->categoria->nombre }}</th>
                </tr>
                <tr class="table-secondary reduced-font">
                    <th>NIVEL</th>
                    <th>: {{ $contrato->nivel->descripcion }}</th>
                </tr>
                @if ($contrato->id_cargo_mae != null)
                    <tr class="table-warning reduced-font">
                        <th>MAE</th>
                        <th>: {{ $contrato->cargo_mae->unidad_mae->mae->nombre}}</th>
                    </tr>
                    <tr class="table-warning reduced-font">
                        <th>UNIDAD</th>
                        <th>: {{ $contrato->cargo_mae->unidad_mae->descripcion }}</th>
                    </tr>
                    <tr class="table-warning reduced-font">
                        <th>CARGO</th>
                        <th>: {{ $contrato->cargo_mae->nombre}}</th>
                    </tr>
                @endif

                @if ($contrato->id_cargo_sm != null)
                    <tr class="table-warning reduced-font">
                        <th>SECRETARIA MUNICIPAL</th>
                        <th>: {{ '['.$contrato->cargo_sm->direccion->secretaria_municipal->sigla.']'.' '.$contrato->cargo_sm->direccion->secretaria_municipal->nombre }}</th>
                    </tr >
                    <tr class="table-warning reduced-font">
                        <th>DIRECCIÓN</th>
                        <th>: {{ '['.$contrato->cargo_sm->direccion->sigla.'] '.$contrato->cargo_sm->direccion->nombre }}</th>
                    </tr>
                    <tr class="table-warning reduced-font">
                        <th>UNIDAD ADMINISTRATIVA SI CORRESPONDE</th>
                        @if (!empty($contrato->cargo_sm->unidades_admnistrativas))
                            <th>: {{ '[ '.$contrato->cargo_sm->unidades_admnistrativas->sigla.'] '.$contrato->cargo_sm->unidades_admnistrativas->nombre }}</th>
                        @else
                            <th></th>
                        @endif

                    </tr>
                    <tr class="table-warning reduced-font">
                        <th>CARGO</th>
                        <th>: {{ $contrato->cargo_sm->nombre }}</th>
                    </tr>
                @endif


                <tr class="table-info reduced-font">
                    <th>AMBITO PROFESIONAL</th>
                    <th>: {{ $contrato->profesion->ambito->nombre }}</th>
                </tr>
                <tr class="table-info reduced-font">
                    <th>PROFESIÓN</th>
                    <th>: {{ $contrato->profesion->nombre }}</th>
                </tr>
                <tr class="table-info reduced-font">
                    <th>GRADO ACÁDEMICO</th>
                    <th>: {{ '['.$contrato->grado_academico->abreviatura.'] '.$contrato->grado_academico->nombre }}</th>
                </tr>
                <tr class="table-info reduced-font">
                    <th>HORARIO</th>
                    <th>
                        <div class="table-responsive text-nowrap" >
                            <table class="table table-hover table-sm">
                                <thead class="table-primary">
                                    <tr class="reduced-font">
                                        <th id="letras_peque" >DESCRIPCIÓN</th>
                                        <th id="letras_peque" >HORA INICIO</th>
                                        <th id="letras_peque">HORA FINAL</th>
                                        <th id="letras_peque">TOLERANCIA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contrato->horario->rango_hora as $lis)
                                        <tr>
                                            <td  id="letras_peque">{{ $lis->nombre }}</td>
                                            <td id="letras_peque">{{ $lis->hora_inicio.' '.obtener_hora($lis->hora_inicio) }}</td>
                                            <td id="letras_peque">{{ $lis->hora_final.' '.obtener_hora($lis->hora_final) }}</td>
                                            <td id="letras_peque">{{ obtenerMinutosLiteral($lis->tolerancia) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </th>
                </tr>

                <tr class="table-danger reduced-font">
                    <th>REGISTRADO POR: </th>
                    {{-- <th>{{ $contrato->usuario->nombres.' '.$contrato->usuario->apellidos }}</th> --}}
                </tr>

            </thead>
        </table>
    @else
    <div class="col-12">
        <div class="alert alert-danger" role="alert">
            <strong class="ltr:mr-1 rtl:ml-1">Nota ! </strong>No tiene contratos registrados
        </div>
    </div>
    @endif
</div>
