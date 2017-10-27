<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Consulta de Temas";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$tema = obtenerReunion ( $id_tema );

	if (! isset ( $_SESSION ['ruta2'] )) {
		$_SESSION ['ruta2'] = null;
	}
	$_SESSION ['ruta2'] = 'informacion_tema.php?idTema=' . $id_tema;
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta']?>">Listado de Temas</a></li>
	<li class="active">Información sobre el Tema</li>
</ol>
<h1>Información sobre el tema</h1>
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
				<li class="list-group-item"><b>Recursos Públicos:</b>
					<ul>
			<?php
	$listaRecursoPublico = obtenerRecursosPublicosTema ( $id_tema );
	$i = 0;
	foreach ( $listaRecursoPublico as $recursoPublico ) {
		$i ++;
		?>
				<li><b>Nombre:</b> <?php echo $recursoPublico['nombre_recurso'];?></li>
				<?php
	}
	?>
			</ul></li>
				<li class="list-group-item"><b>Recursos Privados:</b>
					<ul>
			<?php
	$listaRecursoPublico = obtenerRecursosPrivadosTema ( $id_tema );
	$i = 0;
	foreach ( $listaRecursoPublico as $recursoPublico ) {
		$i ++;
		?>
				<li><b>Nombre:</b> <?php echo $recursoPublico['nombre_recurso'];?></li>
				<?php
	}
	?>
			</ul></li>
				<li class="list-group-item"><b>Tutorías:</b>
					<ul>
			<?php
	$listaTutorias = obtenerTutoria ( $id_tema );
	$i = 0;
	foreach ( $listaTutorias as $tutoria ) {
		$i ++;
		?>
				<li><b>Nombre:</b> <?php echo $tutoria['nombre_recurso'];?></li>
				<?php
	}
	?>
			</ul></li>
				<li class="list-group-item">
					<ul>
						<li><a
							href="modificar_tema.php?idTema=<?php echo $_GET ['idTema'];?>">Modificar
								datos del tema </a></li>
						<li><a
							href="agregar_recurso.php?idTema=<?php echo $_GET ['idTema'];?>">Añadir
								Recurso</a></li>
						<li><a
							href="gestionar_recursos.php?idTema=<?php echo $_GET ['idTema'];?>">Gestionar
								recursos</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>