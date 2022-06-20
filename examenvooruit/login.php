<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

include 'database.php';
include 'helperfunctions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && !empty($_POST['submit'])){
  // maak een array met alle name attributes

  $fields = [
    	"gebruikersnaam",
    	"wachtwoord"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
if($no_error){
  $gebruikersnaam = $_POST['gebruikersnaam'];
  $wachtwoord = $_POST['wachtwoord'];

  $db = new database('localhost', 'root', '', 'hengelsport', 'utf8');
  $db->authenticate_user($wachtwoord, $gebruikersnaam);


  }
}

 ?>


<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<title>login pagina</title>
	</head>
	<body>
		<form id='login' align="center" action='login.php' method='post' accept-charset='UTF-8'>
        <span class="text-danger"><?php echo (!empty($loginStatus) && $loginStatus != '') ? $loginStatus ."<br>": ''  ?></span>
			<fieldset >
				<legend>Inloggen</legend>
				<input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" required/><br><br>
				<input type="password" name="wachtwoord" placeholder="wachtwoord" required/><br><br>
			</fieldset>
      <div align="center">
          <button class="btn btn-outline-success" type="submit" name="submit" value="submit">Login</button>
      </div>
  </form>

	</body>
</html>
