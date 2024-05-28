<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" type="text/css" href="static/fonts/Montserrat/fonts/webfonts/Montserrat-Alt1.css">
    <title>Buchdetails</title>

</head>

<body>
    <?php include('inc/navigation.php');
     include('inc/inc.php'); ?>

    <?php

    // Sicherstellen, dass die Buch-ID gesetzt ist
    if (isset($_GET['id'])) {
        $buchID = $_GET['id'];
        //mysql abfrage vorbereiten und ausführen
        $buchQuery = $conn->prepare("SELECT * FROM buecher, kategorien, zustaende
        WHERE buecher.zustand = zustaende.zustand AND 
        buecher.kategorie = kategorien.id AND buecher.id = :id");
        $buchQuery->bindParam(':id', $buchID, PDO::PARAM_INT);
        $buchQuery->execute();
        $buch = $buchQuery->fetch(PDO::FETCH_ASSOC);


        echo '<br>';
        echo '<div class="detailbild">';
        echo '<a id="zuruck" href="buecher.php"> < zurück</a>';
        if ($buch['foto'] === "book.jpg"){
            echo '<img src="Bilder/book-cover.svg" alt="buchbild">';
        } else {
            echo '<img src="'. $buch['foto'] .'" alt="buchbild">';
        }
        echo '</div>';
        
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
            echo '<form action="buchdetail.php" method="post">';
            echo '<input type="hidden" name="id" value="'. $buchID .'">';
            echo '<button type="submit">update</button>';
            echo '</form>';
        }

        if ($buch) {
            // Buchdetails anzeigen
            echo '<div class="buchdetail">';
            echo '<p><b>Beschreibung:</b> <br> ' . $buch['title'] . '</p>';
            echo '<p><b>Autor:</b> <br>' . $buch['autor'] . '</p>';
            echo '<p><b>Katalog:</b> <br> ' . $buch['katalog'] . '</p>';
            echo '<p><b>Zustand:</b> <br>' . $buch['beschreibung'] . '</p>';
            echo '<p><b>Kategorie:</b> <br>' . $buch['kategorie'] . '</p>';
            echo '</div>';
            echo '<div class="buchdetailTitel">';
            echo '<h2>Titel: ' . $buch['kurztitle'] . '</h2>';
            echo '</div>';
    
            // Update-Formular nur anzeigen, wenn eingeloggt 
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo '<form action="update_buch.php" method="post" class="buchdetail">';
            echo '<input type="hidden" name="id" value="' . $buchID . '">';
            echo '<label>Kurztitel:</label>';
            echo '<input type="text" name="kurztitle" value="' . htmlspecialchars($buch['kurztitle']) . '">';
            echo '<label>Autor:</label>';
            echo '<input type="text" name="autor" value="' . htmlspecialchars($buch['autor']) . '">';
            echo '<label>Beschreibung:</label>';
            echo ' <textarea id="beschreibung" name="beschreibung" rows="4" cols="50">'. htmlspecialchars($buch['title']).'</textarea>';
            echo '<label>Nummer:</label>';
            echo '<input type="number" name="nummer" id="nummer" min="0" value="'. htmlspecialchars($buch['nummer']) .'">';
            echo '<label>Bild:</label>';
            echo '<input type="file" name="bookimage" />';
            echo '<label>Katalog:</label>';
            echo '<input type="number" name="katalog" id="katalog" min="0" value="'. htmlspecialchars($buch['katalog']) .'">';
            echo '<input type="submit" value="Update">';
            echo '</form>';
            }
        }
    }


    ?>

<?php include('inc/footer.php') ?>

</body>

</html>
