<?php
$host = "localhost:3306";
$dbname = "basedatos_local";
$pass = "contrasena_local";
$user = "usuario_local";

//https://www.000webhost.com/forum/t/how-to-connect-to-database-using-php/42093
$host_prod = "localhost";
$dbname_prod = "basedatos_prod";
$pass_prod = "contrasna_prod";
$user_prod = "usuario_prod";

$produccion = true;

$DBH = null;
try {
    if ($produccion) {
        $DBH = new PDO("mysql:host=$host_prod;dbname=$dbname_prod", $user_prod, $pass_prod);
    } else {
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    }
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>