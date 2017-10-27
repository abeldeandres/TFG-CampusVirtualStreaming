<?php
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../common/errors.php");
if (isset ( $_POST ['id_usuario'] )) {
	$id_usuario = $_POST ['id_usuario'];
	$nombre = $_POST ['nombre'];
	$correo = $_POST ['correo'];
	$pass = $_POST ['pass'];
	$pass1 = $_POST ['pass1'];

	// Proteccion por si las contraseñas no coinciden
	if ($pass == $pass1 && $pass != '') {
		if (empty ( $id_usuario )) {
			mensaje ( "warning", "Debe introducir una ID de Usuario" );
		} else {
			// Primero comporbamos que no existe repetido
			$linea = obtenerUsuario ( $id_usuario );
			if ($linea != FALSE) {
				if ($linea ['id_usuario'] == $id_usuario) {
					mensaje ( "warning", "ID del usuario repetido" );
				}
			} else {
				$salt = mcrypt_create_iv ( 16, MCRYPT_DEV_URANDOM );
				$pass = sha1 ( md5 ( $salt . $pass ) );
				$salt = base64_encode ( $salt );
				if ($_POST ['rol'] == "Alumno") {
					$rol = 'Alumno';
				} else {
					$rol = 'Profesor';
				}
				if (empty ( $nombre )) {
					mensaje ( "warning", "Debe rellenar el campo nombre" );
				} else {
					$linea = crearUsuario ( $id_usuario, $nombre, $pass, $correo, $rol, $salt );
					if ($linea != NULL) {
						mensaje ( "success", "Se ha Agregado Correctamente" );
					} else {
						mensaje ( "danger", "No se ha podido registrar el usuario" );
					}
				}
			}
		}
	} else if ($pass == $pass1) {
		mensaje ( "warning", "Debe especificar una contraseña" );
	} else {
		mensaje ( "warning", "Las contraseñas no coinciden" );
	}
}
?>
<?php

require_once ("../../modelo/preparacionConsultaUsuario.php");

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Registrar Usuario";
function imprime_contenido() {
	?>
<h1>Crear Usuarios</h1>
<?php
	mostrar_error ();
	?>
<div class="well">
	<form class="form-horizontal" method="POST" action="crear_usuario.php"
		role="form" id="login">
		<div class="form-group">
			<label for="id_usuario" class="col-lg-4 control-label">ID Usuario</label>
			<div class="col-lg-8">
				<input type="text" id="id_usuario" name="id_usuario"
					placeholder="Introduce tu DNI">
			</div>
		</div>
		<div class="form-group">
			<label for="nombre" class="col-lg-4 control-label">Nombre</label>
			<div class="col-lg-8">
				<input type="text" name="nombre" id="nombre"
					placeholder="Introduce el Nombre">
			</div>
		</div>
		<div class="form-group">
			<label for="correo" class="col-lg-4 control-label">Email</label>
			<div class="col-lg-8">
				<input type="text" name="correo" id="correo"
					placeholder="Introduce el Correo">
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-4"></div>
			<div class="col-lg-8">
				<input type="radio" name="rol" value="Alumno" /> Alumno <br /> <input
					type="radio" name="rol" value="Profesor" /> Profesor
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-lg-4 control-label">Contraseña</label>
			<div class="col-lg-8">
				<input type="password" name="pass" id="password"
					placeholder="Contraseña">
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-lg-4 control-label">Repita la
				Contraseña</label>
			<div class="col-lg-8">
				<input type="password" name="pass1" id="password"
					placeholder="Repita la Contraseña">
			</div>
		</div>
		<div class="form-group">
			<div class="text-center">
				<input type="submit" value="Registrar" class="btn btn-primary">
			</div>
		</div>
	</form>
	<div id="source-button" class="btn btn-primary btn-xs"
		style="display: none;">&lt; &gt;</div>
</div>
<?php
}

require_once '../common/layout.php';
?>
