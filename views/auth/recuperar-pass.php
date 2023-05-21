<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<form  class="formulario" method="POST">
<?php
include_once __DIR__ . "/../templates/alertas.php";
?>
<?php
if($error) return;
?>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Escribe tu password">
    </div>

    <input type="submit" class="boton" value="Guardar cambios">
</form>

<div class="acciones">
    <a href='/'>¿Ya tienes una cuenta? Inicia sesión</a>
    <a href='/olvide'>¿No tienes una? Crear cuenta</a>
</div>