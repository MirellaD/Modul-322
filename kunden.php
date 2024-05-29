<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunden</title>

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
        function openKunden(kid) {
            window.location.href = window.location.pathname + "?kid=" + kid;
            document.getElementById('popupKunden').style.display = 'block';


        }

        function closeKunden() {
            document.getElementById('popupKunden').style.display = 'none';

        }

        // JavaScript-Funktion zum Aktualisieren der Sortierreihenfolge (ohne submit button, sondern bei wählen/klicken)
        function updateSortOrder() {
            // erstellt eine variable sort_order und weist dieser das value des elementes, welches er durch die ID erhält
            var sort_order = document.getElementById("sortieren").value;
            // Weiterleitung an die aktuelle Seite mit dem Sortierparameter
            window.location.href = window.location.pathname + "?sort=" + sort_order;
        }
            //nachfolgende 3 funktionen haben das gleiche prinzip, wie die vorherige

        function updateGeschlecht() {
            var geschlechtU = document.getElementById("geschlecht").value;
            window.location.href = window.location.pathname + "?geschlecht=" + geschlechtU;
        }

        function updateKpE() {
            var EmailU = document.getElementById("KpE").value;
            window.location.href = window.location.pathname + "?KpE=" + EmailU;
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
        <option value="vornameAZ">Vorname(A-Z)</option>
        <option value="vornameZA">Vorname(Z-A)</option>
        <option value="nameAZ">Name(A-Z)</option>
        <option value="nameZA">Name(Z-A)</option>
        <option value="nKunde">neueste Kunden</option>
        <option value="aeKunde">älteste Kunden</option>
    </select>
    
    <!-- Button zum Oeffnen des Popup-Fensters (ruft die javascript funktion openPopup() auf)-->
    <button class="btns" id="popbutton" onclick="openPopup()">Alle Filter</button>
        <!-- Das Popup-Fenster -->
        <div id="popup" class="popup">
            <h2>Alle Filter</h2>

            <select name="geschlecht" id="geschlecht" onchange="updateGeschlecht()">
                <option value="default">Geschlecht</option>
                <option value="F">Weiblich</option>
                <option value="M">Männlich</option>
            </select>
            <br>
            <select name="KpE" id="KpE" onchange="updateKpE()">
                <option value="default">Kontakt per Email</option>
                <option value="1">Ja</option>
                <option value="0">Nein</option>
            </select>
            <br>
            <div class="allFilter">
                <!--löst beim klicken des buttons die javascript funktion closePopup() aus und schliesst das Popup-->
                <input type="button" name="schliessen" onclick="closePopup(event)" value="Schliessen">
            </div>

        </div>

        <div>
            <!--onkeypress löst bei Enter (der keycode für Enter ist 13) drücken die javascript funktion aus-->
                <input id="searchbar" class="btns" type="search" placeholder="Vorname oder Name suchen..." onkeypress="if(event.keyCode === 13) searchResultat();">
        </div>
        <br>

        <button class="btns" id="popbutton" onclick="openHinzufuegen()">Hinzufügen</button>
        <div id="hinzufuegenPop" class="popup">
            <form action="kunden.php" method="post">
                <h2>Kunde hinzufügen</h2><br>
                <label for="vorname">Vorname*:</label>
                <input type="text" name="vorname" id="vorname" required>
                <br><br>
                <label for="nachname">Nachname*:</label>
                <input type="text" name="nachname" id="nachname" required>
                <br><br>
                <label for="geschlecht">Geschlecht:</label><br>
                <input type="radio" name="geschlecht" id="F" value="F" required> Weiblich
                <br>
                <input type="radio" name="geschlecht" id="M" value="M" required> Männlich
                <br><br>
                <label for="email">Email*:</label>
                <input type="email" name="email" id="email" required>
                <br><br>
                <label for="gebu">Geburtstag:</label>
                <input type="date" name="gebu" id="gebu">
                <br><br>
                <label for="Kontakt">Kontakt per Email:</label>
                <input type="checkbox" name="1" id="1" value="1">
                <br><br>
                <div class="allFilter">
                <input type="submit" name="submitKunde" value="Kunde hinzufügen">
                </form>
                <!--löst beim klicken des buttons die javascript funktion closePopup() aus und schliesst das Popup-->
                <input type="button" name="schliessen" onclick="closeHinzufuegen()" value="Schliessen">
            </div>
        </div>
    </div>

        <div id="popupKunden" class="popupKunden">
            <?php
            //schaut ob kid gesetzt ist und holt sie
            if (isset($_GET['kid'])) {
                $kID = $_GET['kid'];
                //sql abfrage der passenden Daten
                $Query = $conn->prepare("SELECT * FROM kunden WHERE kid = :id");
                $Query->bindParam(':id', $kID, PDO::PARAM_INT);
                $Query->execute();
                $kunde = $Query->fetch(PDO::FETCH_ASSOC);
            ?>
            <br>
            <div class="kundenD">
            <form action="kunden.php" method="post">
                <input type="hidden" name="id" value="<?= $kID ?>">
                <em id="kundeI">Id: <?= $kunde['kid'] ?></em>
                <br>
                <label>Vorname: </label>
                <input type="text" name="vorname" value="<?= htmlspecialchars($kunde['vorname']) ?>" required>
                <br>
                <label>Nachname: </label>
                <input type="text" name="nachname" value="<?= htmlspecialchars($kunde['name']) ?>" required>
                <br>
                <label>Geschlecht: </label>
                
                <?php if ($kunde['geschlecht'] === "M"): //für radiobutton auswählen, welcher in der Datenbank ausgewählt wurde?>
                    <input type="radio" name="geschlecht" id="F" value="F"> Weiblich
                    <input type="radio" name="geschlecht" id="M" value="M" checked> Männlich
                <?php elseif ($kunde['geschlecht'] === "F"): ?>
                    <input type="radio" name="geschlecht" id="F" value="F" checked> Weiblich
                    <input type="radio" name="geschlecht" id="M" value="M"> Männlich
                <?php endif ?>
                <br>
                <label>Geb.: </label>
                <input type="date" name="gebu" id="gebu" value="<?= $kunde['geburtstag'] ?>">
                <br>
                <label>E-Mail: </label>
                <input type="email" name="email" id="email" value="<?= $kunde['email'] ?>" required>
                <br>
                <label>Kunde seit: </label>
                <input type="date" name="kundeSeit" id="kundeSeit" value="<?= $kunde['kunde_seit'] ?>">
                <br>
                <label>Kontakt per Mail: </label>
                <?php if ($kunde['kontaktpermail'] === 1): ?>
                    <input type="checkbox" name="1" id="1" value="1" checked>
                <?php else: ?>
                    <input type="checkbox" name="1" id="1" value="1">
                <?php endif ?>
                <br>
                <input type="submit" value="Änderungen bestätigen" name="updateKunde">
            </form>
            
            <button onclick="closeKunden()">Schliessen</button>
            </div>
            <br><br>
            <?php } 
            echo '</div>';
            ?>

    <?php
    if (isset($_POST['submitKunde'])) { // Überprüfen, ob das Formular für das Hinzufügen eines Kunden abgesendet wurde

        // Abfrage, um die maximale ID der Kunden zu erhalten
        $sql = "SELECT MAX(kid) AS idMax FROM kunden";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch();
    
        // Die neue ID für den Kunden berechnen
        $idMax = $row['idMax'];
        $kid = $idMax + 1;
        
        // Die eingereichten Formulardaten erhalten und Bereinigen
        $vorname = trim($_POST['vorname']);
        $name = trim($_POST['nachname']);
        $geschlecht = $_POST['geschlecht'];
        $email = trim($_POST['email']);
        $gebu = $_POST['gebu'];
        $kontakt = isset($_POST['1']); // Prüfen, ob das Kontaktfeld markiert wurde
        $kundeSeit = date('Y-m-d'); // Aktuelles Datum für "Kunde seit"
    
        // Fehlerarray initialisieren
        $errors = [];
    
        // Überprüfen, ob erforderliche Felder leer sind und Fehler hinzufügen
        if (empty($vorname)) $errors[] = "Vorname ist erforderlich.";
        if (empty($name)) $errors[] = "Nachname ist erforderlich.";
        if (empty($email)) $errors[] = "Email ist erforderlich.";
    
        // Überprüfen, ob Fehler vorhanden sind
        if (is_countable($errors) && count($errors) === 0) {
            // Keine Fehler, daher neuen Kunden in die Datenbank einfügen
    
            // Vorbereiten der SQL-Anweisung zum Einfügen der Kundendaten
            $stmt = $conn->prepare("INSERT INTO kunden (kid, geburtstag, vorname, name, geschlecht, kunde_seit, email, kontaktpermail)
                                    VALUES (:kid, :gebu, :vorn, :name, :geschlecht, :seit, :email, :kontakt)");
            
            // Parameter binden
            $stmt->bindParam(':kid', $kid);
            $stmt->bindParam(':gebu', $gebu);
            $stmt->bindParam(':vorn', $vorname);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':geschlecht', $geschlecht);
            $stmt->bindParam(':seit', $kundeSeit);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':kontakt', $kontakt);
    
            // Ausführen der vorbereiteten Anweisung
            $stmt->execute();
    
            // Erfolgsmeldung ausgeben
            echo "Kunde erfolgreich hinzugefügt!";
        } else {
            // Fehler beim Validieren der Eingaben, Fehlermeldungen ausgeben
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
    }
    


        // Überprüfen, ob das Formular zum Aktualisieren des Kunden gesendet wurde
    if (isset($_POST['updateKunde'])) {
        // Die ID des Kunden aus dem Formular erhalten
        $kID = $_POST['id'];

        // Die anderen Formularwerte erhalten
        $vorname = $_POST['vorname'];
        $name = $_POST['nachname'];
        $geschlecht = $_POST['geschlecht'];
        $email = $_POST['email'];
        $gebu = $_POST['gebu'];
        $kundeSeit = $_POST['kundeSeit'];
        $kontakt = isset($_POST['1']) ? 1 : 0;

        // Fehlerarray initialisieren
        $errors = [];

        // Validierung der Formulardaten (kann je nach Anforderungen angepasst werden)
        if (empty($vorname)) $errors[] = "Vorname ist erforderlich.";
        if (empty($name)) $errors[] = "Nachname ist erforderlich.";
        if (empty($email)) $errors[] = "Email ist erforderlich.";

        // Überprüfen, ob Fehler aufgetreten sind
        if (empty($errors)) {
            // Vorbereitung des Update-Statements
            $updateStmt = $conn->prepare("UPDATE kunden SET vorname = :vorname, name = :name, geschlecht = :geschlecht, 
                                            geburtstag = :gebu, email = :email, kunde_seit = :kundeSeit, kontaktpermail = :kontakt 
                                            WHERE kid = :kid");
            // Binden der Parameter
            $updateStmt->bindParam(':vorname', $vorname);
            $updateStmt->bindParam(':name', $name);
            $updateStmt->bindParam(':geschlecht', $geschlecht);
            $updateStmt->bindParam(':gebu', $gebu);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->bindParam(':kundeSeit', $kundeSeit);
            $updateStmt->bindParam(':kontakt', $kontakt);
            $updateStmt->bindParam(':kid', $kID);

            // Ausführen des Update-Statements
            if ($updateStmt->execute()) {
                echo "Kunde erfolgreich aktualisiert!";
            } else {
                echo "Fehler beim Aktualisieren des Kunden!";
            }
        } else {
            // Ausgabe der Fehlermeldungen
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
    }    
        // Standard Sortierreihenfolge
        $kollone = 'kid';
        $orderSort = 'ASC';

        // Es wird überprüft, ob Sortieroption ausgewählt wurde und dann die Variabeln dementsprechend geändert
        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'vornameAZ':
                    $kollone = 'vorname';
                    $orderSort = 'ASC';
                    break;
                case 'vornameZA':
                    $kollone = 'vorname';
                    $orderSort = 'DESC';
                    break;
                case 'nameAZ':
                    $kollone = 'name';
                    $orderSort = 'ASC';
                    break;
                case 'nameZA':
                    $kollone = 'name';
                    $orderSort = 'DESC';
                    break;
                case 'nKunde':
                    $kollone = 'kunde_seit';
                    $orderSort = 'DESC';
                    break;
                case 'aeKunde':
                    $kollone = 'kunde_seit';
                    $orderSort = 'ASC';
                    break;
                case 'default':
                    // Standard Sortierreihenfolge
                    $kollone = 'kid';
                    $orderSort = 'ASC';
                    break;
            }
        }
        
        //alle Filter und Suchfunktionen im 'deafult' modus -> machen nichts/sind leer
        $geschlecht = '';
        $KpE = '';
        $searchVN = '';

        // Hier werden die einzelnen möglichen Filter geprüft und gesetzt (nehmen ihren Wert aus der URL -> GET)
        if (isset($_GET['geschlecht'])) {
            $geschlecht = 'WHERE geschlecht = "' . $_GET['geschlecht'] . '"';
        }
        if (isset($_GET['KpE'])) {
            $KpE = 'WHERE Kontaktpermail = "' . $_GET['KpE'] . '"';
        }
        if (isset($_GET['search'])) {
            $search = htmlspecialchars(trim($_GET['search']));
            $searchVN = 'WHERE vorname LIKE "%' . $search . '%" OR name LIKE "%' . $search . '%"';
        }


        // Anzeige der Datensätze pro Seite 
        $DatensaetzeSeite = 18;

        // Anzahl der Datensätze ermitteln (auch gefiltert)
        $AnzahlDatensaetze = $conn->query("SELECT COUNT(*) FROM kunden $geschlecht $KpE $searchVN")->fetchColumn(0);

        // Die Anzahl der Seiten ermitteln 
        $AnzahlSeiten = ceil($AnzahlDatensaetze / $DatensaetzeSeite);

        // Die aktuelle Seite ermitteln 
        $AktuelleSeite = ($_GET["seite"] ?? 1);

        // Den Wert überprüfen und ggf. ändern 
        $AktuelleSeite = ctype_digit((string)$AktuelleSeite) ? $AktuelleSeite : 1;
        $AktuelleSeite = $AktuelleSeite < 1 || $AktuelleSeite > $AnzahlSeiten ? 1 : $AktuelleSeite;

        // Den Versatz ermitteln 
        $Versatz = $AktuelleSeite * $DatensaetzeSeite - $DatensaetzeSeite;
        
        // Datensätze auslesen 
        $select = $conn->prepare("SELECT `vorname`, `name`, `kid`, `geschlecht`
                                  FROM `kunden`
                                  $geschlecht
                                  $KpE
                                  $searchVN
                                  ORDER BY $kollone $orderSort 
                                  LIMIT :versatz, :dseite");
        $select->bindValue(':versatz', $Versatz, PDO::PARAM_INT);
        $select->bindValue(':dseite', $DatensaetzeSeite, PDO::PARAM_INT);
        $select->execute();
        $nachrichten = $select->fetchAll(PDO::FETCH_OBJ);

        if (isset($_POST['delete'])) {
            $KundeId = $_POST['id'];    
            // SQL zum Löschen des Buches
            $sql = "DELETE FROM kunden WHERE kid = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $KundeId, PDO::PARAM_INT);
            $stmt->execute(); 
        }

        // Ausgabe über eine Foreach-Schleife 
        if ($AnzahlDatensaetze > 0) {
            echo '<div class="kundenliste">';
            foreach ($nachrichten as $nachricht) {
                echo '<div class="kundenEinzeln">';
                echo '<em id="kundeI">Id: ' . $nachricht->kid . '</em>' .
                      '<em id="kundeV">  ' . $nachricht->vorname . '</em>' .
                    ' <em id="kundeN"> ' . $nachricht->name . '</em>' .
                    '<em id="kundeG"> ' . $nachricht->geschlecht . '</em>';
                echo '<form action="kunden.php" method="post">';
                echo '<input type="hidden" name="id" value="'. $nachricht->kid .'">';
                echo '<button type="submit" name="delete"><img src="Bilder/delete.svg" alt="Delete"></button>';
                echo '</form>';
                echo '<button type="button" onclick="openKunden('. $nachricht->kid .')">ändern</button>';
                ;
                echo '</div>';
                echo '<br>';
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
                if (isset($_GET['geschlecht'])) {
                    $urlErweiterung .= '&geschlecht=' . $_GET['geschlecht'];
                }
                if (isset($_GET['KpE'])) {
                    $urlErweiterung .= '&KpE=' . $_GET['KpE'];
                }
                if (isset($_GET['search'])) {
                    $urlErweiterung .= '&search=' . $_GET['search'];
                }
            // gibt schliesslich den Wert $urlErweiterung zurück
                return $urlErweiterung;
            }

        include('inc/footer.php');
        ?>

</body>

</html>
