<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conectamos a la  base de datos
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "db_legger";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consultamos los datos 
if (isset($_GET["consultar"])){
    $sqlclientes = mysqli_query($conexionBD,"SELECT * FROM cliente WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlclientes) > 0){
        $clientes = mysqli_fetch_all($sqlclientes,MYSQLI_ASSOC);
        echo json_encode($clientes);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar dato por id
if (isset($_GET["borrar"])){
    $sqlclientes = mysqli_query($conexionBD,"DELETE FROM cliente WHERE id=".$_GET["borrar"]);
    if($sqlclientes){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro en método post 
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $nit=$data->nit;
	$nombrepunto=$data->nombrepunto;
	$nombreequipo=$data->nombreequipo;
    $ciudad=$data->ciudad;
	$promotor=$data->promotor;
    $rtc=$data->rtc;
	$capitan=$data->capitan;
    $terminos=$data->terminos;
    $ip=$data->ip;
        if(($nombre!="")&&($nit!="")&&($terminos!="")){ //validamos los campos obligatorios
    $sqlclientes = mysqli_query($conexionBD,"INSERT INTO cliente(nombre,nit,nombrepunto,nombreequipo,ciudad,promotor,rtc,capitan,terminos,ip)VALUES('$nombre','$nit','$nombrepunto','$nombreequipo','$ciudad','$promotor','$rtc','$capitan','$terminos','$ip')");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos de cliente
if(isset($_GET["actualizar"])){    
    $data = json_decode(file_get_contents("php://input"));
    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombre=$data->nombre;
    $nit=$data->nit;
	$nombrepunto=$data->nombrepunto;
	$nombreequipo=$data->nombreequipo;
    $ciudad=$data->ciudad;
	$promotor=$data->promotor;
    $rtc=$data->rtc;
	$capitan=$data->capitan;
    $terminos=$data->terminos;    
    $ip=$data->ip;   
    $sqlclientes = mysqli_query($conexionBD,"UPDATE cliente SET 
	nombre='$nombre',
	nit='$nit',
	nombrepunto='$nombrepunto',
	nombreequipo='$nombreequipo',
	ciudad='$ciudad',
	promotor='$promotor',
	rtc='$rtc',
	capitan ='$capitan',
	terminos='$terminos',
	ip='$ip'
	WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla cliente
$sqlclientes = mysqli_query($conexionBD,"SELECT * FROM cliente ");
if(mysqli_num_rows($sqlclientes) > 0){
    $clientes = mysqli_fetch_all($sqlclientes,MYSQLI_ASSOC);
   echo json_encode($clientes);
}
else{ echo json_encode([["success"=>0]]); }
?>
