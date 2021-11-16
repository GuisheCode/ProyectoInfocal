<?php
include ('config.php');
include ('Crud.php');

if (isset($_POST['idClase'])){
$idMateria=$_POST['idClase'];
    $tablaClase=new Crud('clases');
    $tablaClase->where("idClase","=",$idMateria)->update(["ocupado"=>0]);
    echo "Se guardo la confirmación";
}else{
    echo "Error";
}
?>