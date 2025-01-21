<?php
include "menu.php";
include "get_projects.php";

class ProjectManagerTest {
    private $personCache = []; // Cache für Namen von Personen

    /**
     * Holt den vollständigen Namen einer Person anhand der ID.
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
     * Zeigt alle Projekte in einer Tabelle an.
     */
    function display_all_projects() {
        $menu = new Menu(); // Menü erstellen
        $manager = new ProjectManager();

        // API-Daten abrufen
        $projects_json = $manager->all_projects();

        // JSON-Daten in ein PHP-Array umwandeln
        $projects = json_decode($projects_json, true);

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

        // Tabelle generieren
        echo '<div class="content">';
        echo '<h1>Projektübersicht</h1>';
        echo "<table class='project-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Projektname</th>";
        echo "<th>Projektleiter</th>";
        echo "<th>Startdatum</th>";
        echo "<th>Enddatum</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($projects['projects'] as $project) {
            $projectLeaderName = isset($project['projectLeaderId'])
                ? $this->get_person_name($project['projectLeaderId'])
                : 'Unbekannt';

            echo "<tr>";
            echo "<td>" . htmlspecialchars($project['id']) . "</td>"; // Projekt-ID
            echo "<td>" . htmlspecialchars($project['name']) . "</td>"; // Projektname
            echo "<td>" . htmlspecialchars($projectLeaderName) . "</td>"; // Projektleiter als Name
            echo "<td>" . htmlspecialchars(isset($project['start']) ? $project['start'] : 'Unbekannt') . "</td>"; // Startdatum
            echo "<td>" . htmlspecialchars(isset($project['end']) ? $project['end'] : 'Unbekannt') . "</td>"; // Enddatum
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
}

// Instanz erstellen und die Methoden aufrufen
$project_manager_test = new ProjectManagerTest();
$project_manager_test->display_all_projects();
?>
