<?php
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['profesores'] )) {
	$id_profesor = $_POST ['profesores'];
	$id_asignatura = $_POST ['id_asignatura'];
	$ret = agregarResponsable ( $id_asignatura, $id_profesor );
	if ($ret = NULL) {
		mensaje ( "danger", "No se ha podido cambiar el profesor" );
	} else {
		mensaje ( "success", "El profesor se ha modificado correctamente" );
	}
}
?>

<?php
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Cambiar Profesor";
function imprime_contenido() {
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}

	$asignatura = obtenerGrupo ( $id_asignatura );
	$profesor = obtenerUsuario ( $asignatura ['id_profesor'] );
	?>
<ol class="breadcrumb">
	<ol class="breadcrumb">
		<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
		<li class="active">Cambiar Profesor</li>
	</ol>
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
						<dt>Profesor:</dt>
						<dd><?php echo $profesor['nombre'];?></dd>
					</dl>
				</li>
				<li class="list-group-item">
					<?php
	$listaProfesores = obtenerProfesores ();
	?>
<form
						action="cambiar_profesor.php?idAsignatura=<?php echo $id_asignatura ?>"
						method="POST">
						<input type=hidden name="id_asignatura"
							value="<?php echo $asignatura ['id_asignatura'];?>"> <select
							name="profesores">
							<option value="" selected="selected">Elija un Profesor</option>
							<option value="">--------------------</option>
<?php
	$i = 0;
	foreach ( $listaProfesores as $profesor ) {
		$i ++;
		?>
	    <option value="<?php echo $profesor['nombre'];?>"><?php echo $profesor['nombre'];?></option>

<?php
	}
	?>
	</select> <input type="submit" value="Elegir Profesor">
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