<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>ASISTENCIA GAMH</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('rodry/img_logos/logo_png.png') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/css/rtl/theme-semi-dark.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin_template/css/demo.css') }}" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/flatpickr/flatpickr.css') }}" />
    <script src="{{ asset('admin_template/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <script src="{{ asset('admin_template/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>


    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: #003a5fa8;
        }

        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .bubble {
            position: absolute;
            bottom: -150px;
            background-color: rgb(255, 255, 255);
            border-radius: 50%;
            opacity: 0.6;
            animation: rise 15s infinite ease-in;
        }

        .bubble:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-duration: 12s;
        }

        .bubble:nth-child(2) {
            width: 40px;
            height: 40px;
            left: 20%;
            animation-duration: 18s;
        }

        .bubble:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 35%;
            animation-duration: 22s;
        }

        .bubble:nth-child(4) {
            width: 100px;
            height: 100px;
            left: 50%;
            animation-duration: 16s;
        }

        .bubble:nth-child(5) {
            width: 70px;
            height: 70px;
            left: 65%;
            animation-duration: 14s;
        }

        .bubble:nth-child(6) {
            width: 50px;
            height: 50px;
            left: 80%;
            animation-duration: 20s;
        }

        .bubble:nth-child(7) {
            width: 90px;
            height: 90px;
            left: 90%;
            animation-duration: 19s;
        }

        @keyframes rise {
            0% {
                transform: translateY(0);
                opacity: 0.6;
            }
            50% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-1000px);
                opacity: 0;
            }
        }

        .authentication-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }

        .authentication-inner {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .auth-cover-bg {
            position: relative;
            background-image: url("{{ asset('rodry/img_logos/logo_oficial.jpg') }}");
            background-size: cover;
            background-position: center;
            border-radius: 10px 0 0 10px;
        }

        .auth-cover-bg .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.688);
            border-radius: 10px 0 0 10px;
        }

        .auth-illustration {
            z-index: 2;
            position: relative;
            width: 100%;
            height: 80%;
            padding: 10%;
        }

        #formulario {
            font-family: sans-serif;
            background: #205ab4;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        #formulario > h3 {
            color: #fff;
        }

        .btn-primary {
            background-color: #0044aa;
            border-color: #43669c;
        }
    </style>
</head>

<body>
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="authentication-wrapper authentication-bg">
        <div class="authentication-inner row">
            <div class="d-none d-lg-flex col-lg-7 p-0 auth-cover-bg">
                <div class="overlay"></div>
                <img src="{{ asset('rodry/img_logos/logo_png.png') }}" alt="logo" class="img-fluid my-4 p-8 auth-illustration">
            </div>
            <div class="d-flex col-12 col-lg-5 align-items-center p-4">
                <div class="w-100">
                    @if ($errors->any())
                        <script>
                            let errores = @json($errors->all());
                        </script>
                    @endif

                    <div id="formulario">
                        <h3 class="mb-1 text-center">REPORTE DE ASISTENCIA</h3>
                        <p class="mb-4 text-center">¡Por favor ingrese los campos requeridos!</p>
                    </div>

                    <form method="GET" action="{{ route('crep_asistencia_reporte') }}" class="mb-3" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="ci" class="form-label">INGRESE CI</label>
                            <input type="text" class="form-control" id="ci" name="ci" placeholder="Ingrese su CI" value="{{ old('ci') }}">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_inicial" class="form-label">SELECCIONE LA FECHA INICIAL</label>
                            <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" placeholder="Ingrese la fecha inicial" onchange="validar_fechas()">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_final" class="form-label">INGRESE LA FECHA FINAL</label>
                            <input type="text" class="form-control" id="fecha_final" name="fecha_final" placeholder="Ingrese la fecha final" onchange="validar_fechas()">
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100">Generar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin_template/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/js/bootstrap.js') }}"></script>

    <script>
        function fechas_flatpicker(fecha) {
            flatpickr("#" + fecha, {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: {
                    firstDayOfWeek: 1,
                },
            });
        }

        fechas_flatpicker('fecha_inicial');
        fechas_flatpicker('fecha_final');

        function validar_fechas() {
            let fecha_inicio = new Date(document.getElementById('fecha_inicial').value);
            let fecha_final = new Date(document.getElementById('fecha_final').value);
            if (fecha_inicio > fecha_final) {
                alerta_top('error', 'La fecha final debe ser mayor a la fecha inicial');
                document.getElementById('fecha_final').value = '';
            }
        }

        function alerta_top(tipo, mensaje) {
            Swal.fire({
                position: "top-end",
                icon: tipo,
                title: mensaje,
                showConfirmButton: false,
                timer: 1500
            });
        }

        if (typeof errores !== 'undefined') {
            let mensajes = errores.join('<br>');
            Swal.fire({
                title: "NOTA!",
                text: "Datos erróneos",
                icon: "error",
                html: mensajes,
                confirmButtonText: "Ok",
                showCancelButton: false,
            });
        }
    </script>
</body>
</html>
