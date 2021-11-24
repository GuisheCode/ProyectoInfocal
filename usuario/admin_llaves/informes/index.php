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
$title = 'Registro de actividad';

// Incluimos el header y el menu de navegación
require('../../../layout/header.php');
require('../../../layout/menu.php');

$tablaActividad = new Crud('actividad_realizada');
$tablaPersonas = new Crud('personas');
$tablaMaterias = new Crud('materias');
$tablaAulas = new Crud('aulas');
$tablaCargos = new Crud('cargos');

$datosActividad = $tablaActividad->get();

?>
<br><br>
<table id="tabla_clases" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Docente</th>
            <th>Materia</th>
            <th>Llave</th>
            <th>Fecha de entrega</th>
            <th>Hora de entrega</th>
            <th>Fecha de devolución</th>
            <th>Hora de devolución</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($datosActividad as $valorActividad) {
            $datosPersona = $tablaPersonas->where("id_persona", "=", $valorActividad['id_persona'])->get();
            $datosMateria = $tablaMaterias->where("idMateria", "=", $valorActividad['idMateria'])->get();
            $datosAulas = $tablaAulas->where("idAula", "=", $valorActividad['idAula'])->get();
            foreach ($datosPersona as $valorPersona) {
                foreach ($datosMateria as $valorMateria) {
                    foreach ($datosAulas as $valorAula) {
        ?>
                        <tr>
                            <td><?php echo $valorPersona['nombre'] . " " . $valorPersona['apellidos']; ?></td>
                            <td><?php echo $valorMateria['materia']; ?></td>
                            <td><?php echo $valorAula['aula']; ?></td>
                            <td><?php echo $valorActividad['fechaEntrega']; ?></td>
                            <td><?php echo $valorActividad['horaEntrega']; ?></td>
                            <td><?php echo $valorActividad['fechaDevolucion']; ?></td>
                            <td><?php echo $valorActividad['horaDevolucion']; ?></td>
                        </tr>
        <?php
                    }
                }
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
        <th>Docente</th>
            <th>Materia</th>
            <th>Llave</th>
            <th>Fecha de entrega</th>
            <th>Hora de entrega</th>
            <th>Fecha de devolución</th>
            <th>Hora de devolución</th>
        </tr>
    </tfoot>
</table>
<?php
//incluimos header template
require('../../../layout/footer.php');
?>