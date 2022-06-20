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
      "tafels"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $tafels = $_POST['tafels'];


    $db = new database('localhost', 'root', '', 'excellenttaste', 'utf8');
    $db->tafels( $tafels);

      header('location: view_edit_delete_tafels.php');
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>tafels</title>
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

      <form method="post" align="center" action='tafels_toevoegen.php' method='post' accept-charset='UTF-8' style="margin-top:-350px;">
      <fieldset >
        <legend>reservering</legend>
        <input type="text" name="tafels" placeholder="tafelnummer" required/>
        <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Register</button>
        <a class="btn btn-outline-info" href="view_edit_delete_reservering.php">terug naar reservering</a>
      </fieldset>
    </form>
  </body>
</html>
