<?php

namespace Database\Seeders;

use App\Models\Fechas\Dias_semana;
use App\Models\Fechas\Fecha_principal;
use App\Models\Fechas\Gestion;
use App\Models\Fechas\Mes;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Seeder_fecha_principal extends Seeder
{
    public function run(): void{
        // Llenamos los datos de los días de la semana
        $dias_semana_data = [
            ['sigla' => 'LUN', 'nombre' => 'LUNES'],
            ['sigla' => 'MAR', 'nombre' => 'MARTES'],
            ['sigla' => 'MIE', 'nombre' => 'MIÉRCOLES'],
            ['sigla' => 'JUE', 'nombre' => 'JUEVES'],
            ['sigla' => 'VIE', 'nombre' => 'VIERNES'],
            ['sigla' => 'SAB', 'nombre' => 'SÁBADO'],
            ['sigla' => 'DOM', 'nombre' => 'DOMINGO'],
        ];

        foreach ($dias_semana_data as $data) {
            Dias_semana::firstOrCreate($data);
        }

        // PARA EL LLENADO DE LOS MESES
        $meses_data = [
            'enero', 'febrero', 'marzo', 'abril',
            'mayo', 'junio', 'julio', 'agosto',
            'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];

        foreach ($meses_data as $index => $nombre) {
            Mes::firstOrCreate(['numero' => $index + 1, 'nombre' => mb_strtoupper($nombre, 'UTF-8')]);
        }

        // Llenado de las gestiones y fechas
        $gestiones = ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];

        DB::transaction(function () use ($gestiones) {
            foreach ($gestiones as $gestion) {
                $gestionModelo = Gestion::firstOrCreate(['gestion' => $gestion]);
                $this->crear_fechas($gestion, $gestionModelo->id);
            }
        });
    }

    private function crear_fechas($gestion, $gestionId){
        // Extraer el año de la gestión proporcionada
        $anio = substr($gestion, 0, 4);
        // Obtener todos los meses y crear un arreglo asociativo usando el número del mes como clave
        $meses = Mes::all()->keyBy('numero');
        // Obtener todos los días de la semana y crear un arreglo asociativo usando el nombre del día como clave
        $dias_semana = Dias_semana::all()->keyBy('nombre');
        // Iterar sobre los meses del año
        for ($mes = 1; $mes <= 12; $mes++) {
            // Obtener la cantidad de días en el mes actual
            $daysInMonth = Carbon::createFromDate($anio, $mes)->daysInMonth;
            // Iterar sobre los días del mes
            for ($dia = 1; $dia <= $daysInMonth; $dia++) {
                // Crear un objeto Carbon para la fecha actual
                $date = Carbon::createFromDate($anio, $mes, $dia);
                // Convertir el nombre del día a mayúsculas
                $dayName = mb_strtoupper($date->isoFormat('dddd'), 'UTF-8');
                // Obtener el modelo del día de la semana correspondiente
                if ($dias_semana_modelo = $dias_semana->get($dayName)) {
                    // Obtener el objeto del mes correspondiente
                    $mesObj = $meses->get($mes);
                    // Verificar si se obtuvo el objeto del mes
                    if ($mesObj) {
                        // Crear una nueva instancia de Fecha_principal
                        $fecha_principal = new Fecha_principal();

                        // Configurar las propiedades de la nueva fecha principal
                        $fecha_principal->fecha = $date->format('Y-m-d');
                        $fecha_principal->id_gestion = $gestionId;
                        $fecha_principal->id_mes = $mesObj->id;
                        $fecha_principal->id_dia_sem = $dias_semana_modelo->id;
                        // Guardar la nueva fecha principal en la base de datos
                        $fecha_principal->save();
                    }
                }
            }
        }
    }

}
