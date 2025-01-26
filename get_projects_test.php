<?php
include "menu.php";
include "get_projects.php";
require_once 'master_data.php';

class ProjectManagerTest {

    private $cachedProjects = null;

    /**
     * Zeigt alle Projekte in einer Tabelle an.
     */
    function display_all_projects() {
        $resolver = new MasterDataResolver();
        $menu = new Menu(); // Menü erstellen
        $manager = new ProjectManager();

        // Projekte abrufen
        $projects = $this->getProjects();

        // Prüfen, ob Daten vorhanden sind
        if (!$projects || !isset($projects['projects'])) {
            echo "<p>Keine Projekte gefunden oder ein Fehler ist aufgetreten.</p>";
            return;
        }

        // Filter- und Suchwerte auslesen
        $filter_type = $_GET['filter_type'] ?? '';
        $filter_value = $_GET['filter_value'] ?? '';
        $search_query = $_GET['search_query'] ?? '';

        // HTML-Ausgabe
        echo '<!DOCTYPE html>';
        echo '<html lang="de">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="Design.css">'; // CSS-Datei verlinken
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">'; // Font Awesome für Icons
        echo '<title>Projektübersicht</title>';
        echo '</head>';
        echo '<body>';
        echo '<div class="flex min-h-screen">';

        // Such- und Filterleiste
        echo '<form method="GET" action="" class="search-bar">';
        echo '<input type="text" id="search_query" name="search_query" value="' . htmlspecialchars($search_query) . '" placeholder="Suche nach Projekten...">';
        echo '<select id="filter_type" name="filter_type" onchange="this.form.submit()">';
        echo '<option value="">-- Filter --</option>';
        echo '<option value="status" ' . ($filter_type === 'status' ? 'selected' : '') . '>Status</option>';
        echo '<option value="business_area" ' . ($filter_type === 'business_area' ? 'selected' : '') . '>Unternehmensbereich</option>';
        echo '<option value="type" ' . ($filter_type === 'type' ? 'selected' : '') . '>Projektart</option>';
        echo '</select>';

        // Dynamisches zweites Dropdown
        if ($filter_type === 'status') {
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';
            $statuses = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveStatus($project['statusId'] ?? '');
            }, $projects['projects']));

            foreach ($statuses as $status) {
                echo '<option value="' . htmlspecialchars($status) . '" ' . ($filter_value === $status ? 'selected' : '') . '>' . htmlspecialchars($status) . '</option>';
            }
            echo '</select>';
        } elseif ($filter_type === 'business_area') {
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';
            $business_areas = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveDepartment($project['departmentId'] ?? '');
            }, $projects['projects']));

            foreach ($business_areas as $area) {
                echo '<option value="' . htmlspecialchars($area) . '" ' . ($filter_value === $area ? 'selected' : '') . '>' . htmlspecialchars($area) . '</option>';
            }
            echo '</select>';
        } elseif ($filter_type === 'type') {
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';
            $types = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveType($project['typeId'] ?? '');
            }, $projects['projects']));

            foreach ($types as $type) {
                echo '<option value="' . htmlspecialchars($type) . '" ' . ($filter_value === $type ? 'selected' : '') . '>' . htmlspecialchars($type) . '</option>';
            }
            echo '</select>';
        }

        echo '<button type="submit"><i class="fas fa-search"></i> Filtern</button>';
        echo '</form>';

        // Tabelle generieren
        echo '<div class="content">';
        echo '<h1>Projektübersicht</h1>';
        echo "<table class='project-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Projektnummer</th>";
        echo "<th>Projektname</th>";
        echo "<th>Projektleiter</th>";
        echo "<th>Startdatum</th>";
        echo "<th>Enddatum</th>";
        echo "<th>Status</th>";
        echo "<th>Projektart</th>";
        echo "<th>Unternehmensbereich</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($projects['projects'] as $project) {
            $status = $resolver->resolveStatus($project['statusId'] ?? 'Unbekannt');
            $type = $resolver->resolveType($project['typeId'] ?? 'Unbekannt');
            $department = $resolver->resolveDepartment($project['departmentId'] ?? 'Unbekannt');
            $projectLeaderName = isset($project['projectLeaderId'])
                ? $this->get_person_name($project['projectLeaderId'])
                : 'Unbekannt';

            // Filterlogik anwenden
            if ($search_query && stripos($project['name'], $search_query) === false &&
                stripos($projectLeaderName, $search_query) === false) {
                continue;
            }

            if ($filter_type === 'status' && $filter_value && stripos($status, $filter_value) === false) {
                continue;
            }

            if ($filter_type === 'business_area' && $filter_value && stripos($department, $filter_value) === false) {
                continue;
            }

            if ($filter_type === 'type' && $filter_value && stripos($type, $filter_value) === false) {
                continue;
            }

            // Tabellenzeile ausgeben
            echo "<tr>";
            echo "<td>" . htmlspecialchars($project['number']) . "</td>";
            echo "<td>" . htmlspecialchars($project['name']) . "</td>";
            echo "<td>" . htmlspecialchars($projectLeaderName) . "</td>";
            echo "<td>" . htmlspecialchars($this->format_date($project['start'] ?? null)) . "</td>";
            echo "<td>" . htmlspecialchars($this->format_date($project['end'] ?? null)) . "</td>";
            echo "<td>" . htmlspecialchars($status) . "</td>";
            echo "<td>" . htmlspecialchars($type) . "</td>";
            echo "<td>" . htmlspecialchars($department) . "</td>";
            echo "<td><a href='projekteinzelansicht.php?project_id=" . $project['id'] . "'>Details</a></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo '</div>';
        echo '</div>';
        echo '</body>';
        echo '</html>';
    }

    private function getProjects() {
        if ($this->cachedProjects === null) {
            $manager = new ProjectManager();
            $projects_json = $manager->all_projects();
            $this->cachedProjects = json_decode($projects_json, true);
        }
        return $this->cachedProjects;
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
}

$project_manager_test = new ProjectManagerTest();
$project_manager_test->display_all_projects();
?>
