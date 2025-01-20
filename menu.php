<?php

class Menu {

    public function renderMenu() {
        echo '<div class="sidebar">';
        echo '<ul>';
        echo '<li><a href="get_projects_test.php">Projektübersicht</a></li>';
        echo '<li><a href="projekteinzelansicht.php">Projekteinzelansicht</a></li>';
        echo '<li><a href="hilfe.php">Hilfe</a></li>';
        echo '</ul>';
        echo '</div>';
    }
}
?>

