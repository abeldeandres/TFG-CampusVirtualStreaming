<?php
$rol = $_SESSION ['usuario'] ['rol'];
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div
				class="cabecera <?php
				switch ($rol) {
					case "Admin" :
						echo "admin";
						break;
					case "Profesor" :
						echo "profesor";
						break;
					case "Alumno" :
						echo "admin";
						break;
					default :
						break;
				}
				?>">
				<div class="diseño">
					<h1>Modo <?php echo $rol;?></h1>
				</div>
				<div class="datos text-center">
					<div class="text-left">
                Usuario: <?php echo $_SESSION ['usuario']['id_usuario'] ?><br />
                Nombre: <?php echo $_SESSION ['usuario']['nombre'] ?><br />
					</div>
					<a href="../salir.php" class="btn btn-primary ">Salir</a>
				</div>
			</div>
		</div>
	</div>
</div>