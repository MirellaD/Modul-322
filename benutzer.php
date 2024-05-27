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
<div id="userflex">
    <div id="newUser">
        <h2>Benutzer hinzufügen</h2>
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
    if(isset($_POST['newUser'])){ 
        if ((trim($_POST['pass']))===(trim($_POST['passB']))){
        $gleichPass = true;
    }else{
        $gleichPass = false;
        echo"Eingegebene Passwörter stimmen nicht überein";
        exit;
    }

        if(strlen(trim($_POST['pass'])) >= 8 && $gleichPass = true){
            $username = htmlspecialchars(trim($_POST['username']));
            $name = htmlspecialchars(trim($_POST['name']));
            $vorname= htmlspecialchars(trim($_POST['vorname']));
            $pass = trim($_POST['pass']);
            $mail = trim($_POST['email']);
            $admin = isset($_POST['istadmin']);
            $sql = "INSERT INTO benutzer (benutzername, name, vorname, passwort, email, admin) 
            VALUES ('$username', '$name', '$vorname', '$pass', '$mail', $admin)";

            if(isset($username) && isset($pass)){
                $statement = $conn->prepare($sql);
                $statement->execute();
                echo "neuer Benutzer wurde hinzugefügt";
            }
        }
        else{
            echo "Passwort muss min. 8 Zeichen lang sein";
            exit;
        }
    }else{
        exit;
    }
?>

    <?php include ('inc/footer.php')?>        
</body>
</html>