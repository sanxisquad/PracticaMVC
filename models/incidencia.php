<?php
require_once __DIR__ . '/../config/database.php';

class incidencia {
    private $conn;
    private $table = 'incidencies';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function mostrar() {
        $sql = "
            SELECT i.*, t.nom_tipus, p.nom_prioritat 
            FROM incidencies i 
            JOIN tipus t ON i.tipus_id = t.id 
            JOIN prioritats p ON i.prioritat_id = p.id
        ";

        $result = $this->conn->query($sql);
        return $result;
    }

    public function editar($id) {
        $query = "SELECT i.*, t.nom_tipus, p.nom_prioritat 
                  FROM " . $this->table . " i
                  JOIN tipus t ON i.tipus_id = t.id
                  JOIN prioritats p ON i.prioritat_id = p.id
                  WHERE i.codi_incidencia = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTipus() {
        $query = "SELECT * FROM tipus";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPrioritats() {
        $query = "SELECT * FROM prioritats";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function afegir() {

        if (!isset($_SESSION['usuari'])) {
            header('Location: views/layout/login.php');
            exit();
        }

      
        $prioritats = $this->incidencies->getPrioritats();
        $tipus = $this->incidencies->getTipus();
        require 'views/incidencia/afegir.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $descripcio = $_POST['descripcio'];
            $tipus_id = $_POST['tipus'];
            $prioritat_id = $_POST['prioritat'];
            $data_incidencia = $_POST['data_incidencia'];
            $id_usuari = $_SESSION['codi_usuari'];

           
            $arxiusAdjunts = '';
            if (isset($_FILES['arxius_adjunts']) && $_FILES['arxius_adjunts']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['arxius_adjunts']['tmp_name'];
                $fileName = $_FILES['arxius_adjunts']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'pdf', 'docx'];
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = './imatges/';
                    $dest_path = $uploadFileDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $arxiusAdjunts = $dest_path;
                    }
                }
            }

        
            if ($this->incidencies->afegirIncidencia($nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id_usuari, $arxiusAdjunts)) {
                header("Location: ../index.php?controller=incidencia&action=mostrar");
                exit();
            } else {
                echo "Error al afegir la incidència.";
            }
        }
    }
    
    public function actualitzar() {
        
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $descripcio = $_POST['descripcio'];
        $tipus_id = $_POST['tipus'];
        $prioritat_id = $_POST['prioritat'];
        $data_incidencia = $_POST['data_incidencia'];

        $sql = "UPDATE incidencies SET nom=?, descripcio=?, tipus_id=?, prioritat_id=?, data_incidencia=? WHERE codi_incidencia=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id);
        
        if ($stmt->execute()) {
            echo "Incidència actualitzada correctament.";
            header("Location: index.php?controller=incidencia&action=mostrar");
            
            exit();
        } else {
            echo "Error al actualitzar la incidència: " . $stmt->error;
        }

        $stmt->close();
    }
    public function insertar($nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id_usuari, $arxiusAdjunts) {
        // Inserir la incidència
        $stmt = $this->conn->prepare("INSERT INTO incidencies (nom, descripcio, tipus_id, prioritat_id, data_incidencia, codi_usuari, arxius_adjunts) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id_usuari, $arxiusAdjunts);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }
    public function borrar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE codi_incidencia = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }


}
?>
