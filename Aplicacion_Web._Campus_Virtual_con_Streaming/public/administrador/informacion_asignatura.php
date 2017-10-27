<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Listado Asignaturas";
function imprime_contenido() {
	?>
<ol class="breadcrumb">
	<li class="active">Listado de Asignaturas</li>
</ol>
<h1>Información sobre Asignatura</h1>
<div class="row">
<?php
	$listaAsignaturas = obtenerTodosLosGrupos ();
	?>
<form action="informacion_asignatura.php" method="get">
		<select name="asignaturas">
			<option value="" selected="selected">Elija una asignatura</option>
			<option value="">--------------------</option>
<?php
	$i = 0;
	foreach ( $listaAsignaturas as $asignatura ) {
		$i ++;
		?>
	    <option value="<?php echo $asignatura['id_asignatura'];?>"><?php echo $asignatura['nombre'];?></option>

<?php
	}
	?>
	</select> <input type="submit" value="Ver Asignaturas">
	</form>
</div>
<?php
	if (isset ( $_GET ['asignaturas'] )) {
		$id_asignatura = $_GET ['asignaturas'];
		$listaAsignaturas = obtenerGrupo ( $id_asignatura );
		$profesor = obtenerUsuario ( $listaAsignaturas ['id_profesor'] );
		?>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $listaAsignaturas['nombre'];?></h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<dl>
						<dt>Nombre:</dt>
						<dd><?php echo $listaAsignaturas['nombre'];?></dd>
						<dt>Descripción:</dt>
						<dd><?php echo $listaAsignaturas['descripcion'];?></dd>
					</dl>
				</li>
				<li class="list-group-item"><b>Temas:</b>
					<ol>
			<?php
		$listaTemas = obtenerTodasLasReunionesDeGrupo ( $id_asignatura );
		$i = 0;
		foreach ( $listaTemas as $tema ) {
			$i ++;
			?>
				<li><a
							href="informacion_tema.php?idTema=<?php echo $tema['id_tema'];?>"><?php echo $tema['descripcion']?> (<?php echo $tema['fecha']?>)</a></li>
				<?php
		}
		?>
			</ol></li>
				<li class="list-group-item">
					<dl>
						<br>
						<dt>Profesor Responsable:</dt>
						<dd><?php echo $profesor['nombre'];?></dd>
					</dl>
				</li>
				<li class="list-group-item"><b>Alumnos:</b>
					<ul>
			<?php
		$listaAlumnos = obtenerAlumnosAsignatura ( $id_asignatura );
		$i = 0;
		foreach ( $listaAlumnos as $alumno ) {
			$i ++;
			?>
				<li> <?php echo $alumno['nombre'];?> (<?php echo $alumno['id_usuario'];?>)</li>
				<?php
		}
		?>
			</ul></li>
				<li class="list-group-item">
					<ul>
						<li><a
							href="informacion_asignatura_modificar.php?idAsignatura=<?php echo $_GET ['asignaturas'];?>">Modificar
								datos de la asignatura</a></li>
						<li><a
							href="listar_crear_temas.php?idAsignatura=<?php echo $_GET ['asignaturas'];?>">Gestionar
								Temas</a></li>
						<li><a
							href="cambiar_profesor.php?idAsignatura=<?php echo $_GET ['asignaturas'];?>">Cambiar
								profesor</a></li>
						<li><a
							href="cambiar_usuarios_asignatura.php?idAsignatura=<?php echo $_GET ['asignaturas'];?>">Cambiar
								Alumnos Matriculados</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
	}
	?>
<?php
}

require_once '../common/layout.php';
?>