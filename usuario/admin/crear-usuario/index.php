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
$tablaUsuarios = new Crud("usuarios");
$datosUsuarios = $tablaUsuarios->where("username", "=", $nombreUsuario)->get();
foreach ($datosUsuarios as $valorUsuario) {
	$tipoUsuario = $valorUsuario['idTipoUsuario'];
	if ($tipoUsuario == 2) {
		header('Location: ../../../usuario/admin_llaves/router.php');
	}
	if ($tipoUsuario == 3) {
		header('Location: ../../../usuario/admin_multimedia/');
	}
}
// Definimos el titulo de la pagina
$title = 'Crear usuario';

//if form has been submitted process it
if (isset($_POST['submit'])) {

	if (!isset($_POST['username'])) {
		$error[] = "Por favor rellene todos los campos.";
	}

	if (!isset($_POST['email'])) {
		$error[] = "Por favor rellene todos los campos.";
	}

	if (!isset($_POST['password'])) {
		$error[] = "Por favor rellene todos los campos.";
	}
	if (!isset($_POST['nombre'])) {
		$error[] = "Por favor rellene todos los campos.";
	}
	if (!isset($_POST['apellidos'])) {
		$error[] = "Por favor rellene todos los campos.";
	}

	$username = $_POST['username'];

	//very basic validation
	if (!$user->isValidUsername($username)) {
		$error[] = 'El nombre de usuario debe tener al menos 3 caracteres alfanuméricos.';
	} else {
		$stmt = $db->prepare('SELECT username FROM usuarios WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!empty($row['username'])) {
			$error[] = 'El nombre de usuario ya esta en uso.';
		}
	}

	if (strlen($_POST['password']) < 3) {
		$error[] = 'La contraseña es muy corta.';
	}

	if (strlen($_POST['passwordConfirm']) < 3) {
		$error[] = 'La confirmación de contraseña es muy corta.';
	}

	if ($_POST['password'] != $_POST['passwordConfirm']) {
		$error[] = 'Las contraseñas no coinciden.';
	}
	if ($_POST['tipo']==0) {
		$error[] = 'Debe elegir un "tipo de usuario".';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Por favor, introduce una dirección de correo electrónico válida.';
	} else {
		$stmt = $db->prepare('SELECT email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!empty($row['email'])) {
			$error[] = 'El email que ingresaste ya esta en uso.';
		}
	}


	//if no errors have been created carry on
	if (!isset($error)) {

		//hash the password
		$hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(), true));

		$nombre=$_POST['nombre'];
		$apellidos=$_POST['apellidos'];
		$tipo=$_POST['tipo'];

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO usuarios (idTipoUsuario,username,password,nombre,apellidos,email,active) VALUES (:id_tipo, :username, :password, :nombre, :apellidos, :email, :active)');
			$stmt->execute(array(
				':id_tipo'=>$tipo,
				':username' => $username,
				':password' => $hashedpassword,
				':nombre'=>$nombre,
				':apellidos'=>$apellidos,
				':email' => $email,
				':active' => $activasion
			));
			$id = $db->lastInsertId('idUsuario');

			//send email
			$to = $_POST['email'];
			$subject = "Confirmacion de registro";
			$body = "<p>Thank you for registering at demo site.</p>
			<p>To activate your account, please click on this link: <a href='" . DIR . "activate.php?x=$id&y=$activasion'>" . DIR . "activate.php?x=$id&y=$activasion</a></p>
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
		} catch (PDOException $e) {
			$error[] = $e->getMessage();
		}
	}
}

// Incluimos el header y el menu de navegación
require('../../../layout/headerAdmin.php');
require('../../../layout/menuAdmin.php');

$tablaTipo = new Crud("tipo_usuario");
$datosTipo = $tablaTipo->get();
?>
<br><br><br><br>
<h4 class="tituloDocente" style="text-align:center">Registrar nuevo usuario</h4>
<div class="container border rounded shadow-lg p-3 mb-5 bg-white" style="width: 70%;">
	<form role="form" method="post" action="" autocomplete="off" class="">
		<!-- <p class="parrafo">Already a member? <a href='login.php'>Login</a></p> -->

		<?php
		//check for any errors
		if (isset($error)) {
			foreach ($error as $error) {
				echo '<h6 class="bg-danger text-white">' . $error . '</h6>';
			}
		}

		//if action is joined show sucess
		if (isset($_GET['action']) && $_GET['action'] == 'joined') {
			echo "<h6 class='bg-success text-white'>Registro exitoso, el usuario debe revisar su correo electrónico para activar su cuenta.</h6>";
		}
		?>
		<div class="row">
			<div class="col-6">
				<label for="nombre">Nombre(s):</label>
				<input required type="text" name="nombre" id="nombre" class="form-control" value="<?php if (isset($error)) {
																								echo htmlspecialchars($_POST['nombre'], ENT_QUOTES);
																							} ?>" tabindex="1">
			</div>
			<div class="col-6">
				<label for="apellidos">Apellidos:</label>
				<input required type="text" name="apellidos" id="apellidos" class="form-control" value="<?php if (isset($error)) {
																									echo htmlspecialchars($_POST['apellidos'], ENT_QUOTES);
																								} ?>" tabindex="2">
			</div>
		</div>
		<div class="row">
			<div class="col-5">
				<label for="username">Nombre de usuario:</label>
				<input type="text" name="username" id="username" class="form-control" value="<?php if (isset($error)) {
																									echo htmlspecialchars($_POST['username'], ENT_QUOTES);
																								} ?>" tabindex="3">
			</div>
			<div class="col-7">
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" class="form-control" placeholder="email@ejemplo.com" value="<?php if (isset($error)) {
																															echo htmlspecialchars($_POST['email'], ENT_QUOTES);
																														} ?>" tabindex="4">
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="input-group" style="text-align: center;">
					<label for="tipo" class="input-group-text">Tipo de usuario:</label>
					<select name="tipo" id="tipo" class="form-select" tabindex="5">
						<option value="">Elegir...</option>
						<?php
						foreach ($datosTipo as $valorTipo) {
							echo "<option value='" . $valorTipo['idTipoUsuario'] . "'>";
							echo $valorTipo['tipo'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
			<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" tabindex="6">
			</div>
			<div class="col-6">
			<label for="passwordConfirm">Confirmar contraseña:</label>
				<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Confirmar contraseña" tabindex="4">
			</div>
		</div>

		<div class="row text-center">
			<div class="col-xs-12 col-md-12">
				<input style="width:20%;" type="submit" name="submit" value="Crear" class="btn btn-primary btn-block btn-lg" tabindex="7">
			</div>
		</div>
	</form>
</div>



<?php
//incluimos header template
require('../../../layout/footerAdmin.php');
?>