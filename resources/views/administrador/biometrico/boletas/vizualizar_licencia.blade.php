<div class="col-xxl">
    <h5 class="card-header p-2"> DETALLES DE BOLETA - LICENCIA </h5>


    <hr class="mx-n1" />
    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">CI :  <br> NOMBRES : </label>
        <div class="col-sm-9 py-2">
            {{ $licencia->persona->ci.' '.$licencia->persona->complemento }}
            <br>
            {{ $licencia->persona->nombres.' '.$licencia->persona->ap_paterno.' '.$licencia->persona->ap_materno }}
        </div>
    </div>

    <hr class="mx-n1" />
    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">TIPO DE CONTRATO :  </label>
        <div class="col-sm-9 py-2">
            {{ $licencia->contrato->tipo_contrato->nombre }}
        </div>

        <label class="col-sm-3 col-form-label text-sm-end">NÚMERO DE CONTRATO :  </label>
        <div class="col-sm-9 py-2">
            {{ $licencia->contrato->tipo_contrato->sigla.' '.$licencia->contrato->numero_contrato }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">DESCRIPCIÓN DE LA LICENCIA : </label>
        <div class="col-sm-9">
            {{ $licencia->tipo_licencia->normativa }}
            <br>
            {{ $licencia->tipo_licencia->motivo }}
            <br>
            {{ $licencia->tipo_licencia->jornada_laboral }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA GENERADA : </label>
        <div class="col-sm-9">
            {{ fecha_literal($licencia->fecha, 5)}}
        </div>
    </div>

    <hr class=" mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA INICIO : </label>
        <div class="col-sm-9">
            {{ fecha_literal($licencia->fecha_inicio, 5)}}
        </div>
        <label class="col-sm-3 col-form-label text-sm-end">HORA FINAL : </label>
        <div class="col-sm-9">
            {{ $licencia->hora_inicio.' '.determinar_am_pm($licencia->hora_inicio) }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA INICIO : <br> HORA FINAL: </label>
        <div class="col-sm-9">
            {{ fecha_literal($licencia->fecha_final, 5)}}
        </div>
        <label class="col-sm-3 col-form-label text-sm-end"> HORA FINAL: </label>
        <div class="col-sm-9">
            {{ $licencia->hora_final.' '.determinar_am_pm($licencia->hora_final) }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">DESCRIPCIÓN : </label>
        <div class="col-sm-9">
            {{ $licencia->descripcion }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">CREADO POR : </label>
        <div class="col-sm-9">
            {{ 'Us:. '.$licencia->usuario_creado->nombres.' '.$licencia->usuario_creado->apellidos }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">ULTIMA EDICIÓN POR : </label>
        <div class="col-sm-9">
            @if ($licencia->id_us_update != null || $licencia->id_us_update != '')
                {{ 'Us:. '.$licencia->usuario_editado->nombres.' '.$licencia->usuario_editado->apellidos }}
            @endif
        </div>
    </div>
</div>
