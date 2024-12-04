<?php
 include_once "classes/Table.php";
 include_once "classes/Menu.php";
 
use classes\Table;
use classes\Menu;

$table = new Table(); 
$menu = new Menu();

$files = [
    "table" => "table.json",
    "tableTea" => "tableTea.json",
    "nav_menu" => "nav_menu.json"
];

foreach ($files as $type => $filename) {
    if (!file_exists($filename)) {
        if ($type === "nav_menu") {
            $menu->saveDataToFile($type);
        } else {
            $table->saveDataToFile($type);
        }
    }
}

//Načítanie údajov z json do databázy
$table->insertDataFromBothJsonFiles();
