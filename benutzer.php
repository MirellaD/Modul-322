<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer</title>
    <link rel="stylesheet" href="style.css">
</head>
</head>
<body>
    <?php 
    include('inc/navigation.php');  
    include('inc/inc.php'); 
    ?>
    <div id="newUser">
        <h2>Neuer Benutzer</h2>
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
            <input type="checkbox" id="istadmin" name="istadmin"><br><br>
            <input id="logbutton" name="newUser" type="submit" value="Neuer Benutzer">
        </form>
</div>
    <?php include ('inc/footer.php')?>        
</body>
</html>