<?php
// Start økt
session_start();
 
// Fjern alle variabler
$_SESSION = array();
 
// Ødelegg/lukk økt
session_destroy();
 
// Omdiriger til login-siden
header("location: index.php");
exit;
?>