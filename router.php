<?php
require('includes/config.php');
require_once 'includes/Crud.php';
require('includes/traducirFecha.php');
// Si no ha iniciado sesion, lo redirige ala ventana login
if (!$user->is_logged_in()) {
    header('Location: login.php');
    exit();
}
$nombreUsuario = $_SESSION['username'];
$tablaUsuarios= new Crud("usuarios");
$datosUsuarios = $tablaUsuarios->where("username","=",$nombreUsuario)->get();
// Redirecciona al usuario dependiendo que tipo de usuario es
foreach ($datosUsuarios as $valorUsuario) {
    $tipoUsuario=$valorUsuario['idTipoUsuario'];
    if($tipoUsuario == 1){
        header('Location: usuario/admin/');
    }
    if($tipoUsuario == 2){
        header('Location: usuario/admin_llaves/router.php');
    }
    if($tipoUsuario == 3){
        header('Location: usuario/admin_multimedia/');
    }
}
?>