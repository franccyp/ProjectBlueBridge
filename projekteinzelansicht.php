<?php
include "menu.php";
include "get_projects.php"; // Falls Projekt-Daten benötigt werden, ist nicht verwendet

class ProjectIndividualView {

    private $departmentMapping = []; // Unternehmensbereich-Mapping zwischenspeichern
    private $personCache = []; // Cache für Namen von Personen

    public function __construct() {
        // Unternehmensbereiche laden und im Mapping speichern
        $this->departmentMapping = $this->get_departments();
    }

    private function get_project_id_from_url() {
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $params);
        $projectId = $params['project_id'];
        return $projectId;
    }

    /**
     * Hilfsfunktion, um die Priorität abzurufen.
     */
    private function get_priority($priorityId) {
        $manager = new ProjectManager();
        $priorityUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/priorities/' . $priorityId;
        $response = $manager->get_method_url($priorityUrl);
        $data = json_decode($response, true);

        if (isset($data['priority']['text'])) {
            return $data['priority']['text'];
        }

        return 'Unbekannte Priorität';
    }

    /**
     * Hilfsfunktion, um den Projektstatus abzurufen.
     */
    private function get_project_status($statusId) {
        $manager = new ProjectManager();
        $statusUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/statuses/' . $statusId;
        $response = $manager->get_method_url($statusUrl);
        $data = json_decode($response, true);

        if (isset($data['projectStatus']['text'])) {
            return $data['projectStatus']['text'];
        }

        return 'Unbekannter Status';
    }

    /**
     * Hilfsfunktion, um die Unternehmensbereiche abzurufen.
     */
    private function get_departments() {
        $manager = new ProjectManager();
        $departmentsUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/departments';
        $response = $manager->get_method_url($departmentsUrl);
        $data = json_decode($response, true);

        $departmentMapping = [];
        if (isset($data['departments'])) {
            foreach ($data['departments'] as $dept) {
                if (isset($dept['id'], $dept['text'])) {
                    $departmentMapping[$dept['id']] = $dept['text'];
                }
            }
        }

        return $departmentMapping;
    }

    /**
     * Hilfsfunktion, um den Namen einer Person (Projektleiter) abzurufen.
     */
    private function get_person_name($personId) {
        // Überprüfen, ob der Name bereits im Cache ist
        if (isset($this->personCache[$personId])) {
            return $this->personCache[$personId];
        }

        $manager = new ProjectManager();
        $personUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/human/persons/' . $personId;
        $response = $manager->get_method_url($personUrl);
        $data = json_decode($response, true);

        if (isset($data['person']['firstname'], $data['person']['lastname'])) {
            $fullname = $data['person']['firstname'] . ' ' . $data['person']['lastname'];
            $this->personCache[$personId] = $fullname; // Im Cache speichern
            return $fullname;
        }

        return 'Unbekannter Projektleiter';
    }

    /**
     * Zeigt Details zu einem einzelnen Projekt an.
     */
    public function display_project_details() {
        $menu = new Menu(); // Menü erstellen
        $manager = new ProjectManager();

        $projectId = $this->get_project_id_from_url();

        if ($projectId) {
            // Einzelprojekt basierend auf ID abrufen
            $project_data = $manager->get_project_by_id($projectId);

            // Überprüfung ob Projekt existiert
            if (!$project_data || !isset($project_data['project'])) {
                echo "<p>Projekt nicht gefunden.</p>";
                return;
            }

            $project_data = $project_data['project'];

            // Priorität abrufen
            $priority = isset($project_data['priorityId']) ?
                $this->get_priority($project_data['priorityId']) :
                'Keine Priorität verfügbar';

            // Projektstatus abrufen
            $status = isset($project_data['statusId']) ?
                $this->get_project_status($project_data['statusId']) :
                'Nicht verfügbar';

            // Unternehmensbereich abrufen
            $department = isset($project_data['departmentId']) ?
                ($this->departmentMapping[$project_data['departmentId']] ?? 'Unbekannter Bereich') :
                'Keine Angabe';

            // Projektleiter abrufen
            $projectLeader = isset($project_data['projectLeaderId']) ?
                $this->get_person_name($project_data['projectLeaderId']) :
                'Kein Projektleiter angegeben';

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
            echo '<p><strong>Projektleiter:</strong> ' . htmlspecialchars($projectLeader) . '</p>';
            echo '<p><strong>Starttermin:</strong> ' . htmlspecialchars(isset($project_data['start']) ? $project_data['start'] : 'Unbekannt') . '</p>';
            echo '<p><strong>Endtermin:</strong> ' . htmlspecialchars(isset($project_data['end']) ? $project_data['end'] : 'Unbekannt') . '</p>';

            // Unternehmensbereich anzeigen
            echo '<p><strong>Unternehmensbereich:</strong> ' . htmlspecialchars($department) . '</p>';

            // Priorität anzeigen
            echo '<p><strong>Priorität:</strong> ' . htmlspecialchars($priority) . '</p>';

            // Projektstatus anzeigen
            echo '<p><strong>Projektstatus:</strong> ' . htmlspecialchars($status) . '</p>';

            echo '</div>'; // End des Hauptinhalts
            echo '</div>'; // End des flex containers
            echo '</body>';
            echo '</html>';
        } else {
            echo '<p>Ungültige Projekt-ID.</p>';
        }
    }

    function test_get_all_projects() {
        $this->display_project_details(1);
    }

    public function get_project_by_id($project_id) {
        $manager = new ProjectManager();
        $project = $manager->get_project_by_id($project_id);
        return $project;
    }
}

// Instanz des Viewers und Anzeige eines Projekts basierend auf der übergebenen ID
$project_view = new ProjectIndividualView();
$project_view->display_project_details();
?>
