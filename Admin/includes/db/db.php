<?php 

$dsn = "mysql:host=localhost;dbname=moda";
$user = "root";
$password = "";
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
);
try{
    $connect = new PDO($dsn,$user,$password,$option);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
}catch(PDOException $ahmed){
    echo "Failed to Connect DB" . $ahmed->getMessage();
}


?>