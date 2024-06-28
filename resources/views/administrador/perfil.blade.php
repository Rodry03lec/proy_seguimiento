@extends('principal')
@section('titulo', '| PERFIL')
@section('contenido')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">User Profile /</span> Profile
    </h4>


    <!-- Header -->
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-md-12">
            <div class="card mb-4">
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ asset('admin_template/img/avatars/14.png') }}" alt="user image"
                            class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ Auth::user()->nombres.' '.Auth::user()->apellidos }}</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item d-flex gap-1">
                                        <i class='ti ti-map-pin'></i> Bolivia
                                    </li>
                                    <li class="list-inline-item d-flex gap-1">
                                        <i class='ti ti-calendar'></i> .............
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-success">
                                <i class='ti ti-check me-1'></i>Conectado . . . 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Change Password -->
        <div class="card mb-4">
            <h5 class="card-header">Cambio de contraseña</h5>
            <div class="card-body">
                <form id="form_password" method="POST">
                    @csrf
                    <input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="mb-3 col-md-12 col-sm-12 col-xl-12 form-password-toggle">
                            <div class="mb-3">
                                <label class="form-label" for="password_">Nueva Contraseña</label>
                                <input type="email" id="password_" name="password_" class="form-control" placeholder="Ingrese la nueva contraseña" required />
                                <div id="_password_"> </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirmar_password">Repetir la Contraseña</label>
                                <input type="email" id="confirmar_password" name="confirmar_password" class="form-control" placeholder="Repita la nueva contraseña" required />
                                <div id="_confirmar_password"> </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div>
                    <button type="button" id="perfil_btn" class="btn btn-primary me-2">Guardar contraseña</button>
                </div>
            </div>
        </div>
        <!--/ Change Password -->
    </div>
    <!--/ Header -->
@endsection
@section('scripts')
<script>
    let btn_perfil = document.getElementById('perfil_btn');
    btn_perfil.addEventListener('click', async ()=>{
        //verificamos los datos
        let datos = Object.fromEntries(new FormData(document.getElementById('form_password')).entries());
        //ahora activamos el boton
        validar_boton(true, "Verificando datos . . . . ", 'perfil_btn');
        //valores a vaciar
        let valores_errores = ['_password_','_confirmar_password'];
        try {
            let respuesta = await fetch("{{ route('pe_guardar') }}", {
                method : 'POST',
                headers:{
                    'Content-Type':'aplication/json'
                },
                body: JSON.stringify(datos)
            });
            let data = await respuesta.json();
            vaciar_errores(valores_errores);
            if(data.tipo === 'success'){
                validar_boton(true, 'Guardando cambios . . . . ', 'perfil_btn');
                vaciar_errores(valores_errores);
                alerta_top(data.tipo, data.mensaje);
                setTimeout(async function() {
                    let datos = Object.fromEntries(new FormData(document.getElementById('formulario_salir')).entries());
                    try {
                        let respuesta = await fetch("{{ route('salir') }}",{
                            method:"POST",
                            headers:{
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(datos)
                        });
                        let dato = await respuesta.json();
                        alerta_top(dato.tipo, dato.mensaje);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                    } catch (error) {
                        console.log('Ocurrio un error: '+error);
                    }
                }, 2000);
            }
            if(data.tipo === 'error'){
                validar_boton(false, 'Guardar contraseña', 'perfil_btn');
            }
            if(data.tipo === 'errores'){
                let obj = data.mensaje;
                for (let key in obj) {
                    document.getElementById('_' + key).innerHTML = `<p id="error_estilo" >` + obj[key] +`</p>`;
                }
                validar_boton(false, 'Guardar contraseña', 'perfil_btn');
            }
        } catch (error) {
            console.log('Existe un error : '+error);
        }
    });
</script>
@endsection
