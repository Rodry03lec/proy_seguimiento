@extends('principal')
@section('titulo', 'VISTA TRAMITE')

@section('estilos')
    <style>
        .custom-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 15px;
            overflow: hidden;
        }

        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 2rem 5rem rgba(0, 0, 0, 0.2);
        }

        .custom-img {
            width: 100px;
            height: 100px;
            border: 3px solid #007bff;
            transition: transform 0.3s;
        }

        .custom-img:hover {
            transform: rotate(360deg);
        }

        .card-title {
            color: #007bff;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-size: 0.9em;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        .background-animated {
            position: relative;
            overflow: hidden;
        }

        .background-animated:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 123, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(0, 123, 255, 0.1) 50%, rgba(0, 123, 255, 0.1) 75%, transparent 75%, transparent);
            background-size: 50px 50px;
            animation: moveBackground 4s linear infinite;
        }

        @keyframes moveBackground {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 50px 50px;
            }
        }
    </style>
@endsection

@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center text-white">
            <h5 class="mb-0">:::::::: CARGOS :::::::: </h5>
        </div>
    </div>
    @if ($listar_cargos->isNotEmpty())
        <div class="row py-4 background-animated">
            @foreach ($listar_cargos as $lis)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card custom-card shadow-lg">
                        <div class="card-body text-center">
                            <div class="mx-auto my-3">
                                <img src="{{ asset('rodry/img_logos/tramite.png') }}" alt="Trámite" class="rounded-circle custom-img" />
                            </div>
                            <h5 class="mb-1 card-title font-weight-bold">CARGO :
                                {{ $lis->cargo_sm->nombre ?? ($lis->cargo_mae->nombre ?? 'Nombre no disponible') }}</h5>

                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('tcar_cargos', ['id' => encriptar($lis->id)]) }}" class="btn btn-primary d-flex align-items-center me-3">
                                    <i class="ti-xs me-1 ti ti-clipboard me-1"></i>INGRESAR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row py-4">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class="alert-icon text-danger me-2">
                    <i class="ti ti-ban ti-xs"></i>
                </span>
                NO TIENE CARGOS PARA LOS TRÁMITES
            </div>
        </div>
    @endif
@endsection
