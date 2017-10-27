<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");
if (isset ( $_POST ['id_tema'] )) {

	$rutaOrigen = $_FILES ['nombreArchivo'] ['tmp_name'];
	$rutaDestino = $_FILES ['nombreArchivo'] ['name'];

	$ruta = "../archivos/" . $rutaDestino;
	$nombre = $_POST ['nombre'];
	$descripcion = $_POST ['descripcion_recurso'];
	$id_tema = $_POST ['id_tema'];
	$visibilidad = 0;
	$autor = $_POST ['autor'];

	if ($_POST ['visibilidad'] == "Publico")
		$visibilidad = 1;
	$ret = crearContenido ( $ruta, $nombre, $descripcion, $visibilidad, $id_tema, $autor );
	// Cargamos..
	if ((isset ( $_FILES ['nombreArchivo'] ['tmp_name'] ) && ($_FILES ['nombreArchivo'] ['error'] == UPLOAD_ERR_OK))) {
		$ruta = '../archivos/';
		move_uploaded_file ( $_FILES ['nombreArchivo'] ['tmp_name'], $ruta . $_FILES ['nombreArchivo'] ['name'] );
	}
	if ($ret = NULL) {
		mensaje ( "danger", "El recurso no se ha podido crear" );
	} else {
		mensaje ( "success", "El recurso se ha creado correctamente" );
	}
}
?>
<?php
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Agregar Recurso";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$id_usuario = $_SESSION ['usuario'] ['id_usuario'];
	$tema = obtenerReunion ( $id_tema );
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta']?>">Listado de Temas</a></li>
	<li><a href="<?php echo $_SESSION['ruta2']?>">Informacion sobre el Tema</a></li>
	<li class="active">Crear Recurso</li>
</ol>
<h1>Agregar Recurso</h1>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<b><?php echo $tema['descripcion'];?></b>
			</h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<dl>
						<dt>Fecha:</dt>
						<dd><?php echo $tema['fecha'];?></dd>
					</dl>
				</li>
				<li class="list-group-item"><b><h3>
							Agregar nuevo recurso
							</h2></b><br>
					<form method="post"
						action="agregar_recurso.php?idTema=<?php echo $id_tema?>"
						enctype="multipart/form-data">
						<input type="hidden" name="id_tema" value="<?php echo $id_tema;?>" />
						<input type="hidden" name="autor"
							value="<?php echo $id_usuario;?>" />

						<div class="form-group">
							<label for="nombre" class="col-lg-4 control-label">Nombre</label>
							<input type="text" name="nombre" value="" />
						</div>

						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Descripción
								del Recurso</label>
							<textarea name='descripcion_recurso'></textarea>
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
							<input type="submit" name="boton" value="Enviar">

						</div>
					</form></li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>