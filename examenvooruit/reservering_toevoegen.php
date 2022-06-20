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
      "voornaam",
      "achternaam",
      "email",
      "aantal",
      "telefoon",
      "datum",
      "tijd"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $aantal = $_POST['aantal'];
    $telefoon = $_POST['telefoon'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd']; {


    $db = new database('localhost', 'root', '', 'excellenttaste', 'utf8');
    $db->reservering( $voornaam, $achternaam, $email, $aantal ,$telefoon, $datum, $tijd);

      header('location: view_edit_delete_reservering.php');
      exit;
    }
  }
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>reservering</title>
  </head>
  <body>
    <div>
      <legend style="text-align: center;"> excellenttaste </legend>
      <img src="img\logo.png">
      <a class="btn btn-danger" href="logout.php" style="margin-left:1790px; margin-top:-200px">Logout</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="view_edit_delete_medewerker.php">view edit delete user</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_menu.php">view edit menu</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_tafels.php">view edit tafels</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_bestellingen.php">view edit bestellingen</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_reservering.php">view edit reservering</a><br><br>
        </div>
      </div>

      <form method="post" align="center" action='reservering_toevoegen.php' method='post' accept-charset='UTF-8' style="margin-top:-350px;">
      <fieldset >
        <legend>reservering</legend>
        <input type="text" name="voornaam" placeholder="voornaam" required/>
        <input type="text" name="achternaam" placeholder="achternaam" required/><br><Br>
        <input type="text" name="aantal" placeholder="aantal" required/>
        <input type="text" name="email" placeholder="email" required/><br><br>
        <input type="text" name="telefoon" placeholder="telefoon" required/>
        <input type="date" name="datum" placeholder="datum" required/><br><br>
        <input type="time" name="tijd" placeholder="tijd" required/><br><br>
        <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Register</button>
        <a class="btn btn-outline-info" href="view_edit_delete_reservering.php">terug naar reservering</a>
      </fieldset>
    </form>
  </body>
</html>
