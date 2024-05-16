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

    <br>
    <div class='detailbild'>
    <a id="zuruck" href="buecher.php"> < zurück</a>
    <img src="Bilder/book-cover.svg" alt="buchbild">
    </div>
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

        // Wenn das Buch gefunden wurde, zeige die Details an
        if ($buch) {
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
        }
    }
    ?>

    <?php include('inc/footer.php') ?>

</body>

</html>