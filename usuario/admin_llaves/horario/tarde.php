<?php
// Incluimos la configuracion para la base de datos y la clase para el uso de sus funciones
require('../../../includes/config.php');
require_once '../../../includes/Crud.php';
require('../../../includes/traducirFecha.php');
$hora = date('Gis');
$fechaHoy = date('Ymd');

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
$tablaUsuarios= new Crud("usuarios");
$datosUsuarios = $tablaUsuarios->where("username","=",$nombreUsuario)->get();
foreach ($datosUsuarios as $valorUsuario) {
    $tipoUsuario=$valorUsuario['idTipoUsuario'];
    if($tipoUsuario == 1){
        header('Location: ../../../usuario/admin/');
    }
    if($tipoUsuario==3){
        header('Location: ../../../usuario/admin_multimedia/');
    }
}


// Definimos el titulo de la pagina
$title = 'Turno tarde';

// Incluimos el header y el menu de navegación
require('../../../layout/header.php');
require('../../../layout/menu.php');
?>
<!-- <div id="midiv">
    <nav>
      <a class="btn active" href="#hoy">Hoy</a>
      <a class="btn" href="#manana">Mañana</a>
      <a class="btn" href="#semana">Semana</a>
    </nav></div> -->
<div id="app">
</div>

<div>
    <h4 class="fecha"><?php echo $dia . ", " . date('d') . " de " . $mes . " de " . date('Y') ?></h4>
</div>
<div class="fila" id="fila">
    <br>
    <br>
    <?php
    $hora = date('Gis');
    $hora = "130000";
    $dia = "Viernes";
    ?>
    <h4 class="tituloDocente">Turno Tarde - 12:00 hrs a 18:00 hrs</h4>
    <?php
    echo $_SESSION['username'];
    ?>
    <br><br><br>

    <h4 class="tituloDocente">En clases actualmente</h4>
    <hr>
    <?php
    // Todos los datos de la tabla materia
    $tablaClases = new Crud("clases");
    $tablaMaterias =new Crud("materias");
    $tablaHorarios = new Crud("horarios");
    $tablaDocentes = new Crud("docentes");
    $tablaAulas = new Crud("aulas");
    $tablaCarreras = new Crud("carreras");
    $tablaRecursos = new Crud("recursos");

    $clasesAhora = $tablaClases->where("ocupado", "=", 1)->get();

    foreach ($clasesAhora as $valorClases) {
        $datosMaterias = $tablaMaterias->where("idMateria","=",$valorClases['idMateria'])->get();
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
                                    // echo "<br>". $valorMateria['materia'] ."<br>";
                                    // echo "<br>". $valorAula['aula'] ."<br>";
                                    // echo "<br>". $valorCarrera['carrera'] ."<br>";
                                    // echo "<br>". $valorDocente['nombre'] ."<br>";
                                    // echo "<br>". $valorHorario['horaInicio'] ."<br>";
    ?>
                                    <div class="columna">
                                        <div class="card">
                                            <div class="dentroOcupado">
                                                <br>
                                                <i class="fas fa-users iconoTarjeta"></i>
                                                <h4 class="tituloTarjeta">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                                                <h5 class="subtituloTarjeta">Materia: <i><?php echo $valorMateria['materia'] ?></i></h5>
                                            </div>
                                            <h5 class="subTarjeta">Carrera: <b><i><?php echo $valorCarrera['carrera'] ?></i></b></h5>
                                            <h5 class="subTarjeta">Docente: <b><i><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></i></b></h5>
                                            <h5 class="subTarjeta">Horario: <b><i><?php echo $valorHorario['horaInicio'] ?> -
                                                        <?php echo $valorHorario['horaFin'] ?></i></b></h5>
                                            <div class="divBtnRec"><button type="button" id="abrirModal" onclick="capturarIdMateria(<?php echo $valorClases['idClase']; ?>)">Terminar</button></div>
                                        </div>
                                    </div>
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
</div>




<br><br>
<div class="fila" id="fila">
    <h4 class="tituloDocente">Clases que se aproximan:</h4>
    <hr>
    <div>
        <h4>Turno tarde</h4>

        <?php
        // Especificamos seleccionar todos los datos que tengan ocupado=0 (que no se esta pasando clases)
        $clasesTarde = $tablaClases->where("ocupado", "=", 0)->get();

        foreach ($clasesTarde as $valorClase) {
            $datosMaterias= $tablaMaterias->where("idMateria","=",$valorClase['idMateria'])->get();
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
                                        <div class="columna">
                                            <div class="card">
                                                <div class="dentro">
                                                    <br>
                                                    <i class="fas fa-users iconoTarjeta"></i>
                                                    <h4 class="tituloTarjeta">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                                                    <h5 class="subtituloTarjeta">Materia: <i><?php echo $valorMateria['materia'] ?></i></h5>
                                                </div>
                                                <h5 class="subTarjeta">Carrera: <b><i><?php echo $valorCarrera['carrera'] ?></i></b></h5>
                                                <h5 class="subTarjeta">Docente: <b><i><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></i></b></h5>
                                                <h5 class="subTarjeta">Horario: <b><i><?php echo $valorHorario['horaInicio'] ?> -
                                                            <?php echo $valorHorario['horaFin'] ?></i></b></h5>
                                                <div class="divBtnRec"><button type="button" id="abrirModal1" onclick="capturarIdMateriaxd(<?php echo $valorClase['idClase']; ?>)">Iniciar</button></div>
                                            </div>
                                        </div>
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




    </div>
</div>
<div class="fila" id="fila">
    <div>
        <h4>Turno noche</h4>
        <?php
        // Especificamos seleccionar todos los datos que tengan ocupado=1 (que se esta pasando clases)
        $clasesNoche = $tablaClases->where("ocupado", "=", 0)->get();

        foreach ($clasesNoche as $valorClase) {
            $datosMaterias= $tablaMaterias->where("idMateria","=",$valorClase['idMateria'])->get();
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
        ?>
                                        <div class="columna">
                                            <div class="card">
                                                <div class="dentro">
                                                    <br>
                                                    <i class="fas fa-users iconoTarjeta"></i>
                                                    <h4 class="tituloTarjeta">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                                                    <h5 class="subtituloTarjeta">Materia: <i><?php echo $valorMateria['materia'] ?></i></h5>
                                                </div>
                                                <h5 class="subTarjeta">Carrera: <b><i><?php echo $valorCarrera['carrera'] ?></i></b></h5>
                                                <h5 class="subTarjeta">Docente: <b><i><?php echo $valorDocente['nombre'] . " " . $valorDocente['apellidos'] ?></i></b></h5>
                                                <h5 class="subTarjeta">Horario: <b><i><?php echo $valorHorario['horaInicio'] ?> -
                                                            <?php echo $valorHorario['horaFin'] ?></i></b></h5>
                                                <div class="divBtnRec"><button type="button" id="abrirModal1" onclick="capturarIdMateriaxd(<?php echo $valorClase['idClase']; ?>)">Iniciar</button></div>
                                            </div>
                                        </div>
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

    </div>
</div>
<br><br>
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
        $band = false;
        $sql = "SELECT * FROM aulas ORDER BY aula";
        $result = $conn->query($sql);
        $manana = '100000';
        $manana1 = '120000';
        ?>
        <div class="bloque activo">
            <h2 class="h2">Bloque A</h2>
            <div class="contenido">
                <div class="filaDisponible" id="fila">
                    <?php
                    $sql1 = "SELECT DISTINCT idAula FROM clases ORDER BY idAula";
                    $result1 = $conn->query($sql1);
                    $aulasOcupadas = $tablaMaterias->get();
                    foreach ($result1 as $valorAulaO) {
                        foreach ($result as $valorAula) {
                            if ($valorAulaO['idAula'] != $valorAula['idAula']) {
                                $aulasA = substr($valorAula['aula'], 0, 1);
                                if ($aulasA === "A") {
                    ?>
                                    <div class="columnaDisponible">
                                        <div class="cardDisponible">
                                            <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                                            <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                                        </div>
                                    </div>
                    <?php
                                }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "B") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "C") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "D") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "E") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "F") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "G") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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
foreach ($result1 as $valorAulaO) {
    foreach ($result as $valorAula) {
        if ($valorAulaO['idAula'] != $valorAula['idAula']) {
            $aulasA = substr($valorAula['aula'], 0, 1);
            if ($aulasA === "H") {
?>
                <div class="columnaDisponible">
                    <div class="cardDisponible">
                        <i class="fas fa-users iconoTarjetaDisponible"></i><br>
                        <h4 class="tituloTarjetaDisponible">Aula: <b><?php echo $valorAula['aula'] ?></b></h4>
                    </div>
                </div>
<?php
            }
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