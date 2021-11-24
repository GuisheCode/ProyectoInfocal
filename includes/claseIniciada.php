<?php
include ('config.php');
include ('Crud.php');
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/La_Paz');
$hora = date('G:i:s');
$fecha = date('Y-m-d');
$id_usuario = $_SESSION['idUsuario'];
if (isset($_POST['idClase'])){
$idClase=$_POST['idClase'];
    $tablaClases =new Crud('clases');
    $tablaAula=new Crud('aulas');
    $tablaMaterias = new Crud('materias');
    $tablaPersonas=new Crud('personas');
    $tablaCargos=new Crud('cargos');
    $tablaActividad=new Crud('actividad_realizada');
    $datosClases = $tablaClases->where("idClase","=",$idClase)->get();
    foreach ($datosClases as $valorClase) {
        $id_persona=$valorClase['id_persona'];
        $idAula=$valorClase['idAula'];
        $idMateria=$valorClase['idMateria'];
    }
    $datosAula = $tablaAula->where("idAula","=",$idAula)->get();
    foreach ($datosAula as $valorAula) {
        $aula = $valorAula['aula'];
    }
    $datosMateria= $tablaMaterias->where("idMateria","=",$idMateria)->get();
    foreach ($datosMateria as $valorMateria) {
       $materia = $valorMateria['materia']; 
    }
    $datosPersonas=$tablaPersonas->where("id_persona","=",$id_persona)->get();
    foreach ($datosPersonas as $valorPersona) {
        $id_cargo = $valorPersona['id_cargo'];
        $nombre = $valorPersona['nombre'];
        $apellidos=$valorPersona['apellidos'];
    }
    $datosCargos=$tablaCargos->where("id_cargo","=",$id_cargo)->get();
    foreach ($datosCargos as $valorCargo) {
        $cargo=$valorCargo['cargo'];
    }
    $insertar = $tablaActividad->insert([
        "id_actividad"=>"",
        "idUsuario"=>$id_usuario,
        "id_persona"=>$id_persona,
        "idMateria"=>$idMateria,
        "idAula"=>$idAula,
        "fechaEntrega"=>$fecha,
        "horaEntrega"=>$hora,
        "fechaDevolucion"=>"",
        "horaDevolucion"=>"",
        "observacion"=>"",
        "estado_activo"=>"si"
    ]);


    $tablaClases->where("idClase","=",$idClase)->update(["ocupado"=>1]);
    echo "Se guardo la confirmación";
}else{
    echo "Error";
}
?>