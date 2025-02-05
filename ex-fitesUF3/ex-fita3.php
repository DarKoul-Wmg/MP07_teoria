<!-- Realitzar queries amb filtres d'una sola taula -->
 <!DOCTYPE html>
 <html lang="es">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex fita 3 will</title>
 </head>
 <body>
    <form action="ex-fita3.php" method="post">
        <label for="filtre">Pais:</label>
        <input type="text" id="filtre" name="filtre"><br/><br/>
        <input type="submit" value="Enviar">
     </form>
     <br/>
<?php
  try {
    $hostname = "localhost";
    $dbname = "classicmodels";
    $username = "admin";
    $pw = "admin123";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
    exit;
  }

  if (isset($_POST['filtre'])) {
    $pais = $_POST['filtre'];
    var_dump($pais);

    try {
        $qstr = "SELECT customerName, CONCAT(contactFirstName,contactLastName, '') as contact, phone, city, state FROM customers WHERE country = ".$pais.";";
        echo $qstr."<br/>";
        $query = $pdo->prepare($qstr);
        $query->execute();

      } catch (PDOException $e) {
        echo "Error de SQL<br>\n";
        $e = $query->errorInfo();
        if ($e[0]!='00000') {
          echo "\nPDO::errorInfo():\n";
          die("Error accedint a dades: " . $e[2]);
        }  
      }
     //if($query && $query < 0)
      $row = $query->fetch();
      while ( $row ) {
        echo $row['customerName'] ." - " . $row['contact']. " - " . $row['phone']." - " . $row['city'].' - '.$row['state']."<br/>";
          $row = $query->fetch();
      }
  } 
  unset($pdo); 
  unset($query)
?>

 </body>
 </html>