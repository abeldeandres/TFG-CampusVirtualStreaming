<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['id_tema'] )) {
	$nombre = $_POST ['nombre'];
	$descripcion = $_POST ['descripcion_recurso'];
	$id_tema = $_POST ['id_tema'];
	$visibilidad = 1;
	$autor = $_POST ['autor'];
	$id_alumno = $_POST ['alumnos'];
	if (empty ( $nombre )) {
		mensaje ( "warning", "Debe rellenar el campo del nombre" );
	} else {
		$ret = crearTutoria ( $nombre, $descripcion, $visibilidad, $id_tema, $autor, $id_alumno, $id_alumno );
		if ($ret == false) {
			mensaje ( "danger", "Error al insertar la asignatura" );
		} else {
			mensaje ( "success", "La tutoria se ha creado correctamente" );
		}
	}
}
?>
<?php
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Añadir Recurso";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}
	$id_usuario = $_SESSION ['usuario'] ['id_usuario'];
	$tema = obtenerReunion ( $id_tema );
	?>
<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta1']?>">Listado de Temas</a></li>
	<li><a href="<?php echo $_SESSION['ruta2']?>">Información sobre el Tema</a></li>
	<li class="active">Crear Recurso</li>
</ol>
<h1>Crear Tutoría</h1>
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
							Crear nueva tutoría
							</h2></b><br>
					<form method="post"
						action="crear_tutoria.php?idAsignatura=<?php echo $id_asignatura?>&idTema=<?php echo $id_tema;?>"
						enctype="multipart/form-data">
						<input type="hidden" name="id_tema" value="<?php echo $id_tema;?>" />
						<input type="hidden" name="autor"
							value="<?php echo $id_usuario;?>" />

						<div class="form-group">
							<label for="nombre" class="col-lg-4 control-label">Nombre:</label>
							<input type="text" name="nombre" value="" />
						</div>

						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Descripción
								de la tutoría:</label>
							<textarea name='descripcion_recurso'></textarea>
						</div>
						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Elija
								Alumno</label>
							<?php
	$listaAlumnos = obtenerAlumnosAsignatura ( $id_asignatura );
	?>
		<select name="alumnos">
								<option value="" selected="selected">Elija un alumno</option>
								<option value="">--------------------</option>
<?php
	$i = 0;
	foreach ( $listaAlumnos as $alumno ) {
		$i ++;
		?>
	    <option value="<?php echo $alumno['id_usuario'];?>"><?php echo $alumno['nombre'];?></option>

<?php
	}
	?>



						</div>
						<div class="form-group">
							<input type="submit" name="boton" value="Crear">
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