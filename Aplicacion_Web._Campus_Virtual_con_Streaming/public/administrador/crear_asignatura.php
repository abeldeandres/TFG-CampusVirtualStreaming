<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['nombre'] )) {
	$nombre = $_POST ['nombre'];
	$descripcion = $_POST ['descripcion'];
	$id_profesor = $_POST ['profesores'];
	if (empty ( $id_profesor )) {
		mensaje ( "warning", "Necesita seleccionar un profesor" );
	} else {
		if (empty ( $nombre )) {
			mensaje ( "warning", "No ha escrito el nombre de la asignatura" );
		} else {
			$ret = crearAsignatura ( $nombre, $descripcion, $id_profesor );

			if ($ret == false) {
				mensaje ( "danger", "Error al insertar la asignatura" );
			} else {
				mensaje ( "success", "Se ha Agregado Correctamente" );
			}
		}
	}
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Registrar Asignatura";
function imprime_contenido() {
	?>
<h1>Registrar Asignaturas</h1>
<div class="well">
	<form class="form-horizontal" method="POST"
		action="crear_asignatura.php" role="form" id="login">
		<div class="form-group">
			<label for="nombre" class="col-lg-4 control-label">Nombre de la
				Asignatura</label> <input type="text" name="nombre" id="nombre"
				placeholder="Introduce el Nombre">
		</div>
		<div class="form-group">
			<label for="descripcion" class="col-lg-4 control-label">Descripcion
				de la Asignatura</label>
			<textarea name='descripcion'></textarea>
		</div>
		<div class="form-group">
			<div class="text-center">
			<?php
	$listaProfesores = obtenerProfesores ();
	?>
<select name="profesores">
					<option value="" selected="selected">Elija una Profesor</option>
					<option value="">--------------------</option>
<?php
	$i = 0;
	foreach ( $listaProfesores as $profesor ) {
		$i ++;
		?>
	    <option value="<?php echo $profesor['id_usuario'];?>"><?php echo $profesor['nombre'];?></option>

<?php
	}
	?>
	</select>
			</div>
		</div>
		<div class="form-group">
			<div class="text-center">
				<input type="submit" value="Registrar Asignatura"
					class="btn btn-primary">
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