<?php
function obtenerContenidosPublicos() {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT recurso.* ,tema.id_asignatura FROM tema, recurso WHERE recurso.es_publico = 1 AND tema.id_tema = recurso.id_tema" );
	// $sentencia->bind_param('s', $id_usuario);
	$sentencia->execute ();
	$resultado = $sentencia->get_result ();
	$resultado->fetch_assoc ();
	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $resultado;
}

function crearContenido($ruta, $nombre, $descripcion, $visibilidad, $id_tema, $autor) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "INSERT INTO recurso (ruta,nombre_recurso,descripcion_recurso,es_publico,id_tema,autor) VALUES (?, ?, ?, ?, ?, ?)" );
	$sentencia->bind_param ( 'ssssss', $ruta, $nombre, $descripcion, $visibilidad, $id_tema, $autor );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

function crearTutoria($nombre, $descripcion, $visibilidad, $id_tema, $autor,$id_alumno) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "INSERT INTO recurso (nombre_recurso,descripcion_recurso,es_publico,id_tema,autor,id_alumno) VALUES (?, ?, ?, ?, ?, ?)" );
	$sentencia->bind_param ( 'ssssss', $nombre, $descripcion, $visibilidad, $id_tema, $autor,$id_alumno);
	$sentencia->execute ();
	$out= $sentencia->insert_id;
	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

function modificarRecurso($ruta, $nombre, $descripcion, $visibilidad, $id_recurso, $autor) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare (  "UPDATE `recurso` SET `ruta`= ?, `nombre_recurso`= ?, `descripcion_recurso`= ?, `es_publico`= ?, `autor`= ? WHERE id_recurso = ?" );
	$sentencia->bind_param ( 'ssssss', $ruta, $nombre, $descripcion, $visibilidad, $autor, $id_recurso );
	$out=$sentencia->execute ();

	/* cierro stmt */
	$sentencia->close ();
	$mysqli->close ();
	return $out;
}

function obtenerTutoria($id_tema) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.id_alumno IS NOT NULL" );
	$sentencia->bind_param ( 's', $id_tema );
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

function obtenerTutoriaAlumno($id_tema,$id_alumno) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.id_alumno = ?" );
	$sentencia->bind_param ( 'ss', $id_tema,$id_alumno );
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


function obtenerRecursosPublicosTema($id_tema) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.es_publico=1 AND recurso.id_alumno IS NULL" );
	$sentencia->bind_param ( 's', $id_tema );
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

function obtenerRecursosPublicosTemaUsuario($id_tema,$id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.es_publico=1 AND recurso.autor=?" );
	$sentencia->bind_param ( 'ss', $id_tema,$id_usuario );
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

function obtenerRecursosPrivadosTema($id_tema) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.es_publico=0" );
	$sentencia->bind_param ( 's', $id_tema );
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

function obtenerRecursosPrivadosTemaUsuario($id_tema,$id_usuario) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "SELECT * FROM recurso WHERE  recurso.id_tema = ? AND recurso.es_publico=0 AND recurso.autor=?" );
	$sentencia->bind_param ( 'ss', $id_tema,$id_usuario );
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


function eliminarRecurso($id_recurso) {
	$mysqli = new mysqli ( "localhost", "usuario", "", "bd_abel" );
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sentencia = $mysqli->prepare ( "DELETE FROM recurso WHERE id_recurso=?" );
	$sentencia->bind_param('d', $id_recurso);
	$out=$sentencia->execute ();

	$sentencia->close();
	$mysqli->close();
	return $out;
}

function obtenerRecurso($id_recurso){
	$mysqli = new mysqli("localhost", "usuario", "", "bd_abel");
	if ($mysqli->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}


	$sentencia = $mysqli->prepare("SELECT * FROM recurso WHERE id_recurso = ?");
	$sentencia->bind_param('s', $id_recurso);
	$sentencia->execute();
	$resultado = $sentencia->get_result();




	/* cierro stmt */
	$sentencia->close();
	$mysqli->close();
	return $resultado->fetch_assoc ();
}

?>


