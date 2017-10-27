<?php
// Establece una sesion
if (! isset ( $_SESSION )) {
	session_start ();
}

// Variable String con error si hubiera
if (! isset ( $_SESSION ['error'] )) {
	$_SESSION ['error'] = null;
}
function mostrar_error() {
	if ($_SESSION ['error']) {
		?>
<div
	class="alert alert-dismissible alert-<?php echo $_SESSION['error']['type']?>">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong><?php
		switch ($_SESSION ['error'] ['type']) {
			case 'warning' :
				echo '¡ADVERTENCIA!';
				break;
			case 'success' :
				echo '¡Éxito!';
				break;
			default :
				echo '¡ERROR!';
				break;
		}
		?></strong> <?php echo $_SESSION['error']['msg'];?>
				</div>
<?php
	}
	$_SESSION ['error'] = null;
}
function mensaje($tipo, $msg) {
	$_SESSION ['error'] ['type'] = $tipo;
	$_SESSION ['error'] ['msg'] = $msg;
}

?>