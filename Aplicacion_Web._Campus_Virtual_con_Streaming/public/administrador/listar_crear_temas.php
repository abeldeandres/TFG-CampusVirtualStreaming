<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['boton'] )) {
	$boton = $_POST ['boton'];

	if ($boton == 'Registrar Tema') {
		$fecha = $_POST ['fecha'];
		$id_asignatura = $_POST ['id_asignatura'];
		$descripcion = $_POST ['descripcion'];
		if (empty ( $descripcion )) {
			mensaje ( "warning", "Debe insertar una descripción" );
		} else {
			$ret = convocarReunion ( $id_asignatura, $fecha, $descripcion );
			$_POST = array ();
			if ($ret = NULL) {
				mensaje ( "danger", "Error al crear tena" );
			} else {
				mensaje ( "success", "El tema se ha creado correctamente" );
			}
		}
	} else if ($boton == 'Borrar') {
		$ret = eliminar_tema ( $_POST ['id_tema'] );
		if ($ret = NULL) {
			mensaje ( "danger", "Error al borrar el tema" );
		} else {
			mensaje ( "success", "El tema se ha borrado correctamente" );
		}
	}
}

// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Listado Temas";
function imprime_contenido() {
	if (isset ( $_GET ['idAsignatura'] )) {
		$id_asignatura = $_GET ['idAsignatura'];
	}
	$listaAsignaturas = obtenerGrupo ( $id_asignatura );

	if (! isset ( $_SESSION ['ruta'] )) {
		$_SESSION ['ruta'] = null;
	}
	$_SESSION ['ruta'] = 'listar_crear_temas.php?idAsignatura=' . $id_asignatura;
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li class="active">Listado de Temas</li>
</ol>
<h1>Listado de Temas</h1>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $listaAsignaturas['nombre'];?></h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th>Descripcion</th>
								<th>Fecha</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody>
        <?php
	$listaTemas = obtenerTodasLasReunionesDeGrupo ( $id_asignatura );
	foreach ( $listaTemas as $tema ) {
		?>
            <tr>
								<td><a
									href="informacion_tema.php?idTema=<?php echo $tema['id_tema'];?>"><?php echo $tema['descripcion']; ?></a></td>
								<td><?php echo $tema['fecha']; ?></td>
								<td>
									<form name="borrar"
										action="listar_crear_temas.php?idAsignatura=<?php echo $id_asignatura;?>"
										method="POST">
										<input type="hidden" name="id_tema"
											value="<?php echo $tema['id_tema']; ?>" /> <input
											type="hidden" name="id_asignatura"
											value="<?php echo $id_asignatura; ?>" /> <input type="submit"
											value="Borrar" name="boton" />
									</form>

								</td>

							</tr>
        <?php } ?>
        </tbody>
					</table>
				</li>
				<li class="list-group-item"><b><h3>
							Crear nuevo tema
							</h2></b><br>
					<form class="form-horizontal" method="POST"
						action="listar_crear_temas.php?idAsignatura=<?php echo $id_asignatura;?>"
						role="form" id="login">
						<input type="hidden" name="id_asignatura"
							value="<?php echo $id_asignatura; ?>">
						<div class="form-group">
							<label for="fecha" class="col-lg-4 control-label">Fecha
								(dd/mm/aaa)</label> <input type="date" name="fecha" value="" />

						</div>
						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Descripcion
								del tema</label>
							<textarea name='descripcion'></textarea>
						</div>
						<div class="form-group">
							<div class="text-center">
								<input type="submit" value="Registrar Tema" name="boton"
									class="btn btn-primary">
							</div>
						</div>
					</form></li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>