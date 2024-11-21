<?php
  //connexió dins block try-catch:
  //  prova d'executar el contingut del try
  //  si falla executa el catch
  try {
    $hostname = "localhost";
    $dbname = "mundo";
    $username = "admin";
    $pw = "admin123";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
    exit;
  }
 
  try {
    //preparem i executem la consulta
    $query = $pdo->prepare("SELECT name,code FROM country");
    $query->execute();
  } catch (PDOException $e) {
    echo "Error de SQL<br>\n";
    //comprovo errors:
    $e = $query->errorInfo();
    if ($e[0]!='00000') {
      echo "\nPDO::errorInfo():\n";
      die("Error accedint a dades: " . $e[2]);
    }  
  }
 
  //anem agafant les fileres d'amb una amb una
  $row = $query->fetch();
  while ( $row ) {
    echo $row['code']." - " . $row['name']. "<br/>";
	  $row = $query->fetch();
  }
 
  //versió alternativa amb foreach
  /*foreach ($query as $row) {
    echo $row['i']." - " . $row['a']. "<br/>";
  }*/
 
  //eliminem els objectes per alliberar memòria 
  unset($pdo); 
  unset($query)
 
?>