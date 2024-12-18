<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>Projektübersicht</title>
    <link rel="stylesheet" href="Design.css">
</head>
<body>
<ul class="menu">
    <?php
    // Menü-Elemente untereinander anordnen
    $menuItems = [
        "Projektübersicht" => "projektübersicht",
        "Dashboard" => "dashboard.php",
        "Settings" => "settings.php",
        "Help" => "help.php",
    ];

    // Menü dynamisch ausgeben
    foreach ($menuItems as $name => $link) {
        echo "<li><a href='$link'>$name</a></li>";
    }


    ?>
</ul>
</body>
</html>
