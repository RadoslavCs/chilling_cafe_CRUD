<?php

namespace classes;

include_once("classes/Database.php");
use classes\Database;


class Table
{
     // Vytvorenie inštancie databázy
    protected  $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private $table = [
        'header' => [
            '&nbsp;',
            'Hot',
            'Iced',
            'Blended',
        ],
        'rows' => [
            'Americano' => [
                'Hot' => '$10',
                'Iced' => '$15',
                'Blended' => '-',
            ],
            'Cappuccino' => [
                'Hot' => '$15',
                'Iced' => '$18',
                'Blended' => '$20',
            ],
            'Fresh Latte' => [
                'Hot' => '$10',
                'Iced' => '$18',
                'Blended' => '$20',
            ],
            'Mocha' => [
                'Hot' => '$15',
                'Iced' => '$18',
                'Blended' => '$20',
            ],
            'Espresso' => [
                'Hot' => '$10',
                'Iced' => '$15',
                'Blended' => '-',
            ],
            'Black Coffee' => [
                'Hot' => '$15',
                'Iced' => '-',
                'Blended' => '-',
            ],
            'Double Shot Espresso' => [
                'Hot' => '$20',
                'Iced' => '$20',
                'Blended' => '-',
            ],
        ],
    ];

    private $tableTea = [
        'header' => [
            '&nbsp;',
            'Hot',
            'Iced',
            'Addon',
        ],
        'rows' => [
            'Pure White Milk' => [
                'Hot' => '$5',
                'Iced' => '$10',
                'Addon' => '-',
            ],
            'Hong Kong Tea' => [
                'Hot' => '$8',
                'Iced' => '$12',
                'Addon' => '$4',
            ],
            'Taiwan Tea' => [
                'Hot' => '$4',
                'Iced' => '$10',
                'Addon' => '$4',
            ],
            'Bubble Tea' => [
                'Hot' => '$8',
                'Iced' => '$12',
                'Addon' => '-',
            ],
            'Mixed Fruit Tea' => [
                'Hot' => '$10',
                'Iced' => '$15',
                'Addon' => '8',
            ],
            'Black Tea' => [
                'Hot' => '$15',
                'Iced' => '-',
                'Addon' => '$3',
            ],
            'Original Tea' => [
                'Hot' => '$12',
                'Iced' => '$14',
                'Addon' => '-',
            ],
        ],
    ];    
    
    //Funkcia môže generovať HTML kód tabuľky ako string a vrátiť ho.
    public function getTable(string $type = "table"): string
    {
        // Získanie správnej tabuľky na základe typu
        $tableData = $type === "table" ? $this->table : ($type === "tableTea" ? $this->tableTea : null);

        // Ak neexistuje správna tabuľka, vráť prázdny reťazec
        if ($tableData === null || !isset($tableData['header'], $tableData['rows'])) {
            return "<p>Nepodarilo sa načítať tabuľku.</p>";
        }

        // Generovanie tabuľky
        $html = '<table>';

        // Generovanie hlavičky tabuľky
        $html .= $this->generateTableHeader($tableData['header']);

        // Generovanie riadkov tabuľky
        $html .= $this->generateTableRows($tableData);

        $html .= '</table>';

        return $html;
    }

    //Funkcia môže generovať HTML kód tabuľky ako html string pomocou "table.json" a "tableTea.json".
    public function getTableFromFile(string $type = "table"): string
    {
        // Získanie cesty k správnemu súboru
        $filePath = $type === "table" ? "table.json" : ($type === "tableTea" ? "tableTea.json" : null);

        // Kontrola, či súbor existuje
        if ($filePath === null || !file_exists($filePath)) {
            return "<p>Súbor s tabuľkou neexistuje alebo bol zadaný nesprávny typ.</p>";
        }

        // Načítanie a dekódovanie obsahu JSON
        $tableData = json_decode(file_get_contents($filePath), true);

        // Validácia načítaných dát
        if (!isset($tableData['header'], $tableData['rows'])) {
            return "<p>Dáta tabuľky nie sú v očakávanom formáte.</p>";
        }

        // Generovanie tabuľky
        $html = '<table>';

        // Generovanie hlavičky tabuľky
        $html .= $this->generateTableHeader($tableData['header']);

        // Generovanie riadkov tabuľky
        $html .= $this->generateTableRows($tableData);

        $html .= '</table>';

        return $html;
    }

    //Funkcia na generovanie hlavičky tabuľky
    private function generateTableHeader(array $headers): string
    {
        $html = '<tr>';
        foreach ($headers as $headerCell) {
            $html .= "<th>{$headerCell}</th>";
        }
        $html .= '</tr>';
        return $html;
    }

    //Funkcia na generovanie riadkov tabuľky
    private function generateTableRows(array $tableData): string
    {
        $html = '';
        foreach ($tableData['rows'] as $product => $details) {
            $html .= '<tr>';

            // Prvý stĺpec: názov produktu
            $html .= "<td class='tm-text-left'>{$product}</td>";

            // Ostatné stĺpce podľa hlavičky
            foreach ($tableData['header'] as $headerIndex => $headerName) {
                if ($headerIndex === 0) continue; // Preskoč prázdny stĺpec ('&nbsp;')
                $value = $details[$headerName] ?? '-';
                $html .= "<td>{$value}</td>";
            }

            $html .= '</tr>';
        }
        return $html;
    }

    // Funkcia na načítanie tabuľky z databázy
    public function getTableFromDatabase(string $type = "table"): string
    {
        // Nastavenie hlavičiek tabuľky
        $headers = $type === "table" 
            ? ['&nbsp;', 'Hot', 'Iced', 'Blended'] 
            : ($type === "tableTea" ? ['&nbsp;', 'Hot', 'Iced', 'Addon'] : null);

        // Ak hlavičky nie sú správne, vráť prázdnu tabuľku
        if ($headers === null) {
            return "<p>Neplatný typ tabuľky.</p>";
        }

        // Načítanie údajov z databázy
        $dataRows = $type === "table" 
            ? $this->db->getDataForCoffee() 
            : ($type === "tableTea" ? $this->db->getDataForTea() : null);

        if ($dataRows === null || empty($dataRows)) {
            return "<p>Nepodarilo sa načítať údaje z databázy.</p>";
        }

        // Transformácia údajov na štruktúru pre generovanie riadkov
        $tableData = [
            'header' => $headers,
            'rows' => $this->transformDataRows($dataRows, $headers),
        ];

        // Generovanie tabuľky
        $html = '<table>';

        // Generovanie hlavičky tabuľky
        $html .= $this->generateTableHeader($tableData['header']);

        // Generovanie riadkov tabuľky
        $html .= $this->generateTableRows($tableData);

        $html .= '</table>';

        return $html;
    }

        // Transformácia údajov z databázy na štruktúru pre tabuľku
        private function transformDataRows(array $dataRows, array $headers): array
        {
            $transformedRows = [];
            foreach ($dataRows as $row) {
                $rowData = [];
                foreach ($headers as $header) {
                    if ($header === '&nbsp;') {
                        $rowData['name'] = $row['name']; // Názov nápoja
                    } else {
                        $key = strtolower($header) . '_price'; // Mapa kľúčov ako 'hot_price', 'iced_price', 'blended_price', ...
                        $rowData[$header] = isset($row[$key]) && $row[$key] !== '-' ? '$' . $row[$key] : '-';
                    }
                }
                $transformedRows[$row['name']] = $rowData;
            }
            return $transformedRows;
        }

    // Funkcia uloží štruktúru `table` do `table.json` ak $type = "table" 
    // alebo `tableTea.json` ak $type === "tableTea"
    public function saveDataToFile($type = "table")
    {
        $data = ($type === "table") ? $this->table : (($type === "tableTea") ? $this->tableTea : null);
        $fileName = $type . ".json";
    
        if ($data !== null) {
            $save = file_put_contents($fileName, json_encode($data));
            echo $save ? "Menu bolo uspesne ulozene" : "Nastala chyba";
        } else {
            echo "Neznámy typ tabuľky";
        }
        
    }

    //Načíta dáta pre kávu a  čaj z JSON súborov a uloží ich
    public function insertDataFromBothJsonFiles()
    {
        // Názvy súborov pre kávu a čaj
        $coffeeFile = "table.json";
        $teaFile = "tableTea.json";
    
        // Načítanie dát z oboch JSON súborov
        $coffeeData =  json_decode(file_get_contents($coffeeFile), true);
        $teaData = json_decode(file_get_contents($teaFile), true);
    
        // Pridanie stĺpca 'drink_type' pre kávu a čaj
        foreach ($coffeeData['rows'] as $name => $details) {
            $coffeeData['rows'][$name]['drink_type'] = 'Coffee'; // Pre kávu
        }
    
        foreach ($teaData['rows'] as $name => $details) {
            $teaData['rows'][$name]['drink_type'] = 'Tea'; // Pre čaj
        }
    
        // Spojenie dát a odstránenie duplicít podľa názvu nápoja
        $allData = array_merge($coffeeData['rows'], $teaData['rows']);
        $uniqueData = [];
    
        foreach ($allData as $name => $details) {
            if (!isset($uniqueData[$name])) {
                $uniqueData[$name] = $details;
            }
        }
    
        // Kombinované dáta bez duplicít
        $jsonData = [
            'rows' => $uniqueData,
        ];
    
        // Validácia obsahu JSON
        if (!isset($jsonData['rows']) || empty($jsonData['rows'])) {
            echo "Dáta v JSON sú neplatné alebo prázdne.";
            return;
        }
    
        // Príprava SQL na vloženie dát
        $sql = "INSERT INTO menu_table (id, name, drink_type, hot_price, iced_price, addon_price, blended_price) 
                VALUES (:id, :name, :drink_type, :hot_price, :iced_price, :addon_price, :blended_price)
                ON DUPLICATE KEY UPDATE 
                hot_price = VALUES(hot_price), iced_price = VALUES(iced_price), 
                addon_price = VALUES(addon_price), blended_price = VALUES(blended_price)";
    
        // Použitie metódy prepareQuery
        $stmt = $this->db->prepareQuery($sql);
    
        $id = 1; // Počiatočný ID (manuálne inkrementovanie)
    
        // Iterácia cez skombinované dáta a vloženie
        foreach ($jsonData['rows'] as $name => $details) {
            // Príprava dát pre každý riadok
            $hotPrice = isset($details['Hot']) && $details['Hot'] !== '-' ? ltrim($details['Hot'], '$') : '-';
            $icedPrice = isset($details['Iced']) && $details['Iced'] !== '-' ? ltrim($details['Iced'], '$') : '-';
            $addonPrice = isset($details['Addon']) && $details['Addon'] !== '-' ? ltrim($details['Addon'], '$') : '-';
            $blendedPrice = isset($details['Blended']) && $details['Blended'] !== '-' ? ltrim($details['Blended'], '$') : '-';
    
            // Určenie drink_type - už je nastavené
            $drinkType = $details['drink_type'];  // Už je nastavené na Coffee alebo Tea
    
            // Vykonanie SQL s nahradenými parametrami
            $stmt->execute([
                ':id' => $id++,
                ':name' => $name,
                ':drink_type' => $drinkType,
                ':hot_price' => $hotPrice,
                ':iced_price' => $icedPrice,
                ':addon_price' => $addonPrice,
                ':blended_price' => $blendedPrice
            ]);
        }
    
        echo "Dáta zo súborov pre kávu a čaj boli úspešne vložené do tabuľky.";
    }   
   
    
}