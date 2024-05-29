<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buecher</title>

    <script>
        // Funktion zum öffnen des Popup-Fensters
        function openPopup() {
            document.getElementById('popup').style.display = 'block';

        }

        // Funktion zum Schliessen des Popup-Fensters
        function closePopup() {
            document.getElementById('popup').style.display = 'none';

        }

        function openHinzufuegen() {
            document.getElementById('hinzufuegenPop').style.display = 'block';

        }

        function closeHinzufuegen() {
            document.getElementById('hinzufuegenPop').style.display = 'none';

        }

        // JavaScript-Funktion zum Aktualisieren der Sortierreihenfolge (ohne submit button, sondern bei wählen/klicken)
        function updateSortOrder() {
            // erstellt eine variable sort_order und weist dieser das value des elementes, welches er durch die ID erhält
            var sort_order = document.getElementById("sortieren").value;
            // Weiterleitung an die aktuelle Seite mit dem Sortierparameter
            window.location.href = window.location.pathname + "?sort=" + sort_order;
        }
            //nachfolgende 4 funktionen haben das gleiche prinzip, wie die vorherige
        function updateZustand() {
            var zustandU = document.getElementById("zustaende").value;
            window.location.href = window.location.pathname + "?zustand=" + zustandU;
        }

        function updateKategorien() {
            var kategorieU = document.getElementById("kategorien").value;
            window.location.href = window.location.pathname + "?kategorie=" + kategorieU;
        }

        function updateVerfasser() {
            var verfasserU = document.getElementById("verfas").value;
            window.location.href = window.location.pathname + "?verfasser=" + verfasserU;
        }
        function searchResultat() {
            var search = document.getElementById("searchbar").value; // Abrufen des Suchbegriffs
            window.location.href = window.location.pathname + "?search=" + search;
        }

        

    </script>
</head>

<body>
    <?php 
    include('inc/navigation.php');  
    include('inc/inc.php'); 
    ?>
        <!--beim wählen einer option in der dropdownliste wird durch das ""onchange" die javascript funktion ""updateSortOrder" aufgerufen-->
<div class="divbtns">
        <select name="sortieren" class="btns" id="sortieren" onchange="updateSortOrder()">
            <option value="default">Sortieren</option>
            <option value="titelAZ">Titel(A-Z)</option>
            <option value="titelZA">Titel(Z-A)</option>
            <option value="autorAZ">Autor(A-Z)</option>
            <option value="autorZA">Autor(Z-A)</option>
        </select>

        <select name="zustaende" class="btns" id="zustaende" onchange="updateZustand()">
            <option value="default">Zustand</option>
            <option value="G">Gut</option>
            <option value="M">Mittel</option>
            <option value="S">Schlecht</option>
        </select>
        
        <!-- Button zum Oeffnen des Popup-Fensters (ruft die javascript funktion openPopup() auf)-->
        <button class="btns" id="popbutton" onclick="openPopup()">Alle Filter</button>
            <!-- Das Popup-Fenster -->
            <div id="popup" class="popup">
                <h2>Alle Filter</h2>

                <select name="kategorien" id="kategorien" onchange="updateKategorien()">
                    <option value="default">kategorien</option>
                    <option value="1">Alte Drucke, Bibeln, Klassische Autoren</option>
                    <option value="2">Geographie und Reisen</option>
                    <option value="3">Geschichtswissenschaften</option>
                    <option value="4">Naturwissenschaften</option>
                    <option value="5">Kinderbücher</option>
                    <option value="6">Moderne Literatur und Kunst</option>
                    <option value="7">Moderne Kunst und Künstlergraphik</option>
                    <option value="8">Kunstwissenschaften</option>
                    <option value="9">Architektur</option>
                    <option value="10">Technik</option>
                    <option value="11">Naturwissenschaften - Medizin</option>
                    <option value="12">Ozeanien</option>
                    <option value="13">Afrika</option>
                </select>
                <br>
                <select name="verfas" id="verfas" onchange="updateVerfasser()">
                    <option value="default">Verfasser</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <br>
                <div class="allFilter">
                    <!--löst beim klicken des buttons die javascript funktion closePopup() aus und schliesst das Popup-->
                    <input type="button" name="schliessen" onclick="closePopup()" value="Schliessen">
                </div>

            </div>

            <div>
                <!--onkeypress löst bei Enter (der keycode für Enter ist 13) drücken die javascript funktion aus-->
                    <input id="searchbar" class="btns" type="search" placeholder="Buch oder Autor suchen..." onkeypress="if(event.keyCode === 13) searchResultat();">
            </div>
            <br>

</div>
        <?php 
        if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) { ?>
            <button class="loner"  id="popbutton" onclick="openHinzufuegen()">Hinzufügen</button>
            <div id="hinzufuegenPop" class="popup">
            <h2>Buch hinzufügen</h2>

            <form action="buecher.php" method="post">
            <label for="kurztitel">Titel*:</label>
            <input type="text" name="kurztitel" id="kurztitel" required>
            <br>
            <label for="autor">Autor*:</label>
            <input type="text" name="autor" id="autor" required>
            <br>
            <label for="beschreibung">Beschreibung:</label>
            <textarea id="beschreibung" name="beschreibung" rows="4" cols="50"></textarea>
            <br>
            <label for="nummer">Nummer*:</label>
            <input type="number" name="nummer" id="nummer" min="0" required>
            <br>
            <label for="bookimage">Bild des Buches hochladen:</label>
            <input type="file" name="bookimage" />
            <br>
            <label for="katalog">Katalog*:</label>
            <input type="number" name="katalog" id="katalog" min="0" required>
            <br>
            <label for="kategorieInsert">Kategorie*:</label>
            <select name="kategorieInsert" id="kategorieInsert" required>
            <option value="default">kategorien</option>
            <option value="1">Alte Drucke, Bibeln, Klassische Autoren</option>
            <option value="2">Geographie und Reisen</option>
            <option value="3">Geschichtswissenschaften</option>
            <option value="4">Naturwissenschaften</option>
            <option value="5">Kinderbücher</option>
            <option value="6">Moderne Literatur und Kunst</option>
            <option value="7">Moderne Kunst und Künstlergraphik</option>
            <option value="8">Kunstwissenschaften</option>
            <option value="9">Architektur</option>
            <option value="10">Technik</option>
            <option value="11">Naturwissenschaften - Medizin</option>
            <option value="12">Ozeanien</option>
            <option value="13">Afrika</option>
        </select>
        <br>
        <label for="verfasInsert">Verfasser:</label>
        <select name="verfasInsert" id="verfasInsert">
            <option value="default">Verfasser</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
        <br>
        <label for="zustandInsert">Zustand:</label>
        <select name="zustandInsert" id="zustandInsert">
        <option value="default">Zustand</option>
        <option value="G">Gut</option>
        <option value="M">Mittel</option>
        <option value="S">Schlecht</option>
        </select>
        <br>
        <div class="allFilter">
            <input type="submit" name="submitBook" value="Buch hinzufügen">
            </form>
            <!--löst beim klicken des buttons die javascript funktion closePopup() aus und schliesst das Popup-->
            <input type="button" name="schliessen" onclick="closeHinzufuegen()" value="Schliessen">
        </div>
    </div>

<?php } ?>

        <?php

        // Standard Sortierreihenfolge
        $kollone = 'id';
        $orderSort = 'ASC';

        // Es wird überprüft, ob Sortieroption ausgewählt wurde und dann die Variabeln dementsprechend geändert
        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'titelAZ':
                    $kollone = 'kurztitle';
                    $orderSort = 'ASC';
                    break;
                case 'titelZA':
                    $kollone = 'kurztitle';
                    $orderSort = 'DESC';
                    break;
                case 'autorAZ':
                    $kollone = 'autor';
                    $orderSort = 'ASC';
                    break;
                case 'autorZA':
                    $kollone = 'autor';
                    $orderSort = 'DESC';
                    break;
                case 'default':
                    // Standard Sortierreihenfolge
                    $kollone = 'id';
                    $orderSort = 'ASC';
                    break;
            }
        }
        
        //alle Filter und Suchfunktionen im 'deafult' modus -> machen nichts/sind leer
        $zustandFilter = '';
        $kategorie = '';
        $verfasser = '';
        $searchTA = '';
        $searchHome = '';

        // Hier werden die einzelnen möglichen Filter geprüft und gesetzt (nehmen ihren Wert aus der URL -> GET)
        if (isset($_GET['zustand'])) {
            $zustandFilter = 'WHERE zustand = "' . $_GET['zustand'] . '"';
        }
        if (isset($_GET['kategorie'])) {
            $kategorie = 'WHERE kategorie = "' . $_GET['kategorie'] . '"';
        }
        if (isset($_GET['verfasser'])) {
            $verfasser = 'WHERE verfasser = "' . $_GET['verfasser'] . '"';
        }
        if (isset($_GET['search'])) {
            $search = htmlspecialchars(trim($_GET['search']));
            $searchTA = 'WHERE kurztitle LIKE "%' . $search . '%" OR autor LIKE "%' . $search . '%"';
        }
        
        /* Hier wird die suchfunktion von der homeseite gefiltert, dadurch das man nach 1-2 dingen filtern kann
        werden die erhaltenen Werte in ein array gespeichert und schliesslich geschaut, ob dieses leer ist, wenn
        nicht wird bei einem Filter normal mit where gesucht, bei zwei wird ein AND dazwischen hinzugefügt und dann gefiltert */
        if (isset($_GET['autor']) || isset($_GET['titel'])) {
            $searchbeides = array();

            if (isset($_GET['autor'])) {
                $searchAutor = htmlspecialchars(trim($_GET['autor']));
                $searchbeides[] = 'autor LIKE "%' . $searchAutor . '%"';
            }

            if (isset($_GET['titel'])) {
                $searchTitel = htmlspecialchars(trim($_GET['titel']));
                $searchbeides[] = 'kurztitle LIKE "%' . $searchTitel . '%"';
            }

            $searchHome = '';
            if (!empty($searchbeides)) {
                $searchHome = 'WHERE ' . implode(' AND ', $searchbeides);
            }
        }


        // Funktion, um die Dateierweiterung zu überprüfen
        function checkFileExtension($ext) {
            return in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
        }

        // Überprüfen, ob das Formular zum Hinzufügen eines Buchs abgesendet wurde
        if (isset($_POST['submitBook'])) {
            
            // Formulardaten abrufen und bereinigen
            $kurztitel = trim($_POST['kurztitel']);
            $autor = trim($_POST['autor']);
            $beschreibung = trim($_POST['beschreibung']);
            $nummer = trim($_POST['nummer']);
            $katalog = trim($_POST['katalog']);
            $kategorieInsert = trim($_POST['kategorieInsert']);
            $verfasInsert = trim($_POST['verfasInsert']);
            $zustandInsert = trim($_POST['zustandInsert']);

            // Fehlerarray initialisieren
            $errors = [];
            
            // Erforderliche Felder überprüfen
            if (empty($kurztitel)) $errors[] = "Kurztitel ist erforderlich.";
            if (trim(strlen($kurztitel)) > 100) $errors[] = "Der Titel darf maximal 100 Zeichen lang sein.";
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
            if ($kategorieInsert === "default") $errors[] = "Kategorie ist erforderlich.";

            // Standard-Bild-Dateiname festlegen
            $fileNameComplete = "book.jpg";

            // Überprüfen, ob eine Datei hochgeladen wurde und ob keine Fehler beim Hochladen aufgetreten sind
            if (isset($_FILES["bookimage"]) && $_FILES["bookimage"]["error"] === UPLOAD_ERR_OK) {

                // Dateierweiterung überprüfen
                $ext = pathinfo($_FILES['bookimage']['name'], PATHINFO_EXTENSION);
                $fileAccepted = checkFileExtension($ext);

                // Wenn die Dateierweiterung gültig ist
                if ($fileAccepted) {
                    $uploadFileName = $_FILES['bookimage']['name'];
                    $fileName = strtok($uploadFileName, ".");
                    $fileNameShortened = substr($fileName, 0, 20);
                    $fileNameFinalized = str_replace(' ', '_', $fileNameShortened);
                    $fileNameComplete = $fileNameFinalized . '.' . $ext;
                    $dest = __DIR__ . 'Bilder/' . $fileNameComplete;

                } else {
                    // Fehler bei ungültigem Dateiformat
                    $errors[] = "Falsches Dateiformat";
                }
            }

            // Überprüfen, ob Fehler aufgetreten sind
            if (is_countable($errors) && count($errors) === 0) {
                // Keine Fehler, daher Buch in die Datenbank einfügen

                // SQL-Anweisung vorbereiten und Buchdaten einfügen
                $stmt = $conn->prepare("INSERT INTO buecher (kurztitle, autor, title, nummer, katalog, kategorie, verfasser, zustand, foto)
                                        VALUES (:kurztitel, :autor, :beschreibung, :nummer, :katalog, :kategorieInsert, :verfasInsert, :zustandInsert, :bild)");
                
                // Parameter binden
                $stmt->bindParam(':kurztitel', $kurztitel);
                $stmt->bindParam(':autor', $autor);
                $stmt->bindParam(':beschreibung', $beschreibung);
                $stmt->bindParam(':nummer', $nummer);
                $stmt->bindParam(':katalog', $katalog);
                $stmt->bindParam(':kategorieInsert', $kategorieInsert);
                $stmt->bindParam(':verfasInsert', $verfasInsert);
                $stmt->bindParam(':zustandInsert', $zustandInsert);
                $stmt->bindParam(':bild', $fileNameComplete);

                // SQL-Anweisung ausführen
                $stmt->execute();

                // Erfolgsmeldung ausgeben
                echo "Buch erfolgreich hinzugefügt!";
            } else {
                // Fehler beim Validieren der Eingaben, Fehlermeldungen ausgeben
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
        }

        
        
        
        // Anzeige der Datensätze pro Seite 
        $DatensaetzeSeite = 18;

        // Anzahl der Datensätze ermitteln 
        $AnzahlDatensaetze = $conn->query("SELECT COUNT(*) FROM buecher $zustandFilter $kategorie $verfasser $searchTA $searchHome")->fetchColumn(0);

        // Die Anzahl der Seiten ermitteln 
        $AnzahlSeiten = ceil($AnzahlDatensaetze / $DatensaetzeSeite);

        // Die aktuelle Seite ermitteln 
        $AktuelleSeite = ($_GET["seite"] ?? 1);

        // Anzahl Bücher pro Seite anzeigen (oben links bei buecher.php)
        echo '<div>';
            echo '<div class="buchanzahl">';
            $maxBuecher = $AktuelleSeite * 18;
            $minBuecher = $maxBuecher - 17;

        if ($maxBuecher > $AnzahlDatensaetze) {
            echo 'Buch ' . $minBuecher . ' - ' . $AnzahlDatensaetze;
        } else {
            echo 'Buch ' . $minBuecher . ' - ' . $maxBuecher;
        }
        echo '</div>';

        // Den Wert überprüfen und ggf. ändern 
        $AktuelleSeite = ctype_digit((string)$AktuelleSeite) ? $AktuelleSeite : 1;
        $AktuelleSeite = $AktuelleSeite < 1 || $AktuelleSeite > $AnzahlSeiten ? 1 : $AktuelleSeite;

        // Den Versatz ermitteln 
        $Versatz = $AktuelleSeite * $DatensaetzeSeite - $DatensaetzeSeite;
        
        if (isset($_POST['delete'])) {
            $buchId = $_POST['id'];    
            // SQL zum Löschen des Buches
            $sql = "DELETE FROM buecher WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $buchId, PDO::PARAM_INT);
            $stmt->execute(); 
        }

        // Datensätze auslesen 
        $select = $conn->prepare("SELECT `kurztitle`, `autor`, `id`, `foto`
                                  FROM `buecher` 
                                  $zustandFilter
                                  $kategorie
                                  $verfasser
                                  $searchTA
                                  $searchHome
                                  ORDER BY $kollone $orderSort 
                                  LIMIT :versatz, :dseite");
        $select->bindValue(':versatz', $Versatz, PDO::PARAM_INT);
        $select->bindValue(':dseite', $DatensaetzeSeite, PDO::PARAM_INT);
        $select->execute();
        $nachrichten = $select->fetchAll(PDO::FETCH_OBJ);

        // Ausgabe über eine Foreach-Schleife 
        if ($AnzahlDatensaetze > 0) {
            echo '<div class="buchliste">';
            $reiheZahl = 0;
            foreach ($nachrichten as $nachricht) {
                $kurztitel = $nachricht->kurztitle;
                $autor = $nachricht->autor;
                echo '<div class="flex">';
                if ($nachricht->foto === "book.jpg"){
                echo '<a href="buchdetail.php?id=' . $nachricht->id . '"class="BildBuch"><img src="Bilder/book-cover.svg" alt="Bild' . $nachricht->kurztitle . '" class="small-svg"></a> <br>';
                } else {echo '<a href="buchdetail.php?id=' . $nachricht->id . '"class="BildBuch"><img src=Bilder/"'. $nachricht->foto .'" alt="Bild: ' . $nachricht->kurztitle . '" class="small-svg"></a> <br>';}   
                echo '<em id="buchtitel">' . substr($kurztitel, 0, 23) . '</em><br>' .
                    ' <em id="buchautor">' . substr($autor, 0, 25) . '</em><br>';
                if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true) {
                    echo '<form action="buecher.php" method="post">';
                    echo '<input type="hidden" name="id" value="'. $nachricht->id .'">';
                    echo '<button type="submit" name="delete"><img src="Bilder/delete.svg" alt="Delete"></button>';
                    echo '</form>';
                }
                echo '</div>';
                $reiheZahl += 1;
                if ($reiheZahl % 6 == 0) {
                    echo '<br>';
                }
            }
        }

        echo '</div>';
            //Formular und Blätterfunktion
            echo '<form class="blättern" method="GET" autocomplete="off">' .
            (($AktuelleSeite - 1) > 0 ?
            //doppelpfeil links springt auf die erste seite
                '<a class="pfeil" href="?seite=1' . urlWeitergabe() .'">&#9668;&#9668;</a>' :
                '&#9668;&#9668;') .
                //Kästchen bei denen man entscheiden kann ob man 1/2/3 seiten vor/zurück blättert
                (($AktuelleSeite - 3) > 0 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite - 3). urlWeitergabe() . '">'. ($AktuelleSeite - 3).'</a>' : '') .
                (($AktuelleSeite - 2) > 0 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite - 2). urlWeitergabe() . '">'. ($AktuelleSeite - 2).'</a>' : '') .
                (($AktuelleSeite - 1) > 0 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite - 1). urlWeitergabe() . '">'. ($AktuelleSeite - 1).'</a>' : '') .            
                '<label>Seite <input type="text" id="blatttext" value="' . $AktuelleSeite. '" name="seite" size="3" 
                title="Seitenzahl eingeben und Eingabetaste betätigen"> von ' . $AnzahlSeiten . '</label>' .
                (($AktuelleSeite + 1) < $AnzahlSeiten ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 1). urlWeitergabe() . '">'. ($AktuelleSeite + 1).'</a>' : '') .
                (($AktuelleSeite + 2) < $AnzahlSeiten ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 2). urlWeitergabe() . '">'. ($AktuelleSeite + 2).'</a>' : '') .
                (($AktuelleSeite + 3) < $AnzahlSeiten ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 3). urlWeitergabe() . '">'. ($AktuelleSeite + 3).'</a>' : '') .
                (($AktuelleSeite + 1) <= $AnzahlSeiten ?
                //doppelpfeil nach rechts springt auf die letzte Seite
                ' <a class="pfeil" href="?seite=' . $AnzahlSeiten . urlWeitergabe() . '">&#9658;&#9658;</a>' . '<br>' .
                //normaler pfeil links/rechts geht bei drücken eine Seite zurück oder springt zur nächsten
                ' <a class="einsplus" href="?seite=' . ($AktuelleSeite + 1) . urlWeitergabe() . '"> nächste Seite &#9658</a>' :' &#9658;') .
                ' <a class="einsminus" href="?seite=' . ($AktuelleSeite - 1) . urlWeitergabe() . '">◄ vorherige Seite</a>' .

            '</form>';
        
        
            // Funktion, um beim Blättern der Seiten den Filter in der URL zu behalten
            function urlWeitergabe() {
                $urlErweiterung = '';
            //schaut ob sort gesetzt wurde, falls ja wird die $urlErweiterung mit den entsprechenden Attributen erweitert
                if (isset($_GET['sort'])) {
                    $urlErweiterung .= '&sort=' . $_GET['sort'];
                }
                if (isset($_GET['zustand'])) {
                    $urlErweiterung .= '&zustand=' . $_GET['zustand'];
                }
                if (isset($_GET['kategorie'])) {
                    $urlErweiterung .= '&kategorie=' . $_GET['kategorie'];
                }
                if (isset($_GET['verfasser'])) {
                    $urlErweiterung .= '&verfasser=' . $_GET['verfasser'];
                }
                if (isset($_GET['search'])) {
                    $urlErweiterung .= '&search=' . $_GET['search'];
                }
                if (isset($_GET['autor'])) {
                    $urlErweiterung .= '&autor=' . $_GET['autor'];
                }
                if (isset($_GET['titel'])) {
                    $urlErweiterung .= '&titel=' . $_GET['titel'];    
                }
            // gibt schliesslich den Wert $urlErweiterung zurück
                return $urlErweiterung;
            }

        include('inc/footer.php');
        ?>

</body>

</html>

