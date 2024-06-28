@extends('principal')
@section('titulo', '| LISTAR ASISTENCIA')
@section('contenido')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" >
                    <h5 class="mb-0">:::::::: ASISTENCIA :::::::: </h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger mb-0 alert-dismissible" role="alert">
                            <span class="alert-icon text-danger me-2">
                                <i class="ti ti-ban ti-xs"></i>
                            </span>
                            ¡Ups! los campos son obligatorios!!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="get" action="{{ route('asist_generar') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 py-2">
                                <div class="mb-3">
                                    <label for="ci" class="form-label">Ingrese CI</label>
                                    <input type="text" class="form-control" id="ci" name="ci" placeholder="Ingrese el CI" aria-describedby="ci" onkeyup="validar_ci(this.value)" minlength="5" maxlength="10"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 py-2">
                                <div class="mb-3">
                                    <label for="fecha_inicial" class="form-label">Fecha Inicial</label>
                                    <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" placeholder="Ingrese fecha Inicial" onchange="validar_fechas()" disabled="disabled" />
                                    <div id="_fecha_inicial"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 py-2">
                                <div class="mb-3">
                                    <label for="fecha_final" class="form-label">Fecha final</label>
                                    <input type="text" class="form-control" id="fecha_final" name="fecha_final" placeholder="Ingrese fecha final" onchange="validar_fechas()" disabled="disabled" />
                                    <div id="_fecha_final"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 py-2">
                                <div class="mb-3">
                                    <label for="dias" class="form-label">Días</label>
                                    <select name="dias[]" id="dias" class="select2" multiple disabled="disabled">
                                        <?php foreach ($listar_dias as $lis): ?>
                                            <?php
                                                $selected = '';
                                                if (in_array($lis->id, [1, 2, 3, 4, 5])) {
                                                    $selected = 'selected="selected"';
                                                }
                                            ?>
                                            <option value="<?= $lis->id ?>" <?= $selected ?>><?= $lis->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="_dias"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-grid py-2">
                                <label for="" class="form-label"></label>
                                @can('asistencia_generar')
                                    <button type="submit" class="btn btn-outline-primary" id="buton_enviar" style="width: 100%; height: 35px;" disabled="disabled">Generar</button>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
        <script>

            fechas_flatpicker('fecha_inicial');
            fechas_flatpicker('fecha_final');

            //para la validacion de las fechas
            function fechas_flatpicker(fecha){
                flatpickr("#"+fecha, {
                    dateFormat: "Y-m-d",
                    enableTime: false,
                    locale: {
                        firstDayOfWeek: 1,
                    },
                });
            }

            //para la validacion de la fechasss
            function validar_fechas(){
                let fecha_inicio    = new Date(document.getElementById('fecha_inicial').value);
                let fecha_final     = new Date(document.getElementById('fecha_final').value);
                if(fecha_inicio > fecha_final){
                    alerta_top('error', 'la fecha final debe ser mayor a la fecha final');
                    document.getElementById('fecha_final').value = '';
                }
            }

            //para validar el Ci
            async function validar_ci(ci) {
            // Si la cédula no está vacía y tiene al menos 6 caracteres
                if (ci !== null && ci !== '' && ci.length >= 6) {
                    try {
                    // Hacemos una solicitud POST a la ruta de validación
                    let respuesta = await fetch("{{ route('per_validar') }}", {
                        method: "POST",
                        headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ci: ci})
                    });

                    // Si la solicitud no fue exitosa
                    if (!respuesta.ok) {
                        throw new Error('Hubo un problema con la solicitud fetch: ' + respuesta.status);
                    }

                    // Convertimos la respuesta a JSON
                    let dato = await respuesta.json();

                    // Si el tipo de respuesta es "success"
                    if (dato.tipo === 'success') {
                        // Habilitamos el formulario
                        habilitar_deshabiltar(true);
                        // Limpiamos los campos de entrada
                        vaciar_campos_input();
                        // Mostramos un mensaje de error
                        alertify.error('No existe el registro');
                    }

                    // Si el tipo de respuesta es "error"
                    if (dato.tipo === 'error') {
                        // Mostramos un mensaje de éxito
                        alertify.success('Existe el registro');
                        // Limpiamos los campos de entrada
                        vaciar_campos_input();
                        // Deshabilitamos el formulario
                        habilitar_deshabiltar(false);
                    }
                    } catch (error) {
                    // Si hay un error, lo mostramos en la consola
                    console.log('Error :>> ', error);
                    // Limpiamos los campos de entrada
                    vaciar_campos_input();
                    // Habilitamos el formulario
                    habilitar_deshabiltar(true);
                    }
                } else {
                    // Si la cédula está vacía o no tiene la longitud mínima
                    vaciar_campos_input();
                    habilitar_deshabiltar(true);
                }
            }



            //para habilitar y desabilitar
            function habilitar_deshabiltar(valor){
                let valores = ['fecha_inicial', 'fecha_final', 'dias', 'buton_enviar'];
                valores.forEach(elem => {
                    document.getElementById(elem).disabled = valor;
                });
            }
            //par vaciar los campos
            function vaciar_campos_input(){
                let valores = ['fecha_inicial', 'fecha_final'];
                valores.forEach(elem => {
                    document.getElementById(elem).value = '';
                });
            }


        </script>
    @endsection
