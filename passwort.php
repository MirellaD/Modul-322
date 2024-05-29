<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Zeichensatz der Seite auf UTF-8 setzen -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsives Design ermöglichen -->
    <title>Passwort ändern</title> <!-- Titel der Seite -->
</head>
<body>
<?php include ('inc/navigation.php') ?> <!-- Einbinden der Navigationsleiste -->
<?php include ('inc/inc.php');?> <!-- Einbinden weiterer benötigter PHP-Dateien, vermutlich für Datenbankverbindung oder Utility-Funktionen -->
<div id="grosspassform">
    <div id="passform">
        <h2>Passwort ändern</h2>
        <form action="passwort.php" method="post"> <!-- Formular zum Ändern des Passworts -->
            <label for="username">Benutzername:</label><br>
            <input type="text" id="username" name="username" required/><br><br> <!-- Eingabefeld für den Benutzernamen -->
            <label for="passA">Altes Passwort:</label><br>
            <input type="password" id="passA" name="passA" required/><br><br> <!-- Eingabefeld für das alte Passwort -->
            <label for="passN">Neues Passwort:</label><br>
            <input type="password" id="passN" name="passN" required/><br><br> <!-- Eingabefeld für das neue Passwort -->
            <label for="passNB">Neues Passwort bestätigen:</label><br>
            <input type="password" id="passNB" name="passNB" required/><br><br> <!-- Eingabefeld zur Bestätigung des neuen Passworts -->
            <input id="logbutton" name="changePS" type="submit" value="Passwort ändern"><br><br> <!-- Button zum Absenden des Formulars -->
        </form>
    </div>
</div>
<?php
echo "<div class='messagesPass'>";

// Überprüfen, ob das Formular zum Ändern des Passworts abgesendet wurde
if(isset($_POST['changePS'])){ 
    // Überprüfen, ob das neue Passwort mindestens 8 Zeichen lang ist
    if(strlen(trim($_POST['passNB'])) >= 8){
        $error = "Fehler: Überprüfen Sie Ihre Angaben.";
        $username = htmlspecialchars(trim($_POST['username'])); // Benutzernamen bereinigen
        $passAlt = trim($_POST['passA']); // Altes Passwort bereinigen
        $passNeu = trim($_POST['passN']); // Neues Passwort bereinigen
        $passNB = trim($_POST['passNB']); // Bestätigtes neues Passwort bereinigen
        
        // Abfrage, um den Benutzer in der Datenbank zu finden
        $statement = $conn->prepare("SELECT * FROM benutzer WHERE benutzername = :username"); 
        $statement->execute(array(':username' => $username)); 
        $benutzer = $statement->fetch();
    
        // Überprüfen, ob der Benutzer gefunden wurde und das alte Passwort korrekt ist
        if ($benutzer && password_verify($passAlt, $benutzer['passwort'])){ 
            // Überprüfen, ob das neue Passwort mit der Bestätigung übereinstimmt
            if ($passNeu === $passNB){
                // Neues Passwort hashen und in der Datenbank speichern
                $passHash = password_hash($passNeu, PASSWORD_DEFAULT); 
                $sqlUpdate = "UPDATE benutzer SET passwort = :passHash WHERE benutzername = :username"; 
                $stmt = $conn->prepare($sqlUpdate);
                $stmt->execute([':passHash' => $passHash, ':username' => $username]);
                echo "Passwort wurde erfolgreich geändert!"; // Erfolgsmeldung ausgeben
            } else {
                echo "<div class='error'>";
                echo($error); // Fehlermeldung bei nicht übereinstimmenden Passwörtern
                echo "</div>";
            }
        } else {
            echo "<div class='error'>";
            echo($error); // Fehlermeldung bei falschem alten Passwort oder nicht vorhandenem Benutzer
            echo "</div>";
        }
    } else {
        echo "Das neue Passwort muss eine Zeichenlänge von 8 haben."; // Fehlermeldung bei zu kurzem neuen Passwort
    }
}
echo "</div>";
?>
<?php include ('inc/footer.php') ?> <!-- Einbinden der Fußzeile -->
</body>
</html>
