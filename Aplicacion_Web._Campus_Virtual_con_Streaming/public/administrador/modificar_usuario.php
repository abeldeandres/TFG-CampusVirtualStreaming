<?php
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['id_usuario'] )) {
	$id_usuario = $_POST ['id_usuario'];
	$nombre = $_POST ['nombre'];
	$correo = $_POST ['correo'];
	$pass = $_POST ['pass'];
	$boton = $_POST ['boton'];
	$salt = mcrypt_create_iv ( 16, MCRYPT_DEV_URANDOM );
	$pass = sha1 ( md5 ( $salt . $pass ) );
	$salt = base64_encode ( $salt );

	if ($boton != 'Eliminar') {
		if (empty ( $nombre )) {
			mensaje ( "danger", "Debe rellenar el campo de nombre" );
		} else {
			$linea = modificarUsuario ( $nombre, $pass, $correo, $salt, $id_usuario );
			if ($linea = NULL) {
				mensaje ( "danger", "Error al guardar datos" );
			} else {
				mensaje ( "success", "Datos guardados correctamente" );
			}
		}
	} else {
		$linea = eliminarUsuario ( $id_usuario );
		if ($linea = NULL) {
			mensaje ( "danger", "No se ha podido borrar el usuario" );
		} else {
			mensaje ( "success", "Se ha borrado Correctamente" );
		}
	}
}
?>
<?php
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Modificar Usuario";
function imprime_contenido() {
	?>
<h1>Lista de usuarios</h1>
<?php
	$listaUsuarios = obtenerTodosLosUsuarios ();
	?>
<div class="panel-group" id="accordion" role="tablist"
	aria-multiselectable="false">
<?php
	$i = 0;
	foreach ( $listaUsuarios as $usuario ) {
		$i ++;
		?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse"
					data-parent="#accordion" href="#collapse<?php
		echo $i;
		?>"
					aria-expanded="false" aria-controls="collapse<?php echo $i;?>">
          <?php echo $usuario['nombre'];?> (<?php echo $usuario['id_usuario'];?>)
        </a>
			</h4>
		</div>
		<div id="collapse<?php echo $i;?>" class="panel-collapse collapse"
			role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
			<div class="panel-body">
				<form method="post" role="form" action="modificar_usuario.php">
					<input type="hidden" name="id_usuario"
						value="<?php echo $usuario['id_usuario'] ?>" />
					<div class="form-group">
						<label for="nombre" class=" control-label">Nombre</label> <input
							class="form-control" type="text" id="nombre" name="nombre"
							placeholder="Introduce un nombre"
							value="<?php echo $usuario['nombre'];?>">
					</div>
					<div class="form-group">
						<label for="correo" class=" control-label">Correo</label> <input
							class="form-control" type="correo" name="correo" id="correo"
							placeholder="Introduce la dirección de correo electrónico"
							value="<?php echo $usuario ['correo'];  ?>">
					</div>
					<div class="form-group">
						<label for="pass" class=" control-label">Contraseña</label> <input
							class="form-control" type="password" name="pass" id="pass"
							placeholder="Introduce una nueva contraseña">
					</div>
					<div class="form-group">
						<div class="text-center">
							<input type="submit" value="Modificar" name="boton"
								class="btn btn-primary"> <input type="submit" value="Eliminar"
								name="boton" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	}
	?>
</div>
<?php
}

require_once '../common/layout.php';
?>