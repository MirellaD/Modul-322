<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"> <!-- Verknüpfung mit einer CSS-Datei zur Stilgestaltung -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php include ('inc/navigation.php') ?> <!-- Einbinden der Navigationsleiste -->
<?php include ('inc/inc.php');?> <!-- Einbinden weiterer benötigter PHP-Dateien, vermutlich für Datenbankverbindung oder Utility-Funktionen -->
<div class="loginpage">
    <div class="login">
    <h2>Log in</h2>
    <p>Loggen Sie sich ein, indem Sie Ihren Benutzernamen und Ihr Passwort eingeben.</p>
    <form action="login.php" method="post"> 
        <label for="username">Benutzername:</label><br>
        <input type="text" id="username" name="username" required/><br><br> <!-- Eingabefeld für den Benutzernamen -->
        <label for="password">Passwort:</label><br>
        <input type="password" id="password" name="password" required/><br><br> <!-- Eingabefeld für das Passwort -->
        <input id="logbutton" name="login" type="submit" value="Log in"> <!-- Absende-Button für das Formular -->
    </form>
    </div>
</div>
<?php
if(isset($_POST['username']) && isset($_POST['password'])){ 
    // Prüfen, ob Benutzername und Passwort gesendet wurden
    $username = htmlspecialchars(trim($_POST['username'])); // Bereinigen und Trim des Benutzernamens
    $password = trim($_POST['password']); // Trim des Passworts
    $statement = $conn->prepare("SELECT * FROM `benutzer` WHERE `benutzername` = :username"); 
    // Vorbereitung der SQL-Anweisung zur sicheren Abfrage der Benutzerdaten
    $statement->execute(array(':username' => $username)); 
    // Ausführen der Abfrage mit dem bereinigten Benutzernamen
    $benutzer = $statement->fetch(); 
    // Abrufen der Benutzerdaten

    if ($benutzer && password_verify($password, $benutzer['passwort'])){ 
        // Überprüfen, ob der Benutzer existiert und das Passwort korrekt ist
        if ($benutzer['admin'] === 1){
            // Falls der Benutzer ein Admin ist
            $_SESSION['username'] = $benutzer['Benutzername'];
            $_SESSION['loggedin'] = true;
            header('Location: index.php');
            // Umleiten zur Startseite
            exit;
        }else{
            // Falls der Benutzer ein normaler Benutzer ist
            $_SESSION['username'] = $benutzer['Benutzername'];
            $_SESSION['loggedinBenutzer'] = true;
            header('Location: index.php');
            // Umleiten zur Startseite
            exit;
        }
    } else{
        // Wenn das Passwort oder der Benutzername falsch ist
        echo "<div class='error'>";
        $error = "Das Passwort oder der Benutzername ist ungültig.";
        echo($error); // Fehlermeldung anzeigen
        echo "</div>";
        $_SESSION['loggedin'] = false;
        session_destroy(); // Sitzung zerstören
    }
}
?>
<?php include ('inc/footer.php')?> <!-- Einbinden der Fußzeile -->
</body>
</html>
