<?php
// Začneme sesiu, aby sme mohli zrušiť prihlásenie
session_start();
session_unset(); // Vymazanie všetkých session premenných
session_destroy(); // Zrušenie session

header("Location: index.php"); // Presmerovanie na prihlasovaciu stránku
exit();
