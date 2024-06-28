@extends('principal')
@section('titulo', ' | ESPECIAL')
@section('contenido')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">:::::::: ESPECIAL  :::::::: </h5>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ">
            <div class="card text-center mb-3">
                @can('especial_permisos')
                    <div class="card-body">
                        <h5 class="card-title">PERMISOS</h5>
                        <p class="card-text">Administración de los diferentes permisos bajo normativa</p>
                        <a href="{{ route('cper_index') }}" class="btn btn-outline-primary">INGRESAR</a>
                    </div>
                @endcan

            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ">
            <div class="card text-center mb-3">
                @can('especial_licencias')
                    <div class="card-body ">
                        <h5 class="card-title">LICENCIAS</h5>
                        <p class="card-text">Administración de las diferentes licencias bajo normativa</p>
                        <a href="{{ route('clic_configuracion') }}" class="btn btn-outline-primary p-2">INGRESAR</a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ">
            <div class="card text-center mb-3">
                @can('especial_feriado')
                    <div class="card-body">
                        <h5 class="card-title">FERIADO</h5>
                        <p class="card-text">Se realiza el registro de todos los feriados pero por gestión</p>
                        <a href="{{ route('cfer_index') }}" class="btn btn-outline-primary">INGRESAR</a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ">
            <div class="card text-center mb-3">
                @can('especial_horario_continuo')
                    <div class="card-body">
                        <h5 class="card-title">HORARIO CONTINUO</h5>
                        <p class="card-text">Se define de que fecha a que fecha sera el horario continuo</p>
                        <a href="{{ route('chcon_index') }}" class="btn btn-outline-primary">INGRESAR</a>
                    </div>
                @endcan
            </div>
        </div>

    </div>


    <!--/ Text alignment -->
@endsection
@section('scripts')
    <script>

    </script>
@endsection
