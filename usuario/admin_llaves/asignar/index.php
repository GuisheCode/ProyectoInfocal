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

$tablaUso = new Crud("uso_herramientas");
$tablaPersonas = new Crud("personas");
$tablaHerramientas = new Crud("herramientas");


?>
<div class="divnav">
    <ul class="listaentera">
        <li class="lista" style="float:left">
            <h4 class="fecha"><?php echo $dia . ", " . date('d') . " de " . $mes . " de " . date('Y') ?></h4>
        </li>
        <li class="lista" style="float:right"><a href="administrar.php">
                <h5>Administrar</h5>
            </a></li>
        <li class="lista navActive" style="float:right"><a href="index.php">
                <h5>Reservas</h5>
            </a></li>
        <li class="lista" style="float:right">
            <h5 class="tituloLista">Herramientas multimedia: </h5>
        </li>
    </ul>
</div>
<br>
<br>
<h4 class="tituloDocente" style="text-align:center">EQUIPOS EN USO</h4>
<table id="tabla_clases" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Cod. Equipo</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Descripción</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Nombre</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" colspan="2">ENTREGA</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Devolución</th>

        </tr>
        <tr>
            <th style="background-color: #1B1F3B; color:#E1F2FE">Fecha</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE">Hora</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $datosEnUso = $tablaUso->where("estado_activo", "=", "si")->get();
        foreach ($datosEnUso as $valorEnUso) {
            $datosPersonas = $tablaPersonas->where("id_persona", "=", $valorEnUso['id_persona'])->get();
            $datosHerramientas = $tablaHerramientas->where("id_equipo", "=", $valorEnUso['id_equipo'])->get();
            foreach ($datosPersonas as $valorPersona) {
                foreach ($datosHerramientas as $valorHerramienta) {
        ?>
                    <tr>
                        <td><?php echo $valorHerramienta['id_equipo']; ?></td>
                        <td><?php echo $valorHerramienta['equipo']; ?></td>
                        <td><?php echo $valorPersona['nombre'] . " " . $valorPersona['apellidos']; ?></td>
                        <td><?php echo $valorEnUso['fechaEntrega']; ?></td>
                        <td><?php echo $valorEnUso['horaEntrega']; ?></td>
                        <td><button class="btn btn-danger" type="button" id="abrirModal3" onclick="id_equipo_devolucion(<?php echo $valorEnUso['id_uso']; ?>)">Devolución</button> </td>
                    </tr>
        <?php
                }
            }
        }
        ?>
    </tbody>
    <!-- <tfoot>
    <tr>
            <th rowspan="2">Cod. Equipo</th>
            <th rowspan="2">Descripción</th>
            <th colspan="2">ENTREGA</th>
            <th colspan="2">DEVOLUCIÓN</th>
        </tr>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Fecha</th>
            <th>Hora</th>
        </tr>
    </tfoot> -->
</table>
<br><br>
<h4 class="tituloDocente" style="text-align:center">RESERVAS</h4>
<table id="tabla_actual" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Cod. Equipo</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Descripción</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Nombre</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" colspan="2">RESERVADO</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE" class="text-center align-middle" rowspan="2">Salida</th>
        </tr>
        <tr>
            <th style="background-color: #1B1F3B; color:#E1F2FE">Fecha</th>
            <th style="background-color: #1B1F3B; color:#E1F2FE">Hora</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $datosUso = $tablaUso->where("reservado", "=", "si")->get();
        foreach ($datosUso as $valorUso) {
            $datosPersonas = $tablaPersonas->where("id_persona", "=", $valorUso['id_persona'])->get();
            $datosHerramientas = $tablaHerramientas->where("id_equipo", "=", $valorUso['id_equipo'])->get();
            foreach ($datosPersonas as $valorPersona) {
                foreach ($datosHerramientas as $valorHerramienta) {
        ?>
                    <tr>
                        <td><?php echo $valorHerramienta['id_equipo']; ?></td>
                        <td><?php echo $valorHerramienta['equipo']; ?></td>
                        <td><?php echo $valorPersona['nombre'] . " " . $valorPersona['apellidos']; ?></td>
                        <td><?php echo $valorUso['fechaReserva']; ?></td>
                        <td><?php echo $valorUso['horaReserva']; ?></td>
                        <td><button type="button" class="btn btn-danger" type="button" id="abrirModal2" onclick="capturar_id_uso(<?php echo $valorUso['id_uso']; ?>)">Salida</button></td>
                    </tr>
        <?php
                }
            }
        }
        ?>
    </tbody>
    <!-- <tfoot>
    <tr>
            <th rowspan="2">Cod. Equipo</th>
            <th rowspan="2">Descripción</th>
            <th colspan="2">ENTREGA</th>
            <th colspan="2">DEVOLUCIÓN</th>
        </tr>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Fecha</th>
            <th>Hora</th>
        </tr>
    </tfoot> -->
</table>
<br><br>
<h4 class="tituloDocente" style="text-align:center">RESERVAR EQUIPO</h4>

<div class="container">
    <form action="reserva.php" method="post" autocomplete="off">
        <div class="row">
            <div class="col-4">
                <label for="persona" class="form-label">Reservar para:</label>
                <input required class="form-control" list="personal" name="personal" id="persona">
                <datalist id="personal">
                    <?php
                    $datosPersonas = $tablaPersonas->get();
                    foreach ($datosPersonas as $valorPersona) {
                        echo "<option value='" . "Cod:" . $valorPersona['id_persona'] . " - " . $valorPersona['nombre'] . " " . $valorPersona['apellidos'] . "'>";
                    }
                    ?>
                </datalist>
            </div>
            <div class="col-4">
                <label for="equipos" class="form-label">Equipo:</label>
                <input required class="form-control" list="equipo" name="equipo" id="equipos">
                <datalist id="equipo">
                    <?php
                    $datosHerramientas2 = $tablaHerramientas->where("ocupado", "=", "no")->get();
                    foreach ($datosHerramientas2 as $valorHerramienta) {
                        echo "<option value='" . "Cod:" . $valorHerramienta['id_equipo'] . " - " . $valorHerramienta['equipo'] . "'>";
                    }
                    ?>
                </datalist>
            </div>
            <div class="col-2">
                <label for="fecha" class="form-label">Fecha</label>
                <input required class="form-control" type="date" id="fecha" name="fecha">
            </div>
            <div class="col-2">
                <label for="hora" class="form-label">Hora</label>
                <input required class="form-control" type="time" id="hora" name="hora">
            </div>

        </div>
        <div class="row text-center">
            <div class="col-12">
                <input type="submit" value="Guardar" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>


<div class="modal-container2" id="modal-container2">
    <div class="modal-content2">
        <form>
            <h5 class="tituloModal">Confirmar salida de herramienta</h5>
            <div class="botones">
                <button type="submit" id="quitarRecurso2">Si</button>
                <button type="submit" id="cerrarModal2">No</button>
            </div>
        </form>
    </div>
</div>
<!-- Recibir llave - tarea realizada -->
<div class="modal-container-success2" id="modal-container-success2">
    <div class="modal-success2" id="modal-success2">
        <h5 id="respuesta2"></h5>
    </div>
</div>



<!-- Confirmar devolucion de equipo -->
<div class="modal-container3" id="modal-container3">
    <div class="modal-content3">
        <form>
            <h5 class="tituloModal">Confirmar la devolución de equipo</h5>
            <div class="botones">
                <button type="submit" id="quitarRecurso3">Si</button>
                <button type="submit" id="cerrarModal3">No</button>
            </div>
        </form>
    </div>
</div>
<!-- Devolucion de equipo - tarea realizada -->
<div class="modal-container-success3" id="modal-container-success3">
    <div class="modal-success3" id="modal-success3">
        <h5 id="respuesta3"></h5>
    </div>
</div>

<?php
//incluimos header template
require('../../../layout/footer.php');
?>