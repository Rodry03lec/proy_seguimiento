@extends('principal')
@section('titulo', '| BIOMETRICO')

@section('estilos')
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

@endsection
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: BIOMETRICO :::::::: </h5>
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tipo_categoria_nuevo">
                <i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
            </button> --}}
        </div>

        <div class="card-body">
            <form id="form_subido_archivo" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Seleccione Fecha Inicio</label>
                            <input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la fecha inicial" onchange="validarFechas()">
                        </div>
                        <div id="_fecha_inicio" ></div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="fecha_final" class="form-label">Seleccione Fecha Final</label>
                            <input class="form-control" type="text" id="fecha_final" name="fecha_final" placeholder="Seleccione la fecha final" onchange="validarFechas()">
                        </div>
                        <div id="_fecha_final" ></div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Seleccione el archivo</label>
                            <input class="form-control" type="file" id="archivo" name="archivo" accept=".dat">
                        </div>
                        <div id="_archivo"></div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 d-grid">
                        <label for="fecha_final" class="form-label"></label>
                        @can('subir_biometrico_validar_archivo')
                            <button id="btn_subir_archivo" class="btn btn-outline-primary" type="button" style="width: 100%; height: 35px;">Validar Archivo</button>
                        @endcan

                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="tabla_listar_errores" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>DESCRIPCIÓN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>


        fechas_flatpicker('fecha_inicio');
        fechas_flatpicker('fecha_final');

        //para la validacion de las fechas
        function fechas_flatpicker(fecha){
            flatpickr("#"+fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
                // Otras opciones y configuraciones aquí
            });
        }


        //para la parte de la validacion de fechas
        function validarFechas() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaFinal = document.getElementById('fecha_final').value;

            if (fechaInicio && fechaFinal && new Date(fechaFinal) < new Date(fechaInicio)) {
                alerta_top_end('error', 'La fecha final no puede ser menor que la fecha de inicio. Por favor, seleccione otra fecha.');
                document.getElementById('fecha_final').value = '';
            }
        }

        //funcion para vaciar los input o campos
        function vaciar_input_campos(){
            let valores = ['fecha_inicio', 'fecha_final', 'archivo'];
            valores.forEach(elem => {
                document.getElementById(elem).value = '';
            });
            vaciar_errores_biometrico();
        }

        //para el vaciado de errores
        function vaciar_errores_biometrico(){
            let valores = ['_fecha_inicio', '_fecha_final', '_archivo'];
            valores.forEach(elem => {
                document.getElementById(elem).innerHTML = '';
            });
        }

        //para el subido de archivos
        let btn_subir_archivo = document.getElementById('btn_subir_archivo');
        let form_subido_archivo = document.getElementById('form_subido_archivo');
        btn_subir_archivo.addEventListener('click', async ()=>{
            validar_boton(true, 'Verificando datos . . . ', 'btn_subir_archivo');
            vaciar_errores_biometrico();

            let formData = new FormData();
            // Obtiene los valores de los campos del formulario
            let fecha_inicio    = document.getElementById('fecha_inicio').value;
            let fecha_final     = document.getElementById('fecha_final').value;
            let archivoInput    = document.getElementById('archivo');
            let archivo         = archivoInput.files[0]; //  Obtiene el archivo seleccionado

            // Validar si los campos están vacíos
            if (fecha_inicio.trim() === '' || fecha_final.trim() === '' || !archivo) {
                alerta_top('error','Por favor, completa todos los campos, incluyendo la selección de archivo.');
                validar_boton(false, 'Guardar', 'btn_subir_archivo');
            } else {
                // Los campos no están vacíos, procede con la creación de FormData
                formData.append('fecha_inicio', fecha_inicio);
                formData.append('fecha_final', fecha_final);
                formData.append('archivo', archivo);
                // Realiza la solicitud fetch
                let respuesta = await fetch("{{ route('bio_subir') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                // Procesa la respuesta
                let dato = await respuesta.json();
                console.log(dato);
                if(dato.tipo === 'errores'){
                    let obj = dato.mensaje;
                    for (let key in obj) {
                        document.getElementById('_' + key).innerHTML = `<p class="text-sm text-danger" >` + obj[key] +`</p>`;
                    }
                    validar_boton(false, 'Guardar', 'btn_subir_archivo');
                }
                if(dato.tipo === 'success'){
                    alerta_top(dato.tipo, 'Se realizaron los registros correspondientes');
                    validar_boton(false, 'Guardar', 'btn_subir_archivo');
                    vaciar_errores_biometrico();
                    vaciar_input_campos();
                    let i = 1;
                    let persona = Object.values(dato.mensaje);
                    $('#tabla_listar_errores').DataTable({
                        responsive: true,
                        data: persona,
                        dom: 'Bfrtip', // Agrega la letra 'B' para activar los botones
                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                className: 'buttons-pdf', // Agrega la clase personalizada para el color rojo
                                pageSize: 'LEGAL',
                                exportOptions: {
                                    columns: [0, 1]
                                },
                                title: 'LISTADO DE PERSONA NO REGISTRADAS',
                                customize: function(doc) {
                                    // Establece el color de fondo del encabezado del PDF
                                    doc.styles.tableHeader.fillColor = '#3498db';
                                    // Ajusta el ancho del contenido del PDF a la página completa
                                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                }
                            },
                            'excel'
                        ],
                        columns: [{
                                data: null,
                                className: 'table-td',
                                render: function() {
                                    return i++;
                                }
                            },
                            {
                                data: null,
                                className: 'table-td',
                                render: function(data, type, row) {
                                    return data;
                                }
                            },
                        ]
                    });
                }

                setTimeout(() => {
                    alerta_top_end('success','Actualizando la página');
                    setTimeout(() => {
                        actulizar_tabla_biometrico();
                        location.reload();
                    }, 1000);
                }, 10000);
            }
        });

        //funcion  de acctualizar tabla
        function actulizar_tabla_biometrico() {
            $('#tabla_listar_errores').DataTable().destroy();
            $('#tabla_listar_errores').fadeIn(200);
        }
    </script>
@endsection
