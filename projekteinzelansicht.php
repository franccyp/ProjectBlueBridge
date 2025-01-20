<?php

include "get_projects.php";
include "menu.php";
include "project.php"; // Falls Projekt-Daten benötigt werden

class ProjectIndividualView {

    /**
     * Zeigt Details zu einem einzelnen Projekt an.
     */
    public function display_project_details($projectId) {
        echo "Hello";
        $menu = new Menu(); // Menü erstellen
        $manager = new ProjectManager();
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // Use parse_url() function to parse the URL
        // and return an associative array which
        // contains its various components
        $url_components = parse_url($actual_link );

        // Use parse_str() function to parse the
        // string passed via URL
        parse_str($url_components['query'], $params);

        $projectId = $params['project_id'];
        echo $projectId;

        // Projekt-ID über die URL holen
        //$projectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;
        //echo $projectId;

        if ($projectId) {
            // Einzelprojekt basierend auf ID abrufen
            $project_data = $manager->get_project_by_id($projectId);

            // Überprüfung ob Projekt existiert
            if (!$project_data || !isset($project_data['id'])) {
                echo "<p>Projekt nicht gefunden.</p>";
                return;
            }

            // Einzelprojekt Details anzeigen
            echo '<!DOCTYPE html>';
            echo '<html lang="en">';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '<link rel="stylesheet" href="Design.css">'; // CSS-Datei verlinken
            echo '<title>Projekt-Einzelansicht</title>';
            echo '</head>';
            echo '<body>';
            echo '<div class="flex min-h-screen">';

            $menu->renderMenu();

            // Einzelprojekt-Inhalt
            echo '<div class="content">';
            echo '<h1>Projekt Einzelansicht</h1>';
            echo '<p><strong>ID:</strong> ' . htmlspecialchars($project_data['id']) . '</p>';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($project_data['name']) . '</p>';
            echo '<p><strong>Projektleiter:</strong> ' . htmlspecialchars(isset($project_data['projectLeaderId']) ? $project_data['projectLeaderId'] : 'Keine Beschreibung') . '</p>';
            echo '<p><strong>Starttermin:</strong> ' . htmlspecialchars(isset($project_data['start']) ? $project_data['start'] : 'Unbekannt') . '</p>';
            echo '<p><strong>Endetermin:</strong> ' . htmlspecialchars(isset($project_data['end']) ? $project_data['end'] : 'Unbekannt') . '</p>';

            echo '</div>'; // End des Hauptinhalts

            echo '</div>'; // End des flex containers
            echo '</body>';
            echo '</html>';
        } else {
            echo '<p>Ungültige Projekt-ID.</p>';
        }
    }

    // function test_get_projects_filter_name() {
    //   $manager = new ProjectManager();
    // $manager->get_project_filter_name('358638433'); // bei name den Namen des Projekts für Einzelansicht
    //}



    function test_get_all_projects() {
        $this->display_project_details(1);
    }

    public function get_project_by_id($project_id) {
        $manager = new ProjectManager();
        //  $manager = $this->get_project_by_id($project_id);
        $project = $manager->get_project_by_id($project_id);
        print($project);
        return $project;
    }
}

?>



<?php
// Instanz des Viewers und Anzeige eines Projekts basierend auf der übergebenen ID
$project_view = new ProjectIndividualView();
$project_view->display_project_details($_GET['project_id']);
$project_view->get_project_by_id($_GET['project_id']);
$project_view->test_get_all_projects();
?>



