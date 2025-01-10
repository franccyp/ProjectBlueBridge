<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Projekt XY</title>
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
        <h1 class="text-2xl font-bold mb-6">Dashboard - Projekt XY</h1>

        <!-- Projektinformationen -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4m0 0a2 2 0 00-4 0M3 9m0 0a2 2 0 104 0m0 0a2 2 0 00-4 0M7 3v3m0 0v3"/>
                </svg>
                <div>
                    <h2 class="text-lg font-bold">Projektname</h2>
                    <p>Projekt XY</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4m0 0a2 2 0 00-4 0M3 9m0 0a2 2 0 104 0m0 0a2 2 0 00-4 0M7 3v3m0 0v3"/>
                </svg>
                <div>
                    <h2 class="text-lg font-bold">Projektleiter*in</h2>
                    <p>Max Musterman</p>
                </div>
            </div>
        </div>

        <!-- Milestones -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-lg font-bold mb-4">Milestones</h2>
            <ul class="space-y-4">
                <li class="flex items-center">
                    <span class="flex-grow">1. Meilenstein - ABCDEF</span>
                    <div class="relative w-full h-2 bg-gray-200 rounded-full mr-4">
                        <div class="absolute top-0 left-0 h-2 bg-blue-500 rounded-full" style="width: 70%;"></div>
                    </div>
                    <input type="checkbox" class="ml-2">
                </li>
                <li class="flex items-center">
                    <span class="flex-grow">2. Meilenstein - ABCDEF</span>
                    <div class="relative w-full h-2 bg-gray-200 rounded-full mr-4">
                        <div class="absolute top-0 left-0 h-2 bg-blue-500 rounded-full" style="width: 40%;"></div>
                    </div>
                    <input type="checkbox" class="ml-2">
                </li>
            </ul>
        </div>

        <!-- Projektstatus und Laufzeit -->
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2 bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Laufzeit</h2>
                <div class="bg-gray-100 h-64 flex items-center justify-center rounded-lg">
                    <p>Graph oder Diagramm hier einfügen</p>
                </div>
            </div>
            <div class="col-span-1 bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-bold">Projektstatus</h2>
                <div class="flex items-center justify-center bg-blue-500 text-white text-4xl font-bold rounded-full h-32 w-32 mx-auto my-4">
                    85%
                </div>
                <p>Das Projekt ist zu 85% abgeschlossen.</p>
            </div>
        </div>

        <!-- Zielsetzung und Gegenstand -->
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2">Zielsetzung</h2>
                <p>Test Test</p>
                <p>20 Stunden</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2">Gegenstand</h2>
                <p>Test Test</p>
                <p>Lorem Ipsum</p>
            </div>
        </div>
    </main>
</div>

</body>
</html>
