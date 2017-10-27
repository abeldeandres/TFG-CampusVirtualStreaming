<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Listado de Temas";
function imprime_contenido() {
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}
	$asignatura = obtenerGrupo ( $id_asignatura );
	if (! isset ( $_SESSION ['ruta1'] )) {
		$_SESSION ['ruta1'] = null;
	}
	$_SESSION ['ruta1'] = 'listado_temas.php?idAsignatura=' . $id_asignatura;
	?>

<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
	<li class="active">Listado de Temas</a></li>
</ol>
<h1>Listado de Temas</h1>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $asignatura['nombre'] ?></h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">

<?php
	$listaTemas = obtenerTodasLasReunionesDeGrupo ( $id_asignatura );
	foreach ( $listaTemas as $tema ) {
		?>
    <li class="list-group-item">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5 class="panel-title">
							<b><?php echo $tema['descripcion']?> (<?php echo $tema['fecha']?>)</b>
						</h5>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item">
								<dl>
									<dt>Descripción:</dt>
									<dd><?php echo $tema['descripcion'];?></dd>
								</dl>
							</li>
							<li class="list-group-item"><b>Recursos Públicos:</b>
								<table class="table table-striped" border="1">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Descripción</th>
											<th>Ruta</th>
											<th>Autor</th>
										</tr>
									</thead>
									<tbody>
        <?php
		$id_tema = $tema ['id_tema'];
		$listaRecursos = obtenerRecursosPublicosTema ( $id_tema );
		foreach ( $listaRecursos as $recurso ) {
			$profesor = obtenerUsuario ( $recurso ['autor'] );
			?>
            <tr>
											<td><?php echo $recurso['nombre_recurso']; ?></a></td>
											<td><?php echo $recurso['descripcion_recurso']; ?></td>
											<td><?php

if ($recurso ['ruta'] == '../archivos/') {
				echo 'No tiene archivo';
			} else {
				?><a target="_blank"
												href="../archivos/<?php echo $recurso['ruta']; ?>"><?php echo $recurso['ruta']; ?></a>
									<?php }?>
									</td>
											<td><?php echo $profesor['nombre']; ?></td>
										</tr>
        <?php } ?>
        </tbody>
								</table></li>
							<li class="list-group-item"><b>Tutorías</b>
								<table class="table table-striped" border="1">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Descripción</th>
										</tr>
									</thead>
									<tbody>
        <?php
		$id_tema = $tema ['id_tema'];
		$id_usuario = $_SESSION ['usuario'] ['id_usuario'];
		$listaTutorias = obtenerTutoriaAlumno ( $id_tema, $id_usuario );
		foreach ( $listaTutorias as $tutoria ) {
			?>
            <tr>
											<td><a
												href="http://<?php echo $_SERVER['HTTP_HOST']?>:3030/streaming/<?php echo $tutoria['id_recurso'];?>"
												target="_blank"><?php echo $tutoria['nombre_recurso']; ?></a></td>
											<td><?php echo $tutoria['descripcion_recurso']; ?></td>
										</tr>
        <?php } ?>
        </tbody>
								</table></li>
							<li class="list-group-item">
								<ul>
									<li><a
										href="listar_recursos_propios.php?idTema=<?php echo $id_tema;?>">Editar
											mis Recursos</a></li>
									<li><a href="agregar_recurso.php?idTema=<?php echo $id_tema;?>">Añadir
											Recurso</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
<?php
	}
	?>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>