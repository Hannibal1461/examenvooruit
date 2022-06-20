<!--Gemaakt door Yusa Celiker OITAOO8B -->
  <?php
  //class database aan gemaakt
  class database{
    // class met allemaal private variables aangemaakt (property)
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    // maakt class constants (admin en user)
    const ADMIN = 1; // these are the values from the db
    const CHEF = 2;
    const OBER = 3;
    const KLANT = 4;

    public function __construct($host, $user, $pass, $db, $charset){
      $this->host = $host;
      $this->user = $user;
      $this->pass = $pass;
      $this->charset = $charset;

      try {
          $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
          $options = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES   => false,
          ];

          $this->pdo = new PDO($dsn, $user, $pass, $options);
      } catch (\PDOException $e) {
          echo $e->getMessage();
          throw $e;
          // throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    // kijkt of de account die probeert in te loggen admin is met usertype_id. Als hij een admin is dan word 1 door gestuurt, anders 2.
    private function is_admin($gebruikersnaam){
        // query houd de gegevens in die naar de database gestuurd gaat worden
        $query = "SELECT usertype_id FROM medewerker WHERE gebruikersnaam = :gebruikersnaam";

        // dit voert de query uit
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]);

        $result = $stmt->fetch();

        // kijkt of usertype_id gelijk is aan admin zo ja dan ben je admin en word je gestuurt naar homepagina.php
        if($result['usertype_id'] == self::ADMIN){
            return true;
        }

        // user is not admin
        return false;
    }

    // Verwijderd users uit de database. Pagina: view_edit_delete_medewerker
    public function deleteUser($id){
        echo $id;
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM medewerker WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();

        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    // wijzigd de gegevens van een account. Pagina: edit_user.php
    public function editUser($id, $usertype_id, $voorletters, $voorvoegsels, $achternaam){
      $query = "  UPDATE
                    medewerker
                  SET
                    usertype_id = :usertype_id,
                    voorletters = :voorletters,
                    voorvoegsels = :voorvoegsels,
                    achternaam = :achternaam
                  WHERE id = :id";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
      'id'=>$id,
      'usertype_id'=>$usertype_id,
      'voorletters'=>$voorletters,
      'voorvoegsels'=>$voorvoegsels,
      'achternaam'=>$achternaam
      ]);

      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // pakt de account gegevens vanuit de database om het te laten zien in een tabel in pagina: view_edit_delete_medewerker
    public function view_user_detail($gebruikersnaam){

        $query = "SELECT id, usertype_id, voorletters, voorvoegsels, achternaam, gebruikersnaam FROM medewerker

        ";

        if($gebruikersnaam !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE gebruikersnaam = :gebruikersnaam';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $gebruikersnaam !== NULL ? $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // maakt een medewerker aan in het database. Pagina: Register.php
    public function create_medewerker($usertype_id, $voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $wachtwoord){
      $query = "INSERT INTO medewerker
            (id, usertype_id, voorletters, voorvoegsels, achternaam, gebruikersnaam, wachtwoord)
            VALUES
            (NULL, :usertype_id, :voorletters, :voorvoegsels, :achternaam, :gebruikersnaam, :wachtwoord)";

      $statement = $this->pdo->prepare($query);

      // password hashen
      $hashed_password =  password_hash($wachtwoord, PASSWORD_DEFAULT);

      $statement->execute([
        'usertype_id'=>$usertype_id,
        'voorletters'=>$voorletters,
        'voorvoegsels'=>$voorvoegsels,
        'achternaam'=>$achternaam,
        'gebruikersnaam'=>$gebruikersnaam,
        'wachtwoord'=>$hashed_password
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // ----------------------------------------------------------------------------------------------------------------------------------

    // verwijderd artikelen die zn ids overeen komen met die gegeven is. Pagina: view_edit_delete_artikelen
    public function deleteMenu($id){
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM menu WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();
        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    // pakt artikel informatie uit de database pagina: view_edit_delete_artikelen
    public function get_menu_information($product){

        $query = "SELECT id, product, type, verkoopprijs FROM menu

        ";

        if($product !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE product = :product';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // maakt een artikel aan in het database. Pagina: artikel_toevoegen.php
    public function create_menu($product, $type, $verkoopprijs){
      $query = "INSERT INTO menu
            (id, product, type, verkoopprijs)
            VALUES
            (NULL, :product, :type, :verkoopprijs)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'product'=>$product,
        'type'=>$type,
        'verkoopprijs'=>$verkoopprijs
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // update de gegevens van een bestaande artikel. Pagina: artikelwijzigen.php
    public function update_menu($id, $product, $type,$verkoopprijs){
      $query = "UPDATE menu
      SET product = :product, type = :type, verkoopprijs = :verkoopprijs
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'product'=>$product,
        'type'=>$type,
        'verkoopprijs'=>$verkoopprijs
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }
    // maakt een medewerker aan in het database. Pagina: Register.php

    public function reservering($voornaam, $achternaam, $email, $aantal, $telefoon, $datum, $tijd){
      $query = "INSERT INTO reservering
            (id, voornaam, achternaam, email, aantal, telefoon, datum, tijd)
            VALUES
            (NULL, :voornaam, :achternaam, :email, :aantal, :telefoon, :datum, :tijd)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'voornaam'=>$voornaam,
        'achternaam'=>$achternaam,
        'email'=>$email,
        'aantal'=>$aantal,
        'telefoon'=>$telefoon,
        'datum'=>$datum,
        'tijd'=>$tijd
      ]);
    }

    // update de gegevens van een bestaande artikel. Pagina: artikelwijzigen.php
    public function reservering_wijzigen($id, $voornaam, $achternaam, $email, $aantal, $telefoon, $datum, $tijd){
      $query = "UPDATE reservering
      SET voornaam = :voornaam, achternaam = :achternaam, email = :email, aantal = :aantal, telefoon = :telefoon, datum = :datum, tijd = :tijd
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'voornaam'=>$voornaam,
        'achternaam'=>$achternaam,
        'email'=>$email,
        'aantal'=>$aantal,
        'telefoon'=>$telefoon,
        'datum'=>$datum,
        'tijd'=>$tijd
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }

    // pakt artikel informatie uit de database pagina: view_edit_delete_artikelen
    public function get_reservering_information($product){

        $query = "SELECT id, voornaam, achternaam, email, aantal, telefoon, datum, tijd FROM reservering

        ";

        if($product !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE voornaam = :voornaam';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Verwijderd users uit de database. Pagina: view_edit_delete_medewerker
    public function deleteReservering($id){
        echo $id;
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM reservering WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();

        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }
// -----

    public function tafels($tafels){
      $query = "INSERT INTO tafels
            (id, tafels)
            VALUES
            (NULL, :tafels)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'tafels'=>$tafels
      ]);
    }

    // update de gegevens van een bestaande artikel. Pagina: artikelwijzigen.php
    public function tafels_wijzigen($id, $tafels){
      $query = "UPDATE tafels
      SET tafels = :tafels
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'tafels'=>$tafels
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $tafels_id = $this->pdo->lastInsertId();
      return $tafels_id;
    }

    // pakt artikel informatie uit de database pagina: view_edit_delete_artikelen
    public function get_tafels_information($product){

        $query = "SELECT id, tafels FROM tafels

        ";

        if($product !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE tafels = :tafels';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $product !== NULL ? $stmt->execute(['tafels'=>$tafels]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Verwijderd users uit de database. Pagina: view_edit_delete_medewerker
    public function deletetafels($id){
        echo $id;
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM tafels WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();

        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }


// ----------

public function bestellingen($tafID, $menuID, $aantal){
  $query = "INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (NULL, :tafID, :menuID, :aantal)";

  $statement = $this->pdo->prepare($query);

  $statement->execute([
    'tafID'=>$tafID,
    'menuID'=>$menuID,
    'aantal'=>$aantal
  ]);
}

// update de gegevens van een bestaande artikel. Pagina: artikelwijzigen.php
public function bestellingen_wijzigen($id, $tafID, $menuID, $aantal){
  $query = "UPDATE bestellingen
  SET tafID = :tafID, menuID = :menuID, aantal = :aantal
  WHERE id = :id";
  $statement = $this->pdo->prepare($query);
  $statement->execute([
    'id'=>$id,
    'tafID'=>$tafID,
    'menuID'=>$menuID,
    'aantal'=>$aantal
  ]);

  // haalt de laatst toegevoegde id op uit de db
  $artikel_id = $this->pdo->lastInsertId();
  return $artikel_id;
}

public function get_bestellingen_information($product){

    $query = "SELECT id, tafID, menuID, aantal FROM bestellingen

    ";

    if($product !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE product = :product';
    }

    $stmt = $this->pdo->prepare($query);

    // check if username is supplied, if so, pass assoc array to execute
    $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Verwijderd users uit de database. Pagina: view_edit_delete_medewerker
public function deleteBestellingen($id){
    echo $id;
    try{
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("DELETE FROM bestellingen WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        $this->pdo->commit();

    }catch(Exception $e){
        $this->pdo->rollback();
        echo 'Error: '.$e->getMessage();
    }
}

// ----------

public function get_chef_information($product){

    $query = "SELECT m.product, m.type, b.aantal, t.tafels
                  FROM bestellingen as b
                  INNER JOIN tafels as t on b.tafID = t.id
                  INNER JOIN menu as m on b.menuID = m.id
                  WHERE m.type = 'eten'
                  ";

    if($product !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE product = :product';
    }

    $stmt = $this->pdo->prepare($query);

    // check if username is supplied, if so, pass assoc array to execute
    $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


public function get_ober_information($product){

    $query = "SELECT m.product, m.type, b.aantal, t.tafels
                  FROM bestellingen as b
                  INNER JOIN tafels as t on b.tafID = t.id
                  INNER JOIN menu as m on b.menuID = m.id
                  WHERE m.type = 'drinken'
                  ";

    if($product !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE product = :product';
    }

    $stmt = $this->pdo->prepare($query);

    // check if username is supplied, if so, pass assoc array to execute
    $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// ----------------------------------------------------------------------------------------------------------------------------------
    // bekijkt of de gegevens die zijn ingevuld in login.php kloppen zodat je kunt inloggen.
    public function authenticate_user($gebruikersnaam, $wachtwoord){

          $query = "SELECT wachtwoord
          FROM medewerker
          WHERE gebruikersnaam = :gebruikersnaam";

          $stmt = $this->pdo->prepare($query);
          // voorbereide instructieobject wordt uitgevoerd.
          $stmt->execute(['gebruikersnaam' => $gebruikersnaam]); //-> araay
          $result = $stmt->fetch(); // returned een array

          // checkt of $result een array is
          if(is_array($result)){
          // voerd count uit als #result een array is
          if(count($result) > 0){

          $hashed_password = $result['wachtwoord'];

          if($gebruikersnaam && password_verify($wachtwoord, $hashed_password)){
              // session_start();
              // slaat userdata in sessie veriable
              $_SESSION['gebruikersnaam'] = $gebruikersnaam;
              $_SESSION['usertype'] = $result['usertype_id'];
              $_SESSION['loggedin'] = true;

              if($this->is_admin($gebruikersnaam)){
                  header("location: homepagina.php");
                  //make sure that code below redirect does not get executed when redirected.
                  exit;
              }  // redirect user to the user-page if not admin.
                header("location: welcome_user.php");
                exit;
              }
            }
          }
        }


  }
?>
