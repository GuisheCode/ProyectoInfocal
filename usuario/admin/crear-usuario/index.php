<?php
require('../../../includes/config.php');
require_once '../../../includes/Crud.php';
require('../../../includes/traducirFecha.php');
// Si no ha iniciado sesion, lo redirige ala ventana login
if (!$user->is_logged_in()) {
    header('Location: ../../../login.php');
    exit();
}
// Comprueba que clase de usuario es y lo redirige a su area del sistema
$nombreUsuario = $_SESSION['username'];
$tablaUsuarios= new Crud("usuarios");
$datosUsuarios = $tablaUsuarios->where("username","=",$nombreUsuario)->get();
foreach ($datosUsuarios as $valorUsuario) {
    $tipoUsuario=$valorUsuario['idTipoUsuario'];
    if($tipoUsuario==2){
        header('Location: ../../../usuario/admin_llaves/router.php');
    }
    if($tipoUsuario==3){
        header('Location: ../../../usuario/admin_multimedia/');
    }
}
// Definimos el titulo de la pagina
$title = 'Crear usuario';

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (! isset($_POST['username'])) {
    	$error[] = "Please fill out all fields";
    }

    if (! isset($_POST['password'])) {
    	$error[] = "Please fill out all fields";
    }

	if (! isset($_POST['nombre'])) {
    	$error[] = "Please fill out all fields";
    }

	if (! isset($_POST['apellidos'])) {
    	$error[] = "Please fill out all fields";
    }

	if (! isset($_POST['email'])) {
    	$error[] = "Please fill out all fields";
    }

	if (! isset($_POST['idTipoUsuario'])) {
    	$error[] = "Please fill out all fields";
    }

	$username = $_POST['username'];

	//very basic validation
	if (! $user->isValidUsername($username)){
		$error[] = 'Usernames must be at least 3 Alphanumeric characters';
	} else {
		$stmt = $db->prepare('SELECT username FROM usuarios WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (! empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
	}

	$nombre = $_POST['nombre'];

	if (! $user->isValidUsername($nombre)){
		$error[] = 'Names must be at least 3 Alphanumeric characters';
	} else {
		$stmt = $db->prepare('SELECT nombre FROM usuarios WHERE nombre = :nombre');
		$stmt->execute(array(':nombre' => $nombre));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	$apellidos = $_POST['apellidos'];

	//very basic validation
	if (! $user->isValidUsername($apellidos)){
		$error[] = 'lastnames must be at least 3 Alphanumeric characters';
	} else {
		$stmt = $db->prepare('SELECT apellidos FROM usuarios WHERE apellidos = :apellidos');
		$stmt->execute(array(':apellidos' => $apellidos));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		
	}

	if (strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if (strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if ($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if (! filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (! empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}


	//if no errors have been created carry on
	if (!isset($error)){

		//hash the password
		$hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO usuarios (username,password,nombre,apellidos,email,idTipoUsuario,active) VALUES (:username, :password,:nombre, :apellidos, :email, :idTipoUsuario, :active)');
			$stmt->execute(array(
				':username' => $username,
				':password' => $hashedpassword,
				':nombre' => $nombre,
				':apellidos' => $apellidos,
				':email' => $email,
				':idTipoUsuario' => $idTipoUsuario,
				':active' => $activasion
			));
			$id = $db->lastInsertId('idUsuario');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at demo site.</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

// Incluimos el header y el menu de navegación
require('../../../layout/headerAdmin.php');
require('../../../layout/menuAdmin.php');
?>
<br><br><br><br>
	    <div class="">
			<form role="form" method="post" action="" autocomplete="off" class="forma">
				<h2 class="titulo">Crear cuenta</h2>
				<!-- <p class="parrafo">Already a member? <a href='login.php'>Login</a></p> -->
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>
				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="text" name="nombre" id="nombre" class="form-control input-lg" placeholder="Nombre de usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['nombre'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="text" name="apellidos" id="apellidos" class="form-control input-lg" placeholder="Apellidos" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['apellidos'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="2">
				</div>

				<div class="form-group">
					<input type="text" name="idTipoUsuario" id="idTipoUsuario" class="form-control input-lg" placeholder="Tipo de usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['idTipoUsuario'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar contraseña" tabindex="4">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Crear" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>




<?php
//incluimos header template
require('../../../layout/footerAdmin.php');
?>