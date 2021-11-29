<?php
require('../../../includes/config.php');
require_once '../../../includes/Crud.php';
require('../../../includes/traducirFecha.php');
$hora = date('Gis');
$fechaHoy = date('Ymd');
// traduccion de mes y dia actual
$diaIngles = date('l');
$mesIngles = date('F');
$dia = traducirDia($diaIngles);
$mes = traducirMes($mesIngles);
// Si no ha iniciado sesion, lo redirige ala ventana login
if (!$user->is_logged_in()) {
    header('Location: ../../../login.php');
    exit();
}
$nombreUsuario = $_SESSION['username'];
$tablaUsuarios = new Crud("usuarios");
$datosUsuarios = $tablaUsuarios->where("username", "=", $nombreUsuario)->get();
foreach ($datosUsuarios as $valorUsuario) {
    $tipoUsuario = $valorUsuario['idTipoUsuario'];
    if ($tipoUsuario == 1) {
        header('Location: ../../../usuario/admin/');
    }
    if ($tipoUsuario == 3) {
        header('Location: ../../../usuario/admin_multimedia/');
    }
}
// Definimos el titulo de la pagina
$title = 'Todas las clases';

// Incluimos el header y el menu de navegación
require('../../../layout/header.php');
require('../../../layout/menu.php');

$tablaClases = new Crud('clases');
$datosClases = $tablaClases->get();
$tablaMaterias = new Crud("materias");
$tablaHorarios = new Crud("horarios");
$tablaDocentes = new Crud("docentes");
$tablaAulas = new Crud("aulas");
$tablaCarreras = new Crud("carreras");
$tablaRecursos = new Crud("recursos");
?>
<div class="divnav">
    <ul class="listaentera">
        <li class="lista" style="float:left">
            <h4 class="fecha"><?php echo $dia . ", " . date('d') . " de " . $mes . " de " . date('Y') ?></h4>
        </li>
        <li class="lista navActive" style="float:right"><a href="administrar.php">
                <h5>Administrar</h5>
            </a></li>
        <li class="lista" style="float:right"><a href="index.php">
                <h5>Reservas</h5>
            </a></li>
        <li class="lista" style="float:right">
            <h5 class="tituloLista">Herramientas multimedia: </h5>
        </li>
    </ul>
</div>
<br>
<br>
<h4 class="tituloDocente" style="text-align:center">TODAS LAS HERRAMIENTAS</h4>

<table class="table table-bordered" style="width:100%">
  
  
  <tr>
  	<th rowspan="2">1</th>
  	<th rowspan="2">2</th>
    <th colspan="2">3</th>
    <th colspan="2">4</th>
  </tr>
   <tr>
  	<td>1</td>
  	<td>2</td>
    <td>3</td>
  	<td>4</td>
  </tr>
  <tr>
    <td>Eve</td>
    <td>Eve</td>
    <td>Eve</td>
    <td>Jac</td>
    <td>57</td>
    <td>57</td>
  </tr>
</table>


<?php
//incluimos header template
require('../../../layout/footer.php');
?>