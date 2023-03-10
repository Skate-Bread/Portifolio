<?php
//henter all innloggings informasjon
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'elev21imben2302');
define('DB_PASSWORD', 'Skien2204!');
define('DB_NAME', 'webhotel_elev21imben2302');
 
//prøver å tilkobble databasen
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
//sjekk om tilkobblinga var vellykket
if($link === false){
    die("ERROR: Kunne ikke koble til databasen! " . mysqli_connect_error());
}
?>