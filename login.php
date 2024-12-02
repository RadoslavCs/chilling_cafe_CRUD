<?php
// Začneme sesiu, aby sme mohli pracovať s chybovými správami alebo sesion premennými
session_start();

// Zahŕňame triedu User
include_once("classes/User.php");
use classes\User;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Získame údaje z formulára
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vytvoríme nový objekt User a zavoláme login metódu
        $user = new User();
        $user->login($email, $password);

        // Ak prihlásenie prebehlo úspešne a používateľ je admin, presmerujeme používateľa na stránku
        if($user->isAdmin()){            
            header("Location: CRUD.php"); 
            exit();
        }      

    } catch (\Exception $e) {
        // Zachytíme chybu a zobrazíme správu
        $_SESSION['error'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>

    <?php
    include_once("parts/style_register.php");
    ?>

</head>
<body>



<?php
// Zobrazenie chybovej správy
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>

<form method="POST" action="login.php">
<h2>Login</h2>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Heslo:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <div style="display: flex; gap: 10px;"> 
        <input type="submit" value="Prihlásiť sa">
        <a href="register.php">
            <button type="button">Registrácia</button>
        </a>
    </div>
</form>



</body>
</html>
