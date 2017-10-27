<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Informacion Asignatura";
function imprime_contenido() {
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}
	$listaAsignaturas = obtenerGrupo ( $id_asignatura );
	$profesor = obtenerUsuario ( $listaAsignaturas ['id_profesor'] );
	?>
<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
	<li class="active">Ver Informacion Asignatura</li>
</ol>
<h1>Informacion sobre Asignatura</h1>
<div class="row"></div>
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
						<dt>Descripcion:</dt>
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
			</ul>
		</div>
	</div>
</div>
<?php
}
?>
<?php

require_once '../common/layout.php';
?>