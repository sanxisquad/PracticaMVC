<?php
class Usuari {
    private $conn;
    private $table = 'usuaris';

    public $id_usuari;
    public $nom;
    public $cognoms;
    public $email;
    public $contrasenya;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registre() {
        $query = "INSERT INTO usuaris (nom, correu, password_hash) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sss", $this->nom, $this->email, $this->contrasenya);
            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE correu = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($this->contrasenya, $user['password_hash'])) {
                return $user;
            }
        }

        return false;
    }
}
?>