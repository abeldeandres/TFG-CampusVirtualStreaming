<?php
require_once ("../../modelo/preparacionConsultaRecurso.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../common/errors.php");

if (isset ( $_POST ['id_tema'] )) {
	$idTema = $_POST ['id_tema'];
	$descripcionTema = $_POST ['descripcion'];
	$fecha = $_POST ['fecha'];
	if (empty ( $descripcionTema )) {
		mensaje ( "warning", "Debe rellenar el campo de descripción" );
	} else {
		$ret = modificarReunion ( $idTema, $descripcionTema, $fecha );
		if ($ret = NULL) {
			mensaje ( "danger", "No se ha podido modificar el tema" );
		} else {
			mensaje ( "success", "El tema se ha modificado correctamente" );
		}
	}
}
// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Modificar Tema";
function imprime_contenido() {
	if (isset ( $_GET ['idTema'] )) {
		$id_tema = $_GET ['idTema'];
	}
	$tema = obtenerReunion ( $id_tema );
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li><a href="<?php echo $_SESSION['ruta']?>">Listado de Temas</a></li>
	<li><a href="<?php echo $_SESSION['ruta2']?>">Información sobre el Tema</a></li>
	<li class="active">Modificar Tema</li>
</ol>
<h1>Modificar Tema</h1>
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
				<li class="list-group-item">
					<form method="post" role="form"
						action="modificar_tema.php?idTema=<?php echo $id_tema?>">
						<input type="hidden" name="id_tema"
							value="<?php echo $tema['id_tema'];?>" />
						<div class="form-group">
							<label for="fecha" class="col-lg-4 control-label">Fecha
								(dd/mm/aaa)</label> <input type="date" name="fecha"
								value="<?php echo $tema['fecha'];?>" />
						</div>
						<div class="form-group">
							<label for="descripcion" class="col-lg-4 control-label">Descripción
								del tema</label>
							<textarea name='descripcion'><?php echo $tema['descripcion'];?></textarea>
						</div>
						<div class="form-group">
							<div class="text-center">
								<input type="submit" value="Modificar" name="boton"
									class="btn btn-primary">
							</div>
						</div>
					</form>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>