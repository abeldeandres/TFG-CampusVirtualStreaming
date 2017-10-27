<?php
require_once ("../common/errors.php");

// Establece una sesion
if (! isset ( $_SESSION )) {
	session_start ();
}

// Si no exsiste
if (! isset ( $_SESSION ['usuario'] ['id_usuario'] )) {
	header ( 'Location: ../index.php' );
}

// TODO objeto como sesión
// $_SESSION ['usuario']['id_usuario']

// require_once ("menu_administrador.php");
require_once '../common/head_html.php';
?>
<body>
	<?php require '../common/header.php';	?>
	<div class="container-fluid principal">
		<div class="row">
			<div class="col-md-3">
				 <?php
					// TODO switch para el rol
					// require 'menu_administrador.php';
					switch ($_SESSION ['usuario'] ['rol']) {
						case "Admin" :

							require 'menu_administrador.php';
							break;
						case "Profesor" :
							require 'menu_responsable.php';
							break;
						case "Alumno" :
							require 'menu_miembro.php';
							break;
						default :
					}
					?>

			</div>
			<div class="col-md-9 contenido">
			<?php
			mostrar_error ();
			imprime_contenido ();
			?>
			</div>
		</div>
	</div>

        <?php
								require_once '../common/footer.php';
								?>
	</div>
</body>
</html>