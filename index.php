<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" type="text/css" href="static/fonts/Montserrat/fonts/webfonts/Montserrat-Alt1.css">
    <title>Home</title>

</head>

<body>
    <!--die navbar und die datenbankverbindung werden hinzugefügt (bei den anderen Seiten wurde dies auch gemacht)-->
    <?php include('inc/navigation.php') ?>
    <?php include('inc/inc.php'); ?>

    <div class="searchbox">
        <p id="findbuch">Bücher finden</p>
        <form id="search" action="buecher.php">
            <label for="autor">Autor</label> <br>
            <input type="text" id='searchAutor' name="autor" placeholder="Autor eingeben..." onkeypress="suchen" />
            <br>
            <br>
            <label for="titel">Titel</label> <br>
            <input type="text" id='searchTitel' name="titel" placeholder="Titel eingeben..." onkeypress="suchen" />
            <br>
            <br>
            <input type="submit" value="suchen" />
        </form>
    </div>

    <div id="wilkomentext">
        <img id="startbild" src="Bilder\books-1163695_1280.jpg" alt="Startbild">
        <p>
            Willkommen bei unserem Bücherantiquariat, Ihrem Treffpunkt für literarische Schätze und kulturelle Entdeckungen!
            Tauchen Sie ein in die faszinierende Welt der Bücher, in der jede Seite eine Reise durch die Zeit und die Gedanken ihrer Autoren verspricht.
            Unser Sortiment umfasst eine breite Palette von klassischen Meisterwerken bis hin zu seltenen Erstausgaben und vergriffenen Schätzen.
            Egal, ob Sie auf der Suche nach einem zeitlosen Klassiker,
            einem inspirierenden Sachbuch oder einem verloren geglaubten Juwel aus vergangenen Epochen sind - bei uns finden Sie das perfekte Buch,
            um Ihre Bibliothek zu bereichern und Ihre Leselust zu stillen.
            <br>
            Stöbern Sie durch unser virtuelles Antiquariat und entdecken Sie Bücher, die Geschichten erzählen, Wissen vermitteln und die Sinne beflügeln.
            Wir sind stolz darauf, eine sorgfältig kuratierte Auswahl an Büchern anzubieten, die nicht nur Sammler und Literaturliebhaber ansprechen,
            sondern auch neugierige Leser jeden Alters begeistern. Mit Leidenschaft und Fachkenntnis stehen wir Ihnen gerne zur Seite,
            um Ihnen bei der Suche nach Ihrem nächsten literarischen Schatz behilflich zu sein. Willkommen in unserem Bücherparadies,
            wo die Seiten zum Leben erwachen und das Lesen zu einem unvergesslichen Abenteuer wird!
        </p>
    </div>
    <!--der Footer wird hinzugefügt (bei den anderen Seiten wurde dies auch gemacht)-->
    <div>
        <?php include('inc/footer.php') ?>
    </div>
    
</body>

</html>