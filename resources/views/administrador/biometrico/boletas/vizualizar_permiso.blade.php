<div class="col-xxl">
    <h5 class="card-header p-2"> DETALLES DE BOLETA - PERMISO </h5>


    <hr class="mx-n1" />
    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">CI :  <br> NOMBRES : </label>
        <div class="col-sm-9 py-2">
            {{ $permiso->persona->ci.' '.$permiso->persona->complemento }}
            <br>
            {{ $permiso->persona->nombres.' '.$permiso->persona->ap_paterno.' '.$permiso->persona->ap_materno }}
        </div>
    </div>

    <hr class="mx-n1" />
    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">TIPO DE CONTRATO :  </label>
        <div class="col-sm-9 py-2">
            {{ $permiso->contrato->tipo_contrato->nombre }}
        </div>

        <label class="col-sm-3 col-form-label text-sm-end">NÚMERO DE CONTRATO :  </label>
        <div class="col-sm-9 py-2">
            {{ $permiso->contrato->tipo_contrato->sigla.' '.$permiso->contrato->numero_contrato }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">TIPO DE PERMISO : </label>
        <div class="col-sm-9 py-2">
            {{ $permiso->permiso_desglose->tipo_permiso->nombre }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">DESCRIPCIÓN DEL PERMISO : </label>
        <div class="col-sm-9">
            {{ $permiso->permiso_desglose->nombre }}
            <br>
            {{ $permiso->permiso_desglose->descripcion }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA GENERADA : </label>
        <div class="col-sm-9">
            {{ fecha_literal($permiso->fecha, 5)}}
        </div>
    </div>

    <hr class=" mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA INICIO : </label>
        <div class="col-sm-9">
            {{ fecha_literal($permiso->fecha_inicio, 5)}}
        </div>
        <label class="col-sm-3 col-form-label text-sm-end">HORA FINAL : </label>
        <div class="col-sm-9">
            {{ $permiso->hora_inicio.' '.determinar_am_pm($permiso->hora_inicio) }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">FECHA INICIO : <br> HORA FINAL: </label>
        <div class="col-sm-9">
            {{ fecha_literal($permiso->fecha_final, 5)}}
        </div>
        <label class="col-sm-3 col-form-label text-sm-end"> HORA FINAL: </label>
        <div class="col-sm-9">
            {{ $permiso->hora_final.' '.determinar_am_pm($permiso->hora_final) }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">DESCRIPCIÓN : </label>
        <div class="col-sm-9">
            {{ $permiso->descripcion }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">CREADO POR : </label>
        <div class="col-sm-9">
            {{ 'Us:. '.$permiso->usuario_creado->nombres.' '.$permiso->usuario_creado->apellidos }}
        </div>
    </div>

    <hr class="mx-n1" />

    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end">ULTIMA EDICIÓN POR : </label>
        <div class="col-sm-9">
            @if ($permiso->id_us_update != null || $permiso->id_us_update != '')
                {{ 'Us:. '.$permiso->usuario_editado->nombres.' '.$permiso->usuario_editado->apellidos }}
            @endif
        </div>
    </div>




</div>
