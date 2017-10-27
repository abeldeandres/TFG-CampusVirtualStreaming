<?php
require_once ("./../modelo/preparacionConsultaUsuario.php");
require_once ("common/errors.php");

// Establece una sesion
if (! isset ( $_SESSION )) {
	session_start ();
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Iniciar sesión";

// variable que guarda los intentos para acceder a la aplicacion web
if (isset ( $_SESSION ['intentos'] )) {
	$numIntentos = $_SESSION ['intentos'];
} else {
	$numIntentos = 1;
}

// Sólo realiza las operaciones si viene del formulario
// Si carga por primera vez no
if (isset ( $_POST ['id_usuario'] )) {

	// Variables del formulario
	$id_usuario_form = $_POST ['id_usuario'];
	$pass_form = $_POST ['pass'];

	// pagina donde se redireccionará
	$pagina = null;

	$usuario = obtenerUsuario ( $id_usuario_form );
	if ($usuario != null) {
		if ($numIntentos < 3) {
			$numIntentos ++;
			$_SESSION ['intentos'] = $numIntentos;

			// TODO Operaciones BBDD en el modelo
			$saltLogin = base64_decode ( $usuario ['salt'] );
			$pass = sha1 ( md5 ( $saltLogin . $pass_form ) );

			if ($pass == $usuario ['pass']) {
				$_SESSION ['usuario'] ['id_usuario'] = $usuario ['id_usuario'];
				$_SESSION ['usuario'] ['nombre'] = $usuario ['nombre'];
				$_SESSION ['usuario'] ['rol'] = $usuario ['rol'];
				// $_SESSION ['id_usuario'] = $usuario ['id_usuario'];
				// $_SESSION ['nombre'] = $usuario ['nombre'];
				// $_SESSION ['rol'] = $usuario ['rol'];
				if ($usuario ['rol'] === 'Admin') {
					$pagina = 'administrador/index_administrador.php';
				} else if ($usuario ['rol'] === 'Profesor') {
					$pagina = 'profesor/index_responsable.php';
				} else if ($usuario ['rol'] === 'Alumno') {
					$pagina = 'alumno/index_miembro.php';
				} else {
					$pagina = 'index.php';
				}

				header ( 'Location: ' . $pagina );
			} else {
				mensaje ( "danger", "La contraseña es incorrecta" );
			}
		} else {
			// TODO CONSULTAR CON EL TUTOR
			$numIntentos = 1;
			$_SESSION ['intentos'] = $numIntentos;
			mensaje ( "warning", "Número máximo de intentos alcalzado" );
		}
	} else {
		mensaje ( "danger", "No se ha encontrado el usuario" );
		$numIntentos ++;
		$_SESSION ['intentos'] = $numIntentos;
	}
}

// Cabecera HTML
require_once 'common/head_html.php';
?>
<body>
	<div class="container">
		<div class="titulo-login">
			<h1 id="type">Bienvenido a nuestro Campus Virtual</h1>
		</div>
		<div class="row">
			<div class="col-md-7"></div>
			<div class="col-md-5">
<?php
mostrar_error ();
?>
				<div class="well">
					<form class="form-horizontal" method="POST" action="index.php"
						role="form" id="login">
						<div class="form-group">
							<label for="id_usuario" class="col-lg-4 control-label">ID Usuario</label>
							<div class="col-lg-8">
								<input type="text" id="id_usuario" name="id_usuario"
									placeholder="Introduce tu DNI">
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-lg-4 control-label">Password</label>
							<div class="col-lg-8">
								<input type="password" name="pass" id="password"
									placeholder="Contraseña">
							</div>
						</div>
						<div class="form-group">
							<div class="text-center">
								<input type="submit" value="Ingresar" class="btn btn-primary">
							</div>
						</div>
					</form>
					<div id="source-button" class="btn btn-primary btn-xs"
						style="display: none;">&lt; &gt;</div>
				</div>
			</div>
		</div>
        <?php
								require_once 'common/footer.php';
								?>
	</div>
</body>
</html>

