<?php

namespace classes;

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $port;
    private $connection;

    public function __construct($host = "localhost", $dbname = "cafe", $username = "root", $password = "", $port = 3306)
    {
        // Uloženie pripojovacích údajov
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;

        try {
            // Vytvorenie PDO objektu a pripojenie k databáze
            $this->connection = new \PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=utf8",
                $this->username,
                $this->password
            );
            // Nastavenie PDO pre zobrazenie chýb a vynucenie vyvolávania výnimiek
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // Záznam chyby do logu alebo výpis
            error_log("Chyba pri pripojení k databáze: " . $e->getMessage());
            throw new \Exception("Chyba pri pripojení k databáze.");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    // Funkcia na získanie všetkých údajov
    public function getAllDrinks()
    {
        try {
            $query = "SELECT * FROM `menu_table`";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Chyba pri získavaní údajov pre Coffee: " . $e->getMessage());
            return [];
        }
    }

    // Funkcia na získanie údajov pre kávu
    public function getDataForCoffee()
    {
        try {
            $query = "SELECT * FROM `menu_table` WHERE drink_type = 'Coffee'";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Chyba pri získavaní údajov pre Coffee: " . $e->getMessage());
            return [];
        }
    }

     // Funkcia na získanie údajov pre čaj
     public function getDataForTea()
     {
         try {
             $query = "SELECT * FROM `menu_table` WHERE drink_type = 'Tea'";
             $statement = $this->connection->prepare($query);
             $statement->execute();
             return $statement->fetchAll(\PDO::FETCH_ASSOC);
         } catch (\PDOException $e) {
             error_log("Chyba pri získavaní údajov pre Tea: " . $e->getMessage());
             return [];
         }
     }    
     
     //Pripraví SQL dotaz na vykonanie pomocou PDO a vráti pripravený statement.
     public function prepareQuery(string $query)
    {
        try {
            return $this->connection->prepare($query);
        } catch (\PDOException $e) {           
            throw new \Exception("Nepodarilo sa pripraviť dotaz.");
        }
    }
     

     //CRUD     
     // CREATE (INSERT)
    public function createDrink($data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $query = "INSERT INTO `menu_table` ($columns) VALUES ($placeholders)";

            $statement = $this->connection->prepare($query);
            $statement->execute(array_values($data));
            return $this->connection->lastInsertId(); // Vracia ID nového záznamu
        } catch (\PDOException $e) {
            error_log("Chyba pri vkladaní údajov: " . $e->getMessage());
            return false;
        }
    }

    //READ
    public function readDrinkData(int $id)
    {
        try {
            $query = "SELECT * FROM `menu_table` WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC); // Vracia jeden riadok ako asociatívne pole
        } catch (\PDOException $e) {
            error_log("Chyba pri čítaní údajov pre ID $id: " . $e->getMessage());
            return null; // Ak sa vyskytne chyba, vráti null
        }
    }

    // UPDATE
    public function updateDrinkData( $data, $conditions)
    {
        try {
            $setClause = implode(', ', array_map(fn($key) => "`$key` = ?", array_keys($data)));
            $whereClause = implode(' AND ', array_map(fn($key) => "`$key` = ?", array_keys($conditions)));

            $query = "UPDATE `menu_table` SET $setClause WHERE $whereClause";

            $statement = $this->connection->prepare($query);
            $statement->execute(array_merge(array_values($data), array_values($conditions)));
            return $statement->rowCount(); // Počet ovplyvnených riadkov
        } catch (\PDOException $e) {
            error_log("Chyba pri aktualizácii údajov: " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function deleteDrink(int $id)
    {
        try {
            // SQL dotaz na mazanie podľa ID
            $query = "DELETE FROM `menu_table` WHERE `id` = ?";

            // Príprava a vykonanie dotazu
            $statement = $this->connection->prepare($query);
            $statement->execute([$id]);

            // Vrátenie počtu zmazaných riadkov
            return $statement->rowCount(); // Počet zmazaných riadkov
        } catch (\PDOException $e) {
            error_log("Chyba pri mazání údaja s ID $id: " . $e->getMessage());
            return false; // V prípade chyby vráti false
        }
    }

}