<?php
require_once("../../modelo/preparacionConsultaUsuario.php");
require_once ("../common/errors.php");


 if (isset ( $_POST ['id_usuario'] )) {
	$id_usuario  = $_POST['id_usuario'];
	$nombre     = $_POST['nombre'];
	$correo     = $_POST['correo'];
	$pass       = $_POST['pass'];
	$pass1      = $_POST['pass1'];
	$pass2      = $_POST['pass2'];

	$query=obtenerSaltUsuario($id_usuario);
	$salt=$query['salt'];
	$salt=base64_decode($salt);
	$passBD = sha1(md5($salt . $pass));
	$linea=obtenerUsuario($id_usuario);
	if($linea!=NULL){
		if($linea['pass']==$passBD){
			if($pass1 == $pass2){
				//Aqui modificar tabla
				if($pass1!='') $pass=$pass1;
				$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
				$pass = sha1(md5($salt . $pass));
				$salt=base64_encode($salt);
                $linea=modificarUsuario($nombre,$pass,$correo,$salt,$id_usuario);
				if($linea=NULL){
					mensaje ( "danger", "Error al guardar datos" );
				}
				else{
					mensaje ( "success", "Datos guardados correctamente" );
				}
			}
			else{
				mensaje ( "danger", "Las contraseñas nuevas no coinciden" );
			}
		}
		else{
			mensaje ( "danger", "La contraseña no es correcta" );
		}
	}
 }
?>
<?php

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Editar Perfil";
function imprime_contenido() {
	$id_usuario=$_SESSION ['usuario']['id_usuario'];
	$usuario=obtenerUsuario($id_usuario);
	?>
<h1>Editar Perfil</h1>
<p><b>Perfil de <?php echo $id_usuario;?></b></p>
<div class="well">
	<form class="form-horizontal" method="POST" action="configuracion.php"
		role="form" id="login">
		<input  type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>" />
		<div class="form-group">
			<label for="nombre" class="col-lg-4 control-label">Nombre</label>
			<div class="col-lg-8">
				<input type="text" name="nombre" id="nombre"
					value="<?php echo $usuario['nombre']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="correo" class="col-lg-4 control-label">Email</label>
			<div class="col-lg-8">
				<input type="text" name="correo" id="correo"
					value="<?php echo $usuario['correo']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-lg-4 control-label">Contraseña Actual</label>
			<div class="col-lg-8">
				<input type="password" name="pass" id="password"
					placeholder="Contraseña Actual">
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-lg-4 control-label">Contraseña Nueva</label>
			<div class="col-lg-8">
				<input type="password" name="pass1" id="password"
					placeholder="Contraseña Nueva">
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-lg-4 control-label">Repita la Contraseña</label>
			<div class="col-lg-8">
				<input type="password" name="pass2" id="password"
					placeholder="Repita la Contraseña">
			</div>
		</div>
		<div class="form-group">
			<div class="text-center">
				<input type="submit" value="Guardar" class="btn btn-primary">
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
