<?php
include "menu.php";
include "get_projects.php";

class ProjectIndividualView {
    private $departmentMapping = []; // Unternehmensbereich-Mapping zwischenspeichern
    private $personCache = []; // Cache für Namen von Personen
    private $customFieldMapping = []; // Custom Field Definitionen

    public function __construct() {
        // Unternehmensbereiche und Custom Fields laden
        $this->departmentMapping = $this->get_departments();
        $this->customFieldMapping = $this->get_custom_field_definitions();
    }

    private function get_project_id_from_url() {
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $params);
        return isset($params['project_id']) ? $params['project_id'] : null;
    }

    private function get_priority($priorityId) {
        $manager = new ProjectManager();
        $priorityUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/priorities/' . $priorityId;
        $response = $manager->get_method_url($priorityUrl);
        $data = json_decode($response, true);

        return isset($data['priority']['text']) ? $data['priority']['text'] : 'Unbekannte Priorität';
    }

    private function get_project_status($statusId) {
        $manager = new ProjectManager();
        $statusUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects/statuses/' . $statusId;
        $response = $manager->get_method_url($statusUrl);
        $data = json_decode($response, true);

        return isset($data['projectStatus']['text']) ? $data['projectStatus']['text'] : 'Unbekannter Status';
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

    private function get_custom_field_definitions() {
        $manager = new ProjectManager();
        $customFieldsUrl = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/customfield/definitions/Project';
        $response = $manager->get_method_url($customFieldsUrl);
        $data = json_decode($response, true);

        $customFieldMapping = [];
        if (isset($data['customFields'])) {
            foreach ($data['customFields'] as $field) {
                $customFieldMapping[$field['id']] = [
                    'name' => $field['name'],
                    'options' => isset($field['options']) ? $field['options'] : []
                ];
            }
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

        if (isset($data['person']['firstname'], $data['person']['lastname'])) {
            $fullname = $data['person']['firstname'] . ' ' . $data['person']['lastname'];
            $this->personCache[$personId] = $fullname;
            return $fullname;
        }

        return 'Unbekannter Projektleiter';
    }

    private function get_milestones($projectId)
    {
        $manager = new ProjectManager();
        $milestonesUrl = "https://dashboard-examples.blueant.cloud/rest/v1/projects/{$projectId}/planningentries?entryType=milestone&fromDate=2018-09-21&toDate=2022-09-21&includeExternalSystemInformation=true&includeCustomFields=true";
        $response = $manager->get_method_url($milestonesUrl);
        $data = json_decode($response, true);

        // Überprüfen, ob Entries existieren und ob Einträge vom Typ 'milestone' vorhanden sind
        if (!empty($data['entries']) && is_array($data['entries'])) {
            foreach ($data['entries'] as $entry) {
                if ($entry['entryType'] === 'milestone') {
                    $milestones[] = $entry;  // Alle Meilenstein-Einträge sammeln
                }
            }
            return $milestones;
        } else {
            return [];  // Keine Meilensteine gefunden
        }
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
            $priority = $this->get_priority(isset($project_data['priorityId']) ? $project_data['priorityId'] : null);
            $status = $this->get_project_status(isset($project_data['statusId']) ? $project_data['statusId'] : null);
            $department = isset($this->departmentMapping[$project_data['departmentId']]) ? $this->departmentMapping[$project_data['departmentId']] : 'Keine Angabe';
            $projectLeader = $this->get_person_name(isset($project_data['projectLeaderId']) ? $project_data['projectLeaderId'] : null);
            $customFields = isset($project_data['customFields']) ? $project_data['customFields'] : [];
            $milestones = isset($project_data['milestones']) ? $project_data['milestones'] : [];


            // Daten für die Boxen vorbereiten
            $fields = [
                'ID' => htmlspecialchars($project_data['id']),
                'Name' => htmlspecialchars($project_data['name']),
                'Projektleiter' => htmlspecialchars($projectLeader),
                'Starttermin' => htmlspecialchars(isset($project_data['start']) ? $project_data['start'] : 'Unbekannt'),
                'Endtermin' => htmlspecialchars(isset($project_data['end']) ? $project_data['end'] : 'Unbekannt'),
                'Unternehmensbereich' => htmlspecialchars($department),
                'Priorität' => htmlspecialchars($priority),
                'Projektstatus' => htmlspecialchars($status),
            ];

            // Informationen aus Meilensteinen extrahieren und in die Felder einfügen
            if (!empty($milestones)) {
                foreach ($milestones as $milestone) {
                    $fields['Milestone Name'] = htmlspecialchars($milestone['name']);
                    $fields['Milestone Beschreibung'] = htmlspecialchars(isset($milestone['description']) ? $milestone['description'] : 'Keine Beschreibung');
                    $fields['Milestone Start'] = htmlspecialchars(isset($milestone['start']) ? $milestone['start'] : 'Kein Startdatum');
                    $fields['Milestone Ende'] = htmlspecialchars(isset($milestone['end']) ? $milestone['end'] : 'Kein Enddatum');
                    $fields['Milestone Limitation'] = htmlspecialchars(isset($milestone['limitation']) ? $milestone['limitation'] : 'Keine Limitation');
                }
            }

            // Erlaubte Custom Fields definieren
            $allowedCustomFields = [
                'Wichtigkeit',
                'Dringlichkeit',
                'Frage2',
                'Antwort2',
                'Klassifikation',
                'Innovationsgrad',
                'Strategiebeitrag',
                'Sicherheitsgrad',
                'Score',
                'Vertraulichkeit'
            ];

            // Custom Fields hinzufügen (nur erlaubte Felder)
            foreach ($customFields as $fieldId => $fieldValue) {
                $fieldName = isset($this->customFieldMapping[$fieldId]['name']) ? $this->customFieldMapping[$fieldId]['name'] : null;

                // Prüfen, ob das Feld in der Whitelist enthalten ist
                if (!in_array($fieldName, $allowedCustomFields)) {
                    continue;
                }

                $options = isset($this->customFieldMapping[$fieldId]['options']) ? $this->customFieldMapping[$fieldId]['options'] : [];
                $resolvedValue = $fieldValue;

                // Wert auflösen, falls es sich um ein Dropdown-Feld handelt
                foreach ($options as $option) {
                    if (isset($option['key'], $option['value']) && $option['key'] == $fieldValue) {
                        $resolvedValue = $option['value'];
                        break;
                    }
                }

                $fields[$fieldName] = htmlspecialchars($resolvedValue);
            }

            // HTML-Ausgabe
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

            // Dynamische Boxen anzeigen
            echo '<div class="project-row">';
            $counter = 0;
            foreach ($fields as $title => $value) {
                echo '<div class="project-box">';
                echo '<div class="title">' . $title . '</div>';
                echo '<div class="value">' . $value . '</div>';
                echo '</div>';

                $counter++;
                if ($counter % 3 == 0) {
                    echo '</div><div class="project-row">';
                }
            }
            echo '</div>'; // Schließt die letzte Reihe
            echo '</div>'; // Schließt den Container
            echo '</div>'; // Schließt den Flex-Container
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
