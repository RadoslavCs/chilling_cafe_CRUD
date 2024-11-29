<?php
include_once("classes/Database.php");
use classes\Database;
$db = new Database();

// Ak neexistuje ID nápoja v URL, presmeruj na CRUD stránku
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: CRUD.php');
    exit();
}

$id = $_GET['id'];  // Získať ID z URL
$drinkData = $db->readDrinkData($id);  // Načítanie údajov nápoja z databázy

if (!$drinkData) {
    // Ak nenájdeš nápoj, presmeruj späť na CRUD
    echo "Drink not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drink Details</title>    
    <?php
    include_once("parts/style_register.php");
    ?>
</head>
<body>
    <form action="CRUD.php" method="get">
    <h1>Drink Details</h1>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($drinkData['id']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($drinkData['name']); ?></p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($drinkData['drink_type']); ?></p>
    <p><strong>Hot Price:</strong> <?php echo htmlspecialchars($drinkData['hot_price']); ?></p>
    <p><strong>Iced Price:</strong> <?php echo htmlspecialchars($drinkData['iced_price']); ?></p>
    <p><strong>Addon Price:</strong> <?php echo htmlspecialchars($drinkData['addon_price']); ?></p>
    <p><strong>Blended Price:</strong> <?php echo htmlspecialchars($drinkData['blended_price']); ?></p>
        <button type="submit">OK</button>
    </form>
</body>
</html>
