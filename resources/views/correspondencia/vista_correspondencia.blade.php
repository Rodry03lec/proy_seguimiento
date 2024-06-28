<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>SEGUIMIENTO GAMH</title>

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

    <meta name="csrf-token" content="{{ csrf_token() }}">


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
            height: 90vh;
            position: relative;
        }

        .authentication-inner {
            background: #fff;
            padding: 10px;
            border-radius: 20px;
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


        header {
            top: 0cm;
            text-align: right;
            line-height: 1cm;
        }


        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: auto;
            background-color: #ffffff;
            padding: 2px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 13px;
            font-size: 16px;
        }
        th {
            background-color: #0044aa;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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

                    <div id="formulario">
                        <h3 class="mb-1 text-center">BUSQUEDA POR NUMERO UNICO DE CORRESPONDENCIA</h3>
                        <p class="mb-4 text-center">¡Por favor ingrese los campos requeridos!</p>
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label">Nº UNICO DE RUTA</label>
                        <input type="text" class="form-control" id="numero" name="numero" onkeypress="return soloNumeros(event)" onkeyup="validar_numero(this.value)" placeholder="Ingrese el Nº de hoja de ruta" maxlength="10">
                    </div>
                    <hr>
                    <div id="mensaje_corres" ></div>

                    <div class="container">
                        <table class="" >
                            <tr >
                                <th> <strong>NÚMERO ÚNICO</strong> </th>
                                <th> : <span id="numero_unico" ></span></th>
                            </tr>
                            <tr>
                                <th> <strong> FECHA </strong> </th>
                                <th> : <span id="fecha_creada" ></span> </th>
                            </tr>
                            <tr>
                                <th> <strong> REMITENTE  </strong> </th>
                                <th> : <span id="nombre_remitente" ></span></th>
                            </tr>
                            <tr>
                                <th> <strong> REFERENCIA </strong> </th>
                                <th> : <span id="referencia" ></span> </th>
                            </tr>
                            <tr>
                                <th> <strong> DESTINATARIO ACTUAL  </strong> </th>
                                <th> : <span id="destinatario_actual" ></span> </th>
                            </tr>
                            <tr>
                                <th> <strong> ESTADO </strong> </th>
                                <th> <span style="font-weight: bolder" id="estado_actual"> </span> </th>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin_template/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/js/bootstrap.js') }}"></script>

    <script>

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        function soloNumeros(event) {
            // Permite solo números en el campo de texto
            let charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        //para validar el numero
        async function validar_numero(numero){

            let numero_unico        = document.getElementById('numero_unico');
            let fecha_creada        = document.getElementById('fecha_creada');
            let nombre_remitente    = document.getElementById('nombre_remitente');
            let referencia          = document.getElementById('referencia');
            let destinatario_actual = document.getElementById('destinatario_actual');
            let estado_actual       = document.getElementById('estado_actual');
            let mensaje_corres      = document.getElementById('mensaje_corres');

            if(numero.length > 2 && numero != '' && numero != null){
                let respuesta = await fetch("{{ route('crep_seguimiento_correspondencia') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        numero:numero
                    })
                });
                let dato = await respuesta.json();
                console.table(dato);
                if(dato.tipo==='success'){
                    mensaje_corres.innerHTML        =``;
                    numero_unico.innerHTML          = dato.numero_unico;
                    fecha_creada.innerHTML          = dato.fecha_creada;
                    nombre_remitente.innerHTML      = dato.nombre_remitente;
                    referencia.innerHTML            = dato.referencia;
                    destinatario_actual.innerHTML   = dato.destinatario_actual;
                    estado_actual.innerHTML         = dato.estado_actual;
                }

                if(dato.tipo==='error'){
                    mensaje_corres.innerHTML        =`<div class="alert  alert-danger" role="alert">`+dato.mensaje+`</div>`;
                    numero_unico.innerHTML          = '';
                    fecha_creada.innerHTML          = '';
                    nombre_remitente.innerHTML      = '';
                    referencia.innerHTML            = '';
                    destinatario_actual.innerHTML   = '';
                    estado_actual.innerHTML   = '';
                }

            }else{
                mensaje_corres.innerHTML        =``;
                numero_unico.innerHTML          = '';
                fecha_creada.innerHTML          = '';
                nombre_remitente.innerHTML      = '';
                referencia.innerHTML            = '';
                destinatario_actual.innerHTML   = '';
                estado_actual.innerHTML   = '';
            }
        }
    </script>
</body>
</html>
