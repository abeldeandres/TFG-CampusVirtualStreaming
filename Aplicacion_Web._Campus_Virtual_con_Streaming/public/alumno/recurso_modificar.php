<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");
if (isset ( $_POST ['id_recurso'] )) {

	$rutaOrigen = $_FILES ['nombreArchivo'] ['tmp_name'];
	$rutaDestino = $_FILES ['nombreArchivo'] ['name'];

	$ruta = "../archivos/" . $rutaDestino;
	$nombre = $_POST ['nombre'];
	$descripcion = $_POST ['descripcion_recurso'];
	$id_recurso = $_POST ['id_recurso'];
	$visibilidad = 0;
	$autor = $_POST ['autor'];

	if ($_POST ['visibilidad'] == "Publico") {
		$visibilidad = 1;
	}

	$ret = modificarRecurso ( $ruta, $nombre, $descripcion, $visibilidad, $id_recurso, $autor );
	// Cargamos..
	if ((isset ( $_FILES ['nombreArchivo'] ['tmp_name'] ) && ($_FILES ['nombreArchivo'] ['error'] == UPLOAD_ERR_OK))) {
		$ruta = '../archivos/';
		move_uploaded_file ( $_FILES ['nombreArchivo'] ['tmp_name'], $ruta . $_FILES ['nombreArchivo'] ['name'] );
	}
	if ($ret = NULL) {
		mensaje ( 'danger', 'No se ha podido modificar el recurso' );
	} else {
		mensaje ( 'success', 'El recurso se ha modificado correctamente' );
	}
}
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Modificar Recurso";
function imprime_contenido() {
	if (isset ( $_GET ['idRecurso'] )) {
		$id_recurso = $_GET ['idRecurso'];
	}
	$recurso = obtenerRecurso ( $id_recurso );
	?>
<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta']?>">Listado de Temas</a></li>
	<li><a href="<?php echo $_SESSION['ruta2']?>">Listado de Recursos
			Propios</a></li>
	<li class="active">Modificar Recurso</a></li>
</ol>
<h1>Modificar Recurso</h1>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $recurso ['nombre_recurso'];?></h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<dl>
						<dt>Nombre:</dt>
						<dd><?php echo $recurso['nombre_recurso'];?></dd>
						<dt>Descripción:</dt>
						<dd><?php echo $recurso['descripcion_recurso'];?></dd>
						<dt>Autor:</dt>
						<dd><?php echo $recurso['autor'];?></dd>
					</dl>
				</li>

				<li class="list-group-item">Modificar recurso
					</h2> </b><br>
					<form method="post"
						action="recurso_modificar.php?idRecurso=<?php echo $id_recurso?>"
						enctype="multipart/form-data">
						<input type="hidden" name="id_recurso"
							value="<?php echo $recurso['id_recurso'];?>" /> <input
							type="hidden" name="autor"
							value="<?php echo $recurso['autor'];?>" />

						<div class="form-group">
							<label for="nombre" class="col-lg-4 control-label">Nombre</label>
							<input type="text" name="nombre"
								value="<?php echo $recurso['nombre_recurso'];?>" />
						</div>

						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Descripcion
								del Recurso</label>
							<textarea name='descripcion_recurso'><?php echo $recurso['descripcion_recurso'];?></textarea>
						</div>

						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Visibilidad</label>
							<select name="visibilidad" size="1">
								<option value="Publico">Publico</option>
								<option value="Privado">Privado</option>
							</select>
						</div>
						<div class="form-group">
							<label for="cargar" class="col-lg-4 control-label">Seleccionar
								Archivo</label> <input type="file" name="nombreArchivo">
						</div>
						<div class="form-group">
							<input type="submit" name="boton" value="Modificar">

						</div>
					</form>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>