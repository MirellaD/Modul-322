
<?php session_start();?>

<div class="navbar">
    <div class="nav-left"><img src="./Bilder/bookshelf.svg" alt="logo">
    <a href="index.php">ONLINE ANTIQUARIAT</a> <?php 
    if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
    print("Admin");
    } ?> </div>

    <div class = "nav-right">
    <a href="index.php">Home</a>
    <a href="buecher.php">Bücher</a>
    <a href="kontakt.php">Kontakt</a>
    <a href="passwort.php">Passwort</a>
    
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
        echo "<a href='kunden.php'>Kunden</a>";
        echo"<div class='dropdown'>";
            echo "<button id='login' type='button'>Logged-in</button>";
            echo "<div class='dropdown-menu' aria-labelledby='login'>";
                echo"<a class='dropdown-content' href='logout.php'>logout</a>";
                echo"<a class='dropdown-content' href='passwort.php'>Passwort</a>";
                echo"<a class='dropdown-content' href='benutzer.php'>neuer Benutzer</a>";
            echo"</div>";
        echo"</div>";
    } else {
        echo "<button id='login' onclick="."window.location.href='login.php'".">Login</button>"; 
    } 

    //echo $_SESSION['loggedin'];

    ?>
    </div>
</div>