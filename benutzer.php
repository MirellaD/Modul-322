<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
// Einbinden der Navigationsleiste und anderer benötigter Dateien
include('inc/navigation.php');  
include('inc/inc.php'); 
?>

<div id="userflex">
    <div id="newUser">
        <h2>Benutzer hinzufügen</h2>
        <!-- Formular zum Hinzufügen eines neuen Benutzers -->
        <form action="benutzer.php" method="post"> 
            <label for="username">Benutzername: *</label><br>
            <input type="text" id="username" name="username" required/><br><br>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" /><br><br>
            <label for="vorname">Vorname:</label><br>
            <input type="text" id="vorname" name="vorname"/><br><br>
            <label for="passN">Passwort: *</label><br>
            <input type="password" id="pass" name="pass" required/><br><br>
            <label for="passNB">Passwort bestätigen: *</label><br>
            <input type="password" id="passB" name="passB" required/><br><br>
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"/><br><br>
            <label for="istadmin">Admin?:</label>
            <input type="checkbox" id="istadmin" name="istadmin" value="1"><br><br>
            <input id="logbutton" name="newUser" type="submit" value="Neuer Benutzer"> <br><br>
        </form>
    </div>
</div>

<?php 
// Überprüft, ob das Formular abgesendet wurde
if(isset($_POST['newUser'])){ 

    // Array zum Speichern von Fehlern
    $errors = [];
    
    // Abfrage aller bestehenden Benutzernamen aus der Datenbank
    $statement = $conn->prepare("SELECT `benutzername` FROM `benutzer`");  
    $statement->execute();
    $existierendeNamen = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Überprüfung der Eingabedaten
    if (trim($_POST['pass']) !== trim($_POST['passB'])) $errors[] = "Eingegebene Passwörter stimmen nicht überein.";
    if (strlen(trim($_POST['pass'])) < 8) $errors[] = "Passwort muss mindestens 8 Zeichen lang sein.";
    if (empty($_POST['username'])) $errors[] = "Benutzername erforderlich.";
    if (empty($_POST['pass'])) $errors[] = "Passwort erforderlich.";
    if (strlen(trim($_POST['username'])) > 45) $errors[] = "Benutzername darf maximal 45 Zeichen lang sein.";
    if (in_array($_POST['username'], $existierendeNamen)) {
        $errors[] = "Benutzername existiert bereits, bitte wählen Sie einen anderen Benutzernamen.";
    }

    // Wenn keine Fehler vorliegen, Benutzer in die Datenbank einfügen
    if (is_countable($errors) && count($errors) === 0){
        // Bereinigung der Eingabedaten
        $username = htmlspecialchars(trim($_POST['username']));
        $name = htmlspecialchars(trim($_POST['name']));
        $vorname= htmlspecialchars(trim($_POST['vorname']));
        $pass = trim($_POST['pass']);
        $mail = trim($_POST['email']);
        $admin = isset($_POST['istadmin']);
        $hashP = password_hash($pass, PASSWORD_DEFAULT);

        // Vorbereitung und Ausführung des SQL-Statements zum Einfügen eines neuen Benutzers
        $stmt = $conn->prepare("INSERT INTO benutzer (benutzername, name, vorname, passwort, email, admin) VALUES (?,?,?,?,?,?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $vorname);
        $stmt->bindParam(4, $hashP);
        $stmt->bindParam(5, $mail);
        $stmt->bindParam(6, $admin);

        // Erfolgsmeldung oder Fehlermeldung anzeigen
        if ($stmt->execute()) {
            echo "Neuer Benutzer wurde hinzugefügt";
        } else {
            echo "Fehler beim Hinzufügen des Benutzers";
        }
    } else {
        // Ausgabe der Fehler
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}
?>

<!-- Einbindung der Fußzeile -->
<?php include ('inc/footer.php')?>        
</body>
</html>
