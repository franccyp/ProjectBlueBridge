<h1 class="page-title">Projekteinzelansicht</h1>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekteinzelansicht</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0b0b45;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background-color: #1e1e6e;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #bbb;
        }

        /* Fortschrittsleiste */
        .progress-section {
            margin: 20px auto;
            width: 80%;
            text-align: center;
        }
        .progress-bar {
            background: #333;
            border-radius: 20px;
            height: 25px;
            width: 100%;
            position: relative;
        }
        .progress-bar span {
            display: block;
            background: #ff5733;
            height: 100%;
            width: 46%; /* Fortschrittsanteil */
            border-radius: 20px 0 0 20px;
        }
        .progress-label {
            margin-top: 10px;
            font-size: 16px;
        }

        /* Hauptsektion */
        .main-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            padding: 20px;
            width: 80%;
            margin: auto;
        }
        .card {
            background-color: #1e1e6e;
            border-radius: 10px;
            padding: 20px;
            flex: 1;
            min-width: 250px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        .card h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        /* Diagramme */
        .charts-section {
            width: 80%;
            margin: 20px auto;
        }
        .chart {
            background-color: #1e1e6e;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .chart h3 {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Kreisdiagramm */
        .pie-chart {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(
                    #ff5733 0% 31%,
                    #ffcd3c 31% 56%,
                    #33ff57 56% 100%
            );
            margin: 0 auto;
        }
        .pie-labels {
            text-align: center;
            margin-top: 10px;
        }
        .pie-label {
            margin: 5px 0;
        }

        /* Balkendiagramm */
        .bar-chart {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin: 20px auto;
            height: 200px;
            width: 90%;
        }
        .bar {
            width: 15%;
            text-align: center;
            background-color: #ff5733;
            border-radius: 5px 5px 0 0;
            position: relative;
        }
        .bar div {
            position: absolute;
            top: -25px;
            width: 100%;
            font-size: 14px;
            color: white;
        }
        .bar p {
            margin-top: 5px;
            font-size: 14px;
        }

        /* Meilensteine */
        .timeline {
            margin-top: 20px;
        }
        .milestone {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
            color: white;
        }
        .milestone span {
            font-size: 16px;
        }

        /* Footer */
        .footer {
            background-color: #1e1e6e;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Projekteinzelansicht - Projekt A</h1>
    <p>Geplanter Starttermin: 31. Januar 2025</p>
</div>

<div class="progress-section">
    <div class="progress-bar">
        <span></span>
    </div>
    <p class="progress-label">Fortschritt: 46%</p>
</div>

<div class="main-section">
    <div class="card">
        <h2>Planung</h2>
        <p>✔️ Abgeschlossen</p>
    </div>
    <div class="card">
        <h2>Design</h2>
        <p>✔️ Abgeschlossen</p>
    </div>
    <div class="card">
        <h2>Entwicklung</h2>
        <p>🔄 In Bearbeitung</p>
    </div>
    <div class="card">
        <h2>Testen</h2>
        <p>⚠️ Noch ausstehend</p>
    </div>
</div>

<div class="charts-section">
    <div class="chart">
        <h3>Aufgabenverteilung</h3>
        <div class="pie-chart"></div>
        <div class="pie-labels">
            <div class="pie-label">🔴 31% Planung</div>
            <div class="pie-label">🟡 25% Design</div>
            <div class="pie-label">🟢 44% Entwicklung</div>
        </div>
    </div>

    <div class="chart">
        <h3>Workload der Personen</h3>
        <div class="bar-chart">
            <div class="bar" style="height: 49%;">
                <div>49%</div>
                <p>Eshmam</p>
            </div>
            <div class="bar" style="height: 73%;">
                <div>73%</div>
                <p>Ranya</p>
            </div>
            <div class="bar" style="height: 42%;">
                <div>42%</div>
                <p>Linda</p>
            </div>
            <div class="bar" style="height: 38%;">
                <div>38%</div>
                <p>Amelie</p>
            </div>
            <div class="bar" style="height: 85%;">
                <div>85%</div>
                <p>David</p>
            </div>
        </div>
    </div>

    <div class="chart">
        <h3>Meilensteine</h3>
        <div class="timeline">
            <div class="milestone">
                <span>✅ Planung abgeschlossen</span>
                <span>Datum: 01.01.2025</span>
            </div>
            <div class="milestone">
                <span>✅ Design abgeschlossen</span>
                <span>Datum: 10.01.2025</span>
            </div>
            <div class="milestone">
                <span>🔄 Entwicklung läuft</span>
                <span>Ende: 20.01.2025</span>
            </div>
            <div class="milestone">
                <span>⚠️ Testen steht aus</span>
                <span>Geplant: 25.01.2025</span>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>© 2025 Projektmanagement</p>
</div>

</body>
</html>
