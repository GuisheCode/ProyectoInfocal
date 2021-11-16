<?php
$valorStringInicio = $materia['fechaInicio'];
$valorEnteroInicio = str_replace("-", "", $valorStringInicio);
$diferenciaInicio = $fechaHoy - $valorEnteroInicio;

$valorStringFin = $materia['fechaFin'];
$valorEnteroFin = str_replace("-", "", $valorStringFin);
$diferenciaFin = $fechaHoy - $valorEnteroFin;

$horaInicioString = $materia['horaInicio'];
$horaInicioEntero = str_replace(":", "", $horaInicioString);
$diferenciaHoraInicio = $hora - $horaInicioEntero;

$horaFinString = $materia['horaFin'];
$horaFinEntero = str_replace(":", "", $horaFinString);
$diferenciaHoraFin = $hora - $horaFinEntero;

// if ($diferenciaInicio>=0 && $diferenciaFin<=0 && $diferenciaHoraInicio>=0 && $diferenciaHoraFin<=0){
// PARA MOSTRAR AULA OCUPADA: PONER CONDICION ALA HORA DE CREAR EL div class dentro o dentroOcupado
if ($diferenciaInicio >= 0 && $diferenciaFin <= 0 && $diferenciaHoraFin <= 0) {
    $selectAllAulas = $seleccionTablaAulas->where("idAula", "=", $materia['idAula'])->get();
    $selectAllDocentes = $seleccionTablaDocentes->where("idDocente", "=", $materia['idDocente'])->get();
    $selectAllCarreras = $seleccionTablaCarreras->where("idCarrera", "=", $materia['idCarrera'])->get();
    $selectAllRecursos = $seleccionTablaRecursos->where("idMateria", "=", $materia['idMaterias'])->get();
    foreach ($selectAllDocentes as $valoresDocentes) {
        foreach ($selectAllCarreras as $valoresCarreras) {
            foreach ($selectAllAulas as $valoresAulas) {
?>
                <div class="columna">
                    <div class="card">
                        <div class="dentroOcupado">
                            <br>
                            <i class="fas fa-users iconoTarjeta"></i>
                            <h4 class="tituloTarjeta">Aula: <b><?php echo $valoresAulas['aula'] ?></b></h4>
                            <h5 class="subtituloTarjeta">Materia: <i><?php echo $materia['materia'] ?></i></h5>
                        </div>
                        <h5 class="subTarjeta">Carrera: <b><i><?php echo $valoresCarreras['carrera'] ?></i></b></h5>
                        <h5 class="subTarjeta">Docente: <b><i><?php echo $valoresDocentes['nombre'] . " " . $valoresDocentes['apellidos'] ?></i></b></h5>
                        <h5 class="subTarjeta">Horario: <b><i><?php echo $materia['horaInicio'] ?> -
                                    <?php echo $materia['horaFin'] ?></i></b></h5>

                    </div>
                </div>
            <?php
            }
        }
    }
}
?>