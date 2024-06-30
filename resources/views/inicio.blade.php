@extends('principal')
@section('titulo', '| INICIO')

<!-- Agregar algunos estilos CSS adicionales -->
<style>
    .card-header img {
        transition: transform 0.5s ease-in-out;
        border-radius: 0.25rem;
    }

    .card-header img:hover {
        transform: scale(1.1);
    }

    .position-absolute img {
        transition: transform 0.5s ease-in-out;
    }

    .position-absolute img:hover {
        transform: scale(1.2);
    }

    .card {
        border: none;
        border-radius: 0.75rem;
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0;
    }
</style>

@section('contenido')
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card shadow-lg">
                <div class="card-header position-relative p-0 overflow-hidden">
                    <!-- Imagen principal -->
                    <img src="{{ asset('graice/titicaca_lago_puno_portada.jpg') }}" class="img-fluid" alt="Imagen Principal" style="width: 100%; height: auto; max-height: 250px; object-fit: cover;">

                    <!-- Logo adicional superpuesto -->
                    <div class="position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2 shadow-lg" style="width: 80px; height: 80px;">
                        <img src="{{ asset('rodry/img_logos/logo_png.png') }}" alt="Logo" class="img-fluid" style="width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>

        <!-- /Line Chart -->
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-subtitle text-muted mb-1">CONTRATOS</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="horizontalBarChart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-subtitle text-muted mb-1">TIPOS DE TRÁMITES REALIZADOS</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="horizontal_segundo"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var opciones = {
                chart: {
                    height: 450,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '30%',
                        startingShape: 'rounded',
                        borderRadius: 8,
                    },
                },
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: -20,
                        bottom: -12
                    },
                },
                colors: ['#0C77FF'], // Ajusta el color según tu configuración
                dataLabels: {
                    enabled: true
                },
                series: [{
                    data: @json($contrato_persona->values())
                }],
                xaxis: {
                    categories: @json($contrato_persona->keys()),
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '8px'
                        }
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '8px'
                        }
                    }
                },
            };

            let chart_primero = new ApexCharts(document.querySelector("#horizontalBarChart"), opciones);
            chart_primero.render();


            const tramiteContar =
                @json($tramite_contar); // Esto convierte los datos PHP a un objeto JavaScript

            // Convertir los datos para usarlos en ApexCharts
            const seriesData = Object.values(tramiteContar);
            const categoriesData = Object.keys(tramiteContar);

            var opciones_1 = {
                chart: {
                    height: 450,
                    type: "line",
                    parentHeightOffset: 0,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                    name: "Trámites",
                    data: seriesData
                }],
                markers: {
                    strokeWidth: 15,
                    strokeOpacity: 1,
                    strokeColors: ["#000"], // Reemplaza con el valor de 'e' si es necesario
                    colors: ["#FFB300"], // Reemplaza con el valor de 'config.colors.warning' si es necesario
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: "straight"
                },
                colors: ["#FFB300"], // Reemplaza con el valor de 'config.colors.warning' si es necesario
                grid: {
                    borderColor: "#E0E0E0", // Reemplaza con el valor de 's' si es necesario
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: -10
                    },
                },
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex
                    }) {
                        return (
                            '<div class="px-3 py-2"><span>' +
                            series[seriesIndex][dataPointIndex] +
                            "%</span></div>"
                        );
                    },
                },
                xaxis: {
                    categories: categoriesData,
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true
                    },
                    labels: {
                        style: {
                            colors: "#333", // Reemplaza con el valor de 'r' si es necesario
                            fontSize: "8px"
                        }
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: "#333", // Reemplaza con el valor de 'r' si es necesario
                            fontSize: "8px"
                        }
                    }
                },
            };

            let chart_segundo = new ApexCharts(document.querySelector("#horizontal_segundo"), opciones_1);
            chart_segundo.render();


        });
    </script>
@endsection
