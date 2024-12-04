<?php

namespace classes;
include_once("classes/Table.php");
use classes\Table;

class Menu extends Table
{
    public function __construct()
    {
        // Volanie konštruktora rodiča
        parent::__construct();
    }  

    private $nav_menu = [
        0 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "#coffee-menu",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "Coffee",
        ],
        1 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "#tea-menu",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "Tea",
        ],
        2 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "#special-items",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "Specials",
        ],
        3 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "#about-us",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "About",
        ],
        4 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "#contact-us",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "Contact",
        ],
        5 => [
            'class' => "tm-nav-item",
            'class-a' => "tm-nav-link",
            'href' => "login.php",
            'style' => "color: #fff; text-decoration: none; font-size: 30px;",
            'content' => "Login",
        ],
    ];

    // Overriden method
    public function saveDataToFile($type = "nav_menu")
    {
        // Vlastná implementácia ukladania menu
        $data = ($type === "nav_menu") ? $this->nav_menu : null;
        $fileName = $type . ".json";

        if ($data !== null) {
            $save = file_put_contents($fileName, json_encode($data, JSON_PRETTY_PRINT));
            echo $save ? "Menu bolo úspešne uložené do $fileName" : "Nastala chyba pri ukladaní.";
        } else {
            echo "Neznámy typ menu.";
        }
    }
    
}