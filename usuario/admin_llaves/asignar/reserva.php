<?php
require('../../../includes/config.php');
require_once '../../../includes/Crud.php';

// $hora = date('G:i:s');
// $fecha = date('Y-m-d');
$tablaPersonas=new Crud("personas");
$tablaHerramientas=new Crud("herramientas");
$tablaUso=new Crud("uso_herramientas");

if (isset($_POST['personal'])) {
    $id_persona =(int) filter_var($_POST['personal'], FILTER_SANITIZE_NUMBER_INT);
    $id_equipo = (int) filter_var($_POST['equipo'], FILTER_SANITIZE_NUMBER_INT);
    $fecha=$_POST['fecha'];
    $hora=$_POST['hora'];
    // echo $id_persona;
    // echo $id_equipo;
    // echo $_POST['fecha'];
    $tablaUso->insert([
        "id_equipo"=>$id_equipo,
        "id_persona"=>$id_persona,
        "fechaReserva"=>$fecha,
        "horaReserva"=>$hora,
        "reservado"=>"si"
    ]);
    $tablaHerramientas->where("id_equipo","=",$id_equipo)->update([
        "ocupado"=>"si"
    ]);
    header('Location: index.php');
}
?>
