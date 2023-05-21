<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu E-mail</p>

<form action="/olvide" class="formulario" method="POST"> 
<?php
include_once __DIR__ . "/../templates/alertas.php";
?>
<div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Escribe tu Email">
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href='/'>¿Ya tienes una cuenta? Inicia sesión</a>
    <a href='/crear-cuenta'>¿Aún no tienes una cuenta? Crear cuenta</a>
</div>
