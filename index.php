<?php
//incluimos config
require_once('includes/config.php');

//Comprueba si ha iniciado sesion, va al dashboard
if( $user->is_logged_in() ){ header('Location: router.php'); exit(); }

//procesar el formulario de inicio de sesión si se envía
if(isset($_POST['submit'])){

	if (! isset($_POST['username'])) {
		$error[] = "Please fill out all fields";
	}

	if (! isset($_POST['password'])) {
		$error[] = "Please fill out all fields";
	}

	$username = $_POST['username'];
	if ($user->isValidUsername($username)){
		if (! isset($_POST['password'])){
			$error[] = 'A password must be entered';
		}

		$password = $_POST['password'];

		if ($user->login($username, $password)){
			$_SESSION['username'] = $username;
			header('Location: router.php');
			exit;

		} else {
			$error[] = 'Wrong username or password or your account has not been activated.';
		}
	}else{
		$error[] = 'Usernames are required to be Alphanumeric, and between 3-16 characters long';
	}

}//end if submit

//definimos el titulo de la pagina
$title = 'Infocal';

//incluimos header template
require('layout/header.php'); 
?>
<div class="max-auto">
<div class="card text-center mx-auto" style="width: 40%; height:300px;margin-top:50px;">
<div class="card-body">
	    <div class="forma">
			<form role="form" method="post" action="" autocomplete="off">
				<h2 class="titulo">Iniciar sesión</h2>
				<br>
				<!-- <p class="parrafoEnlace"><a href='./'>Volver a la pagina de inicio</a></p> -->
				<hr>
				<br>

				<?php
				//comprobar si hay errores
				if (isset($error)){
					foreach ($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if (isset($_GET['action'])){

					//comprobar 'action'
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}

				
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Nombre de Usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
				</div>
				<br>
				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
				</div>
				<br>
						 <a class="parrafoEnlace" href='reset.php'>Olvide mi contraseña</a>
				<hr>
				<br>
					<input type="submit" name="submit" value="Ingresar" class="btn btn-primary btn-block btn-lg" tabindex="5">
			</form>
		</div>
		</div></div></div>
<?php 
//incluimos header template
require('layout/footer.php'); 
?>
