<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Registro\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Controlador_usuario extends Controller
{

    /**
     * @version 1.0
     * @author   Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de usuario
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    //ENCRIPTAR
    public function encriptar(Request $request){
        if($request->id){
            $id =  encriptar($request->id);
            $data = mensaje_mostrar('success', $id);
        }else{
            $data = mensaje_mostrar('error', 'No se pudo optener los datos..');
        }
        return response()->json($data);
    }

    /**
     * PARA LA PARTE DEL PERFIL
     */
    //para la parte del perfil
    public function perfil()
    {
        $data['menu'] = null;
        return view('administrador.perfil', $data);
    }
    //para cambiar el usuario y contraseña nuevo
    public function guardar_password(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'password_'  => 'required|min:5|max:12',
            'confirmar_password' => 'required|min:5|max:12|same:password_'
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $usuario = User::find($request->id_user);
            $usuario->password =  Hash::make($request->password_);
            $usuario->save();
            if ($usuario->id) {
                $data = mensaje_mostrar('success', 'Se cambio la contraseña nueva con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE PERFIL
     */

    /**
     * ADMINISTRACION DE LOS USUARIOS
     */
    public function  usuarios(){
        $data['menu'] = '1';
        $data['listar_roles']   = Role::OrderBy('id','desc')->get();
        $data['listar_persona'] = Persona::with(['contrato'=>function($con){
            $con->where('estado', 'activo');
        }])->where('estado', 'activo')->get();
        return view('administrador.usuarios.usuarios', $data);
    }
    //para listar los usuarios
    public function listar_usuario(){
        $usuarios_listar = User::with(['roles'])
                            ->where('id', '!=', 1)
                            ->where('deleted_at', null)
                            ->OrderBy('id','desc')
                            ->get();
        return response()->json($usuarios_listar);
    }
    //para validar el usuario
    public function validar_usuario(Request $request){
        try {
            $persona = Persona::find($request->id);
            if($persona){
                $nombres_array = explode(" ", $persona->nombres);
                $primer_nombre = $nombres_array[0];
                $data = [
                    'tipo'      => 'success',
                    'nombre_us' => $primer_nombre,
                    'mensaje'   => $persona
                ];
            }else{
                $data = mensaje_mostrar('null', '');
            }
        } catch (\Throwable $e) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al validar'.$e);
        }
        return response()->json($data);
    }

    //para el guardado del usuario nuevo
    public function nuevo_usuario(Request $request){
        $validar = Validator::make($request->all(), [
            'persona'   => 'required',
            'rol'       => 'required',
            'usuario'   => 'required|unique:users,usuario',
            'password'  => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            // Seleccionamos a las personas
            $persona = Persona::find($request->persona);

            // Seleccionamos el rol específico
            $role = Role::find($request->rol);

            // Crear nuevo usuario
            $usuario = new User();
            $usuario->usuario = $request->usuario;
            $usuario->password = Hash::make($request->password);
            $usuario->ci = $persona->ci;
            $usuario->nombres = $persona->nombres;
            $usuario->apellidos = $persona->ap_paterno . ' ' . $persona->ap_materno;
            $usuario->estado = 'activo';
            $usuario->id_persona = $persona->id;

            // Guardar usuario
            if ($usuario->save()) {
                // Obtener el nombre del rol
                $usuario->assignRole($role->name);
                $data = mensaje_mostrar('success', 'Se realizó el registro del usuario con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrió un error al registrar el usuario');
            }
        }

        return response()->json($data);
    }

    //PARA ELIMINAR EL REGISTRO DEL USUARIO
    public function eliminar_usuario(Request $request){
        try {
            $usuario = User::find($request->id);
            if($usuario->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar');
        }
        return response()->json($data);
    }

    //para cambiar el estado
    public function estado_usuario(Request $request){
        try {
            $usuario = User::find($request->id);
            $usuario->estado = ($usuario->estado == 'activo') ? 'inactivo' : 'activo';
            $usuario->save();
            if($usuario->id){
                $data = mensaje_mostrar('success', 'Se cambio el estado con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar el estado');
        }
        return response()->json($data);
    }

    //para editar el usuario
    public function edit_usuario(Request $request){
        try {
            $usuario = User::with(['roles'])->find($request->id);
            if($usuario){
                $data = mensaje_mostrar('success', $usuario);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }

    //para guardar el usuario editado
    public function update_usuario(Request $request){
        $validar = Validator::make($request->all(), [
            'rol_'       => 'required',
            //'usuario_'   => 'required|unique:users,usuario,'.$request->id_usuario_,
            'password_'  => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            //para el rol
            $rol = Role::find($request->rol_);
            // Crear nuevo usuario
            $usuario            =  User::find($request->id_usuario_);
            //$usuario->usuario   = $request->usuario_;
            $usuario->password  = Hash::make($request->password_);
            // Guardar usuario
            if ($usuario->save()) {
                // Obtener el nombre del rol
                $usuario->syncRoles([$rol->name]);
                $data = mensaje_mostrar('success', 'Se edito el registro del usuario con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrió un error al registrar el usuario');
            }
        }

        return response()->json($data);
    }
    /**
     * FIN DE ADMINISTRACION DE LOS USUARIOS
     */


    /**
    * PARA LA PARTE DE LOS ROLES
    */
    public function roles(){
        $data['menu'] = '2';
        $data['listar_roles']   = Role::OrderBy('id','desc')->get();
        $data['permisos']       = Permission::get();
        return view('administrador.usuarios.roles', $data);
    }

    //para guardar el rol
    public function roles_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_rol'=>'required|unique:roles,name'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $rol = new Role();
            $rol->name = $request->nombre_rol;
            $rol->save();
            if($rol->id){
                $rol->syncPermissions($request->permisos);
                $data = mensaje_mostrar('success', 'Se guardo con exito el Rol y los permisos asiganados');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al crear un nuevo rol');
            }
        }
        return response()->json($data);
    }
    //para editar el rol
    public function roles_editar(Request $request){
        $data['id'] = $request->id;
        $rol = Role::find($request->id);
        $data['roles_edi'] = $rol;
        $data['permiso'] = Permission::all()->pluck('name', 'id');
        $rol->load('permissions');
        return view('administrador.usuarios.roles_editar', $data);
    }
    //para guardar el rol
    public function roles_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_rol_'=>'required|unique:roles,name,'.$request->id_rol
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $rol = Role::find($request->id_rol);
            $rol->name = $request->nombre_rol_;
            $rol->save();
            if($rol->id){
                $rol->syncPermissions($request->permisos);
                $data = mensaje_mostrar('success', 'Se guardo con exito el Rol y los permisos asiganados');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al crear un nuevo rol');
            }
        }
        return response()->json($data);
    }
    //para eliminar el permiso
    public function roles_eliminar(Request $request){
        try {
            $rol = Role::find($request->id);
            if($rol->delete()){
                $data = mensaje_mostrar('success','Se eliminó con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }

    //para vizuzaliar la parte de los roles
    public function  roles_vizualizar(Request $request){
        try {
            $rol = Role::with(['permissions'])->find($request->id);
            if($rol){
                $data = mensaje_mostrar('success', $rol->permissions);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al listar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al listar los datos');
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA PARTE DE LOS ROLES
     */



    /**
     * PARTE DE LOS PERMISOS
     */
    public function permisos()
    {
        $data['menu'] = '3';
        return view('administrador.usuarios.permisos', $data);
    }
    //para guardar el permiso
    public function guardar_permiso(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'nombre' => 'required|unique:permissions,name'
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $permiso = new Permission();
            $permiso->name = $request->nombre;
            $permiso->save();
            if ($permiso->id) {
                $data = mensaje_mostrar('success', 'Se guardo el nuevo permiso con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar');
            }
        }
        return response()->json($data);
    }
    //para listar el permiso
    public function permiso_listar()
    {
        $datos = Permission::OrderBy('id', 'desc')->get();
        return response()->json($datos);
    }

    //para editar el permiso
    public function permiso_editar(Request $request)
    {
        try {
            $permiso = Permission::find($request->id);
            if ($permiso) {
                $data = mensaje_mostrar('success', $permiso);
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
        }
        return response()->json($data);
    }

    //para guardar el permiso editado
    public function permiso_editar_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'nombre_' => 'required|unique:permissions,name,' . $request->id_permiso,
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $permiso = Permission::find($request->id_permiso);
            $permiso->name = $request->nombre_;
            $permiso->save();
            if ($permiso->id) {
                $data = mensaje_mostrar('success', 'Se editó el nuevo permiso con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        }
        return response()->json($data);
    }
    //para eliminar el permiso
    public function permiso_eliminar(Request $request)
    {
        try {
            $permiso = Permission::find($request->id);
            if ($permiso->delete()) {
                $data = mensaje_mostrar('success', 'Se eliminó el registro con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE LOS PERMISOS
     */
}
