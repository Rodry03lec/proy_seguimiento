<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo ">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('rodry/img_logos/logo_png.png') }}" alt=""  width="35" height="35">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">GAMH</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Misc -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Misc">INICIO</span>
        </li>
        <li class="menu-item @if ($menu=='0') active @endif ">
            <a href="{{ route('inicio') }}"  class="menu-link">
                <i class="menu-icon tf-icons ti ti-lifebuoy"></i>
                <div>INICIO</div>
            </a>
        </li>

        @can('admin_usuario_menu')
            <li class="menu-item @if ($menu == '1'||$menu == '2'|| $menu == '3') open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Users">ADMIN USUARIOS</div>
                </a>
                <ul class="menu-sub">
                    @can('usuario_submenu')
                        <li class="menu-item @if($menu == '1') active @endif">
                            <a href="{{ route('usuarios') }}" class="menu-link">
                                Usuarios
                            </a>
                        </li>
                    @endcan

                    @can('roles_submenu')
                        <li class="menu-item @if($menu == '2') active @endif">
                            <a href="{{ route('roles') }}" class="menu-link">
                                Roles
                            </a>
                        </li>
                    @endcan

                    @can('permisos_submenu')
                        <li class="menu-item @if($menu == '3') active @endif">
                            <a href="{{ route('permisos') }}" class="menu-link">
                                Permisos
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        @can('configuracion_menu')
            <li class="menu-item @if ($menu == '4' || $menu == '5'|| $menu == '6'|| $menu=='7'|| $menu=='8'||$menu == '9'||$menu == '10'||$menu == '11'||$menu == '12') open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Users">CONFIGURACIÓN</div>
                </a>
                <ul class="menu-sub">
                    @can('tipo_contrato_submenu')
                        <li class="menu-item @if($menu == '4') active @endif">
                            <a href="{{ route('ctc_tipoContato') }}" class="menu-link">
                                Tipo de Contrato
                            </a>
                        </li>
                    @endcan

                    @can('tipo_categoria_submenu')
                        <li class="menu-item @if($menu == '5') active @endif">
                            <a href="{{ route('xtc_tipocategoria') }}" class="menu-link">
                                Tipo de categoría
                            </a>
                        </li>
                    @endcan

                    @can('grados_academicos_submenu')
                        <li class="menu-item @if($menu == '6') active @endif">
                            <a href="{{ route('gac_index') }}" class="menu-link">
                                Grados Académicos
                            </a>
                        </li>
                    @endcan

                    @can('ambito_profesional_submenu')
                        <li class="menu-item @if($menu == '7') active @endif">
                            <a href="{{ route('cap_index') }}" class="menu-link">
                                Ambito - Profesional
                            </a>
                        </li>
                    @endcan

                    @can('mae_unidad_submenu')
                        <li class="menu-item @if($menu == '8') active @endif">
                            <a href="{{ route('mae_index') }}" class="menu-link">
                                Mae - Unidad
                            </a>
                        </li>
                    @endcan

                    @can('unidades_administrativas_submenu')
                        <li class="menu-item @if($menu == '9') active @endif">
                            <a href="{{ route('uadm_index') }}" class="menu-link">
                                Unidades Administrativas
                            </a>
                        </li>
                    @endcan

                    @can('secretaria_municipales_direccion_submenu')
                        <li class="menu-item @if($menu == '10') active @endif">
                            <a href="{{ route('smun_index') }}" class="menu-link">
                                Secretarias municipales - Dirección
                            </a>
                        </li>
                    @endcan

                    @can('horarios_submenu')
                        <li class="menu-item @if($menu == '11') active @endif">
                            <a href="{{ route('hor_index') }}" class="menu-link">
                                Horarios
                            </a>
                        </li>
                    @endcan

                    @can('genero_estado_civil_submenu')
                        <li class="menu-item @if($menu == '12') active @endif">
                            <a href="{{ route('ges_index') }}" class="menu-link">
                                Genero - Estado Civil
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan


        @can('registros_menu')
            <li class="menu-item @if ($menu == '13'|| $menu == '14') open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Users">REGISTROS</div>
                </a>
                <ul class="menu-sub">
                    @can('persona_submenu')
                        <li class="menu-item @if($menu == '13') active @endif">
                            <a href="{{ route('per_index') }}" class="menu-link">
                                Personas
                            </a>
                        </li>
                    @endcan

                    @can('contrato_submenu')
                        <li class="menu-item @if($menu == '14') active @endif">
                            <a href="{{ route('cco_index') }}" class="menu-link">
                                Contratos
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        {{-- VAMOS A OCUPAR EL MENU  E 15 AL 20 --}}
        @can('adm_biometrico_menu')
            <li class="menu-item @if ($menu == '15'|| $menu == '16'|| $menu == '17'||$menu == '18'||$menu == '19') open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-server"></i>
                    <div data-i18n="Users">ADM. BIOMETRICO</div>
                </a>
                <ul class="menu-sub">
                    @can('subir_biometrico_submenu')
                        <li class="menu-item @if($menu == '15') active @endif">
                            <a href="{{ route('bio_index') }}" class="menu-link">
                                Subir Biometrico
                            </a>
                        </li>
                    @endcan

                    @can('especial_submenu')
                        <li class="menu-item @if($menu == '16') active @endif">
                            <a href="{{ route('bio_especial') }}" class="menu-link">
                                Especial
                            </a>
                        </li>
                    @endcan


                    @can('asistencia_submenu')
                        <li class="menu-item @if($menu == '17') active @endif">
                            <a href="{{ route('asist_index') }}" class="menu-link">
                                Asistencias
                            </a>
                        </li>
                    @endcan


                    @can('boletas_submenu')
                        <li class="menu-item @if($menu == '18') active @endif">
                            <a href="{{ route('cbol_index') }}" class="menu-link">
                                Boletas
                            </a>
                        </li>
                    @endcan


                    {{-- <li class="menu-item @if($menu == '19') active @endif">
                        <a href="{{ route('cbol_index') }}" class="menu-link">
                            Aprobar boletas
                        </a>
                    </li> --}}
                </ul>
            </li>
        @endcan


        {{-- AQUI VAMOS A OCUPAR EL MENU DE 21 A 25 --}}
        {{-- <li class="menu-item @if ($menu == '21'|| $menu == '22') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Users">REPORTES</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if($menu == '21') active @endif">
                    <a href="{{ route('bio_index') }}" class="menu-link">
                        Biometrico asistencia
                    </a>
                </li>
            </ul>
        </li> --}}



        @can('menu_configuracion_tramite')
            <!--VAMOS A UTILIZAR DESDE EL 50 al 60  PARA LA PARTE DE LOS TRAMITES-->
            <li class="menu-item @if ($menu == '50' || $menu == '51' || $menu == '52') open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Users">CONFIGURACIÓN TRAMITE</div>
                </a>
                <ul class="menu-sub">
                    @can('tipos_tramite_submenu')
                        <li class="menu-item @if($menu == '50') active @endif">
                            <a href="{{ route('ttram_index') }}" class="menu-link">
                                Tipo de Tramite
                            </a>
                        </li>
                    @endcan

                    @can('tipos_esado_submenu')
                        <li class="menu-item @if($menu == '51') active @endif">
                            <a href="{{ route('test_index') }}" class="menu-link">
                                Tipos de estado
                            </a>
                        </li>
                    @endcan

                    @can('habilitar_tramite_submenu')
                        <li class="menu-item @if($menu == '52') active @endif">
                            <a href="{{ route('htram_index') }}" class="menu-link">
                                Habilitar a tramite
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan



        {{-- PARA LA ADMINISTRACION DE LOS PERMISOS DEL 60 PARA ARRIBA --}}
        <li class="menu-item @if ($menu=='60') active @endif ">
            <a href="{{ route('ctram_index') }}"  class="menu-link">
                <i class="menu-icon tf-icons ti ti-filter"></i>
                <div>TRAMITES</div>
            </a>
        </li>

        {{-- PARA LA ADMINISTRACION DE LOS PERMISOS DEL 70 PARA ARRIBA --}}
        <li class="menu-item @if ($menu=='70') active @endif ">
            <a href="{{ route('cobus_index') }}"  class="menu-link">
                <i class="menu-icon tf-icons ti ti-search"></i>
                <div>BUSCAR TRAMITES</div>
            </a>
        </li>

        <!--VAMOS A UTILIZAR DESDE EL 80  PARA LA PARTE DE LOS TRAMITES-->
        <li class="menu-item @if ($menu == '80' || $menu == '81' || $menu == '82') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-clipboard"></i>
                <div data-i18n="Users">REPORTES PDF</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if($menu == '80') active @endif">
                    <a href="{{ route('crt_reportes_index') }}" class="menu-link">
                        Reporte Tramite
                    </a>
                </li>
                {{-- <li class="menu-item @if($menu == '81') active @endif">
                    <a href="{{ route('test_index') }}" class="menu-link">
                        Reporte del personal
                    </a>
                </li> --}}
            </ul>
        </li>


    </ul>



</aside>
<!-- / Menu -->
