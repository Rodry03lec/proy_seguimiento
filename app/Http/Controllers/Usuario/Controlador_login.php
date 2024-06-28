<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Registro\Contrato;
use App\Models\Tramite\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class Controlador_login extends Controller
{
    /**
     * @version 1.0
     * @author   Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de usuario resgistrados LOGIN
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA EL INGRESO DEL USUARIO POR USUARIO Y CONTRASEÑA
     */
    public function ingresar(Request $request){

        //par arecuperar el cpacha de la session
        $capcha_recuperado = session()->get('captchaText_recuperado');
        //eliminar los estilos
        $captcha_texto = strip_tags($capcha_recuperado);

        $mensaje = "Usuario y contraseña invalidos";
        $validar = Validator::make($request->all(),[
            'usuario'=>'required',
            'password'=>'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('error', 'Todos los campos son requeridos');
        }else{
            if($request->captcha == $captcha_texto){
                $usuario = User::where('usuario', $request->usuario)->get();
                if(!$usuario->isEmpty()){
                    $compara = Auth::attempt([
                        'usuario'       => $request->usuario,
                        'password'      => $request->password,
                        'estado'        => 'activo',
                        'deleted_at'    => NULL
                    ]);
                    if($compara){
                        $data = mensaje_mostrar('success', 'Inicion de session con éxito');
                        $request->session()->regenerate();
                    }else{
                        $data = mensaje_mostrar('error', $mensaje);
                    }
                }else{
                    $data = mensaje_mostrar('error', $mensaje);
                }
            }else{
                $data = mensaje_mostrar('error', $mensaje);
            }
        }
        return response()->json($data);
    }
    /**
     * FIN PARA EL INGRESO DEL USUARIO Y CONTRASEÑA
     */

    /**
     * PARA INGRESAR AL INICIO
    */
    public function inicio(){
        $data['menu']   = 0;
        // Obtener todos los contratos con su tipo de contrato
        $contratos = Contrato::with(['tipo_contrato'])->get();

        // Agrupar los contratos por tipo de contrato y contarlos
        $contratosPorTipo = $contratos->groupBy('tipo_contrato.nombre')->map(function ($contratos) {
            return $contratos->count();
        });
        $data['contrato_persona'] = $contratosPorTipo;

        //ahora para los tramites
        $tramite = Tramite::with(['tipo_tramite'])->get();

        $contarPorTipo_tramite = $tramite->groupBy('tipo_tramite.nombre')->map(function($tramites){
            return $tramites->count();
        });

        $data['tramite_contar'] = $contarPorTipo_tramite;
        return view('inicio', $data);
    }
    /**
     * FIN PARA INGRESAR AL INICIO
     */



    /**
     * PARA MOSTRAR EL MENSAJE AL INICIO
     */
    public function mensaje(){

        if (!Session::has('bienvenida_mostrada')) {
            $usuario = Auth::user()->nombres.' '.Auth::user()->apellidos;
            $mensaje = "¡Bienvenido al sistema RLQ v1: Usuario $usuario!";

            // Almacena en sesión que se mostró el mensaje
            Session::put('bienvenida_mostrada', true);

            $data = mensaje_mostrar('success', $mensaje);

            return response()->json($data);
        }

        return response()->json(['tipo' => 'error', 'mensaje' => 'Bienvenido de nuevo.']);
    }
    /**
     * FIN PARA MOSTRAR EL MENSAJE AL INICIO
     */

    /**
     * CERRAR LA SESSIÓN
     */
    public function cerrar_session(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $data = mensaje_mostrar('success', 'Finalizó la session con éxito!');
        return response()->json($data);
    }
    /**
     * FIN DE CERRAR LA SESSIÓN
     */


    //para la parte de captcha
    public function generateCaptchaImage(){
        $length = 5; // Longitud del CAPTCHA
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $captchaText = '';
        // Genera el texto CAPTCHA aleatorio
        for ($i = 0; $i < $length; $i++) {
            $captchaText .= $characters[rand(0, strlen($characters) - 1)];
        }
        // Distorsión del texto
        $captchaText = $this->distortText($captchaText);
        session()->put('captchaText_recuperado', $captchaText);
        return $captchaText;
    }

    private function distortText($text) {
        $distortedText = '';
        $maxRotation = 25; // Máxima rotación en grados
        $letterSpacing = -1; // Espaciado entre letras en píxeles

        for ($i = 0; $i < strlen($text); $i++) {
            // Genera un color aleatorio en formato hexadecimal (#RRGGBB)
            $randomColor = 'red';

            // Calcula una rotación aleatoria entre -maxRotation y maxRotation
            $rotation = rand(-$maxRotation, $maxRotation);

            // Aplica la rotación, el espaciado y el color al carácter actual
            $distortedText .= $this->rotateAndSpaceAndColorCharacter($text[$i], $rotation, $letterSpacing, $randomColor);
        }

        return $distortedText;
    }

    private function rotateAndSpaceAndColorCharacter($char, $rotation, $letterSpacing, $color) {
        // Rotación, espaciado y color de un carácter
        return '<span style="transform: rotate(' . $rotation . 'deg); display: inline-block; margin-right: ' . $letterSpacing . 'px; color: ' . $color . ';">' . $char . '</span>';
    }
}
