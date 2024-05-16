<?php
$servername = "localhost";
$username = "root";
$password = "";

//eine Datenbankverbindung wird mithilfe der oben erstellten Variabeln erstellt
$conn = new PDO("mysql:host=$servername;dbname=book", $username, $password);
//Den nachfolgenden Code lassen wir hier, um bei allfälligen Problemen zu überprüfen, ob eine Verbindung mit der Datenbank erfolgreich erstellt wurde

/*try {
  $conn = new PDO("mysql:host=$servername;dbname=book", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}*/

?> 