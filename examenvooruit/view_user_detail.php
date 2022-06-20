<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }
include 'database.php';
  ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>View user details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
  </head>

  <body>
    <div>
      <legend style="text-align: center;"> DE HENGELSPORT </legend>
      <img src="img\logo.png">
      <a class="btn btn-success" href="leverancier_toevoegen.php" style="margin-left:530;">leverancier toevoegen</a>
      <a class="btn btn-danger" href="logout.php" style="margin-left:760px; margin-top:-200px">Logout</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="view_edit_delete_artikelen.php">view edit artikelen</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_leverancier.php">view edit leverancier</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_locatie.php">view edit locatie</a><br><br>
          <a class="btn btn-outline-info" href="voorraad.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>

    <?php

    $db = new database('localhost', 'root', '', 'hengelsport', 'utf8');
    // show_profile_details_user returns an associative array (get first index first)
    $result_set = $db->view_user_detail($_SESSION['gebruikersnaam'])[0];

    // result_set is an associative array, get keys with array_keys and values with array_values.
    $columns = array_keys($result_set);
    $row_data = array_values($result_set);
    ?>

    <div class="container" style="margin-top:-400px; margin-right:500px;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>View user details</b></h2>
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

                    <tr>
                    <?php foreach($row_data as $value){ ?>
                      <td>
                        <?php  echo $value ?>
                      </td>
                    <?php } ?>

                      </tr>
              </table>
            </div>
          </div>
        </div>
    </body>
</html>
