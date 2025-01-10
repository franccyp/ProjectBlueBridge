<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektübersicht</title>
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r flex-shrink-0">
        <div class="p-4">
            <h1 class="text-lg font-bold text-blue-700">Blue Ant</h1>
            <p class="text-sm text-gray-500">Part of Hypergene</p>
        </div>
        <nav class="mt-6">
            <h2 class="px-4 py-2 text-gray-700 text-sm font-bold">Menü</h2>
            <ul class="space-y-2">
                <li>
                    <a href="projektuebersicht.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m5 8l5 5m0-5l-5 5"/>
                        </svg>
                        Projektübersicht
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
        <h1 class="text-2xl font-bold mb-6">Projektübersicht</h1>
        <?php
        function build_table($array) {
            $html = '<table class="w-full text-sm text-left text-gray-500 border-collapse">';
            $html .= '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
            $html .= '<tr>';
            $html .= '<th class="px-6 py-3">Status</th>';
            $html .= '<th class="px-6 py-3">Projektname</th>';
            $html .= '<th class="px-6 py-3">Bereich</th>';
            $html .= '<th class="px-6 py-3">Projektleiter*in</th>';
            $html .= '<th class="px-6 py-3">Startdatum</th>';
            $html .= '<th class="px-6 py-3">Enddatum</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            foreach ($array as $value) {
                $html .= '<tr class="bg-white border-b">';
                $status_color = '';
                if ($value['Status'] == 'Gut') {
                    $status_color = 'text-green-500 bg-green-100';
                } elseif ($value['Status'] == 'Schlecht') {
                    $status_color = 'text-red-500 bg-red-100';
                } elseif ($value['Status'] == 'Information') {
                    $status_color = 'text-blue-500 bg-blue-100';
                }

                $html .= '<td class="px-6 py-4"><span class="' . $status_color . ' px-3 py-1 rounded-full">' . $value['Status'] . '</span></td>';
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Projektname']) . '</td>';
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Bereich']) . '</td>';
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Projektleiter']) . '</td>';
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Startdatum']) . '</td>';
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value['Enddatum']) . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            return $html;
        }

        $array = array(
            array('Status' => 'Gut', 'Projektname' => 'Project A', 'Bereich' => 'Finance', 'Projektleiter' => 'David Assmann', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
            array('Status' => 'Schlecht', 'Projektname' => 'Project B', 'Bereich' => 'IT', 'Projektleiter' => 'Amelie Seidl', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
            array('Status' => 'Information', 'Projektname' => 'Project C', 'Bereich' => 'Governance', 'Projektleiter' => 'Tom Musterman', 'Startdatum' => '02/01/2024', 'Enddatum' => '06/07/2024'),
        );

        echo build_table($array);
        ?>
    </main>
</div>

</body>
</html>
