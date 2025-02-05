<!-- Realitzar queries amb filtres d'una sola taula -->
<!DOCTYPE html>
 <html lang="es">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex fita 4 will</title>
 </head>
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
?>
  <body>
  <form action="ex-fita4.php" method="post">
      <label for="filtre">Client:</label>
      <select name="filtre" id ="filtre">
            <?php
            // options
                try {
                    $qstr = "SELECT customerName FROM customers ORDER BY customerName ASC;";
                    $query = $pdo->prepare($qstr);
                    $query -> execute();
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option>".$row['customerName']."</option>";
                    }
                        

                } catch (PDOException $e) {
                    echo "Error de SQL<br>\n";
                    echo "Error en la consulta SQL: " . $e->getMessage();
                }
            ?>
        </select>
        <input type="submit" value="Enviar">
   </form>


<?php
  if (isset($_POST['filtre'])) {
    $customer = '%'.$_POST['filtre'].'%';
    //var_dump($pais);

    try {
        $qstr = "SELECT customerName, CONCAT(contactFirstName,' ',contactLastName) as contact, 
                        phone, city, c.state, country, addressLine1, addressLine2, postalCode, creditLimit
                 FROM customers c
                 WHERE customerName LIKE :customer;";

        $query = $pdo->prepare($qstr);
        $query -> bindParam(':customer',$customer,PDO::PARAM_STR);
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
          <li>Pais: <?php echo $row['country']?></li>
          <li>Adreça 1: <?php echo $row['addressLine1']?></li>
          <li>Adreça 2: <?php echo $row['addressLine2']? $row['addressLine2'] : "N/A"?></li>
          <li>Codi postal: <?php echo $row['postalCode']?></li>
          <li>Limit de credit: <?php echo $row['creditLimit']?></li>
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