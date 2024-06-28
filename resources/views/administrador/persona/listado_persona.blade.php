<div class="card-header d-flex flex-wrap justify-content-between gap-3">
    @if ($listar_persona != null)
        <table class="table table-hover" id="tabla_tipo_categoria" style="width: 100%">
            <thead>
                <tr>
                    <th>CI</th>
                    <th> : @if ($listar_persona[0]->complemento)
                        {{ $listar_persona[0]->ci.' '.$listar_persona[0]->complemento }}
                    @else
                        {{ $listar_persona[0]->ci }}
                    @endif</th>
                </tr>
                <tr>
                    <th>NIT</th>
                    <th> : {{ $listar_persona[0]->nit }}</th>
                </tr>
                <tr>
                    <th>NOMBRES Y APELLIDOS </th>
                    <th> : {{ $listar_persona[0]->nombres.' '.$listar_persona[0]->ap_paterno.' '.$listar_persona[0]->ap_materno }}</th>
                </tr>
                <tr>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>: {{ fecha_literal($listar_persona[0]->fecha_nacimiento, 5) }} </th>
                </tr>
                <tr>
                    <th>GMAIL </th>
                    <th>: {{ $listar_persona[0]->gmail }}</th>
                </tr>
                <tr>
                    <th>CELULAR </th>
                    <th>: {{ $listar_persona[0]->celular }}</th>
                </tr>
                <tr>
                    <th>DIRECCIÓN</th>
                    <th>: {{ $listar_persona[0]->direccion }}</th>
                </tr>
                <tr>
                    <th>GÉNERO</th>
                    <th>: {{ $listar_persona[0]->genero->nombre }}</th>
                </tr>
                <tr>
                    <th>ESTADO CIVIL</th>
                    <th>: {{ $listar_persona[0]->estado_civil->nombre }}</th>
                </tr>
                <tr>
                    <th>ESTADO</th>
                    <th>: @if ($listar_persona[0]->estado == 'activo')
                        <span class="badge bg-label-success">{{ $listar_persona[0]->estado }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ $listar_persona[0]->estado }}</span>
                    @endif</th>
                </tr>
            </thead>
        </table>
        <div class="demo-inline-spacing">
            @can('persona_editar')
                <button type="button" class="btn btn-outline-primary" onclick="editar_persona({{ $listar_persona[0]->id }})">Editar</button>
            @endcan

            @can('persona_eliminar')
                <button type="button" class="btn btn-outline-danger" onclick="eliminar_persona({{ $listar_persona[0]->id }})">Eliminar</button>
            @endcan

            @can('persona_listar_contratos')
                <a href="{{ route('lc_listar_contratos', ['id' => encriptar($listar_persona[0]->id)]) }}" class="btn btn-outline-success">Listar Contratos</a>
            @endcan
        </div>
    @else
    <div class="col-12">
        <div class="alert alert-danger" role="alert">
            <strong class="ltr:mr-1 rtl:ml-1">Nota ! </strong>No existe registros similares . . . .
        </div>
    </div>
    @endif
</div>
