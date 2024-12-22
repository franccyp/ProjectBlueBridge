<h1 class ="page-title">Projektübersicht</h1>
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<?php
function build_table($array){
    // start table
    $html = '<table class="w-full text-sm text-left rtl:text-right text-gray-500 ">';
    // header row+
    $html .= '<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 ">';
    $html .= '<tr class="bg-white border-b ">';

    foreach($array[0] as $key=>$value){
        $html .= '<th class="px-6 py-3">' . htmlspecialchars($key) . '</th>';
    }
    $html .= '</tr>';
$html .= '</thead>';
    // data rows
    $html .= '<tbody>';
    foreach( $array as $key=>$value){
        $html .= '<tr class="bg-white border-b ">';
        foreach($value as $key2=>$value2){
            if ($key2 == 'Status' ){
              $html .=  '<td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">Green</span></td>';

            }else {
                $html .= '<td class="px-6 py-4">' . htmlspecialchars($value2) . '</td>';
            }

        }
        $html .= '</tr>';
    }
$html .= '</tbody>';
    // finish table and return it

    $html .= '</table>';
    return $html;
}

$array = array(
    array('Status'=>'Gut', 'Projektname'=>'Project A', 'Bereich'=>'Finance', 'Projektleiter'=>'David Assmann', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Schlecht', 'Projektname'=>'Project B', 'Bereich'=>'IT', 'Projektleiter'=>'Amelie Seidl', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Schlecht', 'Projektname'=>'Project C', 'Bereich'=>'Governance', 'Projektleiter'=>'Max Musterfrau', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Information', 'Projektname'=>'Project D', 'Bereich'=>'R&D', 'Projektleiter'=>'Tom Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Gut', 'Projektname'=>'Project E', 'Bereich'=>'Science', 'Projektleiter'=>'Anna Schmitt', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Schlecht', 'Projektname'=>'Project F', 'Bereich'=>'Finance', 'Projektleiter'=>'Max Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Schlecht', 'Projektname'=>'Project G', 'Bereich'=>'Finance', 'Projektleiter'=>'Max Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Information', 'Projektname'=>'Project H', 'Bereich'=>'Finance', 'Projektleiter'=>'Max Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Information', 'Projektname'=>'Project I', 'Bereich'=>'Finance', 'Projektleiter'=>'Max Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),
    array('Status'=>'Gut', 'Projektname'=>'Project J', 'Bereich'=>'Finance', 'Projektleiter'=>'Max Musterman', 'Startdatum'=>'02/01/2024', 'Enddatum'=>'06/07/2024'),

);

echo build_table($array);
?>