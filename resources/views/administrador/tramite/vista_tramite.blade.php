@extends('principal')
@section('titulo', 'VISTA TRAMITE')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: CARGOS :::::::: </h5>
        </div>
    </div>
    @if ($listar_cargos->isNotEmpty())
        <div class="row py-4">
            @foreach ($listar_cargos as $lis)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mx-auto my-3">
                                <img src="{{ asset('rodry/img_logos/tramite.png') }}" alt="Trámite" class="rounded-circle w-px-100" />
                            </div>
                            <h5 class="mb-1 card-title">CARGO :
                                {{ $lis->cargo_sm->nombre ?? ($lis->cargo_mae->nombre ?? 'Nombre no disponible') }}</h5>

                            {{-- @if(isset($lis->tramite->hojas_ruta))
                                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                    <div>
                                        <h4 class="mb-0">{{ $lis->tramite->hojas_ruta->bandeja_entrada_count ?? 0 }}</h4>
                                        <span class="badge bg-label-success">Bandeja de entrada</span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $lis->tramite->hojas_ruta->recibidos_count ?? 0 }}</h4>
                                        <span class="badge bg-label-primary">Recibidos</span>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                    <div>
                                        <h4 class="mb-0">0</h4>
                                        <span class="badge bg-label-success">Bandeja de entrada</span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">0</h4>
                                        <span class="badge bg-label-primary">Recibidos</span>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                <div>
                                    <h4 class="mb-0">4</h4>
                                    <span class="badge bg-label-success">Bandeja de entrada</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">3</h4>
                                    <span class="badge bg-label-primary">Recibidos</span>
                                </div>
                            </div>

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
@section('scripts')

@endsection
