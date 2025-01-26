<?php
include "menu.php";
include "get_projects.php";

class ProjectIndividualView {
    private $departmentMapping = [];
    private $personCache = [];
    private $customFieldMapping = [];
    private $statusCache = [];

    public function __construct() {
        $this->departmentMapping = $this->get_departments();
        $this->customFieldMapping = $this->get_custom_field_definitions();
    }

    private function format_date($date) {
        if (!$date) {
            return 'Unbekannt';
        }

        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        if ($dateObject) {
            return $dateObject->format('d-m-Y');
        }

        return 'Ungültiges Datum';
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
        foreach ($data['departments'] as $dept) {
            $departmentMapping[$dept['id']] = $dept['text'];
        }

        return $departmentMapping;
    }

    private function get_custom_field_definitions() {
        $manager = new ProjectManager();
        $customFieldsUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/customfield/definitions/Project';
        $response = $manager->get_method_url($customFieldsUrl);
        $data = json_decode($response, true);

        $customFieldMapping = [];
        foreach ($data['customFields'] as $field) {
            $customFieldMapping[$field['id']] = [
                'name' => $field['name'],
                'options' => $field['options'] ?? []
            ];
        }

        return $customFieldMapping;
    }

    private function get_person_name($personId) {
        if (isset($this->personCache[$personId])) {
            return $this->personCache[$personId];
        }

        $manager = new ProjectManager();
        $personUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/human/persons/' . $personId;
        $response = $manager->get_method_url($personUrl);
        $data = json_decode($response, true);

        $fullname = $data['person']['firstname'] . ' ' . $data['person']['lastname'] ?? 'Unbekannt';
        $this->personCache[$personId] = $fullname;

        return $fullname;
    }

    private function get_milestones($projectId) {
        $manager = new ProjectManager();
        $milestonesUrl = "https://dashboard-examples.blueant.cloud/rest/v1/projects/{$projectId}/planningentries";
        $response = $manager->get_method_url($milestonesUrl);
        $data = json_decode($response, true);

        if (isset($data['entries']) && is_array($data['entries'])) {
            return array_filter($data['entries'], fn($entry) => $entry['entryType'] === 'milestone');
        }

        return [];
    }

    public function display_project_details() {
        $menu = new Menu();
        $manager = new ProjectManager();
        $projectId = $this->get_project_id_from_url();

        if (!$projectId) {
            echo '<p>Ungültige Projekt-ID.</p>';
            return;
        }

        $projectData = $manager->get_project_by_id($projectId)['project'] ?? null;

        if (!$projectData) {
            echo '<p>Projekt nicht gefunden.</p>';
            return;
        }

        $fields = [
            'Projektnummer' => $projectData['number'] ?? 'Unbekannt',
            'Name' => $projectData['name'] ?? 'Unbekannt',
            'Projektleiter' => $this->get_person_name($projectData['projectLeaderId'] ?? null),
            'Starttermin' => $this->format_date($projectData['start'] ?? null),
            'Endtermin' => $this->format_date($projectData['end'] ?? null),
            'Unternehmensbereich' => $this->departmentMapping[$projectData['departmentId']] ?? 'Unbekannt',
            'Priorität' => $this->get_priority($projectData['priorityId'] ?? null),
            'Projektstatus' => $this->get_project_status($projectData['statusId'] ?? null),
        ];

        $milestones = $this->get_milestones($projectId);

        echo '<!DOCTYPE html>';
        echo '<html lang="de">';
        echo '<head><meta charset="UTF-8"><link rel="stylesheet" href="Design.css"><title>Projekt Einzelansicht</title></head>';
        echo '<body>';
        echo '<div class="flex min-h-screen">';
        $menu->renderMenu();
        echo '<div id="projekt-container">';
        echo '<h1>Projekt Einzelansicht</h1>';

        echo '<div class="project-row">';
        foreach ($fields as $title => $value) {
            echo '<div class="project-box">';
            echo '<div class="title">' . htmlspecialchars($title) . '</div>';
            echo '<div class="value">' . htmlspecialchars($value) . '</div>';
            echo '</div>';
        }
        echo '</div>';

        if (!empty($milestones)) {
            echo '<h2>Meilensteine</h2>';
            echo '<ul>';
            foreach ($milestones as $milestone) {
                echo '<li>';
                echo '<strong>' . htmlspecialchars($milestone['number'] ?? 'Keine Nummer') . ':</strong> ';
                echo htmlspecialchars($milestone['description'] ?? 'Keine Beschreibung');
                echo ' (Fortschritt: ' . htmlspecialchars($milestone['progressActual'] ?? '0') . '%)';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Keine Meilensteine verfügbar.</p>';
        }

        echo '</div></div></body></html>';
    }
}

$projectView = new ProjectIndividualView();
$projectView->display_project_details();