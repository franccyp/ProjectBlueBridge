<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektübersicht</title>
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .pastel-blue {
            background-color: #d8e6f3;
        }
        .pastel-blue-dark {
            background-color: #aac8e8;
        }
        .pastel-blue-hover:hover {
            background-color: #c3d9ef;
        }
        .pastel-text {
            color: #345b7e;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 pastel-blue text-pastel-text flex-shrink-0">
        <div class="p-4">
            <img src="https://via.placeholder.com/150x50" alt="Blue Ant" class="mb-4">
            <h1 class="text-lg font-bold">Blue Ant</h1>
            <p class="text-sm opacity-75">Part of Hypergene</p>
        </div>
        <nav class="mt-6">
            <ul class="space-y-2">
                <li>
                    <a href="projektuebersicht.php" class="flex items-center px-4 py-2 pastel-blue-dark text-white rounded hover:pastel-blue-hover">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m5 8l5 5m0-5l-5 5"/>
                        </svg>
                        Projektübersicht
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" class="flex items-center px-4 py-2 text-pastel-text hover:pastel-blue-hover rounded">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.723A2 2 0 013 15.553V6.447a2 2 0 011.553-1.947L9 3m10 17v-4a4 4 0 00-4-4H5m14 4l-5 5"/>
                        </svg>
                        Dashboard - Projekt XY
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Projektübersicht</h1>
            <input type="text" placeholder="Suche..." class="border rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <!-- Filterbereich -->
        <div class="flex items-center mb-6 space-x-4">
            <select class="border rounded-lg px-4 py-2 w-48">
                <option>Projektleiter*in</option>
                <option>Linda Izadi</option>
                <option>Amelie Seidel</option>
                <option>Ranya Cherara</option>
                <option>Max Musterman</option>
            </select>
            <select class="border rounded-lg px-4 py-2 w-48">
                <option>Bereich</option>
                <option>Finance</option>
                <option>IT</option>
                <option>Governance</option>
                <option>Science</option>
            </select>
            <select class="border rounded-lg px-4 py-2 w-48">
                <option>Startdatum</option>
            </select>
            <select class="border rounded-lg px-4 py-2 w-48">
                <option>Enddatum</option>
            </select>
            <select class="border rounded-lg px-4 py-2 w-48">
                <option>Status</option>
                <option>laufend</option>
                <option>abgeschlossen</option>
            </select>
        </div>

        <!-- Tabelle -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-600 bg-white shadow-md rounded-lg">
                <thead class="pastel-blue-dark text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Projektname</th>
                    <th class="px-6 py-3 text-left">Details</th>
                    <th class="px-6 py-3 text-left">Bereich</th>
                    <th class="px-6 py-3 text-left">Projektleiter*in</th>
                    <th class="px-6 py-3 text-left">Startdatum</th>
                    <th class="px-6 py-3 text-left">Enddatum</th>
                </tr>
                </thead>
                <tbody>
                <?php
                function build_table($array) {
                    $html = '';
                    foreach ($array as $value) {
                        $status_icon = '';
                        if ($value['Status'] == 'Gut') {
                            $status_icon = '<span class="text-green-600 font-bold">✔</span>';
                        } elseif ($value['Status'] == 'Schlecht') {
                            $status_icon = '<span class="text-red-600 font-bold">✖</span>';
                        } elseif ($value['Status'] == 'Information') {
                            $status_icon = '<span class="text-yellow-600 font-bold">ℹ</span>';
                        }

                        $html .= '<tr class="border-b hover:bg-gray-50">';
                        $html .= '<td class="px-6 py-4">' . $status_icon . '</td>';
                        $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Projektname']) . '</td>';
                        $html .= '<td class="px-6 py-4"><a href="dashboard.php" class="text-blue-600 hover:underline">Details</a></td>';
                        $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Bereich']) . '</td>';
                        $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Projektleiter']) . '</td>';
                        $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Startdatum']) . '</td>';
                        $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Enddatum']) . '</td>';
                        $html .= '</tr>';
                    }
                    return $html;
                }

                $array = array(
                    array('Status' => 'Gut', 'Projektname' => 'Project A', 'Bereich' => 'Finance', 'Projektleiter' => 'David Assmann', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
                    array('Status' => 'Schlecht', 'Projektname' => 'Project B', 'Bereich' => 'IT', 'Projektleiter' => 'Amelie Seidl', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
                    array('Status' => 'Information', 'Projektname' => 'Project C', 'Bereich' => 'Governance', 'Projektleiter' => 'Max Musterman', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
                );

                echo build_table($array);
                ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
