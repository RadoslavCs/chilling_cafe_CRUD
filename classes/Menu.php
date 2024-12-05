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
    
    //Funkcia načíta údaje z JSON súboru nav_menu.json a vloží ich do tabuľky nav_menu
    public function insertNavMenuData()
    {
        // Názov JSON súboru
        $fileName = "nav_menu.json";

        // Načítanie dát zo súboru
        $menuData = json_decode(file_get_contents($fileName), true);

        // Validácia obsahu JSON
        if (empty($menuData)) {
            echo "Dáta v súbore {$fileName} sú neplatné alebo prázdne.";
            return;
        }

        // Príprava SQL na vloženie dát
        $sql = "INSERT INTO nav_menu (`id`, `class`, `class-a`, `href`, `style`, `content`) 
        VALUES (:id, :class, :class_a, :href, :style, :content)
        ON DUPLICATE KEY UPDATE 
        `class` = VALUES(`class`), `class-a` = VALUES(`class-a`), 
        `href` = VALUES(`href`), `style` = VALUES(`style`), `content` = VALUES(`content`)";

        // Použitie metódy prepareQuery
        $stmt = $this->db->prepareQuery($sql);

        $id = 1; // Počiatočný ID 

        // Iterácia cez dáta a vloženie do databázy
        foreach ($menuData as $menuItem) {
            // Validácia jednotlivých atribútov
            $class = $menuItem['class'] ?? '';
            $classA = $menuItem['class-a'] ?? '';
            $href = $menuItem['href'] ?? '';
            $style = $menuItem['style'] ?? '';
            $content = $menuItem['content'] ?? '';

            // Vykonanie SQL s nahradenými parametrami
            $stmt->execute([
                ':id' => $id++,
                ':class' => $class,
                ':class_a' => $classA,
                ':href' => $href,
                ':style' => $style,
                ':content' => $content,
            ]);
        }

        echo "Dáta zo súboru {$fileName} boli úspešne vložené do tabuľky nav_menu.";
    }

    //Metóda načíta dáta z databázy a vráti požadovaný HTML
    public function getMenuFromDatabase()
    {
        // SQL dotaz na načítanie všetkých záznamov z tabuľky nav_menu
        $sql = "SELECT `href`, `class`, `class-a`, `style`, `content` FROM nav_menu ORDER BY id ASC";
        
        // Príprava SQL dotazu
        $stmt = $this->db->prepareQuery($sql);
        $stmt->execute();
        
        // Načítanie výsledkov
        $menuData = $stmt->fetchAll();

        // Ak nie sú žiadne dáta, vráti prázdny reťazec
        if (empty($menuData)) {
            return '';
        }

        // Generovanie HTML zo získaných dát
        $html = '';
        foreach ($menuData as $menuItem) {
            $html .= '<li class="' . htmlspecialchars($menuItem['class']) . '">
                        <a href="' . htmlspecialchars($menuItem['href']) . '" class="' . htmlspecialchars($menuItem['class-a']) . '" 
                        style="' . htmlspecialchars($menuItem['style']) . '">' . htmlspecialchars($menuItem['content']) . '</a>
                    </li>';
        }

        return $html;
    }


}