<?php
function agregarMiembroAGrupo($id_usuario,$id_asignatura){
    $mysqli = new mysqli("localhost", "usuario", "", "bd_abel");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $sentencia = $mysqli->prepare("INSERT INTO `miembro` (`id_usuario`, `id_asignatura`) VALUES (?, ?)");
    $sentencia->bind_param('ss', $id_usuario,$id_asignatura);
    $out=$sentencia->execute();
        /* cierro stmt */
        $sentencia->close();
        $mysqli->close();
        return $out;

    }

    function eliminarMiembrosAsignatura($id_asignatura){
    	$mysqli = new mysqli("localhost", "usuario", "", "bd_abel");
    	if ($mysqli->connect_errno) {
    		echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    	}

    	$sentencia = $mysqli->prepare("DELETE FROM miembro WHERE id_asignatura= ?");
    	$sentencia->bind_param('s', $id_asignatura);
    	$out=$sentencia->execute();
    	/* cierro stmt */
    	$sentencia->close();
    	$mysqli->close();
    	return $out;

    }

function eliminarMiembroDeGrupo($id_usuario,$id_asignatura){
    $mysqli = new mysqli("localhost", "usuario", "", "bd_abel");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }


    $sentencia = $mysqli->prepare("DELETE FROM miembro WHERE id_usuario = ? AND id_asignatura = ?");
    $sentencia->bind_param('ss', $id_usuario,$id_asignatura);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $fila = $resultado->fetch_assoc();




        /* cierro stmt */
        $sentencia->close();
        $mysqli->close();
        return $fila;
    }

    function obtenerTodosLosGruposDelQueEsMiembro($id_usuario){
    $mysqli = new mysqli("localhost", "usuario", "", "bd_abel");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }


    $sentencia = $mysqli->prepare("SELECT * FROM miembro, asignatura WHERE `miembro`.`id_usuario` = ?");
    $sentencia->bind_param('s', $id_usuario);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $resultado->fetch_assoc();




        /* cierro stmt */
        $sentencia->close();
        $mysqli->close();
        return $resultado;
    }

?>
