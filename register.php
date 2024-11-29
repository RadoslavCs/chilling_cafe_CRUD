<?php
// Začneme sesiu, aby sme mohli neskôr pracovať s chybovými správami alebo inými informáciami
session_start();

// Zahŕňame triedu User
include_once("classes/User.php");
use classes\User;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Získame údaje z formulára
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vytvoríme nový objekt User a zavoláme register metódu
        $user = new User();
        $user->register($login, $email, $password);

        // Ak registrácia prebehla úspešne, presmerujeme používateľa na prihlasovaciu stránku
        $_SESSION['success'] = "Registrácia bola úspešná!";
        header("Location: login.php");
        exit();

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
    <title>Registrácia</title>
    <?php
    include_once("parts/style_register.php");
    ?>
</head>
<body>

<?php
// Zobrazenie chybovej alebo úspešnej správy
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>

<form method="POST" action="register.php">
    <h2>Register</h2>
    <label for="login">Login:</label><br>
    <input type="text" id="login" name="login" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Heslo:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Registrovať">
</form>

</body>
</html>
