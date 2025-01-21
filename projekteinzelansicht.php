<?php
include "menu.php";
include "get_projects.php";

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
        return $params['project_id'] ?? null;
    }

    private function get_priority($priorityId) {
        $manager = new ProjectManager();
        $priorityUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/priorities/' . $priorityId;
        $response = $manager->get_method_url($priorityUrl);
        $data = json_decode($response, true);

        return $data['priority']['text'] ?? 'Unbekannte Priorität';
    }

    private function get_project_status($statusId) {
        $manager = new ProjectManager();
        $statusUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/statuses/' . $statusId;
        $response = $manager->get_method_url($statusUrl);
        $data = json_decode($response, true);

        return $data['projectStatus']['text'] ?? 'Unbekannter Status';
    }

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

    private function get_person_name($personId) {
        if (isset($this->personCache[$personId])) {
            return $this->personCache[$personId];
        }

        $manager = new ProjectManager();
        $personUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/human/persons/' . $personId;
        $response = $manager->get_method_url($personUrl);
        $data = json_decode($response, true);

        if (isset($data['person']['firstname'], $data['person']['lastname'])) {
            $fullname = $data['person']['firstname'] . ' ' . $data['person']['lastname'];
            $this->personCache[$personId] = $fullname;
            return $fullname;
        }

        return 'Unbekannter Projektleiter';
    }

    public function display_project_details() {
        $menu = new Menu();
        $manager = new ProjectManager();
        $projectId = $this->get_project_id_from_url();

        if ($projectId) {
            $project_data = $manager->get_project_by_id($projectId);

            if (!$project_data || !isset($project_data['project'])) {
                echo "<p>Projekt nicht gefunden.</p>";
                return;
            }

            $project_data = $project_data['project'];
            $priority = $this->get_priority($project_data['priorityId'] ?? null);
            $status = $this->get_project_status($project_data['statusId'] ?? null);
            $department = $this->departmentMapping[$project_data['departmentId']] ?? 'Keine Angabe';
            $projectLeader = $this->get_person_name($project_data['projectLeaderId'] ?? null);

            // Ausgabe des HTML
            echo '<!DOCTYPE html>';
            echo '<html lang="en">';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '<link rel="stylesheet" href="Design.css">';
            echo '<title>Projekt-Einzelansicht</title>';
            echo '</head>';
            echo '<body>';
            echo '<div class="flex min-h-screen">';
            $menu->renderMenu();
            echo '<div id="projekt-container">';
            echo '<h1>Projekt Einzelansicht</h1>';

            // Dynamische Boxen erstellen
            echo '<div class="project-row">';
            echo '<div class="project-box">';
            echo '<div class="title">ID</div>';
            echo '<div class="value">' . htmlspecialchars($project_data['id']) . '</div>';
            echo '</div>';

            echo '<div class="project-box">';
            echo '<div class="title">Name</div>';
            echo '<div class="value">' . htmlspecialchars($project_data['name']) . '</div>';
            echo '</div>';
            echo '</div>'; // Ende der ersten Reihe

            echo '<div class="project-row">';
            echo '<div class="project-box">';
            echo '<div class="title">Projektleiter</div>';
            echo '<div class="value">' . htmlspecialchars($projectLeader) . '</div>';
            echo '</div>';

            echo '<div class="project-box">';
            echo '<div class="title">Starttermin</div>';
            echo '<div class="value">' . htmlspecialchars($project_data['start'] ?? 'Unbekannt') . '</div>';
            echo '</div>';
            echo '</div>'; // Ende der zweiten Reihe

            echo '<div class="project-row">';
            echo '<div class="project-box">';
            echo '<div class="title">Endtermin</div>';
            echo '<div class="value">' . htmlspecialchars($project_data['end'] ?? 'Unbekannt') . '</div>';
            echo '</div>';

            echo '<div class="project-box">';
            echo '<div class="title">Unternehmensbereich</div>';
            echo '<div class="value">' . htmlspecialchars($department) . '</div>';
            echo '</div>';
            echo '</div>'; // Ende der dritten Reihe

            echo '<div class="project-row">';
            echo '<div class="project-box">';
            echo '<div class="title">Priorität</div>';
            echo '<div class="value">' . htmlspecialchars($priority) . '</div>';
            echo '</div>';

            echo '<div class="project-box">';
            echo '<div class="title">Projektstatus</div>';
            echo '<div class="value">' . htmlspecialchars($status) . '</div>';
            echo '</div>';
            echo '</div>'; // Ende der vierten Reihe

            echo '</div>'; // Ende Container
            echo '</div>'; // Ende flex
            echo '</body>';
            echo '</html>';
        } else {
            echo '<p>Ungültige Projekt-ID.</p>';
        }
    }
}

// Instanz erstellen und aufrufen
$project_view = new ProjectIndividualView();
$project_view->display_project_details();
?>
