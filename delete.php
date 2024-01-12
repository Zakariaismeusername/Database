<?php
class Database {
    
    public function deleteData($table, $condition) {

        $sql = "DELETE FROM $table WHERE $condition";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

$host = "localhost";
$dbname = "jouw_database";
$username = "jouw_gebruikersnaam";
$password = "jouw_wachtwoord";

$database = new Database($host, $dbname, $username, $password);

$table = "jouw_tabel";
$deleteCondition = "id = 1";

$database->deleteData($table, $deleteCondition);
?>