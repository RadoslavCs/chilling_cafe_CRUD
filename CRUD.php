<?php
// Predpokladajme, že už máš pripojenie k databáze a triedu Database inicializovanú
include_once("classes/Database.php");

use classes\Database;

// Inicializuj triedu Database
$db = new Database();

//Read načítaj všetky záznamy z menu_table
$menuItems = $db->getAllDrinks(); 

// Delete ak bol odoslaný formulár na mazanie, spracuj ho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $result = $db->deleteDrink($id);
    
    if ($result) {
        header("Location: CRUD.php"); // Presmerovanie po vymazaní
        exit();
    } else {
        echo "Chyba pri vymazávaní záznamu.";
    }
}

// Update spracovanie aktualizácie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    // Získanie údajov z formulára
    $data = [
        'id' => $_POST['update_id'],
        'name' => $_POST['name'],
        'drink_type' => $_POST['drink_type'],
        'hot_price' => $_POST['hot_price'],
        'iced_price' => $_POST['iced_price'],
        'addon_price' => $_POST['addon_price'],
        'blended_price' => $_POST['blended_price']
    ];

    // Aktualizácia záznamu v databáze
    $result = $db->updateDrinkData($data, ['id' => $data['id']]);

    if ($result) {
        header("Location: CRUD.php"); // Presmerovanie po úspešnej aktualizácii
        exit();
    } else {
        echo "Chyba pri aktualizácii záznamu.";
    }
}

// Create spracovanie 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    // Získanie údajov z formulára
    $data = [
        'name' => $_POST['name'],
        'drink_type' => $_POST['drink_type'],
        'hot_price' => $_POST['hot_price'],
        'iced_price' => $_POST['iced_price'],
        'addon_price' => $_POST['addon_price'],
        'blended_price' => $_POST['blended_price']
    ];

    // Volanie metódy na vytvorenie nového záznamu
    $result = $db->createDrink($data);

    if ($result) {
        header("Location: CRUD.php"); // Presmerovanie po úspešnom vytvorení
        exit();
    } else {
        echo "Chyba pri vytváraní záznamu.";
    }
}

//Read údaje o nápoji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['read_id'])) {
    // Získaj ID drinku z formulára
    $id = $_POST['read_id'];

    // Použi metódu readDrinkData z triedy Database
    $drinkData = $db->readDrinkData($id);

    // Skontroluj, či sa údaje úspešne načítali
    if ($drinkData) {
        // Zobraz údaje o drinku vo vyskakovacom okne (alebo môžeš zobraziť priamo na stránke)
        echo "<script type='text/javascript'>
            alert('Drink details: \\nID: " . htmlspecialchars($drinkData['id']) . "\\nName: " . htmlspecialchars($drinkData['name']) . "\\nType: " . htmlspecialchars($drinkData['drink_type']) . "\\nHot Price: " . htmlspecialchars($drinkData['hot_price']) . "\\nIced Price: " . htmlspecialchars($drinkData['iced_price']) . "\\nAddon Price: " . htmlspecialchars($drinkData['addon_price']) . "\\nBlended Price: " . htmlspecialchars($drinkData['blended_price']) . "');
        </script>";
    } else {
        echo "<script type='text/javascript'>alert('Drink not found!');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="fontawesome/css/all.min.css" rel="stylesheet" />
    <title>CRUD Formulár</title>
    <?php
    include_once("parts/style_table.php");
    ?>

</head>
<body>

<nav class="tm-nav" style="display: flex; justify-content: center; align-items: center; gap: 40px;">
    <ul class="tm-nav-list" style="list-style: none; margin: 0; padding: 0; display: flex; gap: 20px;">
      <li class="tm-nav-item"><a href="logout.php" class="tm-nav-link" style="color: #000; text-decoration: none; font-size: 30px;">Logout</a></li>   
    </ul>
</nav>

<h2>Drinks</h2>

<!-- Zobrazenie údajov v tabuľke -->
<table>
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Name</th>
            <th>Drink</th>
            <th>Hot Price</th>
            <th>Iced Price</th>
            <th>Addon Price</th>
            <th>Blended Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menuItems as $item): ?>
            <tr onclick="populateForm(<?php echo htmlspecialchars(json_encode($item)); ?>)">
                <!-- <td><?php echo htmlspecialchars($item['id']); ?></td> -->
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['drink_type']); ?></td>
                <td><?php echo htmlspecialchars($item['hot_price']); ?></td>
                <td><?php echo htmlspecialchars($item['iced_price']); ?></td>
                <td><?php echo htmlspecialchars($item['addon_price']); ?></td>
                <td><?php echo htmlspecialchars($item['blended_price']); ?></td>
                <td>
                    <!-- Formulár na vymazanie -->
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" onsubmit="return confirm('Naozaj chcete vymazať tento nápoj?');" style="display: inline-block; margin-right: 5px;">
                        <input type="hidden" name="delete_id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    
                    <!-- Formulár na čítanie -->
                    <form action="drink_details.php" method="GET" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Read</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Update</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="hidden" name="update_id" value="">
    <input type="text" name="name" value="" required>
    <select name="drink_type">
        <option value="Coffee">Coffee</option>
        <option value="Tea">Tea</option>
    </select>
    <input type="text" name="hot_price" value="" required>
    <input type="text" name="iced_price" value="" required>
    <input type="text" name="addon_price" value="" required>
    <input type="text" name="blended_price" value="" required>
    <button type="submit">Update</button>
</form>

<h2>Create</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="hidden" name="action" value="create"> <!-- Označuje, že ide o vytvorenie -->
    <input type="text" name="name" placeholder="Name" required>
    <select name="drink_type">
        <option value="Coffee">Coffee</option>
        <option value="Tea">Tea</option>
    </select>
    <input type="text" name="hot_price" placeholder="Hot Price" required>
    <input type="text" name="iced_price" placeholder="Iced Price" required>
    <input type="text" name="addon_price" placeholder="Addon Price" required>
    <input type="text" name="blended_price" placeholder="Blended Price" required>
    <button type="submit">Create</button>
</form>

<?php include_once("parts/form.php");?>

</body>
</html>
