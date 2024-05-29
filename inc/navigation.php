<?php 
// Startet eine neue oder fortlaufende Session
session_start();
?>

<!-- Navigationsleiste -->
<div class="navbar">
    <div class="nav-left">
        <!-- Logo-Bild und Link zur Startseite -->
        <img src="./Bilder/bookshelf.svg" alt="logo">
        <a href="index.php">ONLINE ANTIQUARIAT</a> 
        <?php 
        // Überprüft, ob ein Administrator angemeldet ist
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
            // Wenn ja, zeigt "Admin" an
            print("Admin");
        } 
        ?> 
    </div>

    <div class="nav-right">
        <!-- Links zu verschiedenen Seiten der Website -->
        <a href="index.php">Home</a>
        <a href="buecher.php">Bücher</a>
        <a href="kontakt.php">Kontakt</a>
        
        <?php
        // Überprüft, ob ein Administrator angemeldet ist
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
            // Zeigt zusätzliche Links für Administratoren an
            echo "<a href='kunden.php'>Kunden</a>";

            // Dropdown-Menü für angemeldete Administratoren
            echo "<div class='dropdown'>";
                echo "<button id='login' onclick=showDrop() >Logged-in</button>";
                echo "<div id='dropMenu' class='dropdown-content'>";
                    echo "<a href='logout.php'>Logout</a>";
                    echo "<a href='passwort.php'>Passwort ändern</a>";
                    echo "<a href='benutzer.php'>Neuer Benutzer</a>";
                echo "</div>";
            echo "</div>";
        } 
        // Überprüft, ob ein Benutzer (kein Admin) angemeldet ist
        elseif (isset($_SESSION["loggedinBenutzer"]) && $_SESSION['loggedinBenutzer'] == true) {
            // Dropdown-Menü für angemeldete Benutzer
            echo "<div class='dropdown'>";
                echo "<button id='login' onclick=showDrop() >Logged-in</button>";
                echo "<div id='dropMenu' class='dropdown-content'>";
                    echo "<a href='logout.php'>Logout</a>";
                    echo "<a href='passwort.php'>Passwort ändern</a>";
                echo "</div>";
            echo "</div>";
        } 
        // Wenn niemand angemeldet ist
        else {
            // Zeigt den Login-Button an
            echo "<button id='login' onclick="."window.location.href='login.php'".">Login</button>"; 
        } 
        ?>
        
        <!-- JavaScript-Funktion zum Umschalten des Dropdown-Menüs -->
        <script>
            // Funktion zum Umschalten der Sichtbarkeit des Dropdown-Menüs
            function showDrop() {
                document.getElementById("dropMenu").classList.toggle("show");
            }
        </script>
    </div>
</div>
