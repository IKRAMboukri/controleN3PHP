<?php
$host="localhost";
$port=3306;
$dbName = "gestion_employes";
$user = "root";
$password = "";

$dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";
try{
  $pdo = new PDO($dsn,$user,$password);
  echo "connection succefly:";

}catch(PDOException $e){
  echo "connection failed: " . $e.getMessage();

}