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

        // API-Daten abrufen
//        $projects_json = $manager->all_projects();
        $projects = $this->getProjects();


        // JSON-Daten in ein PHP-Array umwandeln
//        $projects = json_decode($projects_json, true);

//        var_dump($projects); // Inhalt der Variable anzeigen
//        die(); // Skript beenden, um die Ausgabe klar zu sehen

        // Prüfen, ob Daten vorhanden sind
        if (!$projects || !isset($projects['projects'])) {
            echo "<p>Keine Projekte gefunden oder ein Fehler ist aufgetreten.</p>";
            return;
        }

        // HTML-Ausgabe
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="Design.css">'; // CSS-Datei verlinken
        echo '<title>Projektübersicht</title>';
        echo '</head>';
        echo '<body>';
        echo '<div class="flex min-h-screen">';

        $menu->renderMenu();

        // Suchfeld hinzufügen


        // Filterformular
        echo '<form method="GET" action="" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">';
        echo '<label for="search_query">Suchen: </label>';
        echo '<input type="text" id="search_query" name="search_query" value="' . htmlspecialchars($_GET['search_query'] ?? '') . '" placeholder="Suchen..." />';
        echo '<button type="submit">Suchen</button>';

// Dropdown für die Filterkategorie
        echo '<label for="filter_type">Filter nach: </label>';
        echo '<select id="filter_type" name="filter_type" onchange="this.form.submit()">';
        echo '<option value="">-- Wählen Sie --</option>';
        echo '<option value="status" ' . (isset($_GET['filter_type']) && $_GET['filter_type'] === 'status' ? 'selected' : '') . '>Status</option>';
        echo '<option value="business_area" ' . (isset($_GET['filter_type']) && $_GET['filter_type'] === 'business_area' ? 'selected' : '') . '>Unternehmensbereich</option>';
        echo '<option value="type" ' . (isset($_GET['filter_type']) && $_GET['filter_type'] === 'type' ? 'selected' : '') . '>Projektart</option>';
        echo '</select>';

// Zweites Dropdown basierend auf der Auswahl
        if (isset($_GET['filter_type']) && $_GET['filter_type'] === 'status') {
            echo '<label for="filter_value">Status: </label>';
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';

            // Dynamische Statuswerte basierend auf Projektdaten
            $statuses = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveStatus($project['statusId'] ?? '');
            }, $projects['projects']));

            foreach ($statuses as $status) {
                echo '<option value="' . htmlspecialchars($status) . '" ' . (isset($_GET['filter_value']) && $_GET['filter_value'] === $status ? 'selected' : '') . '>' . htmlspecialchars($status) . '</option>';
            }

            echo '</select>';
        } elseif (isset($_GET['filter_type']) && $_GET['filter_type'] === 'business_area') {
            echo '<label for="filter_value">Unternehmensbereich: </label>';
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';

            // Dynamische Unternehmensbereiche basierend auf Projektdaten
            $business_areas = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveDepartment($project['departmentId'] ?? '');
            }, $projects['projects']));

            foreach ($business_areas as $area) {
                echo '<option value="' . htmlspecialchars($area) . '" ' . (isset($_GET['filter_value']) && $_GET['filter_value'] === $area ? 'selected' : '') . '>' . htmlspecialchars($area) . '</option>';
            }

            echo '</select>';
        } elseif (isset($_GET['filter_type']) && $_GET['filter_type'] === 'type') {
            echo '<label for="filter_value">Typ: </label>';
            echo '<select id="filter_value" name="filter_value">';
            echo '<option value="">Alle</option>';

            // Dynamische Typen basierend auf Projektdaten
            $types = array_unique(array_map(function ($project) use ($resolver) {
                return $resolver->resolveType($project['typeId'] ?? '');
            }, $projects['projects']));

            foreach ($types as $type) {
                echo '<option value="' . htmlspecialchars($type) . '" ' . (isset($_GET['filter_value']) && $_GET['filter_value'] === $type ? 'selected' : '') . '>' . htmlspecialchars($type) . '</option>';
            }

            echo '</select>';
        }

        echo '<button type="submit">Filtern</button>';
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
        echo "<th>Status</th>"; // Neue Spalte für Status
        echo "<th>Projektart</th>"; // Neue Spalte für Typ
        echo "<th>Unternehmensbereich</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";


        $filter_type = $_GET['filter_type'] ?? '';
        $filter_value = $_GET['filter_value'] ?? '';

        $search_query = $_GET['search_query'] ?? '';

        foreach ($projects['projects'] as $project) {
            $status = $resolver->resolveStatus($project['statusId'] ?? 'Unbekannt');
            $type = $resolver->resolveType($project['typeId'] ?? 'Unbekannt');
            $department = $resolver->resolveDepartment($project['departmentId'] ?? 'Unbekannt');
            $projectLeaderName = isset($project['projectLeaderId'])
                ? $this->get_person_name($project['projectLeaderId'])
                : 'Unbekannt';

            // Suchlogik: Überprüfen, ob die Suchanfrage in einem der Felder vorkommt
            if ($search_query && stripos($project['name'], $search_query) === false &&
                stripos($project['projectLeaderId'] ?? '', $search_query) === false) {
                continue; // Projekt wird übersprungen, wenn es nicht zur Suche passt
            }

            if ($filter_type === 'status' && $filter_value && stripos($status, $filter_value) === false) {
                continue; // Überspringe Projekte, die nicht dem Status-Filter entsprechen
            }

            if ($filter_type === 'business_area' && $filter_value && stripos($department, $filter_value) === false) {
                continue; // Überspringe Projekte, die nicht dem Unternehmensbereich-Filter entsprechen
            }

            if ($filter_type === 'type' && $filter_value && stripos($type, $filter_value) === false) {
                continue; // Überspringe Projekte, die nicht dem Typ-Filter entsprechen
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($project['number']) . "</td>";
            echo "<td>" . htmlspecialchars($project['name']) . "</td>";
            echo "<td>" . htmlspecialchars($projectLeaderName) . "</td>";
            echo "<td>" . htmlspecialchars($this->format_date($project['start'] ?? null)) . "</td>"; // Startdatum
            echo "<td>" . htmlspecialchars($this->format_date($project['end'] ?? null)) . "</td>"; // Enddatum
            echo "<td>" . htmlspecialchars($status) . "</td>";
            echo "<td>" . htmlspecialchars($type) . "</td>";
            echo "<td>" . htmlspecialchars($department) . "</td>";
            echo "<td><a href='projekteinzelansicht.php?project_id=" . $project['id'] . "'>Details</a></td>"; // Link zur Einzelansicht hinzufügen
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        echo '</div>';
        echo '</body>';
        echo '</html>';
    }

    /**
     * Testet die Projektsuche anhand eines Filters (z. B. nach Namen).
     */
    function test_get_projects_filter_name() {
        $manager = new ProjectManager();
        $manager->get_project_filter_name('Project BlueBridge'); // bei name den Namen des Projekts für Einzelansicht
    }

    /**
     * Testet die Anzeige aller Projekte.
     */
    function test_get_all_projects() {
        $this->display_all_projects();
    }

    function test_get_all_projects_by_filter() {
        $this->display_all_projects();
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
     * Formatiert ein Datum in das deutsche Format (DD-MM-YYYY).
     */
    private function format_date($date) {
        if (!$date) {
            return 'Unbekannt';
        }

        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        if ($dateObject) {
            return $dateObject->format('d-m-Y'); // Datum ins deutsche Format ändern
        }

        return 'Ungültiges Datum';
    }

}


?>

<?php
$project_manager_test = new ProjectManagerTest();
$project_manager_test->display_all_projects();

// Optional: Nur zum Testen, aber nicht zusammen mit display_all_projects
// $project_manager_test->test_get_all_projects();
// $project_manager_test->test_get_projects_filter_id(358638433);
?>