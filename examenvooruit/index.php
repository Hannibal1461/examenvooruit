<?php
// initialize the session
session_start();

include 'database.php';
include 'helperfunctions.php';

if(isset($_SESSION['loggedin'])){
    header('location: homepagina.php');
    exit;
}
?>

<html>
    <head>
        <title>home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <div>
      <legend style="text-align: center;"> DE HENGELSPORT </legend>
      <img src="img\logo.png">

      <a class="btn btn-danger" href="login.php" style="margin-left:1680px; margin-top:-200px">inloggen medewerker</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="voorraad_klant.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>
        <div align="center">
          <img src="img\product1.jpg" width="250" height="250">
          <img src="img\product2.jpg" width="250" height="250">
          <img src="img\product3.jpg" width="250" height="250">
        </div>
    </body>
</html>
