<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../common/errors.php");

if (isset ( $_GET ['idAsignatura'] )) {
	$id_asignatura = $_GET ['idAsignatura'];
}

if (isset ( $_POST ['boton'] )) {
	$boton = $_POST ['boton'];

	$id_asignatura = $_POST ['id_asignatura'];

	if ($boton == 'Modificar') {
		$descripcion = $_POST ['descripcion'];
		$nombre = $_POST ['nombre'];
		if (empty ( $nombre )) {
			mensaje ( "warning", "Debe rellenar el campo de nombre" );
		} else {
			$ret = modificarGrupoSinProfesor ( $id_asignatura, $descripcion, $nombre );
			if ($ret = NULL) {
				mensaje ( "danger", "Error al modificar asignatura" );
			} else {
				mensaje ( "success", "Asignatura modificada correctamente" );
			}
		}
	} else if ($boton == 'Eliminar') {
		$ret = eliminarGrupo ( $id_asignatura );
		if ($ret = NULL) {
			mensaje ( "danger", "Error al eliminar asignatura" );
		} else {
			mensaje ( "success", "Asignatura eliminada correctamente" );
		}
	}
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Modificar Asignatura";
function imprime_contenido() {
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}

	$asignatura = obtenerGrupo ( $id_asignatura );
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li class="active">Modificar Asignatura</li>
</ol>
<h1>Modificar Asignatura</h1>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $asignatura ['nombre'];?></h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<dl>
						<dt>Nombre:</dt>
						<dd><?php echo $asignatura ['nombre'];?></dd>
						<dt>Descripcion:</dt>
						<dd><?php echo $asignatura['descripcion'];?></dd>
					</dl>
				</li>
				<li class="list-group-item">
					<form method="post" role="form"
						action="informacion_asignatura_modificar.php?idAsignatura=<?php echo $id_asignatura ?>">
						<input type="hidden" name="id_asignatura"
							value="<?php echo $asignatura['id_asignatura'] ?>" />
						<div class="form-group">
							<label for="nombre" class=" control-label">Nombre de la
								Asignatura</label> <input class="form-control" type="text"
								id="nombre" name="nombre" placeholder="Introduce un nombre"
								value="<?php echo $asignatura['nombre'];?>">
						</div>
						<div class="form-group">
							<label for="descripcion" class=" control-label">Descripcion de la
								Asignatura</label>
						</div>
						<div class="form-group">
							<textarea name='descripcion'><?php echo $asignatura['descripcion'];?></textarea>
						</div>
						<div class="form-group">
							<div class="text-center">
								<input type="submit" value="Modificar" name="boton"
									class="btn btn-primary"> <input type="submit" value="Eliminar"
									name="boton" class="btn btn-primary">
							</div>
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