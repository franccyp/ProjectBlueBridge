<?php

class MasterDataResolver {
    private $baseUrl = "https://dashboard-examples.blueant.cloud/rest/v1/masterdata/projects";
    private $authHeader = "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI3OTkzMjYxMDAiLCJpYXQiOjE3MzQwOTAzNjAsImlzcyI6IkJsdWUgQW50wqkiLCJleHAiOjE4OTE3NzAzNjB9.efWIguMIVfA24nz2Jp7NWEgBJiTWEBaN_hXUbff1Dfk";
    private $resolvedData = [
        'statuses' => [],
        'types' => [],
        'departments' => []
    ];

    private $departments = 'https://dashboard-examples.blueant.cloud/rest/v1/masterdata/departments';

    /**
     * Führt einen cURL-GET-Aufruf aus, um Daten anhand einer ID zu holen
     */
    private function fetchById($endpoint, $id) {
        $url = "{$this->baseUrl}{$endpoint}/{$id}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            $this->authHeader
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

//        var_dump($response); // Inhalt der Variable anzeigen
//        die();

        if ($httpCode === 200) {
            return json_decode($response, true);
        } else {
            error_log("Fehler beim Abrufen der Daten von {$url}: HTTP {$httpCode}");
            return null;
        }
    }

    /**
     * Holt den Statusnamen anhand der Status-ID
     */
    public function resolveStatus($statusId) {
        if (!isset($this->resolvedData['statuses'][$statusId])) {
            $data = $this->fetchById('/statuses', $statusId);

            // Debugging: Zeige die gesamte Antwort
//            echo "Antwort für Status ID {$statusId}: ";
//            var_dump($data);

            // Überprüfen, ob projectStatus und text existieren
            if ($data && isset($data['projectStatus']['text'])) {
                $this->resolvedData['statuses'][$statusId] = $data['projectStatus']['text']; // Wert extrahieren
            } else {
                $this->resolvedData['statuses'][$statusId] = "Unbekannt"; // Fallback, wenn keine Daten vorhanden sind
            }
        }

        return $this->resolvedData['statuses'][$statusId];
    }



    /**
     * Holt den Typnamen anhand der Typ-ID
     */
    public function resolveType($typeId) {
        if (!isset($this->resolvedData['types'][$typeId])) {
            $data = $this->fetchById('/types', $typeId);

            // Debugging: Zeige die gesamte API-Antwort
//                echo "Antwort für Typ ID {$typeId}: ";
//                var_dump($data);

            // Entferne das die() für die Debugging-Ausgabe, um den weiteren Code ausführbar zu machen
            if (isset($data['type']['shortDescription'])) {
                $this->resolvedData['types'][$typeId] = $data['type']['shortDescription']; // Extrahiere die Kurzbeschreibung
            } elseif (isset($data['status']['code']) && $data['status']['code'] === 404) {
                $this->resolvedData['types'][$typeId] = "Nicht gefunden (404)"; // Spezifische Fehlermeldung für 404
            } else {
                $this->resolvedData['types'][$typeId] = "Unbekannt"; // Genereller Fallback
            }
        }

        return $this->resolvedData['types'][$typeId];
    }





    /**
     * Holt den Namen des Unternehmensbereichs anhand der Department-ID
     */
    public function resolveDepartment($departmentId) {
        if (!isset($this->resolvedData['departments'][$departmentId])) {
            // Manuelle Anpassung des Endpunkts mit zusätzlichen Parametern
            $url = "{$this->departments}/{$departmentId}?includeCustomFields=true&includeExternalSystemInformation=true";




            // cURL-Aufruf
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "accept: application/json",
                $this->authHeader
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
//            echo("DATEN:");

//            var_dump($url);
//            die();

            // Verarbeitung der API-Antwort
            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if ($data && isset($data['department']['text'])) {
                    $this->resolvedData['departments'][$departmentId] = $data['department']['text'];
                } else {
                    $this->resolvedData['departments'][$departmentId] = "Unbekannt";
                }
            } else {
                // Fehlerbehandlung
                $this->resolvedData['departments'][$departmentId] = "Unbekannt";
                error_log("Fehler beim Abrufen der Daten für Unternehmensbereich ID {$departmentId}: HTTP {$httpCode}");
            }
        }

        return $this->resolvedData['departments'][$departmentId];
    }



}

?>