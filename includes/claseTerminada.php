<?php
include ('config.php');
include ('Crud.php');
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/La_Paz');
$hora = date('G:i:s');
$fecha = date('Y-m-d');

if (isset($_POST['idClase'])){
$idClase=$_POST['idClase'];
    $tablaClase=new Crud('clases');
    $tablaPersonas=new Crud('personas');
    $tablaActividad=new Crud('actividad_realizada');
    $datosClases = $tablaClase->where("idClase","=",$idClase)->get();
    foreach ($datosClases as $valorClase) {
        $id_persona=$valorClase['id_persona'];
        $idAula=$valorClase['idAula'];
    }
    $act_actividad = $tablaActividad->where("id_persona","=",$id_persona)->where("estado_activo","=","si")->update([
        "fechaDevolucion"=>$fecha,
        "horaDevolucion"=>$hora,
        "estado_activo"=>"no"
    ]);
    $tablaClase->where("idClase","=",$idClase)->update(["ocupado"=>2]);
    echo "Se guardo la confirmación";
}else{
    echo "Error";
}
?>