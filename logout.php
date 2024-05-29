<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Zeichensatz der Seite auf UTF-8 setzen -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsives Design ermöglichen -->
    <title>Logout</title> <!-- Titel der Seite -->
</head>
<body>
<?php include ('inc/navigation.php') ?> <!-- Einbinden der Navigationsleiste -->
<?php include ('inc/inc.php');?> <!-- Einbinden weiterer benötigter PHP-Dateien, vermutlich für Datenbankverbindung oder Utility-Funktionen -->
<?php 
    session_destroy(); // Zerstören der aktuellen Sitzung, um den Benutzer auszuloggen
    header('Location: login.php'); // Umleiten zur Login-Seite
    exit; // Sicherstellen, dass kein weiterer Code ausgeführt wird
?>

<?php include ('inc/footer.php')?> <!-- Einbinden der Fußzeile -->
</body>
</html> 
