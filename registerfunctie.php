<?php
    public function connect() {
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function addUser($username, $email) {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error adding user: " . $e->getMessage());
        } finally {
            $conn = null; // Sluit de databaseverbinding
        }
    }
}

// Verwerk het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];

    try {
        // Voer inputvalidatie uit (hier kun je extra validaties toevoegen)
        if (empty($username) || empty($email)) {
            throw new Exception("Vul alle velden in.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Ongeldig e-mailadres.");
        }

        // Voeg gebruiker toe aan de database
        $db = new Database();
        $db->addUser($username, $email);

        echo "Registratie succesvol!";
    } catch (Exception $e) {
        echo "Fout: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Accountregistratie</title>
    <style>

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}
h1 {
    text-align: center;
    color: #333333;
}
label {
    display: block;
    margin: 10px 0;
    color: #555555;
}
input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #cccccc;
    border-radius: 4px;
}
button {
    background-color: #4caf50;
    color: #ffffff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}
button:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <h1>Accountregistratie</h1>
    <form action="register.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">E-mailadres:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Registreer</button>
    </form>
    
    <script>
    </script>
</body>
</html>

<?php
class Database {
    private $host = "localhost";
    private $username = "jouw_gebruikersnaam";
    private $password = "jouw_wachtwoord";
    private $database = "jouw_database";
