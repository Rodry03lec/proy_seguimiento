<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-semi-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum=1.0" />
    <title>Login</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('rodry/img_logos/logo_png.png') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/css/rtl/theme-semi-dark.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin_template/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/libs/%40form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/vendor/css/pages/page-auth.css') }}">
    <!-- Helpers -->
    <script src="{{ asset('admin_template/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/js/template-customizer.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('rodry/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/css/css.css') }}">

    <link rel="stylesheet" href="{{ asset('rodry/estilo/estilo_capcha.css') }}">



    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #010101f3 15%, #000000e7 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('rodry/imagenes/fondo_img.jpeg') }}') center/cover no-repeat;
            opacity: 0.8;
            z-index: -1;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(0, 0, 0);
            /* Color de la superposición oscura */
            opacity: 0.1;
            /* Nivel de transparencia de la superposición oscura */
            z-index: -1;
            /* Coloca la superposición detrás del contenido pero encima de la imagen de fondo */
        }

        .background-logo {
            position: absolute;
            top: auto;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            opacity: 0.1;
            /* 50% de transparencia */
            z-index: 900;
            /* Un valor alto para asegurar que esté al frente */
            pointer-events: none;
            /* Evita la interferencia con otros elementos */
        }

        .background-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black;
            /* Color oscuro para la superposición */
            opacity: 0.5;
            /* Nivel de oscuridad */
            z-index: -1;
            /* Asegura que la superposición esté detrás de la imagen */
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.369);
            background: rgb(255, 255, 255);
            backdrop-filter: blur(10px);
            z-index: 1;
        }

        .card-body {
            padding: 2rem;
            color: #333;
        }

        .app-brand {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .app-brand .app-brand-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
        }

        .form-label {
            color: #333;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.777);
            border: 1px solid rgba(7, 0, 0, 0.345);
            color: #000000;
        }

        .form-control::placeholder {
            color: #999;
        }

        .btn-primary {
            background-color: #667eea;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #000000d0;
        }

        .spinner-border {
            color: #667eea;
        }

        #loading-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <!-- Loading wrapper start -->
    <div id="loading-wrapper">
        <div class="spinner-border"></div>
        <span style="color: white;">Cargando login . . . .</span>
    </div>
    <!-- Loading wrapper end -->

    <img src="{{ asset('rodry/img_logos/logo_png.png') }}" alt="Logo" class="background-logo">

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bold ms-1"><strong>LOGIN</strong> </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <div id="mensaje_error"></div>

                        <form id="formulario_login" class="mb-3" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label for="usuario" class="form-label"> <strong>USUARIO</strong> </label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    placeholder="Ingrese usuario" autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"> <strong>CONTRASEÑA</strong> </label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Ingrese su contraseña" autofocus>
                            </div>

                            <div class="mb-3">
                                <div class="captcha">
                                    <div class="captcha-container">
                                        <div class="rectangulo"></div>
                                        <span class="captcha-text" id="optener_cap"></span>
                                    </div>
                                    <button class="action-btn btn-refrescar" onclick="inicio()" type="button">
                                        <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block capitalize form-label">Captcha</label>
                                <div class="relative">
                                    <input type="text" name="captcha" id="captcha" class="form-control py-2" placeholder="Ingrese captcha">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" id="btn_ingresar_usuario">INGRESAR</button>
                            </div>

                            <div class="divider my-1">
                                <div class="divider-text">
                                    <a target="_blank" href="{{ route('correspondencia_vista') }}">
                                        <span class="badge bg-primary">SEGUIMIENTO</span>
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_template/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/js/menu.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin_template/js/pages-auth.js') }}"></script>

    <script>
        window.addEventListener('load', function() {
            setTimeout(() => {
                var loader = document.getElementById('loading-wrapper');
                loader.style.display = 'none';
            }, 500);
        });

        let login_btn = document.getElementById('btn_ingresar_usuario');
        let nuevo_icono = document.createElement('span');
        let nuevo_mensaje = document.createElement('span');

        login_btn.addEventListener('click', async () => {
            let datos = Object.fromEntries(new FormData(document.getElementById('formulario_login')).entries());
            console.log(datos);

            validar_boton(true, "Verificando datos . . . . ");
            try {
                let respuesta = await fetch("{{ route('cl_ingresar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos)
                });
                let data = await respuesta.json();
                if (data.tipo === 'success') {
                    document.getElementById('mensaje_error').innerHTML = `<p id="success_estilo" >` + data
                        .mensaje + `</p>`;
                    window.location = '';
                    validar_boton(false, 'Datos correctos . . . . ');
                }
                if (data.tipo === 'error') {
                    document.getElementById('mensaje_error').innerHTML = `<p id="error_estilo" >` + data
                        .mensaje + `</p>`;
                    validar_boton(false, 'INGRESAR');
                }
            } catch (error) {
                console.log('Existe un error : ' + error);
                validar_boton(false, 'INGRESAR');
            }
        });

        function validar_boton(valor, msj) {
            if (valor === true) {
                nuevo_icono.className = "spinner-border";
                let contenedor = document.createElement("div");
                contenedor.appendChild(nuevo_icono);
                contenedor.appendChild(document.createTextNode(" "));
                contenedor.appendChild(login_btn.firstChild);
                login_btn.insertBefore(contenedor, login_btn.firstChild);
                login_btn.disabled = true;
            }
            if (valor === false) {
                login_btn.innerHTML = msj;
                login_btn.disabled = false;
            }
        }


        function inicio() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = xhr.responseText;
                    document.getElementById('optener_cap').innerHTML = data;
                    //document.getElementById('captcha_validar').value = data;
                }
            };
            xhr.open("GET", "{{ route('captcha') }}", true);
            xhr.send();
        }

        document.addEventListener("DOMContentLoaded", inicio);
    </script>
</body>

</html>
