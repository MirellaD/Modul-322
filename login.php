
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php include ('inc/navigation.php') ?>
<?php include ('inc/inc.php');?>

<h2>Log in</h2>
<p>Loggen Sie sich ein, indem Sie Ihren Benutzernamen und Ihr Passwort eingeben.</p>
<div class="login">
<form action="login.php" method="post"> 
    <label for="username">Benutzername:</label><br>
    <input type="text" id="username" name="username" required/><br><br>
    <label for="password">Passwort:</label><br>
    <input type="password" id="password" name="password" required/><br><br>
    <input id="logbutton" name="login" type="submit" value="Log in">
</form>
</div>
<?php
if(isset($_POST['username']) && isset($_POST['password'])){ 
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $statement = $conn->prepare("SELECT * FROM `benutzer` WHERE `Benutzername` = :username"); 
    $statement->execute(array(':username' => $username)); 
    $benutzer = $statement->fetch();
    
    if ($benutzer && password_verify($password, $benutzer['passwort'])){ 
        if ($benutzer['admin'] === 1){
            $_SESSION['username'] = $benutzer['Benutzername'];
            $_SESSION['loggedin'] = true;
            header('Location: index.php');
            exit;
        }else{
            $_SESSION['username'] = $benutzer['Benutzername'];
            $_SESSION['loggedinBenutzer'] = true;
            header('Location: index.php');
            exit;
        }
    } else{
        echo "<div class='error'>";
        $error = "Das Passwort oder der Benutzername ist ungültig.";
        echo($error);
        echo "</div>";
        $_SESSION['loggedin'] = false;
        session_destroy();
    }
}
?>
<?php include ('inc/footer.php')?>
</body>
</html>
