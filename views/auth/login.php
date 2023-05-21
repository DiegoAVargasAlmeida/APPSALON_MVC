<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>



<form action="/" class="formulario" method="POST">
<?php
include_once __DIR__ . "/../templates/alertas.php";
?>
<div class="campo">
    <label for="email">Email</label>
    <input type="text" type="email" id="email" placeholder="Tu email" name="email">
</div>
<div class="campo">
    <label for="password">Password</label>
    <input type="password" type="password" id="password" placeholder="Tu password" name="password">
</div>

<input type="submit" class="boton" value="Iniciar sesión">
</form>

<div class="acciones">
    <a href='/crear-cuenta'>¿Aún no tienes una cuenta? Crear cuenta</a>
    <a href='/olvide'>¿Olvidaste tu password?</a>
</div>