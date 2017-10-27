<?php
require_once ("../../modelo/preparacionConsultaAsignatura.php");
require_once ("../../modelo/preparacionConsultaTema.php");
require_once ("../../modelo/preparacionConsultaUsuario.php");
require_once ("../../modelo/preparacionConsultaMiembro.php");
require_once ("../common/errors.php");

if (isset($_POST['idAsignatura'])) {
	$id_asignatura=$_POST['idAsignatura'];
	eliminarMiembrosAsignatura($id_asignatura);
	foreach ($_POST['selectRight'] as $alumno) {
		agregarMiembroAGrupo($alumno,$id_asignatura);
	}
	mensaje('success','Alumnos almacenados con éxito');
}



// Variable para el título de la página
$titulo_pagina = "CampusVirtual - Cambiar Usuarios";
function imprime_contenido() {
	?>
<ol class="breadcrumb">
	<li><a href="informacion_asignatura.php">Listado de Asignaturas</a></li>
	<li class="active">Agregar/Eliminar Alumnos</li>
</ol>
<h1>Agregar/Eliminar Alumnos</h1>
<?php
	$id_asignatura = $_GET ['idAsignatura'];
	$listaAsignaturas = obtenerGrupo ( $id_asignatura );
	$profesor = obtenerUsuario ( $listaAsignaturas ['id_profesor'] );
	?>
<script type="text/javaScript">

function moveToRightOrLeft(side){
	var listLeft=document.getElementById('selectLeft');
	var listRight=document.getElementById('selectRight');

	if (side == 1) {
		if(listLeft.options.length==0){
			alert('You have already moved all countries to Right');
			return false;
		}
		else {
			var selectedCountry=listLeft.options.selectedIndex;
			move(listRight,listLeft.options[selectedCountry].value,listLeft.options[selectedCountry].text);
			listLeft.remove(selectedCountry);
			if(listLeft.options.length>0) {
				listLeft.options[0].selected=true;
			}
		}
	}
	else if(side == 2){
		if(listRight.options.length==0){
			alert('You have already moved all countries to Left');
			return false;
		}
		else {
			var selectedCountry=listRight.options.selectedIndex;
			move(listLeft,listRight.options[selectedCountry].value,listRight.options[selectedCountry].text);
			listRight.remove(selectedCountry);
			if(listRight.options.length>0) {
				listRight.options[0].selected=true;
			}
		}
	}
}

function move(listBoxTo,optionValue,optionDisplayText){
	var newOption = document.createElement("option");
	newOption.value = optionValue;
	newOption.text = optionDisplayText;
	listBoxTo.add(newOption, null);
	return true;
}

function enviarAlumnos() {
	var listRight=document.getElementById('selectRight');

	for (var i = 0; i < listRight.children.length; i++) {
		var option = listRight.children[i];

		option.selected = true;
	}

	document.getElementById("formAlumnos").submit();
}

</script>
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
				<li class="list-group-item">
					<dl>
						<br>
						<dt>Profesor Responsable:</dt>
						<dd><?php echo $profesor['nombre'];?></dd>
					</dl>
				</li>
				<li class="list-group-item">
					<table border="0">

						<tr>
							<td colspan="2"><b>Alumnos del Sistema</b></td>
							<td align="left">&nbsp;</td>
							<td colspan="2"><b>Alumnos de la Asignatura</b></td>
						</tr>
						<tr>
							<td rowspan="3" align="right"><label> <select name="selectLeft"
									size="10" id="selectLeft" multiple>
									<?php
										$listaAlumnosAsignatura = obtenerTodosLosAlumnoQueNoEstanGrupo ( $id_asignatura );
										$i = 0;
										foreach ( $listaAlumnosAsignatura as $alumnos ) {
											$i ++;
											?>
										<option value="<?php echo $alumnos['id_usuario'];?>"><?php echo $alumnos['id_usuario'];?> / <?php echo $alumnos['nombre'];?></option>
										<?php
									}
									?>
								</select>
							</label></td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td rowspan="3" align="left">
								<form method="post" id="formAlumnos" action="cambiar_usuarios_asignatura.php?idAsignatura=<?php echo $id_asignatura?>">
									<input type="hidden" name="idAsignatura" value="<?php echo $id_asignatura?>">
									<select name="selectRight[]" size="10" id="selectRight" multiple>
										<?php
											$listaAlumnosAsignatura = obtenerAlumnosAsignatura ( $id_asignatura );
											$i = 0;
											foreach ( $listaAlumnosAsignatura as $alumnos ) {
												$i ++;
												?>
											<option value="<?php echo $alumnos['id_usuario'];?>"><?php echo $alumnos['id_usuario'];?> / <?php echo $alumnos['nombre'];?></option>
											<?php
										}
										?>
								</select><br /> <input type="button" value="Guardar alumnos"
										onclick="enviarAlumnos()" />
								</form>
							</td>
						</tr>
						<tr>
							<td align="left">&nbsp;</td>
							<td align="left"><label> <input name="btnRight" type="button"
									id="btnRight" value="&gt;&gt;"
									onClick="javaScript:moveToRightOrLeft(1);">
							</label></td>
						</tr>
						<tr>
							<td align="left">&nbsp;</td>
							<td align="left"><label> <input name="btnLeft" type="button"
									id="btnLeft" value="&lt;&lt;"
									onClick="javaScript:moveToRightOrLeft(2);">
							</label></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
					</table>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
}

require_once '../common/layout.php';
?>
