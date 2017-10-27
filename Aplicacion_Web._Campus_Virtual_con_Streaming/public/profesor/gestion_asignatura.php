<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Gestión de Asignaturas";
function imprime_contenido() {
	?>
<ol class="breadcrumb">
	<li class="active">Asignaturas</li>
</ol>
<h1>Listado de Asignaturas</h1>
<?php
	$id_usuario = $_SESSION ['usuario'] ['id_usuario'];

	$listaAsignaturas = obtenerTodasLasAsignaturasImpartidas ( $id_usuario );

	foreach ( $listaAsignaturas as $asignatura ) {
		$usuario = obtenerUsuario ( $asignatura ['id_profesor'] );
		?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $asignatura['nombre'] ?></h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">
				<dl>
					<dt>Descripción:</dt>
					<dd><?php echo $asignatura['descripcion'];?></dd>
					<dt>Profesor:</dt>
					<dd><?php echo $usuario['nombre'];?></dd>
					<br>
					<?php
		if (! isset ( $_SESSION ['ruta'] )) {
			$_SESSION ['ruta'] = null;
		}
		$_SESSION ['ruta'] = 'listar_crear_temas.php?idAsignatura=' . $asignatura ['id_asignatura'];
		?>
					<dt>
						<a
							href="listar_crear_temas.php?idAsignatura=<?php echo $asignatura['id_asignatura'] ?>">Ver
							Temas</a>
					</dt>
					<dt>
						<a
							href="informacion_asignatura.php?idAsignatura=<?php echo $asignatura['id_asignatura'] ?>">Ver
							Información Completa</a>
					</dt>
				</dl>
			</li>
			<ul>

	</div>
</div>
<?php
	}
}

require_once '../common/layout.php';
?>