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
    // Funktion, um Dropdown-Liste aus Datenbank abzurufen
    function getDropdownOptions($conn, $table, $column) {
        $query = $conn->prepare("SELECT $column FROM $table");
        $query->execute();
        $options = $query->fetchAll(PDO::FETCH_COLUMN);
        return $options;
    }

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

    echo '<a id="zuruck" href="buecher.php"> < zurück</a>';
        echo '<br>';
        echo '<div class="detailbild">';
        
        
        
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
            echo '<form action="    " method="post">';
            echo '<input type="hidden" name="id" value="'. $buchID .'">';
            echo '<button type="submit" name="updateButton">update</button>';
            echo '</form>';


            echo '<div class="buchdetail">';
            echo '<label>Beschreibung</label><br>';
            echo '<textarea id="editbuch" rows="5" cols="70">' . $buch['title'] . '</textarea>';

            echo '<br><br>';
            echo '<label>Autor</label><br>';
            echo '<input type="text" id="editbuch" value="' . $buch['autor'] . '"/>';

            echo '<br><br>';
            echo '<label>Kategorie</label><br>';
            $kategorieOptions = getDropdownOptions($conn, 'kategorien', 'kategorie');
            echo '<select name="katalog">';
            foreach ($kategorieOptions as $option) {
                echo '<option value="' . $option . '"' . ($option === $buch['kategorie'] ? ' selected' : '') . '>' . $option . '</option>';
            }
            echo '</select>';

            echo '<br><br>';
            echo '<label>Zustand</label><br>';
            $zustandOptions = getDropdownOptions($conn, 'zustaende', 'zustand');
            echo '<select name="zustand">';
            foreach ($zustandOptions as $option) {
                echo '<option value="' . $option . '"' . ($option === $buch['beschreibung'] ? ' selected' : '') . '>' . $option . '</option>';
            }
            echo '</select>';

            echo '<br><br>';
            echo '<label>Katalog</label><br>';
            echo '<input type="number" name="katalog" value="' . $buch['katalog'] . '">';

            echo '<br><br>';
            echo '<label>Nummer</label><br>';
            echo '<input type="number" name="nummer" value="' . $buch['nummer'] . '">';

            echo '<br><br>';
            echo '<label>Verkauft</label><br>';
            echo '<input type="checkbox" name="verkauft" value="1" ' . ($buch['verkauft'] ? 'checked' : '') . '>';

            echo '<br><br>';
            echo '<label>Verfasser</label><br>';
            echo '<select name="verfasser">';
            for ($i = 1; $i <= 6; $i++) {
                echo '<option value="' . $i . '"' . ($i == $buch['verfasser'] ? ' selected' : '') . '>' . $i . '</option>';
            }
            echo '</select>';

            echo '<br><br>';
            echo '<label>Bild</label><br>';
            echo '<input type="file" name="bild">';
            echo '<br><br>';

            echo '<label>Käufer</label><br>';
            echo '<input type="number" name="kaufer" value="' . $buch['kaufer'] . '">';
            echo '<div>';

            echo '<div>';
            echo '<div class="buchdetailTitel"><br>';
            echo '<label>Titel</label>';
            echo '<input type="text" id="editbuch" value="' . $buch['kurztitle'] . '"/>';
        
        }

        if ($buch && (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == false) || !isset($_SESSION["loggedin"])) {
            // Buchdetails anzeigen
            echo '<div class="buchdetailTitel">';
            
                echo '<h2>Titel: ' . $buch['kurztitle'] . '</h2>';
            echo '</div>';

            if ($buch['foto'] === "book.jpg"){
                echo '<img src="Bilder/book-cover.svg" alt="buchbild">';
            } else {
                echo '<img src="'. $buch['foto'] .'" alt="buchbild">';
            }
            echo '</div>';
            echo '<div class="buchdetail">';
            echo '<p><b>Beschreibung:</b> <br> ' . $buch['title'] . '</p>';
            echo '<p><b>Autor:</b> <br>' . $buch['autor'] . '</p>';
            echo '<p><b>Katalog:</b> <br> ' . $buch['katalog'] . '</p>';
            echo '<p><b>Zustand:</b> <br>' . $buch['beschreibung'] . '</p>';
            echo '<p><b>Kategorie:</b> <br>' . $buch['kategorie'] . '</p>';
            echo '</div>';
        }}
   
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $kurztitle = $_POST['kurztitle'];
        $autor = $_POST['autor'];
        $katalog = $_POST['katalog'];
        $beschreibung = $_POST['beschreibung'];
        $nummer = $_POST['nummer'];
        $verkauft = isset($_POST['verkauft']) ? 1 : 0; // Überprüfen, ob verkauft Checkbox ausgewählt ist
        $verfasser = $_POST['verfasser'];
        $zustand = $_POST['zustand'];
        // Hier müssten Sie den Bildupload-Teil einfügen und das Bild in den entsprechenden Ordner speichern
        $bild = $_FILES['bild']['name'];
        $bild_temp = $_FILES['bild']['tmp_name'];
        move_uploaded_file($bild_temp, "Bilder/$bild");
        $kaufer = $_POST['kaufer'];
        $kategorie = $_POST['kategorie'];

        $errors = [];

        // Validierung der Eingabefelder
        if (empty($kurztitle)) $errors[] = "Kurztitel ist erforderlich.";
        if (empty($autor)) $errors[] = "Autor ist erforderlich.";
        if (empty($nummer)) {
            $errors[] = "Nummer ist erforderlich.";
        } elseif (!is_numeric($nummer) || $nummer <= 0) {
            $errors[] = "Nummer muss eine positive Zahl sein.";
        }
        if (empty($katalog)) {
            $errors[] = "Katalog ist erforderlich.";
        } elseif (!is_numeric($katalog) || $katalog <= 0) {
            $errors[] = "Katalog muss eine positive Zahl sein.";
        }
        if ($kategorie === "default") $errors[] = "Kategorie ist erforderlich.";

        if (empty($errors)) {
            // SQL-Update-Statement vorbereiten und ausführen
            $sql = "UPDATE buecher SET kurztitle = :kurztitle, autor = :autor, katalog = :katalog, title = :beschreibung, nummer = :nummer, verkauft = :verkauft, verfasser = :verfasser, zustand = :zustand, foto = :bild, kaufer = :kaufer, kategorie = :kategorie WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':kurztitle', $kurztitle);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':katalog', $katalog);
            $stmt->bindParam(':beschreibung', $beschreibung);
            $stmt->bindParam(':nummer', $nummer);
            $stmt->bindParam(':verkauft', $verkauft);
            $stmt->bindParam(':verfasser', $verfasser);
            $stmt->bindParam(':zustand', $zustand);
            $stmt->bindParam(':bild', $bild);
            $stmt->bindParam(':kaufer', $kaufer);
            $stmt->bindParam(':kategorie', $kategorie);

            if ($stmt->execute()) {
                echo 'Buch erfolgreich geändert!';
            } else {
                echo 'Fehler beim Aktualisieren des Buches.';
            }
        } else {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
    }

    

    ?>

<?php include('inc/footer.php') ?>

</body>

</html>
