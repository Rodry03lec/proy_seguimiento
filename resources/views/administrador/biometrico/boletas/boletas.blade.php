@extends('principal')
@section('titulo', ' | BOLETAS')

@section('estilos')
    <style>
        .cards-list {
            z-index: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card_rodry {
            margin: 30px auto;
            width: 300px;
            height: 300px;
            border-radius: 40px;
            box-shadow: 5px 5px 30px 7px rgba(0, 0, 0, 0.25), -5px -5px 30px 7px rgba(0, 0, 0, 0.22);
            cursor: pointer;
            transition: 0.4s;
            background-color: #000000
        }

        .card_rodry .card_image {
            width: inherit;
            height: inherit;
            border-radius: 40px;
        }

        .card_rodry .card_image img {
            width: inherit;
            height: inherit;
            border-radius: 40px;
            object-fit: cover;
        }

        .card_rodry .card_title {
            text-align: center;
            border-radius: 0px 0px 40px 40px;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 30px;
            margin-top: -50px;
            height: 40px;
        }

        .card_rodry:hover {
            transform: scale(0.9, 0.9);
            box-shadow: 5px 5px 30px 15px rgba(0, 0, 0, 0.25),
                -5px -5px 30px 15px rgba(0, 0, 0, 0.22);
        }

        .title-white {
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .title-black {
            color: black;
        }

        @media all and (max-width: 500px) {
            .card-list {
                /* On small screens, we are no longer using row direction but column */
                flex-direction: column;
            }
        }

        /* Responsive CSS */
        @media screen and (max-width: 768px) {
            .card_rodry {
                width: 100%;
                height: auto; /* Ajusta la altura automáticamente */
                margin: 20px auto; /* Cambia el margen */
            }

            .card_rodry .card_title {
                margin-top: -40px; /* Ajusta el margen superior del título */
            }
        }
    </style>
@endsection

@section('contenido')

    <div class="card card-responsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: BOLETAS :::::::: </h5>
        </div>

        <div class="cards-list">
            @can('boletas_generar_permiso')
                <a href="{{ route('cbol_boleta_permiso') }}">
                    <div class="card_rodry">
                        <div class="card_image">
                            <img src="{{ asset('rodry/imagenes/primero.webp') }}" />
                        </div>
                        <div class="card_title title-white">
                            <p>PERMISOS</p>
                        </div>
                    </div>
                </a>
            @endcan

            @can('boletas_generar_licencia')
                <a href="{{ route('cbol_boleta_licencia') }}">
                    <div class="card_rodry">
                        <div class="card_image">
                            <img src="{{ asset('rodry/imagenes/segundo.webp') }}" />
                        </div>
                        <div class="card_title title-white">
                            <p>LICENCIAS</p>
                        </div>
                    </div>
                </a>
            @endcan

        </div>
    </div>
@endsection
@section('scripts')
    <script></script>
@endsection
