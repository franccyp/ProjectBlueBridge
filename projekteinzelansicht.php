<?php
include "menu.php";
include "get_projects.php"; // Falls Projekt-Daten benötigt werden, ist nicht verwendet

class ProjectIndividualView {

    private function get_project_id_from_url(){

        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $url_components = parse_url($actual_link );

        parse_str($url_components['query'], $params);

        $projectId = $params['project_id'];

        return $projectId;
    }

    /**
     * Zeigt Details zu einem einzelnen Projekt an.
     */
    public function display_project_details() {

        $menu = new Menu(); // Menü erstellen

        $manager = new ProjectManager();

        $projectId = $this->get_project_id_from_url();


        // Projekt-ID über die URL holen
        //$projectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;
        //echo $projectId;

        if ($projectId) {
            // Einzelprojekt basierend auf ID abrufen
            $project_data = $manager->get_project_by_id($projectId);

            // Überprüfung ob Projekt existiert
            if (!$project_data || !isset($project_data['project'])) {
                echo "<p>Projekt nicht gefunden.</p>";
                return;
            }

            $project_data = $project_data['project'];

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
            echo '<div class="date-box"<div class="date-box" style="background-color: #87CEEB; color: white; position: absolute; right: 100px; top: 30%; transform: translateY(-50%);">';
            echo '<p><strong>Starttermin:</strong> ' . htmlspecialchars(isset($project_data['start']) ? $project_data['start'] : 'Unbekannt') . '</p>';
            echo '<p><strong>Endetermin:</strong> ' . htmlspecialchars(isset($project_data['end']) ? $project_data['end'] : 'Unbekannt') . '</p>';
            echo '</div>';
            echo '<p><strong>ID:</strong> ' . htmlspecialchars($project_data['id']) . '</p>';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($project_data['name']) . '</p>';
            echo '<p><strong>Projektleiter:</strong> ' . htmlspecialchars(isset($project_data['projectLeaderId']) ? $project_data['projectLeaderId'] : 'Keine Beschreibung') . '</p>';
            echo '<p><strong>Planungstyp:</strong> ' . htmlspecialchars(isset($project_data['planningType']) ? $project_data['planningType'] : 'Unbekannt') . '</p>';

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
        return $project;
    }
}

?>



<?php
// Instanz des Viewers und Anzeige eines Projekts basierend auf der übergebenen ID
$project_view = new ProjectIndividualView();
$project_view->display_project_details();
?>
