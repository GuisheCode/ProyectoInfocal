<?php
include ('config.php');
include ('Crud.php');
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/La_Paz');
$hora = date('G:i:s');
$fecha = date('Y-m-d');
$id_usuario = $_SESSION['idUsuario'];
$vacio = NULL;
if (isset($_POST['id_uso'])){
$id_uso=$_POST['id_uso'];
    $tablaUso=new Crud("uso_herramientas");
    $tablaUso->where("id_uso","=",$id_uso)->update([
        "fechaEntrega"=>$fecha,
        "horaEntrega"=>$hora,
        "reservado"=>"no",
        "estado_activo"=>"si"
    ]);
    echo "Se guardo la confirmación";
}else{
    echo "Error";
}
?>