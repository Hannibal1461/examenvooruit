<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    // header('location: homepagina.php');
    // exit;
  }
include 'database.php';
include 'HelperFunctions.php';

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "usertype_id",
      "voorletters",
      "voorvoegsels",
      "achternaam",
      "gebruikersnaam",
      "Wachtwoord"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $usertype_id = $_POST['usertype_id'];
    $voorletters = $_POST['voorletters'];
    $voorvoegsels = $_POST['voorvoegsels'];
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $Wachtwoord = $_POST['Wachtwoord']; {


    $db = new database('localhost', 'root', '', 'excellenttaste', 'utf8');
    $db->populate($usertype_id, $voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $wachtwoord, $levID, $product, $type, $inkoopprijs, $verkoopprijs,$leverancier, $telefoon, $locatie);

      header('location: index.php');
      exit;
    }
  }
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Registratie scherm</title>
  </head>
  <body>
    <div>
      <legend style="text-align: center;"> excellenttaste </legend>
      <img src="img\logo.png">
      <a class="btn btn-danger" href="logout.php" style="margin-left:1780px; margin-top:-200px">Logout</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="view_edit_delete_medewerker.php">view edit delete medewerker</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_artikelen.php">view edit artikelen</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_leverancier.php">view edit leverancier</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_locatie.php">view edit locatie</a><br><br>
          <a class="btn btn-outline-info" href="voorraad.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>

      <form method="post" align="center" action='register.php' method='post' accept-charset='UTF-8' style="margin-top:-350px;">
      <fieldset >
        <legend>Registratie admin acc</legend>
        <input type="text" name="usertype_id" placeholder="usertype_id" value="1" hidden required/>
        <input type="text" name="voorletters" placeholder="voorletters" value="admin" hidden required/><br><Br>
        <input type="text" name="voorvoegsels" placeholder="voorvoegsels" value="admin" hidden required/>
        <input type="text" name="achternaam" placeholder="achternaam" value="admin" hidden required/><br><br>
        <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam"value="admin" hidden required/>
        <input type="password" name="Wachtwoord" placeholder="Wachtwoord" value="admin" hidden required/><br><br>
        <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Register</button>
      </fieldset>
    </form>
  </body>
</html>
