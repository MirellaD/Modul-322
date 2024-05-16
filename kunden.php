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
        function closePopup(event) {
            event.stopPropagation(); // Stoppt das Event-Bubbling (Ereignisverarbeitung, bei dem ein Ereignis, das an einem bestimmten Element ausgelöst wird, durch die Hierarchie seiner übergeordneten Elemente "aufblubbert" (aufsteigt), bis es das Wurzelelement erreicht.)
            document.getElementById('popup').style.display = 'none';

        }

        // JavaScript-Funktion zum Aktualisieren der Sortierreihenfolge (ohne submit button, sondern bei wählen/klicken)
        function updateSortOrder() {
            // erstellt eine variable sort_order und weist dieser das value des elementes, welches er durch die ID erhält
            var sort_order = document.getElementById("sortieren").value;
            // Weiterleitung an die aktuelle Seite mit dem Sortierparameter
            window.location.href = window.location.pathname + "?sort=" + sort_order;
        }
            //nachfolgende 3 funktionen haben das gleiche prinzip, wie die vorherige

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
    <select name="sortieren" class="btns" id="sortieren" onchange="updateSortOrder()">
        <option value="default">Sortieren</option>
        <option value="vornameAZ">Vorname(A-Z)</option>
        <option value="vornameZA">Vorname(Z-A)</option>
        <option value="nameAZ">Name(A-Z)</option>
        <option value="nameZA">Name(Z-A)</option>
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
                <input type="button" name="schliessen" onclick="closePopup(event)" value="Schliessen">
            </div>

        </div>

        <div>
            <!--onkeypress löst bei Enter (der keycode für Enter ist 13) drücken die javascript funktion aus-->
                <input id="searchbar" class="btns" type="search" placeholder="Vorname oder Name suchen..." onkeypress="if(event.keyCode === 13) searchResultat();">
        </div>
        <br>

        <?php
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
                case 'default':
                    // Standard Sortierreihenfolge
                    $kollone = 'kid';
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
            $searchTA = 'WHERE vorname LIKE "%' . $search . '%" OR name LIKE "%' . $search . '%"';
        }


        // Anzeige der Datensätze pro Seite 
        $DatensaetzeSeite = 18;

        // Anzahl der Datensätze ermitteln 
        $AnzahlDatensaetze = $conn->query("SELECT COUNT(*) FROM kunden")->fetchColumn(0);

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
        $select = $conn->prepare("SELECT `vorname`, `name`, `kid` 
                                  FROM `kunden` 
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
            echo '<div class="kundenliste">';
            foreach ($nachrichten as $nachricht) {
                echo '<div class="kundenEinzeln">';
                echo '<em id="kundeV">' . $nachricht->vorname . '</em><br>' .
                    ' <em id="kundeN">' . $nachricht->name . '</em><br>';
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
                (($AktuelleSeite + 1) < 181 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 1). urlWeitergabe() . '">'. ($AktuelleSeite + 1).'</a>' : '') .
                (($AktuelleSeite + 2) < 181 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 2). urlWeitergabe() . '">'. ($AktuelleSeite + 2).'</a>' : '') .
                (($AktuelleSeite + 3) < 181 ? '<a class="vorseite" href="?seite='. ($AktuelleSeite + 3). urlWeitergabe() . '">'. ($AktuelleSeite + 3).'</a>' : '') .
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
