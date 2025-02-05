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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
    echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
    exit;
  }

  if (isset($_POST['filtre'])) {
    $pais = '%'.$_POST['filtre'].'%';
    //var_dump($pais);

    try {
        $qstr = "SELECT customerName, CONCAT(contactFirstName,' ',contactLastName) as contact, phone, city, c.state 
                 FROM customers c
                 WHERE country LIKE :pais ;";

        $query = $pdo->prepare($qstr);
        $query -> bindParam(':pais',$pais,PDO::PARAM_STR);
        $query->execute();

      } catch (PDOException $e) {
        echo "Error de SQL<br>\n";
        echo "Error en la consulta SQL: " . $e->getMessage();
      }
     //if($query && $query < 0)

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <ul>
          <li>Nom: <?php echo $row['customerName'] ?></li>
          <li>Contacte: <?php echo $row['contact'] ?></li>
          <li>Tel: <?php echo $row['phone'] ?></li>
          <li>Ciutat: <?php echo $row['city'] ?></li>
          <li>Estat: <?php echo $row['state']? $row['state'] : 'N/A'; ?></li>
        </ul>
      <?php
        //echo  $row['customerName']." - " . $row['contact']. " - " . $row['phone']." - " . $row['city'].' - '.$row['state']."<br/>";
      }
  } 
  unset($pdo); 
  unset($query)
?>

 </body>
 </html>