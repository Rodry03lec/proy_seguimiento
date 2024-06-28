<?php

function sumar_horas($hora_final, $tolerancia)
{

    // Dividir las horas y los minutos
    list($horasTol, $minutosTol) = explode(':', $tolerancia);
    list($horasFinal, $minutosFinal) = explode(':', $hora_final);

    // Sumar horas y minutos
    $totalHoras = $horasTol + $horasFinal;
    $totalMinutos = $minutosTol + $minutosFinal;

    // Ajustar si los minutos superan 60
    if ($totalMinutos >= 60) {
        $totalMinutos -= 60;
        $totalHoras++;
    }

    // Formatear el resultado
    $hora_final_sumada = sprintf('%02d:%02d', $totalHoras, $totalMinutos);

    // Imprimir el resultado
    return $hora_final_sumada;
}

function contar_minutos_segundos($hora_ingreso_ma, $sumado_primero)
{
    // Convertir la hora de ingreso matutino a segundos desde la época Unix
    $hora_ingreso_ma_segundos = strtotime($hora_ingreso_ma);
    // Convertir la hora sumada a segundos desde la época Unix
    $sumado_primero_segundos = strtotime($sumado_primero);

    // Calcular la diferencia en segundos
    $diferencia_segundos = $hora_ingreso_ma_segundos - $sumado_primero_segundos;
    $diferencia_segundos = abs($diferencia_segundos);

    // Calcular las horas, minutos y segundos
    $horas = floor($diferencia_segundos / 3600);
    $minutos = floor(($diferencia_segundos % 3600) / 60);
    $segundos = $diferencia_segundos % 60;

    // Formatear la salida
    $resultado = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);

    return $resultado;
}


function sumar_tiempo($tiempo_base, $tiempo_a_sumar)
{
    // Convertir el tiempo base a segundos
    if ($tiempo_base == '0') {
        $total_segundos_base = 0;
    } else {
        list($horas_base, $minutos_base, $segundos_base) = explode(':', $tiempo_base);
        $total_segundos_base = ($horas_base * 3600) + ($minutos_base * 60) + $segundos_base;
    }

    // Convertir el tiempo a sumar a segundos
    list($horas_sumar, $minutos_sumar, $segundos_sumar) = explode(':', $tiempo_a_sumar);
    $total_segundos_sumar = ($horas_sumar * 3600) + ($minutos_sumar * 60) + $segundos_sumar;

    // Sumar los segundos totales
    $total_segundos_final = $total_segundos_base + $total_segundos_sumar;

    // Calcular las horas, minutos y segundos finales
    $horas_final = floor($total_segundos_final / 3600);
    $minutos_final = floor(($total_segundos_final - ($horas_final * 3600)) / 60);
    $segundos_final = $total_segundos_final - ($horas_final * 3600) - ($minutos_final * 60);

    // Formatear la salida
    $nuevo_tiempo = sprintf('%02d:%02d:%02d', $horas_final, $minutos_final, $segundos_final);

    return $nuevo_tiempo;
}


function determinar_am_pm($hora)
{
    // Extraemos la hora
    $hora = date('H', strtotime($hora));

    // Verificamos si la hora es menor a 12 para determinar si es AM o PM
    if ($hora < 12) {
        return "AM";
    } else {
        return "PM";
    }
}

//PARA LA PARTE DE LOS MINTOS Y SEGUNDOS
function horaen_palabras($hora)
{
    // Definir array con las palabras para horas
    $horasArray = array(
        1 => 'una hora',
        2 => 'dos horas',
        3 => 'tres horas',
        4 => 'cuatro horas',
        5 => 'cinco horas',
        6 => 'seis horas',
        7 => 'siete horas',
        8 => 'ocho horas',
        9 => 'nueve horas',
        10 => 'diez horas',
        11 => 'once horas',
        12 => 'doce horas'
    );

    // Separar la hora en horas, minutos y segundos
    list($horas, $minutos, $segundos) = explode(':', $hora);

    // Construir la hora en palabras
    $horaEnPalabras = '';

    // Agregar horas si es diferente de cero
    if ($horas != '00') {
        $horaEnPalabras .= $horasArray[(int)$horas];
    }

    // Agregar minutos si es diferente de cero
    if ($minutos != '00') {
        $horaEnPalabras .= ($horaEnPalabras != '' ? ' con ' : '') . ($minutos == '01' ? 'un minuto' : $minutos . ' minutos');
    }

    // Agregar segundos si es diferente de cero
    if ($segundos != '00') {
        $horaEnPalabras .= ($horaEnPalabras != '' ? ' y ' : '') . ($segundos == '01' ? 'un segundo' : $segundos . ' segundos');
    }

    return $horaEnPalabras;
}




//para la parte de los mensajes
function mensaje_mostrar($tipo, $mensaje)
{
    return array(
        'tipo' => $tipo,
        'mensaje' => $mensaje
    );
}



//Para encriptar y desencriptar
function encriptar($string)
{
    $method = 'AES-256-CBC';
    $secret_key = '@Graice';
    $secret_iv = '25081999';

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($string, $method, $key, 0, $iv);

    if ($output === false) {
        throw new Exception("Error al encriptar el mensaje");
    }

    $output = base64_encode($iv . $output);
    return $output;
}

function desencriptar($string)
{
    $method = 'AES-256-CBC';
    $secret_key = '@Graice';
    $secret_iv = '25081999';

    $key = hash('sha256', $secret_key);
    $iv_length = openssl_cipher_iv_length($method);

    $decoded = base64_decode($string);
    $iv = substr($decoded, 0, $iv_length);
    $encrypted_text = substr($decoded, $iv_length);

    $output = openssl_decrypt($encrypted_text, $method, $key, 0, $iv);

    if ($output === false) {
        throw new Exception("Error al desencriptar el mensaje");
    }

    return $output;
}


//para 1000000.00
function sin_separador_comas($monto)
{
    $saldo_respuesta = str_replace(",", "", $monto);
    return $saldo_respuesta;
}
//para 100,000.00
function con_separador_comas($monto)
{
    $saldo_respuesta = number_format($monto, 2, '.', ',');
    return $saldo_respuesta;
}

//para las fechas
function fecha_literal($Fecha, $Formato)
{
    $dias = array(
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Mièrcoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sàbado'
    );
    $meses = array(
        1 => 'enero',
        2 => 'febrero',
        3 => 'marzo',
        4 => 'abril',
        5 => 'mayo',
        6 => 'junio',
        7 => 'julio',
        8 => 'agosto',
        9 => 'septiembre',
        10 => 'octubre',
        11 => 'noviembre',
        12 => 'diciembre'
    );
    $aux = date_parse($Fecha);
    switch ($Formato) {
        case 1:  // 04/10/23
            return date('d/m/y', strtotime($Fecha));
        case 2:  //04/oct/23
            return sprintf('%02d/%s/%02d', $aux['day'], substr($meses[$aux['month']], 0, 3), $aux['year'] % 100);
        case 3:   //octubre 4, 2023
            return $meses[$aux['month']] . ' ' . sprintf('%.2d', $aux['day']) . ', ' . $aux['year'];
        case 4:   // 4 de octubre de 2023
            return $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
        case 5:   //lunes 4 de octubre de 2023
            $numeroDia = date('w', strtotime($Fecha));
            return $dias[$numeroDia] . ' ' . $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
        case 6:
            return date('d/m/Y', strtotime($Fecha));
        default:
            return date('d/m/Y', strtotime($Fecha));
    }
}


//para ver si es masculino femenino o prefiere no decir
function verificar_persona_generto($genero)
{
    if ($genero == 'M') {
        return 'MASCULINO';
    }
    if ($genero == 'F') {
        return 'FEMENINO';
    }
    if ($genero == 'ND') {
        return 'PREFIERE NO DECIR';
    }
}

function obtenerNombreMes($numeroMes)
{
    $nombresMeses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    // Verificar que el número de mes esté dentro del rango válido
    if ($numeroMes >= 1 && $numeroMes <= 12) {
        return $nombresMeses[$numeroMes];
    } else {
        return 'Número de mes no válido';
    }
}



function obtener_hora($hora)
{
    // Obtener el periodo (AM o PM)
    $periodo = date('a', strtotime($hora));
    // Convertir la hora a formato de 12 horas
    $hora12 = date('h:i A', strtotime($hora));
    // Mensaje final
    $mensaje = "";

    if ($periodo == 'am') {
        $mensaje .= " AM";
    } else {
        $mensaje .= " PM";
    }

    return $mensaje;
}


function obtenerMinutosLiteral($hora)
{
    // Obtener los minutos
    $minutos = date('i', strtotime($hora));

    // Mensaje final
    $mensaje = "";

    // Añadir el nombre del minuto directamente
    $mensaje .= obtenerNombreMinuto($minutos) . ' minutos';

    return $mensaje;
}

function obtenerNombreMinuto($minuto)
{
    // Lista de nombres de minutos
    $nombresMinutos = [
        '00' => 'cero',
        '01' => 'uno',
        '02' => 'dos',
        '03' => 'tres',
        '04' => 'cuatro',
        '05' => 'cinco',
        '06' => 'seis',
        '07' => 'siete',
        '08' => 'ocho',
        '09' => 'nueve',
        '10' => 'diez',
        '11' => 'once',
        '12' => 'doce',
        '13' => 'trece',
        '14' => 'catorce',
        '15' => 'quince',
        '16' => 'dieciséis',
        '17' => 'diecisiete',
        '18' => 'dieciocho',
        '19' => 'diecinueve',
        '20' => 'veinte',
        '21' => 'veintiuno',
        '22' => 'veintidós',
        '23' => 'veintitrés',
        '24' => 'veinticuatro',
        '25' => 'veinticinco',
        '26' => 'veintiséis',
        '27' => 'veintisiete',
        '28' => 'veintiocho',
        '29' => 'veintinueve',
        '30' => 'treinta',
        '31' => 'treinta y uno',
        '32' => 'treinta y dos',
        '33' => 'treinta y tres',
        '34' => 'treinta y cuatro',
        '35' => 'treinta y cinco',
        '36' => 'treinta y seis',
        '37' => 'treinta y siete',
        '38' => 'treinta y ocho',
        '39' => 'treinta y nueve',
        '40' => 'cuarenta',
        '41' => 'cuarenta y uno',
        '42' => 'cuarenta y dos',
        '43' => 'cuarenta y tres',
        '44' => 'cuarenta y cuatro',
        '45' => 'cuarenta y cinco',
        '46' => 'cuarenta y seis',
        '47' => 'cuarenta y siete',
        '48' => 'cuarenta y ocho',
        '49' => 'cuarenta y nueve',
        '50' => 'cincuenta',
        '51' => 'cincuenta y uno',
        '52' => 'cincuenta y dos',
        '53' => 'cincuenta y tres',
        '54' => 'cincuenta y cuatro',
        '55' => 'cincuenta y cinco',
        '56' => 'cincuenta y seis',
        '57' => 'cincuenta y siete',
        '58' => 'cincuenta y ocho',
        '59' => 'cincuenta y nueve',
    ];

    // Obtener el nombre del minuto
    return $nombresMinutos[$minuto];
}



function cadena_sin_guion_punto($valor)
{
    $cadena_sin_guiones_y_puntos = str_replace(['-', ':'], ' ', $valor);
    // Eliminar espacios en blanco
    $cadena_sin_espacios = str_replace(' ', '', $cadena_sin_guiones_y_puntos);
    return $cadena_sin_espacios;
}


function unidad($numuero)
{
    switch ($numuero) {
        case 9:
            $numu = "Nueve";
            break;
        case 8:
            $numu = "Ocho";
            break;
        case 7:
            $numu = "Siete";
            break;
        case 6:
            $numu = "Seis";
            break;
        case 5:
            $numu = "Cinco";
            break;
        case 4:
            $numu = "Cuatro";
            break;
        case 3:
            $numu = "Tres";
            break;
        case 2:
            $numu = "Dos";
            break;
        case 1:
            $numu = "Uno";
            break;
        case 0:
            $numu = "";
            break;
    }
    return $numu;
}


function decena($numdero)
{
    if ($numdero >= 90 && $numdero <= 99) {
        $numd = "Noventa ";
        if ($numdero > 90)
            $numd = $numd . "Y " . (unidad($numdero - 90));
    } else if ($numdero >= 80 && $numdero <= 89) {
        $numd = "Ochenta ";
        if ($numdero > 80)
            $numd = $numd . "Y " . (unidad($numdero - 80));
    } else if ($numdero >= 70 && $numdero <= 79) {
        $numd = "Setenta ";
        if ($numdero > 70)
            $numd = $numd . "Y " . (unidad($numdero - 70));
    } else if ($numdero >= 60 && $numdero <= 69) {
        $numd = "Sesenta ";
        if ($numdero > 60)
            $numd = $numd . "Y " . (unidad($numdero - 60));
    } else if ($numdero >= 50 && $numdero <= 59) {
        $numd = "Cincuenta ";
        if ($numdero > 50)
            $numd = $numd . "Y " . (unidad($numdero - 50));
    } else if ($numdero >= 40 && $numdero <= 49) {
        $numd = "Cuarenta ";
        if ($numdero > 40)
            $numd = $numd . "Y " . (unidad($numdero - 40));
    } else if ($numdero >= 30 && $numdero <= 39) {
        $numd = "Treinta ";
        if ($numdero > 30)
            $numd = $numd . "Y " . (unidad($numdero - 30));
    } else if ($numdero >= 20 && $numdero <= 29) {
        if ($numdero == 20)
            $numd = "Veinte ";
        else
            $numd = " Veinte" . (unidad($numdero - 20));
    } else if ($numdero >= 10 && $numdero <= 19) {
        switch ($numdero) {
            case 10:
                $numd = "Diez ";
                break;
            case 11:
                $numd = "Once ";
                break;
            case 12:
                $numd = "Doce ";
                break;
            case 13:
                $numd = "Trece ";
                break;
            case 14:
                $numd = "Catorce ";
                break;
            case 15:
                $numd = "Quince ";
                break;
            case 16:
                $numd = " Dieciseis ";
                break;
            case 17:
                $numd = " Diecisiete";
                break;
            case 18:
                $numd = " Dieciocho";
                break;
            case 19:
                $numd = " Diecinueve";
                break;
        }
    } else
        $numd = unidad($numdero);
    return $numd;
}


function centena($numc)
{
    if ($numc >= 100) {
        if ($numc >= 900 && $numc <= 999) {
            $numce = " Novecientos ";
            if ($numc > 900)
                $numce = $numce . (decena($numc - 900));
        } else if ($numc >= 800 && $numc <= 899) {
            $numce = " Ochocientos ";
            if ($numc > 800)
                $numce = $numce . (decena($numc - 800));
        } else if ($numc >= 700 && $numc <= 799) {
            $numce = " Setecientos ";
            if ($numc > 700)
                $numce = $numce . (decena($numc - 700));
        } else if ($numc >= 600 && $numc <= 699) {
            $numce = "Seiscientos ";
            if ($numc > 600)
                $numce = $numce . (decena($numc - 600));
        } else if ($numc >= 500 && $numc <= 599) {
            $numce = "Quiñientos ";
            if ($numc > 500)
                $numce = $numce . (decena($numc - 500));
        } else if ($numc >= 400 && $numc <= 499) {
            $numce = "Cuatrocientos ";
            if ($numc > 400)
                $numce = $numce . (decena($numc - 400));
        } else if ($numc >= 300 && $numc <= 399) {
            $numce = "Trecientos ";
            if ($numc > 300)
                $numce = $numce . (decena($numc - 300));
        } else if ($numc >= 200 && $numc <= 299) {
            $numce = "Docientos ";
            if ($numc > 200)
                $numce = $numce . (decena($numc - 200));
        } else if ($numc >= 100 && $numc <= 199) {
            if ($numc == 100)
                $numce = "Cien ";
            else
                $numce = "Ciento " . (decena($numc - 100));
        }
    } else
        $numce = decena($numc);

    return $numce;
}


function miles($nummero)
{
    if ($nummero >= 1000 && $nummero < 2000) {
        $numm = "Mil " . (centena($nummero % 1000));
    }
    if ($nummero >= 2000 && $nummero < 10000) {
        $numm = unidad(Floor($nummero / 1000)) . " mil " . (centena($nummero % 1000));
    }
    if ($nummero < 1000)
        $numm = centena($nummero);

    return $numm;
}


function decmiles($numdmero)
{
    if ($numdmero == 10000)
        $numde = "Diez mil";
    if ($numdmero > 10000 && $numdmero < 20000) {
        $numde = decena(Floor($numdmero / 1000)) . "Mil " . (centena($numdmero % 1000));
    }
    if ($numdmero >= 20000 && $numdmero < 100000) {
        $numde = decena(Floor($numdmero / 1000)) . " Mil " . (miles($numdmero % 1000));
    }
    if ($numdmero < 10000)
        $numde = miles($numdmero);

    return $numde;
}


function cienmiles($numcmero)
{
    if ($numcmero == 100000)
        $num_letracm = "Cien mil";
    if ($numcmero >= 100000 && $numcmero < 1000000) {
        $num_letracm = centena(Floor($numcmero / 1000)) . " Mil " . (centena($numcmero % 1000));
    }
    if ($numcmero < 100000)
        $num_letracm = decmiles($numcmero);
    return $num_letracm;
}


function millon($nummiero)
{
    if ($nummiero >= 1000000 && $nummiero < 2000000) {
        $num_letramm = "Un millon " . (cienmiles($nummiero % 1000000));
    }
    if ($nummiero >= 2000000 && $nummiero < 10000000) {
        $num_letramm = unidad(Floor($nummiero / 1000000)) . " Millones " . (cienmiles($nummiero % 1000000));
    }
    if ($nummiero < 1000000)
        $num_letramm = cienmiles($nummiero);

    return $num_letramm;
}


function decmillon($numerodm)
{
    if ($numerodm == 10000000)
        $num_letradmm = "Diez millones";
    if ($numerodm > 10000000 && $numerodm < 20000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . "Millones " . (cienmiles($numerodm % 1000000));
    }
    if ($numerodm >= 20000000 && $numerodm < 100000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . " Millones " . (millon($numerodm % 1000000));
    }
    if ($numerodm < 10000000)
        $num_letradmm = millon($numerodm);

    return $num_letradmm;
}

function cienmillon($numcmeros)
{
    if ($numcmeros == 100000000)
        $num_letracms = "Cien millones";
    if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
        $num_letracms = centena(Floor($numcmeros / 1000000)) . " Millones " . (millon($numcmeros % 1000000));
    }
    if ($numcmeros < 100000000)
        $num_letracms = decmillon($numcmeros);
    return $num_letracms;
}

function milmillon($nummierod)
{
    if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
        $num_letrammd = "Mil " . (cienmillon($nummierod % 1000000000));
    }
    if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
        $num_letrammd = unidad(Floor($nummierod / 1000000000)) . " Mil " . (cienmillon($nummierod % 1000000000));
    }
    if ($nummierod < 1000000000)
        $num_letrammd = cienmillon($nummierod);

    return $num_letrammd;
}




function convertir($numero)
{
    $num = str_replace(",", "", $numero);
    $num = number_format($num, 2, '.', '');
    $cents = substr($num, strlen($num) - 2, strlen($num) - 1);
    $num = (int)$num;


    if ($num === 0) {
        return 'CERO';
    }

    $numf = milmillon($num);

    if ($cents > 0) {
        return $numf . " con " . centena($cents) . ' centavos';
    } else {
        return $numf . ' Bolivianos';
    }
}

//para la abreviacion de palabras
function abreviarCargo($cadena)
{
    // Divide la cadena en palabras
    $palabras = explode(' ', $cadena);
    // Define las palabras de enlace que deben eliminarse
    $palabras_a_eliminar = ['DE', 'Y'];
    // Recorre las palabras y reemplaza por sus abreviaciones
    $abreviada = [];
    foreach ($palabras as $palabra) {
        // Si la palabra es una palabra de enlace, se elimina
        if (in_array($palabra, $palabras_a_eliminar)) {
            continue;
        }
        // Abrevia cada palabra tomando las tres primeras letras y agregando un punto
        if (strlen($palabra) > 2) {
            $abreviada[] = substr($palabra, 0, 3) . '.';
        } else {
            $abreviada[] = $palabra;
        }
    }
    // Junta las palabras abreviadas en una sola cadena
    return implode(' ', $abreviada);
}


function abreviarCargo_tres($cadena)
{
    // Divide la cadena en palabras
    $palabras = explode(' ', $cadena);
    // Define las palabras de enlace que deben eliminarse
    $palabras_a_eliminar = ['DE', 'Y'];
    // Recorre las primeras tres palabras y reemplaza por sus abreviaciones
    $abreviada = [];
    $contador = 0;
    foreach ($palabras as $palabra) {
        if ($contador >= 3) {
            break;
        }
        // Si la palabra es una palabra de enlace, se elimina
        if (in_array($palabra, $palabras_a_eliminar)) {
            continue;
        }
        // Abrevia cada palabra tomando las tres primeras letras y agregando un punto
        if (strlen($palabra) > 2) {
            $abreviada[] = substr($palabra, 0, 3) . '.';
        } else {
            $abreviada[] = $palabra;
        }
        $contador++;
    }
    // Junta las palabras abreviadas en una sola cadena
    return implode(' ', $abreviada);
}


function numero_a_ordinal($numero)
{
    $unidades = [
        1 => 'primer',
        2 => 'segundo',
        3 => 'tercer',
        4 => 'cuarto',
        5 => 'quinto',
        6 => 'sexto',
        7 => 'séptimo',
        8 => 'octavo',
        9 => 'noveno'
    ];

    $decenas = [
        10 => 'décimo',
        20 => 'vigésimo',
        30 => 'trigésimo',
        40 => 'cuadragésimo',
        50 => 'quincuagésimo',
        60 => 'sexagésimo',
        70 => 'septuagésimo',
        80 => 'octogésimo',
        90 => 'nonagésimo'
    ];

    $centenas = [
        100 => 'centésimo',
        200 => 'ducentésimo',
        300 => 'tricentésimo',
        400 => 'cuadringentésimo',
        500 => 'quingentésimo',
        600 => 'sexcentésimo',
        700 => 'septingentésimo',
        800 => 'octingentésimo',
        900 => 'noningentésimo'
    ];

    $miles = [
        1000 => 'milésimo',
        2000 => 'dosmilésimo'
    ];

    if (isset($unidades[$numero])) {
        return mb_strtoupper($unidades[$numero] . ' DESTINATARIO');
    }

    if (isset($decenas[$numero])) {
        return mb_strtoupper($decenas[$numero] . ' DESTINATARIO');
    }

    if (isset($centenas[$numero])) {
        return mb_strtoupper($centenas[$numero] . ' DESTINATARIO');
    }

    if (isset($miles[$numero])) {
        return mb_strtoupper($miles[$numero] . ' DESTINATARIO');
    }

    // Descomponer el número en unidades, decenas, centenas y millares
    $u = $numero % 10;
    $d = ($numero % 100) - $u;
    $c = ($numero % 1000) - $d - $u;
    $m = $numero - $c - $d - $u;

    $resultado = '';

    if ($m > 0) {
        $resultado .= $miles[$m];
    }

    if ($c > 0) {
        $resultado .= ' ' . $centenas[$c];
    }

    if ($d > 0) {
        $resultado .= ' ' . $decenas[$d];
    }

    if ($u > 0) {
        $resultado .= ' ' . $unidades[$u];
    }

    if ($numero === 0) {
        return 'CERO DESTINATARIO';
    }

    // Reemplazar 'primer' y 'tercer' por 'primero' y 'tercero'
    $resultado = str_replace(['primer', 'tercer'], ['primero', 'tercero'], $resultado);

    return mb_strtoupper(trim($resultado) . ' DESTINATARIO');
}



//para solo mostrar las primeras 100 letras

function mostrarprimeras100letras($texto)
{
    // Obtiene las primeras 100 letras del texto
    $primeras100Letras = substr($texto, 0, 150);
    return $primeras100Letras;
}

function mostrarprimeras50letras($texto)
{
    // Obtiene las primeras 100 letras del texto
    $primeras100Letras = substr($texto, 0, 50);
    return $primeras100Letras;
}


function getTimeElapsed($date){
    // Crear un objeto DateTime a partir de la fecha proporcionada
    $inputDate = new DateTime($date);
    // Obtener la fecha actual como un objeto DateTime
    $currentDate = new DateTime();
    // Calcular la diferencia entre las dos fechas
    $interval = $inputDate->diff($currentDate);

    // Formatear la diferencia en un formato legible
    if ($interval->y > 0) {
        $diffForHumans = $interval->y . ' año' . ($interval->y > 1 ? 's' : '');
    } elseif ($interval->m > 0) {
        $diffForHumans = $interval->m . ' mes' . ($interval->m > 1 ? 'es' : '');
    } elseif ($interval->d >= 7) {
        $diffForHumans = floor($interval->d / 7) . ' semana' . (floor($interval->d / 7) > 1 ? 's' : '');
    } elseif ($interval->d > 0) {
        $diffForHumans = $interval->d . ' día' . ($interval->d > 1 ? 's' : '');
    } elseif ($interval->h > 0) {
        $diffForHumans = $interval->h . ' hora' . ($interval->h > 1 ? 's' : '');
    } elseif ($interval->i > 0) {
        $diffForHumans = $interval->i . ' minuto' . ($interval->i > 1 ? 's' : '');
    } else {
        $diffForHumans = 'unos segundos';
    }

    return "La fecha proporcionada fue hace $diffForHumans.";
}
