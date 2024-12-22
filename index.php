<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>Projektübersicht</title>
    <link rel="stylesheet" href="Design.css"> <!-- CSS-Datei wird eingebunden-->
</head>
<body>
    <ul class="menu">
       <li><a href="index.php?page=projektuebersicht">Projektübersicht</a></li>
       <li><a href="index.php?page=dashboard">Dashboard</a></li>
       <li><a href="index.php?page=hilfe">Hilfe</a></li>
    </ul>

    <!--Dynamischer Seiteninhalt-->
    <div class="page-title">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'projektuebersicht'; //Standardseite

        // Seiteninhalt wird je nach Seite ausgelesen
        switch ($page) {
            case 'projektuebersicht':
                include 'projektuebersicht.php';
                break;
            case 'dashboard':
                include 'dashboard.php';
                break;
            case 'hilfe':
                include 'hilfe.php';
                break;
            default:
                echo "<h1>Seite nicht gefunden!</h1>";
        }
        ?>
    </div>
</body>
</html>
