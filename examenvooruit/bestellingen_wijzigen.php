<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }
include 'database.php';
include 'HelperFunctions.php';

$db = new database('localhost', 'root', '', 'excellenttaste', 'utf8');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $tafID = $_GET['tafID'];
  $menuID = $_GET['menuID'];
  $aantal = $_GET['aantal'];

  $account=$db->get_bestelling_information($id);
  // redirect to overview
  header("location: bestellingen_wijzigen.php");
  exit;
}

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "id",
      "tafID",
      "menuID",
      "aantal"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $tafID = $_POST['tafID'];
    $menuID = $_POST['menuID'];
    $aantal = $_POST['aantal'];


    $db->bestellingen_wijzigen($id, $tafID, $menuID, $aantal);

      header('location: bestellingen_wijzigen.php');
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>bestellingen wijzigen</title>
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
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
    <?php

        // admin should be able to see all users. should not filter on user, hence the NULL.
        $results = $db->get_bestellingen_information(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        ?>

    <div class="container" style="margin-top:-250px; margin-right:500px;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>bestellingen wijzigen</b></h2>
                            <a class="btn btn-success" href="view_edit_delete_bestellingen.php" class="edit_btn" >terug naar bestellingen</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <?php foreach($columns as $column){ ?>
                              <th><strong> <?php echo $column ?> </strong></th>
                          <?php } ?>
                        </tr>
                    </thead>
                    <?php foreach($results as $rows => $row){ ?>
                        <?php $row_id = $row['id']; ?>
                        <tr>
                            <?php foreach($row as $row_data){?>
                                <td>
                                    <?php echo $row_data ?>
                                </td>
                            <?php } ?>
                      </tr>
                    <?php } ?>
              </table>
              <form method="post" align="center" action='bestellingen_wijzigen.php' method='post' accept-charset='UTF-8'>
                <fieldset>
                  <input type="text" name="id" placeholder="id" required/>
                  <input type="text" name="tafID" placeholder="tafID" required/>
                  <input type="text" name="menuID" placeholder="menuID" required/>
                  <input type="text" name="aantal" placeholder="aantal" required/>
                  <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Update!</button>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
    </body>
  </html>
