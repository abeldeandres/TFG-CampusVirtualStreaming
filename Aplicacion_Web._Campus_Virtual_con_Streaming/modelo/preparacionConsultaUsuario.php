<?php
function obtenerSaltUsuario($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT salt FROM usuario where id_usuario =?" );
	$sentencia->bind_param ( 's', $id_usuario );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();

	// cierro conexión y sentencia
	$sentencia->close ();
	$mysqli->close ();

	return $resultado->fetch_assoc ();
}

function obtenerUsuario($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM usuario WHERE id_usuario = ?" );
	$sentencia->bind_param ( 's', $id_usuario );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $resultado->fetch_assoc ();
}

function eliminarUsuario($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "DELETE FROM usuario WHERE id_usuario = ?" );
	$sentencia->bind_param ( 's', $id_usuario );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}

function crearUsuario($id_usuario,$nombre,$pass,$correo,$rol,$salt) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "INSERT INTO `usuario` (`id_usuario`, `nombre`, `pass`, `correo`, `rol`, `salt`) VALUES (?, ?, ?, ?, ?, ?)");
	$sentencia->bind_param ( 'ssssss', $id_usuario,$nombre,$pass,$correo,$rol,$salt );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}


function obtenerTodosLosUsuarios() {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM usuario" );
	// $sentencia->bind_param('s', $id_usuario);
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();

	$out = null;

	while ($out[] = $resultado->fetch_assoc());
	//Quitamos el último que va a ser null
	array_pop($out);

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}


function obtenerAlumnosAsignatura($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT usuario.id_usuario,usuario.nombre, usuario.correo, usuario.rol FROM usuario,miembro,asignatura WHERE usuario.id_usuario= miembro.id_usuario AND miembro.id_asignatura = asignatura.id_asignatura AND asignatura.id_asignatura=? AND miembro.id_usuario<> (SELECT id_profesor FROM asignatura where asignatura.id_asignatura=?)" );
	$sentencia->bind_param ( 'dd', $id_asignatura,$id_asignatura );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ($out[] = $resultado->fetch_assoc());
	//Quitamos el último que va a ser null
	array_pop($out);

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}


function obtenerProfesores() {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM `usuario` WHERE rol='Profesor'" );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ($out[] = $resultado->fetch_assoc());
	//Quitamos el último que va a ser null
	array_pop($out);

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}



function obtenerTodosLosUsuariosQueNoEstanGrupo($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM usuario WHERE usuario.id_usuario NOT IN (SELECT miembro.id_usuario FROM miembro WHERE miembro.id_asignatura= ?)" );
	$sentencia->bind_param ( 'd', $id_asignatura );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ($out[] = $resultado->fetch_assoc());
	//Quitamos el último que va a ser null
	array_pop($out);

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}

function obtenerTodosLosAlumnoQueNoEstanGrupo($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM usuario WHERE usuario.id_usuario NOT IN (SELECT miembro.id_usuario FROM miembro WHERE miembro.id_asignatura= ?) AND usuario.rol='Alumno'" );
	$sentencia->bind_param ( 'd', $id_asignatura );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ($out[] = $resultado->fetch_assoc());
	//Quitamos el último que va a ser null
	array_pop($out);

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}


function modificarUsuario($nombre, $pass, $correo, $salt, $id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "UPDATE `usuario` SET `nombre`= ?, `pass`= ?, `correo`= ?, `salt`= ? WHERE id_usuario = ?" );
	$sentencia->bind_param ( 'sssss', $nombre, $pass, $correo, $salt, $id_usuario );
	$out=$sentencia->execute ();

	// $resultado->fetch_assoc();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

?>
