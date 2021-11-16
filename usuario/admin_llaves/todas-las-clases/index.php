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

<table id="tabla" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Aula</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Docente</th>
            <th>Horario</th>
            <th>Fecha de inicio</th>
            <th>Fecha de fin</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($datosClases as $valorClase) {
            $datosMaterias = $tablaMaterias->where("idMateria", "=", $valorClase['idMateria'])->get();
            $datosCarreras = $tablaCarreras->where("idCarrera", "=", $valorClase['idCarrera'])->get();
            $datosDocentes = $tablaDocentes->where("idDocente", "=", $valorClase['idDocente'])->get();
            $datosAulas = $tablaAulas->where("idAula", "=", $valorClase['idAula'])->get();
            foreach ($datosMaterias as $valorMateria) {
                foreach ($datosCarreras as $valorCarrera) {
                    foreach ($datosDocentes as $valorDocente) {
                        foreach ($datosAulas as $valorAula) {
                            $datosHorarios = $tablaHorarios->where("idMateria", "=", $valorMateria['idMateria'])->get();
        ?>
                            <tr>
                                <td><?php echo $valorAula['aula']; ?></td>
                                <td><?php echo $valorMateria['materia']; ?></td>
                                <td><?php echo $valorCarrera['carrera']; ?></td>
                                <td><?php echo $valorDocente['nombre']; ?></td>
                                <td>
                                    <?php foreach ($datosHorarios as $valorHorario) {
                                        if ($valorHorario['Lunes'] == 1) {
                                            echo "Lun. ";
                                        }
                                        if ($valorHorario['Martes'] == 1) {
                                            echo "Mar. ";
                                        }
                                        if ($valorHorario['Miercoles'] == 1) {
                                            echo "Mie. ";
                                        }
                                        if ($valorHorario['Jueves'] == 1) {
                                            echo "Jue. ";
                                        }
                                        if ($valorHorario['Viernes'] == 1) {
                                            echo "Vie. ";
                                        }
                                        if ($valorHorario['Sabado'] == 1) {
                                            echo "Sab. ";
                                        }
                                        echo $valorHorario['horaInicio'] . " a " . $valorHorario['horaFin'] . " ";
                                    }
                                    ?></td>
                                <td><?php echo $valorMateria['fechaInicio']; ?></td>
                                <td><?php echo $valorMateria['fechaFin']; ?></td>
                            </tr>
        <?php }
                    }
                }
            }
        }

        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Aula</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Docente</th>
            <th>Horario</th>
            <th>Fecha de inicio</th>
            <th>Fecha de fin</th>
        </tr>
    </tfoot>
</table>
<?php
$datosClases1 = $tablaClases->get();
$tablaMaterias1 = new Crud("materias");

foreach ($datosClases1 as $key) {
    $datosMaterias1 = $tablaMaterias1->where("idMateria", "=", $key['idMateria'])->get();

    foreach ($datosMaterias1 as $valorMateria) {
?>

        <?php echo $key['idClase']; ?>
        <?php echo $valorMateria['materia']; ?>
        <?php echo $valorMateria['materia']; ?>

<?php


    }
}
?>
<?php
//incluimos header template
require('../../../layout/footer.php');
?>