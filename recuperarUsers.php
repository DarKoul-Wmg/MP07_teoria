<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $hostname = "localhost";
        $dbname = "users";
        $username = "admin";
        $pw = "admin123";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
        exit;
    }

    try {
        $query = $pdo->prepare("SELECT usuario, contrasenya FROM cuentas");
        $query->execute();
    } catch (PDOException $e) {
        echo "Error de SQL<br>\n";
        $e = $query->errorInfo();
        if ($e[0] != '00000') {
            echo "\nPDO::errorInfo():\n";
            die("Error accedint a dades: " . $e[2]);
        }
    }

    $loginCorrecte = false;
    $usuariLogin = $_POST['user'];
    $contraLogin = $_POST['passw'];

    while ($cuentas = $query->fetch(PDO::FETCH_ASSOC)) {
        $usuariBD = $cuentas['usuario'];
        $contrasenya = $cuentas['contrasenya'];

        if (($usuariLogin === $usuariBD) && ($contraLogin === $contrasenya)) {
            $loginCorrecte = true;
            break;
        }
    }

    if ($loginCorrecte) {
        echo '<h3> Login Correcte </h3>';
    } else {
        echo '<h3> Login Incorrecte </h3>';
    }

    unset($pdo);
    unset($query);
}
?>
<html>
<head>
    <title>Login BBDD</title>
</head>
<body>
    <h1>Inicia sesion</h1>
    <form method="post" action="">
        <label for="user"> Nom usuari:</label>
        <input type="text" name="user" required/>
        <br/>
        <label for="passw"> Contrasenya:</label>
        <input type="password" name="passw" required/>
        <button type="submit">login</button>
    </form>
</body>
</html>