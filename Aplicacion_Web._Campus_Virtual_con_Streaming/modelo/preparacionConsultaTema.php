<?php
function obtenerTodasLasReunionesDeGrupo($id_asignatura) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM tema WHERE tema.id_asignatura = ?" );
	$sentencia->bind_param ( 's', $id_asignatura );
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
function convocarReunion($id_asignatura, $fecha, $descripcion) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "INSERT INTO tema (fecha,descripcion,id_asignatura) VALUES (?, ?, ?)" );
	$sentencia->bind_param ( 'sss', $fecha, $descripcion, $id_asignatura );
	$fila = $sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $fila;
}
function obtenerReunion($id_tema) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM tema where id_tema = ?" );
	$sentencia->bind_param ( 's', $id_tema );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $resultado->fetch_assoc ();
}
function modificarReunion($id_tema, $descripcion, $fecha) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "UPDATE `bd_abel`.`tema` SET `fecha` = ?, `descripcion` = ? WHERE `tema`.`id_tema` = ?" );
	$sentencia->bind_param ( 'sss', $fecha, $descripcion, $id_tema );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}
function obtenerTodasLasReuniones($id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM tema WHERE tema.id_asignatura IN (SELECT miembro.id_asignatura FROM miembro WHERE miembro.id_usuario = ?)" );
	$sentencia->bind_param ( 's', $id_usuario );
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$resultado->fetch_assoc ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $resultado;
}
function eliminar_tema($id_tema) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "DELETE FROM tema WHERE id_tema=?" );
	$sentencia->bind_param ( 'd', $id_tema );
	$ret = $sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $ret;
}

?>