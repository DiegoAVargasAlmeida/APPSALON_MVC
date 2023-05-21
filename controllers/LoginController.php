<?php

namespace Controllers;
use Classes\Email;
use FFI;
use Model\usuario;
use MVC\Router;

class LoginController{

public static function login(Router $router)
{   
    $alertas=[];

    if($_SERVER['REQUEST_METHOD']==='POST'){

        $auth = new usuario($_POST);
        $alertas = $auth->validarLogin(); 
        
        if(empty($alertas)){
            $usuario = usuario::where('email', $auth->email);
           
            if($usuario){
                
               if( $usuario->comprobarPasswordandverificado($auth->password)){
                    session_start();

                    $_SESSION['id'] = $usuario->id; 
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido; 
                    $_SESSION['email'] = $usuario->email; 
                    $_SESSION['login'] = true; 

                    if($usuario -> admin === "1"){
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    }else{
                        header('Location: /cita');
                    }
                }
            }
        }else{
            usuario::setAlerta('error', 'Usuario no encontrado');
        }
    }
    $alertas = usuario::getAlertas();
    $router -> render('auth/login',[
        'alertas'=> $alertas
    ]);
}
public static function logout()
{
    session_start();
    
    $_SESSION = [];
   
        header('Location: /');
     
    
    
    
}
public static function olvide(Router $router)
{   $alertas=[];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $auth = new usuario($_POST);
        $alertas = $auth->validarEmail();

        if(empty($alertas)){
            $usuario = usuario::where('email', $auth->email);
            
            if($usuario && $usuario->confirmado === "1"){
                
                //generar un token
                $usuario->crearToken();
                $usuario->guardar();

                // Enviar email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email->enviarInstrucciones();

                //Alerta
                usuario::setAlerta('exito', 'Revisa tu email');
               
            }else{
                usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                
            }
    }

    }
    $alertas = usuario::getAlertas();
    $router -> render('auth/olvide-password',[
        'alertas'=> $alertas
    ]);
}

public static function recuperar(Router $router)
{   $alertas=[];
    $error =false;

    $token = s($_GET['token']);
    $usuario = usuario::where('token', $token);
    
    if(empty($usuario)){
        usuario::setAlerta('error','Token No Válido');
        $error=true;
    }
    

    if($_SERVER['REQUEST_METHOD']==='POST'){
        //LEER EL NUEVO PASSWORD Y GUARDARLO 
        
        $password = new usuario($_POST);
        $alertas = $password -> validarPassword();

        if(empty($alertas)){
            $usuario->password = null;
          
            $usuario->password = $password -> password;
            
            $usuario->hashPassword();
            
            $usuario->token = null;
        
            $resultado = $usuario -> guardar();

            if($resultado){
                header('Location: /');
            }
        }
    }
    $alertas = usuario::getAlertas();
    $router -> render('auth/recuperar-pass',[
        'alertas'=> $alertas,
        'error'=> $error
    ]);
}
public static function crear(Router $router )
{
    $usuario = new usuario;
    $alertas =[];
    $mensaje=null;
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $usuario->sincronizar($_POST);
        $alertas = $usuario->validarNuevaCuenta();

        //revisar que alertas este vacío 

        if(empty($alertas)){
            //verificar que el usuario no esté registrado
        $resultado = $usuario->existeUsuario();
        if($resultado->num_rows){
            $alertas = usuario::getAlertas();
         }else{
            //hashear password

            $usuario -> hashPassword();
            //crearToken(
            $usuario -> crearToken();
           
            //enviar e mail

            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
           
    
            $email->enviarConfirmacion();
           
                //crear el usuario
                $resultado = $usuario -> guardar();
                if($resultado){
                    header('Location:/mensaje');
                }
         }
        }
    }
    $router -> render('auth/crear-cuenta', [
        'usuario' => $usuario,
        'alertas' => $alertas
    ]);
}

public static function mensaje(Router $router)
{
   $router->render('auth/mensaje');
}
public static function confirmar(Router $router)
{   $alertas =[];

    $token = s($_GET['token']);
    $usuario = usuario::where('token', $token);

    if(empty($usuario)){
        usuario::setAlerta('error','Token No Válido');
    }else{

        $usuario->confirmado="1";
        $usuario->token=null;
        $usuario->guardar();


        usuario::setAlerta('exito','Cuenta Confirmada Correctamente');

    }
    $alertas = usuario::getAlertas();
   $router->render('auth/confirmar-cuenta',[
    'alertas'=> $alertas 
   ]);
}

}