<?php
 include_once "classes/Table.php";
 
use classes\Table;
$table = new Table(); 

$files = [
    "table" => "table.json",
    "tableTea" => "tableTea.json"
];

foreach ($files as $type => $filename) {
    if (!file_exists($filename)) {
        $table->saveDataToFile($type);
    }
}
