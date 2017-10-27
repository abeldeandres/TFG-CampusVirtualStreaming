<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['id_tema'] )) {
	$id_recurso = $_POST ['id_recurso'];
	$ret = eliminarRecurso ( $id_recurso );
	if ($ret == false) {
		mensaje ( "danger", "Error al borrar la tutoria" );
	} else {
		mensaje ( "success", "La tutoría se ha borrado correctamente" );
	}
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Información del tema";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}
	$tema = obtenerReunion ( $id_tema );
	if (! isset ( $_SESSION ['ruta2'] )) {
		$_SESSION ['ruta2'] = null;
	}
	$_SESSION ['ruta2'] = 'informacion_tema.php?idAsignatura=' . $id_asignatura . '&idTema=' . $id_tema;
	?>
<ol class="breadcrumb">
	<li><a href="gestion_asignatura.php">Listado de Asignaturas</a></li>
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
				<li class="list-group-item"><b>Tutorias:</b>
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody>
        <?php
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$listaTutorias = obtenerTutoria ( $id_tema );
	foreach ( $listaTutorias as $tutoria ) {
		?>
            <tr>
								<td><a target="_blank"
									href="http://<?php echo $_SERVER['HTTP_HOST']?>:3030/streaming/<?php echo $tutoria['id_recurso'];?>"><?php echo $tutoria['nombre_recurso']; ?></a></td>
								<td><?php echo $tutoria['descripcion_recurso']; ?></td>
								<td>
									<form name="borrar"
										action="informacion_tema.php?idAsignatura=<?php echo $id_asignatura?>&idTema=<?php echo $id_tema?>"
										method="POST">
										<input type="hidden" name="id_tema"
											value="<?php echo $id_tema ?>" /> <input type="hidden"
											name="id_recurso"
											value="<?php echo $tutoria['id_recurso'];?>" /> <input
											type="submit" value="Borrar" />
									</form>

								</td>

							</tr>
        <?php } ?>
        </tbody>
					</table></li>
				<li class="list-group-item">
					<ul>
						<li><a
							href="modificar_tema.php?idTema=<?php echo $_GET ['idTema'];?>">Modificar
								datos del tema </a></li>
						<li><a
							href="agregar_recurso.php?idTema=<?php echo $_GET ['idTema'];?>">Añadir
								Recurso</a></li>
						<li><a
							href="crear_tutoria.php?idAsignatura=<?php echo $id_asignatura?>&idTema=<?php echo $_GET ['idTema'];?>">Crear
								Tutoría</a></li>
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
