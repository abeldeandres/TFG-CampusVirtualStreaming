<?php
// Funciona
function obtenerTodasLasAsignaturas($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM asignatura WHERE asignatura.id_asignatura IN (SELECT miembro.id_asignatura FROM miembro WHERE miembro.id_usuario = ?) " );
	$sentencia->bind_param ( 's', $id_usuario );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ( $out [] = $resultado->fetch_assoc () )
		;
		// Quitamos el último que va a ser null
	array_pop ( $out );

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}

// Funciona
function crearAsignatura($nombre,$descripcion,$id_profesor) {

	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "INSERT INTO `asignatura` (`nombre`, `descripcion`, `id_profesor`) VALUES (?, ?, ?)" );
	$sentencia->bind_param ( 'sss', $nombre,$descripcion,$id_profesor );
	$out = $sentencia->execute();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;

}

function obtenerTodasLasAsignaturasImpartidas($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM asignatura WHERE id_profesor = ?" );
	$sentencia->bind_param ( 's', $id_usuario );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ( $out [] = $resultado->fetch_assoc () )
		;
		// Quitamos el último que va a ser null
	array_pop ( $out );

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}
function obtenerGrupo($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM asignatura WHERE id_asignatura = ?" );
	$sentencia->bind_param ( 's', $id_asignatura );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $resultado->fetch_assoc ();
}
function obtenerTodosLosGrupos() {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM asignatura" );
	// $sentencia->bind_param('s', $id_asignatura);
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$out = null;

	while ( $out [] = $resultado->fetch_assoc () )
		;
		// Quitamos el último que va a ser null
	array_pop ( $out );

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();

	return $out;
}
function modificarGrupo($id_asignatura, $descripcion, $nombre, $id_profesor) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "UPDATE  asignatura SET nombre = ?, descripcion = ?, id_profesor= ? WHERE asignatura.id_asignatura = ? " );
	$sentencia->bind_param ( 'ssss', $nombre, $descripcion, $id_asignatura, $id_profesor);
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

function modificarGrupoSinProfesor($id_asignatura, $descripcion, $nombre) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "UPDATE  asignatura SET nombre = ?, descripcion = ? WHERE asignatura.id_asignatura = ? " );
	$sentencia->bind_param ( 'sss', $nombre, $descripcion, $id_asignatura);
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}
function eliminarGrupo($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "DELETE FROM asignatura WHERE id_asignatura = ?" );
	$sentencia->bind_param ('s', $id_asignatura );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

function agregarResponsable($id_asignatura, $id_profesor) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "UPDATE asignatura SET id_profesor =  ? WHERE id_asignatura = ?" );
	$sentencia->bind_param ( 'ss', $id_profesor, $id_asignatura );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}


?>
