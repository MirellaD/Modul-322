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
        
        // Überprüfen, ob ein Buch gefunden wurde
        if ($buch === false) {
            echo "<p class='error'>Buch nicht gefunden.</p>";
        } else {
            echo '<a id="zuruck" href="buecher.php"> < zurück</a>';
            echo '<br><br>';
        
        
        //Wenn man als admin angemeldet ist, dann...
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
            echo '<form action="buchdetail.php" method="post" enctype="multipart/form-data">';
            //update button mit der id versteckt des buches
            echo '<input type="hidden" name="id" value="'. $buch['id'] .'">';
            echo '<button type="submit" class="delitus" name="updateButton">update</button>';
            //Alle Daten inform von inputs ausprinten, mit den aktuellen in der Datenbank eingetragenen Daten
            echo '<div class="buchdetailTitel"><br>';
            echo '<label>Titel</label>';
            echo '<input type="text" id="editbuch" name="kurztitle" value="' . $buch['kurztitle'] . '"/>';
            echo '</div>';
            echo '<br>';
            echo '<div class="buchundbes">';

            //ausprinten vom Buchbild
            echo '<div class="detailbild">';
            if ($buch['foto'] === "book.jpg"){
                echo '<img src="Bilder/book-cover.svg" alt="buchbild">';
            } else {
                echo '<img src="'. $buch['foto'] .'" alt="buchbild">';
            }
            echo '</div>';


            echo '<div class="buchdetail">';
            echo '<label>Beschreibung</label><br>';
            echo '<textarea id="editbuch" name="beschreibung" rows="5" cols="70">' . $buch['title'] . '</textarea>';

            echo '<br><br>';
            echo '<label>Autor</label><br>';
            echo '<input type="text" id="editbuch" name="autor" value="' . $buch['autor'] . '"/>';

            echo '<br><br>';
            //Benutzt die oben erstellte funktion und übergibt dieser die Werte der kollone und der tabelle, welche man in der dropdown braucht
            echo '<label>Kategorie</label><br>';
            $kategorieOptions = getDropdownOptions($conn, 'kategorien', 'kategorie');
            echo '<select name="kategorie">';
            //alle optionen des dropdown werden erstellt, die welche in der Datenbank ist wird ausgewählt
            foreach ($kategorieOptions as $option) {
                echo '<option name="kategorie" value="' . $option . '"' . ($option === $buch['kategorie'] ? ' selected' : '') . '>' . $option . '</option>';
            }
            echo '</select>';

            //gleich wie bei kategorie
            echo '<br><br>';
            echo '<label>Zustand</label><br>';
            $zustandOptions = getDropdownOptions($conn, 'zustaende', 'zustand');
            echo '<select name="zustand">';
            foreach ($zustandOptions as $option) {
                echo '<option name="zustand" value="' . $option . '"' . ($option === $buch['beschreibung'] ? ' selected' : '') . '>' . $option . '</option>';
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
            //schaut, ob der wert von verkauft in der Datenbank 1 ist, falls ja wird die Checkbox gecheckt
            echo '<input type="checkbox" name="verkauft" value="1" ' . ($buch['verkauft'] ? 'checked' : '') . '>';

            echo '<br><br>';
            echo '<label>Verfasser</label><br>';
            echo '<select name="verfasser">';
            //nur 6 verfasser gibt es, daher eine for schleife für alle dropdown punkte
            for ($i = 1; $i <= 6; $i++) {
                //$i wird mit den Datenbankdaten verglichen und das was in der datenbank steht wird bei dem dropdown ausgewählt
                echo '<option name="verfasser" value="' . $i . '"' . ($i == $buch['verfasser'] ? ' selected' : '') . '>' . $i . '</option>';
            }
            echo '</select>';

            echo '<br><br>';
            echo '<label>Bild</label><br>';
            echo '<input type="file" name="bild">';
            echo '<br><br>';

            echo '<label>Käufer</label><br>';
            echo '<input type="number" name="kaufer" value="' . $buch['kaufer'] . '">';
            echo '<div>';
            echo '</div>';
            
            echo '</form>';
        }

        //Buchdetails für Benutzer und nicht angemeldete
        if ($buch && (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == false) || !isset($_SESSION["loggedin"])) {
            // Buchdetails anzeigen
            echo '<div class="buchdetailTitel">';
                echo '<h2>Titel: ' . $buch['kurztitle'] . '</h2>';
            echo '</div>';

        echo '<div class="buchundbes">';
        //Foto des Buches
            echo '<div class="detailbild">';
            if ($buch['foto'] === "book.jpg"){
                echo '<img src="Bilder/book-cover.svg" alt="buchbild">';
            } else {
                echo '<img src="'. $buch['foto'] .'" alt="buchbild">';
            }
            echo '</div>';

            //Nimmt die zur id gefetchten daten und printet sie aus
            echo '<div class="buchdetail">';
            echo '<p><b>Beschreibung:</b> <br> ' . $buch['title'] . '</p>';
            echo '<p><b>Autor:</b> <br>' . $buch['autor'] . '</p>';
            echo '<p><b>Katalog:</b> <br> ' . $buch['katalog'] . '</p>';
            echo '<p><b>Zustand:</b> <br>' . $buch['beschreibung'] . '</p>';
            echo '<p><b>Kategorie:</b> <br>' . $buch['kategorie'] . '</p>';
            echo '</div>';
        echo '</div>';
        }}
   
    //wenn der update Button gedrückt wird
    if (isset($_POST['updateButton'])) {
        //prüfen ob alles gesetzt wurde
        $id = $_POST['id'];
        $kurztitle = $_POST['kurztitle'];
        $autor = $_POST['autor'];
        $katalog = $_POST['katalog'];
        $beschreibung = $_POST['beschreibung'];
        $nummer = $_POST['nummer'];
        $verkauft = isset($_POST['verkauft']) ? 1 : 0; // Überprüfen, ob verkauft Checkbox ausgewählt ist
        $verfasser = $_POST['verfasser'];
        $zustand = $_POST['zustand'];
        $bild = $_POST['bild'];
        $kaufer = $_POST['kaufer'];
        $kategorie = $_POST['kategorie'];

        if (isset($_POST['bild'])){
            $bild = $_POST['bild'];
        } else {
            $bild = "book.jpg";
        }

        /*$bild = $_FILES['bild']['name'] == "" ? "book.jpg" : $_FILES['bild']['name'];
        if ($bild != "book.jpg") {
            $bild_temp = $_FILES['bild']['tmp_name'];
            move_uploaded_file($bild_temp, "Bilder/$bild");
        }*/
        
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

        //wenn es keine errors gibt (0) dann if durchführen
        if (count($errors) === 0) {
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
                //echo "Error: " . $e->getMessage();

            } else {
                echo 'Fehler beim Aktualisieren des Buches.';
                //echo "Error: " . $e->getMessage();

            }
        } else {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
    }
    }
    

    ?>

<?php include('inc/footer.php') ?>

</body>

</html>
