<!-- Add role form -->
<form id="formulario_editar_rol" class="row g-3">
    <input type="hidden" name="id_rol_editar" id="id_rol_editar" value="{{ $roles_edi->id }}">
    <div class="col-12 mb-4">
        <label class="form-label" for="nombre_rol_">Rol</label>
        <input type="text" id="nombre_rol_" name="nombre_rol_" class="form-control" value="{{ $roles_edi->name }}" placeholder="Ingrese el nombre del rol" tabindex="-1" />
        <div id="_nombre_rol_" ></div>
    </div>
    <div class="col-12">
        <h5>Permisos</h5>
        <!-- Permission table -->
        <div class="table-responsive">
            <table class="table table-flush-spacing">
                <tbody>

                    @if ($permiso->isEmpty())
                        <hr>
                        No hay ningun permiso registrado
                    @else
                        <tr>
                            <td class="text-nowrap fw-medium">Seleccionar todos<i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Seleccionar todos los permisos disponibles solo para superadministrador"></i></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="marcar_des"  onchange="marcar_desmarcar_edi(this);" />
                                </div>
                            </td>
                        </tr>
                        @foreach ($permiso as $id => $value)
                            <tr>
                                <td class="text-nowrap fw-medium">{{ $value }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="form-check me-3 me-lg-5">
                                            <input class="form-check-input" type="checkbox" name="permisos_edi[]" id="{{ $value }}" value="{{ $value }}"  {{ $roles_edi->permissions->contains($id) ? 'checked' : '' }}/>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Permission table -->
    </div>
</form>
<!--/ Add role form -->
