<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Projekt XY</title>
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
        <div class="p-4 flex flex-col items-center">
            <img src="image.png" alt="Blue Ant Logo" class="mb-4 w-32 h-auto">
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
                    <a href="dashboard.php" class="flex items-center px-4 py-2 pastel-blue-dark text-white rounded hover:pastel-blue-hover">
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
    <main class="flex-1 p-6 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pastel-text">Dashboard - Projekt XY</h1>
            <input type="text" placeholder="Suche..." class="border rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <!-- Projektinformationen -->
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-bold mb-1 text-gray-600">Projektleiter*in</h2>
                <p>Max Musterman</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-bold mb-1 text-gray-600">Startdatum</h2>
                <p>03/04/2024</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-bold mb-1 text-gray-600">Enddatum</h2>
                <p>03/04/2024</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-bold mb-1 text-gray-600">Abteilung</h2>
                <p>Finanzen</p>
            </div>
        </div>

        <!-- Milestones -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4 pastel-text">Milestones</h2>
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="flex-grow">1. Meilenstein - ABCDEF</span>
                        <div class="relative w-full h-2 bg-gray-200 rounded-full mr-4">
                            <div class="absolute top-0 left-0 h-2 bg-blue-400 rounded-full" style="width: 70%;"></div>
                        </div>
                        <input type="checkbox">
                    </li>
                    <li class="flex items-center">
                        <span class="flex-grow">2. Meilenstein - ABCDEF</span>
                        <div class="relative w-full h-2 bg-gray-200 rounded-full mr-4">
                            <div class="absolute top-0 left-0 h-2 bg-blue-400 rounded-full" style="width: 50%;"></div>
                        </div>
                        <input type="checkbox">
                    </li>
                    <li class="flex items-center">
                        <span class="flex-grow">3. Meilenstein - ABCDEF</span>
                        <div class="relative w-full h-2 bg-gray-200 rounded-full mr-4">
                            <div class="absolute top-0 left-0 h-2 bg-blue-400 rounded-full" style="width: 30%;"></div>
                        </div>
                        <input type="checkbox">
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-bold mb-2 pastel-text">Status</h2>
                <div class="flex items-center justify-center bg-blue-100 text-blue-500 text-4xl font-bold rounded-full h-32 w-32 mx-auto my-4">
                    62%
                </div>
                <p>Ziel</p>
            </div>
        </div>

        <!-- Laufzeit -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4 pastel-text">Laufzeit</h2>
            <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center">
                <p>Graph oder Diagramm hier einfügen</p>
            </div>
        </div>

        <!-- Zielsetzung und Gegenstand -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2 pastel-text">Zielsetzung</h2>
                <p>Das Ziel des Projekts ist es ........</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2 pastel-text">Gegenstand</h2>
                <p>Test Test</p>
                <p>Lorem Ipsum</p>
            </div>
        </div>

        <!-- List Box und Freitext -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2 pastel-text">List Box</h2>
                <ul class="list-disc pl-5">
                    <li>A</li>
                    <li>B</li>
                    <li>C</li>
                    <li>D</li>
                    <li>E</li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <button class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-500">Berechnetes Feld</button>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <textarea class="w-full border rounded p-2" placeholder="Freitextfeld"></textarea>
            </div>
        </div>
    </main>
</div>

</body>
</html>
