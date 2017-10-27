<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
if (isset ( $_POST ['boton'] )) {
	$boton = $_POST ['boton'];

	$id_asignatura = $_POST ['id_asignatura'];

	if ($boton == 'Modificar') {
		$descripcion = $_POST ['descripcion'];
		$nombre = $_POST ['nombre'];
		$id_profesor = $_POST ['profesores'];

		modificarGrupo ( $id_asignatura, $descripcion, $nombre, $id_profesor );
		header ( 'Location: modificar_asignatura.php' );
	} else if ($boton == 'Eliminar') {
		eliminarGrupo ( $id_asignatura );
		header ( 'Location: modificar_asignatura.php' );
	}
}
?>
<?php
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Modificar Usuario";
function imprime_contenido() {
	?>
<h1>Lista Asignaturas</h1>
<?php
	$listaAsignaturas = obtenerTodosLosGrupos ();
	?>
<div class="panel-group" id="accordion" role="tablist"
	aria-multiselectable="false">
<?php
	$i = 0;
	foreach ( $listaAsignaturas as $asignatura ) {
		$i ++;
		?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse"
					data-parent="#accordion" href="#collapse<?php
		echo $i;
		?>"
					aria-expanded="false" aria-controls="collapse<?php echo $i;?>">
          <?php echo $asignatura['nombre'];?> (Profesor:<?php echo $asignatura['id_profesor'];?>)
        </a>
			</h4>
		</div>
		<div id="collapse<?php echo $i;?>" class="panel-collapse collapse"
			role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
			<div class="panel-body">
				<form method="post" role="form" action="modificar_asignatura.php">
					<input type="hidden" name="id_asignatura"
						value="<?php echo $asignatura['id_asignatura'] ?>" />
					<div class="form-group">
						<label for="nombre" class=" control-label">Nombre de la Asignatura</label>
						<input class="form-control" type="text" id="nombre" name="nombre"
							placeholder="Introduce un nombre"
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
						<label for="profesor" class=" control-label">Profesor de la
							Asignatura: </label> <label><?php echo $asignatura['id_profesor'];?></label>

					</div>
					<div class="form-group">
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
					<div class="form-group">
						<div class="text-center">
							<input type="submit" value="Modificar" name="boton"
								class="btn btn-primary"> <input type="submit" value="Eliminar"
								name="boton" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	}
	?>
</div>
<?php
}

require_once '../common/layout.php';
?>
