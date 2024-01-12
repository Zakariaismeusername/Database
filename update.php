<?php
class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;


        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function updateData($table, $data, $condition) {

        $updateFields = [];
        foreach ($data as $key => $value) {
            $updateFields[] = "$key = :$key";
        }

        $updateFieldsString = implode(', ', $updateFields);

        $sql = "UPDATE $table SET $updateFieldsString WHERE $condition";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
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
$dataToUpdate = ['naam' => 'Nieuwe naam', 'leeftijd' => 25];
$updateCondition = "id = 1";

$database->updateData($table, $dataToUpdate, $updateCondition);
?>