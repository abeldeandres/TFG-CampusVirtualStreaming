<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['id_tema'] )) {
	$id_tema=$_POST ['id_tema'];
	$id_recurso = $_POST ['id_recurso'];
	$ret=eliminarRecurso ( $id_recurso );
	if($ret=NULL)
	{
		mensaje ( "danger", "Error al borrar el recurso");
	}
	else{
		mensaje ( "success", "El recurso se ha eliminado correctamente" );
	}
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Gestión de Recursos";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$tema = obtenerReunion ( $id_tema );

	if (! isset ( $_SESSION ['ruta3'] )) {
		$_SESSION ['ruta3'] = null;
	}
	$_SESSION ['ruta3'] = 'gestionar_recursos.php?idTema=' . $id_tema;
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta']?>">Listado de Temas</a></li>
	<li><a href="<?php echo $_SESSION['ruta2']?>">Información sobre el Tema</a></li>
	<li class="active">Gestionar Recursos</li>
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
				<li class="list-group-item"><b>Recursos Públicos:</b>
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Ruta</th>
								<th>Autor</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody>
        <?php
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$listaRecursos = obtenerRecursosPublicosTema ( $id_tema );
	foreach ( $listaRecursos as $recurso ) {
		$profesor = obtenerUsuario ( $recurso ['autor'] );
		?>
            <tr>
								<td><a
									href="informacion_recurso_modificar.php?idRecurso=<?php echo $recurso['id_recurso'];?>"><?php echo $recurso['nombre_recurso']; ?></a></td>
								<td><?php echo $recurso['descripcion_recurso']; ?></td>
								<td><?php if($recurso['ruta']=='../archivos/'){
									echo 'No tiene archivo';}
									else{
									?><a target="_blank" href="../archivos/<?php echo $recurso['ruta']; ?>"><?php echo $recurso['ruta']; ?></a>
									<?php }?>
									</td>
								<td><?php echo $profesor['nombre']; ?></td>
								<td>
									<form name="borrar" action="gestionar_recursos.php?idTema=<?php echo $id_tema ?>"
										method="POST">
										<input type="hidden" name="id_tema"
											value="<?php echo $id_tema ?>" /> <input type="hidden"
											name="id_recurso"
											value="<?php echo $recurso['id_recurso'];?>" /> <input
											type="submit" value="Borrar" />
									</form>

								</td>

							</tr>
        <?php } ?>
        </tbody>
					</table></li>
				<li class="list-group-item"><b>Recursos Privados:</b>
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Ruta</th>
								<th>Autor</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody>
        <?php
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$listaRecursos = obtenerRecursosPrivadosTema ( $id_tema );
	foreach ( $listaRecursos as $recurso ) {
		$profesor = obtenerUsuario ( $recurso ['autor'] );
		?>
            <tr>
								<td><a
									href="informacion_recurso_modificar.php?idRecurso=<?php echo $recurso['id_recurso'];?>"><?php echo $recurso['nombre_recurso']; ?></a></td>
								<td><?php echo $recurso['descripcion_recurso']; ?></td>
								<td><?php if($recurso['ruta']=='../archivos/'){
									echo 'No tiene archivo';}
									else{
									?><a target="_blank" href="../archivos/<?php echo $recurso['ruta']; ?>"><?php echo $recurso['ruta']; ?></a>
									<?php }?>
									</td>
								<td><?php echo $profesor['nombre']; ?></td>
								<td>
									<form name="borrar" action="gestionar_recursos.php?idTema=<?php echo $id_tema ?>"
										method="POST">
										<input type="hidden" name="id_tema"
											value="<?php echo $id_tema ?>" /> <input type="hidden"
											name="id_recurso"
											value="<?php echo $recurso['id_recurso'];?>" /> <input
											type="submit" value="Borrar" />
									</form>

								</td>

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