<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }

include 'database.php';

$db = new database('localhost', 'root', '', 'excellenttaste', 'utf8');

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//
//     $db->get_chef_information($id);
//
//     // redirect to overview
//     header("location: view_edit_delete_tafels.php");
//     exit;
// }

  // in case of field values, proceed, execute insert
  if(isset($_POST['export'])){
      $filename = "user_data_export.xls";
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");
      $print_header = false;

      $result = $db->get_chef_information(NULL);
      if(!empty($result)){
          foreach($result as $row){
              if(!$print_header){
                  echo implode("\t", array_keys($row)) ."\n";
                  $print_header=true;
              }
              echo implode("\t", array_values($row)) ."\n";
          }
      }
      exit;
  }
  ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>View edit and delete tafels</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
        $results = $db->get_chef_information(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        $values = array_values($results);
        // print_r(array_values($values));
        // $inkoopprijs = $values['inkoopprijs'];
        // print_r($values);
        ?>

      <div class="container" style="margin-top:-300px; margin-right:500px;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>View edit and delete tafels</b></h2>
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
                        <?php $row_id = $row ?>
                        <tr>
                            <?php foreach($row as $row_data){?>
                                <td>
                                    <?php echo $row_data ?>
                                </td>
                            <?php } ?>

                      </tr>

                    <?php } ?>
              </table>
              <form action='view_edit_delete_tafels.php' method='POST'>
                  <input type='submit' name='export' value='Export to excel file' />
              </form>
            </body>
        </html>
