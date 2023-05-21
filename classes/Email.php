<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;




class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
       $this->email=$email;
       $this->nombre=$nombre;
       $this->token=$token;
    }

    public function enviarConfirmacion(){
        
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '544047efcd09ad';
        $mail->Password = 'c62ef3a5020fca';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //set html
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido= "<html>";
        $contenido .= "<p><strong>Hola" . $this->nombre . "</strong> Has creado tu cuenta en 
        App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p> Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" .$this->token ."'> Confirmar cuenta </a> </p>";
         $contenido .= "<p> Si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
         $contenido .="</html>";

         $mail->Body = $contenido;
         $mail -> AltBody = 'Esto es texto alternativo';
         $mail->send();


         if($mail -> send()){
            $mensaje = "Mensaje enviado correctamente";
        }else {
            $mensaje = "El mensaje no fue enviado";
        }
    }

    public function enviarInstrucciones(){
         //crear el objeto de email
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = 'sandbox.smtp.mailtrap.io';
         $mail->SMTPAuth = true;
         $mail->Port = 2525;
         $mail->Username = '544047efcd09ad';
         $mail->Password = 'c62ef3a5020fca';
 
         $mail->setFrom('cuentas@appsalon.com');
         $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
         $mail->Subject = 'Recupera tu cuenta';
 
         //set html
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';
 
         $contenido= "<html>";
         $contenido .= "<p><strong>Hola" . $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
         $contenido .= "<p> Presiona aquí: <a href='http://localhost:3000/recuperar-pass?token=" .$this->token ."'>Reestablecer Password</a> </p>";
          $contenido .= "<p> Si tu no solicitaste este cambio, puedes ignorar el mensaje </p>";
          $contenido .="</html>";
 
          $mail->Body = $contenido;
          $mail -> AltBody = 'Esto es texto alternativo';
          $mail->send();
 
 
          if($mail -> send()){
             $mensaje = "Mensaje enviado correctamente";
         }else {
             $mensaje = "El mensaje no fue enviado";
         }
    }
}