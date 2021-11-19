<?php
// Incluimos la configuracion para la base de datos y la clase para el uso de sus funciones
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
$title = 'Turno tarde';
// Incluimos el header y el menu de navegación
require('../../../layout/header.php');
require('../../../layout/menu.php');
?>
<div>
    <ul>
        <li class="lista" style="float:left">
            <h4 class="fecha"><?php echo $dia . ", " . date('d') . " de " . $mes . " de " . date('Y') ?></h4>
        </li>
        <li class="lista" style="float:right"><a href="noche.php">
                <h5>Noche</h5>
            </a></li>
        <li class="lista navActive" style="float:right"><a href="tarde.php">
                <h5>Tarde</h5>
            </a></li>
        <li class="lista" style="float:right"><a href="manana.php">
                <h5>Mañana</h5>
            </a></li>
        <li class="lista" style="float:right">
            <h5 class="tituloLista">Turnos: </h5>
        </li>
    </ul>
</div>
<br>
<br>
<?php
$hora = date('Gis');
$hora = "130000";
$dia = "Viernes";
?>
<h4 class="tituloDocente">Turno Tarde - 12:00 hrs a 18:00 hrs</h4>
<br><br><br>
<h4 class="tituloDocente">En clases actualmente</h4>
<hr>
<table id="tabla_actual" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Cod. Oferta</th>
            <th>Aula</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Docente</th>
            <th>Horario</th>
            <th>Terminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Todos los datos de la tabla materia
        $tablaClases = new Crud("clases");
        $tablaMaterias = new Crud("materias");
        $tablaHorarios = new Crud("horarios");
        $tablaDocentes = new Crud("docentes");
        $tablaAulas = new Crud("aulas");
        $tablaCarreras = new Crud("carreras");
        $tablaRecursos = new Crud("recursos");
        $clasesAhora = $tablaClases->where("ocupado", "=", 1)->get();
        foreach ($clasesAhora as $valorClases) {
            $datosMaterias = $tablaMaterias->where("idMateria", "=", $valorClases['idMateria'])->get();
            foreach ($datosMaterias as $valorMateria) {
                // convertimos las fechas de inicio y fin en numeros enteros
                $valorStringInicio = $valorMateria['fechaInicio'];
                $valorEnteroInicio = str_replace("-", "", $valorStringInicio);
                $valorStringFin = $valorMateria['fechaFin'];
                $valorEnteroFin = str_replace("-", "", $valorStringFin);
                // comparamos los valores con la fecha actual
                $diferenciaInicio = $fechaHoy - $valorEnteroInicio;
                $diferenciaFin = $fechaHoy - $valorEnteroFin;
                // si la diferencia con la fecha inicio es mayor o igual a 0 y si la diferencia con la fecha fin es menor o igual a 0, estan sucediendo
                if ($diferenciaInicio >= 0 && $diferenciaFin <= 0) {
                    // extraemos los datos de la tabla horarios con los idMateria ya seleccionados en fecha
                    $datosHorarios = $tablaHorarios->where("idMateria", "=", $valorClases['idMateria'])->get();
                    foreach ($datosHorarios as $valorHorario) {
                        //seleccionar solo datos que esten hoy
                        if ($valorHorario["$dia"] == 1) {
                            // convertimos en enteros las hora inicio y fin
                            $horaInicioString = $valorHorario['horaInicio'];
                            $horaInicioEntero = str_replace(":", "", $horaInicioString);
                            $horaFinString = $valorHorario['horaFin'];
                            $horaFinEntero = str_replace(":", "", $horaFinString);
                            $diferenciaHoraInicio = $hora - $horaInicioEntero;
                            $diferenciaHoraFin = $hora - $horaFinEntero;
                            // seleccionamos todos los datos que esten en el horario mañana, tarde o noche
                            if ($horaInicioEntero >= 120000 && $horaFinEntero <= 180000) {
                                $datosDocentes = $tablaDocentes->where("idDocente", "=", $valorClases['idDocente'])->get();
                                $datosAulas = $tablaAulas->where("idAula", "=", $valorClases['idAula'])->get();
                                $datosCarreras = $tablaCarreras->where("idCarrera", "=", $valorClases['idCarrera'])->get();
                                foreach ($datosDocentes as $valorDocente) {
                                    foreach ($datosAulas as $valorAula) {
                                        foreach ($datosCarreras as $valorCarrera) {
        ?>
                                            <tr>
                                                <td><?php echo $valorClases['cod_oferta'] ?> </td>
                                                <td><?php echo $valorAula['aula'] ?></td>
                                                <td><?php echo $valorMateria['materia'] ?></td>
                                                <td><?php echo $valorCarrera['carrera'] ?></td>
                                                <td><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></td>
                                                <td><?php echo $valorHorario['horaInicio'] ?> a <?php echo $valorHorario['horaFin'] ?></td>
                                                <td>
                                                    <div class="divBtnRec"><button type="button" id="abrirModal" onclick="capturarIdMateria(<?php echo $valorClases['idClase']; ?>)">Terminar</button></div>
                                                </td>
                                            </tr>
        <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Cod. Oferta</th>
            <th>Aula</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Docente</th>
            <th>Horario</th>
            <th>Terminar</th>
        </tr>
    </tfoot>
</table>
<br><br>
<h4 class="tituloDocente">Clases que se aproximan:</h4>
<hr>
<div>
    <h4>Turno tarde</h4>
    <table id="tabla_tarde" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Cod. Oferta</th>
                <th>Aula</th>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Docente</th>
                <th>Horario</th>
                <th>Terminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Especificamos seleccionar todos los datos que tengan ocupado=0 (que no se esta pasando clases)
            $clasesTarde = $tablaClases->where("ocupado", "=", 0)->get();

            foreach ($clasesTarde as $valorClase) {
                $datosMaterias = $tablaMaterias->where("idMateria", "=", $valorClase['idMateria'])->get();
                foreach ($datosMaterias as $valorMateria) {
                    // convertimos las fechas de inicio y fin en numeros enteros
                    $valorStringInicio = $valorMateria['fechaInicio'];
                    $valorEnteroInicio = str_replace("-", "", $valorStringInicio);
                    $valorStringFin = $valorMateria['fechaFin'];
                    $valorEnteroFin = str_replace("-", "", $valorStringFin);
                    // comparamos los valores con la fecha actual
                    $diferenciaInicio = $fechaHoy - $valorEnteroInicio;
                    $diferenciaFin = $fechaHoy - $valorEnteroFin;
                    // si la diferencia con la fecha inicio es mayor o igual a 0 y si la diferencia con la fecha fin es menor o igual a 0, estan sucediendo
                    if ($diferenciaInicio >= 0 && $diferenciaFin <= 0) {
                        // extraemos los datos de la tabla horarios con los idMateria ya seleccionados en fecha
                        $datosHorarios = $tablaHorarios->where("idMateria", "=", $valorClase['idMateria'])->get();
                        foreach ($datosHorarios as $valorHorario) {
                            //seleccionar solo datos que esten hoy
                            if ($valorHorario["$dia"] == 1) {
                                // convertimos en enteros las hora inicio y fin
                                $horaInicioString = $valorHorario['horaInicio'];
                                $horaInicioEntero = str_replace(":", "", $horaInicioString);
                                $horaFinString = $valorHorario['horaFin'];
                                $horaFinEntero = str_replace(":", "", $horaFinString);
                                $diferenciaHoraInicio = $hora - $horaInicioEntero;
                                $diferenciaHoraFin = $hora - $horaFinEntero;
                                // seleccionamos todos los datos que esten en el horario mañana, tarde o noche
                                if ($horaInicioEntero >= 120000 && $horaFinEntero <= 180000) {
                                    $datosDocentes = $tablaDocentes->where("idDocente", "=", $valorClase['idDocente'])->get();
                                    $datosAulas = $tablaAulas->where("idAula", "=", $valorClase['idAula'])->get();
                                    $datosCarreras = $tablaCarreras->where("idCarrera", "=", $valorClase['idCarrera'])->get();
                                    foreach ($datosDocentes as $valorDocente) {
                                        foreach ($datosAulas as $valorAula) {
                                            foreach ($datosCarreras as $valorCarrera) {
            ?>
                                                <tr>
                                                    <td><?php echo $valorClase['cod_oferta'] ?></td>
                                                    <td><?php echo $valorAula['aula'] ?></td>
                                                    <td><?php echo $valorMateria['materia'] ?></td>
                                                    <td><?php echo $valorCarrera['carrera'] ?></td>
                                                    <td><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></td>
                                                    <td><?php echo $valorHorario['horaInicio'] ?> a <?php echo $valorHorario['horaFin'] ?></td>
                                                    <td>
                                                        <div class="divBtnRec"><button type="button" id="abrirModal1" onclick="capturarIdMateriaxd(<?php echo $valorClase['idClase']; ?>)">Iniciar</button></div>
                                                    </td>
                                                </tr>
            <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Cod. Oferta</th>
                <th>Aula</th>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Docente</th>
                <th>Horario</th>
                <th>Terminar</th>
            </tr>
        </tfoot>
    </table>

    <h4>Turno noche</h4>
    <table id="tabla_noche" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Cod. Oferta</th>
                <th>Aula</th>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Docente</th>
                <th>Horario</th>
                <th>Terminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Especificamos seleccionar todos los datos que tengan ocupado=1 (que se esta pasando clases)
            $clasesNoche = $tablaClases->where("ocupado", "=", 0)->get();

            foreach ($clasesNoche as $valorClase) {
                $datosMaterias = $tablaMaterias->where("idMateria", "=", $valorClase['idMateria'])->get();
                foreach ($datosMaterias as $valorMateria) {
                    // convertimos las fechas de inicio y fin en numeros enteros
                    $valorStringInicio = $valorMateria['fechaInicio'];
                    $valorEnteroInicio = str_replace("-", "", $valorStringInicio);
                    $valorStringFin = $valorMateria['fechaFin'];
                    $valorEnteroFin = str_replace("-", "", $valorStringFin);
                    // comparamos los valores con la fecha actual
                    $diferenciaInicio = $fechaHoy - $valorEnteroInicio;
                    $diferenciaFin = $fechaHoy - $valorEnteroFin;
                    // si la diferencia con la fecha inicio es mayor o igual a 0 y si la diferencia con la fecha fin es menor o igual a 0, estan sucediendo
                    if ($diferenciaInicio >= 0 && $diferenciaFin <= 0) {

                        // extraemos los datos de la tabla horarios con los idMateria ya seleccionados en fecha
                        $datosHorarios = $tablaHorarios->where("idMateria", "=", $valorMateria['idMateria'])->get();
                        foreach ($datosHorarios as $valorHorario) {

                            //seleccionar solo datos que esten hoy
                            if ($valorHorario["$dia"] == 1) {
                                // convertimos en enteros las hora inicio y fin
                                $horaInicioString = $valorHorario['horaInicio'];
                                $horaInicioEntero = str_replace(":", "", $horaInicioString);
                                $horaFinString = $valorHorario['horaFin'];
                                $horaFinEntero = str_replace(":", "", $horaFinString);

                                $diferenciaHoraInicio = $hora - $horaInicioEntero;
                                $diferenciaHoraFin = $hora - $horaFinEntero;
                                // seleccionamos todos los datos que esten en el horario mañana, tarde o noche
                                if ($horaInicioEntero >= 180000 && $horaFinEntero <= 220000) {
                                    $datosDocentes = $tablaDocentes->where("idDocente", "=", $valorClase['idDocente'])->get();
                                    $datosAulas = $tablaAulas->where("idAula", "=", $valorClase['idAula'])->get();
                                    $datosCarreras = $tablaCarreras->where("idCarrera", "=", $valorClase['idCarrera'])->get();
                                    foreach ($datosDocentes as $valorDocente) {
                                        foreach ($datosAulas as $valorAula) {
                                            foreach ($datosCarreras as $valorCarrera) {
            ?> <tr>
                                                    <td><?php echo $valorClase['cod_oferta'] ?></td>
                                                    <td><?php echo $valorAula['aula'] ?></td>
                                                    <td><?php echo $valorMateria['materia'] ?></td>
                                                    <td><?php echo $valorCarrera['carrera'] ?></td>
                                                    <td><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></td>
                                                    <td><?php echo $valorHorario['horaInicio'] ?> a <?php echo $valorHorario['horaFin'] ?></td>
                                                    <td>
                                                        <div class="divBtnRec"><button type="button" id="abrirModal1" onclick="capturarIdMateriaxd(<?php echo $valorClase['idClase']; ?>)">Iniciar</button></div>
                                                    </td>
                                                </tr>
            <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Cod. Oferta</th>
                <th>Aula</th>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Docente</th>
                <th>Horario</th>
                <th>Terminar</th>
            </tr>
        </tfoot>
    </table>
    <br><br>


    <?php
    $datosfiltrados=array();
    $c4=0;
    $tablaClases = new Crud("clases");
    $tablaMaterias = new Crud("materias");
    $tablaHorarios = new Crud("horarios");
    $tablaDocentes = new Crud("docentes");
    $tablaAulas = new Crud("aulas");
    $tablaCarreras = new Crud("carreras");
    $tablaRecursos = new Crud("recursos");

    $clasesAhora = $tablaClases->where("ocupado", "=", 1)->get();

    foreach ($clasesAhora as $valorClases) {
        $datosMaterias = $tablaMaterias->where("idMateria", "=", $valorClases['idMateria'])->get();
        foreach ($datosMaterias as $valorMateria) {
            // convertimos las fechas de inicio y fin en numeros enteros
            $valorStringInicio = $valorMateria['fechaInicio'];
            $valorEnteroInicio = str_replace("-", "", $valorStringInicio);
            $valorStringFin = $valorMateria['fechaFin'];
            $valorEnteroFin = str_replace("-", "", $valorStringFin);
            // comparamos los valores con la fecha actual
            $diferenciaInicio = $fechaHoy - $valorEnteroInicio;
            $diferenciaFin = $fechaHoy - $valorEnteroFin;
            // si la diferencia con la fecha inicio es mayor o igual a 0 y si la diferencia con la fecha fin es menor o igual a 0, estan sucediendo
            if ($diferenciaInicio >= 0 && $diferenciaFin <= 0) {

                // extraemos los datos de la tabla horarios con los idMateria ya seleccionados en fecha
                $datosHorarios = $tablaHorarios->where("idMateria", "=", $valorClases['idMateria'])->get();
                foreach ($datosHorarios as $valorHorario) {

                    //seleccionar solo datos que esten hoy
                    if ($valorHorario["$dia"] == 1) {
                        // convertimos en enteros las hora inicio y fin
                        $horaInicioString = $valorHorario['horaInicio'];
                        $horaInicioEntero = str_replace(":", "", $horaInicioString);
                        $horaFinString = $valorHorario['horaFin'];
                        $horaFinEntero = str_replace(":", "", $horaFinString);

                        $diferenciaHoraInicio = $hora - $horaInicioEntero;
                        $diferenciaHoraFin = $hora - $horaFinEntero;
                        // seleccionamos todos los datos que esten en el horario mañana, tarde o noche
                        if ($horaFinEntero <= 120000) {
                            $datosfiltrados[$c4]= $valorClases['idAula'];
                            $c4++;
                        }
                        if ($horaInicioEntero >= 200000) {
                            $datosfiltrados[$c4]= $valorClases['idAula'];
                            $c4++;
                        }
                    }
                }
            }
        }
    }
    var_dump($datosfiltrados);
    echo $hora;
    ?>



    <div id="acord">

        <h4 class="tituloDocente">Aulas por Bloques:</h4>
        <hr>
        <div class="acordeon">
            <!-- Prueba, extraer datos en orden -->
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "infocal";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM aulas ORDER BY aula";
            $todasAulas = $conn->query($sql);
            $sql1 = "SELECT DISTINCT idAula FROM clases ORDER BY idAula";
            $aulasOcupadas = $conn->query($sql1);
            $c = 0;
            $c1 = 0;
            $datos = array();
            $datos1 = array();
            foreach ($aulasOcupadas as $valor) {
                $datos[$c1] = $valor['idAula'];
                $c1++;
            }
            foreach ($todasAulas as $valor) {
                $datos1[$c] = $valor['idAula'];
                $c++;
            }
            $resultado = array_diff($datos1, $datos);
            $b = array_values($resultado);
            $cont = count($b);
            ?>
            <div class="bloque activo">
                <h2 class="h2">Bloque A</h2>
                <div class="contenido">
                    <div class="filaDisponible" id="fila">
                        <?php
                        foreach ($b as $key) {
                            $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                            $aula = $conn->query($sql3);
                            foreach ($aula as $aulaDisponible) {
                                $aulaA = substr($aulaDisponible['aula'], 0, 1);
                                if ($aulaA == "A") {
                        ?>
                                    <div class="columnaDisponible">
                                        <div class="cardDisponible">
                                            <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                            <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque B</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "B") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque C</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "C") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque D</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "D") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque E</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "E") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque F</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "F") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque G</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "G") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="bloque">
                <h2 class="h2">Bloque H</h2>
                <div class="contenido">
                    <?php
                    foreach ($b as $key) {
                        $sql3 = 'SELECT * FROM aulas WHERE idAula = "' . $key . '" ORDER BY aula';
                        $aula = $conn->query($sql3);
                        foreach ($aula as $aulaDisponible) {
                            $aulaA = substr($aulaDisponible['aula'], 0, 1);
                            if ($aulaA == "H") {
                    ?>
                                <div class="columnaDisponible">
                                    <div class="cardDisponible">
                                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $aulaDisponible['aula'] ?></b></h4>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Formularios confirmar que se recibio la llave -->
    <!-- Confirmar recibir llave -->
    <div class="modal-container" id="modal-container">
        <div class="modal-content">
            <form>
                <h5 class="tituloModal">Confirmar que recibí la llave</h5>
                <div class="botones">
                    <button type="submit" id="quitarRecurso">Si</button>
                    <button type="submit" id="cerrarModal">No</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Recibir llave - tarea realizada -->
    <div class="modal-container-success" id="modal-container-success">
        <div class="modal-success" id="modal-success">
            <h5 id="respuesta"></h5>
        </div>
    </div>

    <!-- Formularios confirmar que se esta entregando la llave -->
    <!-- Confirmar entregar llave -->
    <div class="modal-container1" id="modal-container1">
        <div class="modal-content1">
            <form>
                <h5 class="tituloModal">Confirmar que entregué la llave</h5>
                <div class="botones">
                    <button type="submit" id="quitarRecurso1">Si</button>
                    <button type="submit" id="cerrarModal1">No</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Entregar llave - tarea realizada -->
    <div class="modal-container-success1" id="modal-container-success1">
        <div class="modal-success1" id="modal-success1">
            <h5 id="respuesta1"></h5>
        </div>
    </div>

    <?php
    //incluimos header template
    require('../../../layout/footer.php');
    ?>