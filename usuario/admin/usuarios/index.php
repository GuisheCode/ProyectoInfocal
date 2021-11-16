<?php
require('../../../includes/config.php');
require_once '../../../includes/Crud.php';
require('../../../includes/traducirFecha.php');
// Si no ha iniciado sesion, lo redirige ala ventana login
if (!$user->is_logged_in()) {
    header('Location: ../../../login.php');
    exit();
}
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
$title = 'Todos los usuarios';

// Incluimos el header y el menu de navegación
require('../../../layout/headerAdmin.php');
require('../../../layout/menuAdmin.php');
?>

<br><br><br><br>
<table id="tabla" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>


<?php
//incluimos header template
require('../../../layout/footerAdmin.php');
?>