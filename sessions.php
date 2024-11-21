<h1>sessions</h1>

<?php 

session_start();
echo $_SESSION['nom'];
$_SESSION['nom']= "Willy";


 ?>