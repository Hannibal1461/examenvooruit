<?php

// initialiseerd sessie
session_start();

// unset alle sessie veriables. Weet je niet zeker welke? bekijk de login methode!!!!!
$_SESSION = [];

// kill'd de sessie
session_destroy();

// user word geriderect naar login pagina
header('location: index.php');
exit;

?>
