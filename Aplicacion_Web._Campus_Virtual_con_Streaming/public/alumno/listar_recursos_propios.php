<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");

if (isset ( $_POST ['id_tema'] )) {
	$id_recurso = $_POST ['id_recurso'];
	eliminarRecurso ( $id_recurso );
	header ( 'Location: listar_crear_temas.php' );
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Listado Temas";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$tema = obtenerReunion ( $id_tema );
	$id_usuario = $_SESSION ['usuario'] ['id_usuario'];
	if (! isset ( $_SESSION ['ruta2'] )) {
		$_SESSION ['ruta2'] = null;
	}
	$_SESSION ['ruta2'] = 'listar_recursos_propios.php?idTema=' . $id_tema;
	?>
<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta1']?>">Listado de Temas</a></li>
	<li class="active">Listado de Recursos</a></li>
</ol>
<h1>Listado de Recursos</h1>
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
				<li class="list-group-item"><b>Recursos Publicos:</b>
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Ruta</th>
								<th>Autor</th>
							</tr>
						</thead>
						<tbody>
        <?php
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$listaRecursos = obtenerRecursosPublicosTemaUsuario ( $id_tema, $id_usuario );
	foreach ( $listaRecursos as $recurso ) {
		$profesor = obtenerUsuario ( $recurso ['autor'] );
		?>
            <tr>
								<td><a
									href="recurso_modificar.php?idRecurso=<?php echo $recurso['id_recurso'];?>"><?php echo $recurso['nombre_recurso']; ?></a></td>
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
				<li class="list-group-item"><b>Recursos Privados:</b>
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Ruta</th>
								<th>Autor</th>
							</tr>
						</thead>
						<tbody>
        <?php
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$listaRecursos = obtenerRecursosPrivadosTemaUsuario ( $id_tema, $id_usuario );
	foreach ( $listaRecursos as $recurso ) {
		$profesor = obtenerUsuario ( $recurso ['autor'] );
		?>
            <tr>
								<td><a
									href="recurso_modificar.php?idRecurso=<?php echo $recurso['id_recurso'];?>"><?php echo $recurso['nombre_recurso']; ?></a></td>
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
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>