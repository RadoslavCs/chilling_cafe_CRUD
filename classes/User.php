<?php

namespace classes;

include_once("classes/Database.php");
use classes\Database;

class User extends Database
{
    private $rola;

    protected $connection;

    public function __construct(){
        parent::__construct(); // Zavolá konštruktor triedy Database
        $this->rola = "user";
        $this->connection = $this->getConnection();
    }

    public function register($login, $email, $password)
    {
        try {

            // Overenie platnosti vstupov
            if (empty($login) || empty($email) || empty($password)) {
                throw new \Exception("Všetky polia musia byť vyplnené.");
            }

            $hashedPassword = password_hash($password, algo: PASSWORD_BCRYPT);

            //overenenie či sa používateľ nachádza v db
            $sql = "SELECT * FROM `user` WHERE (login = ? OR email = ?) LIMIT 1;";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $login);
            $statement->bindParam(2, $email);
            $statement->execute();
            $existingUser = $statement->fetch();

            if ($existingUser) 
            {
                throw new \Exception( message: "Poživateľ už existuje.");
            }

            $sql = "INSERT INTO `user` (login, email, heslo, rola) VALUES (?, ?, ?, ?) ";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $login);
            $statement->bindParam(2, $email);
            $statement->bindParam(3, $hashedPassword);
            $statement->bindParam(4, $this->rola);
            $statement->execute();

        }catch (\Exception $e){
            echo "Chyba pri vkladani dát do databázy: " . $e->getMessage();
        } finally {
            $this->connection=null;        
        }
    }

    public function login($email, $password) {
        //Kontrola existencie používateľa
        $sql = "SELECT * FROM `user` WHERE email = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $email);
        $statement->execute();
        $user = $statement->fetch();
        if (!$user) {
        throw new \Exception( message: "Požívatel s daným menom neexistuje.");
        }
        //Parameter heslo je názov stĺpca v db
        $storedPassword = $user['heslo' ];
        // Overenie hesla
        if (!password_verify($password, $storedPassword)) 
        {
         throw new \Exception( message: "Nespravne heslo.");
        }
        // Spustenie session a uloženie informácií o používateľovi
        session_start();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['rola'] = $user['rola'];
    }

    public function Logout () {
        session_start();
        session_unset(); // Vymazanie všetkých session premenných
        session_destroy();
        header( header: 'Location: http://localhost/index.php');
        exit();
    }

    public function isAdmin(){
        session_start();
        if (isset($_SESSION['rola' ]) && $_SESSION['user_id' ]) {
            if($_SESSION['rola'] == 'admin'){
            echo "admin je tu";
            return true;
            }else{
                echo "session sa spustil, ale nie je admin";        
            }
        }else{
            echo "nenašiel sa session";
            return false;
        }
    }
}

