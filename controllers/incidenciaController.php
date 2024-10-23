<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/incidencia.php';

class incidenciaController {
    private $conn;
    private $incidencies;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
        $this->incidencies = new incidencia($this->conn);
    }

    public function mostrar() {
        
        $incidencies = new incidencia();
        $result = $incidencies->mostrar(); 
        $rows = $result->fetch_all(MYSQLI_ASSOC);
       
        require "views/incidencia/mostrar.php";
    }

    public function insertar() {
       
        $incidencies = new incidencia();
        $tipus = $incidencies->getTipus(); 
        $prioritats = $incidencies->getPrioritats(); 

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
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

                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'pdf', 'docx');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = './imatges/';
                    $dest_path = $uploadFileDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $arxiusAdjunts = $dest_path;
                    }
                }
            }

           
            $incidencies->insertar($nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id_usuari, $arxiusAdjunts);

           
            header("Location: index.php?controller=incidencia&action=mostrar");
            exit();
        }

    
        require "views/incidencia/insertar.php";
    }

    public function editar() {
    
        if (!isset($_GET['id'])) {
            header("Location: incidencies.php"); 
            exit();
        }

  
        $id = $_GET['id']; 

     
        $incidencies = new incidencia();

        
        $result = $incidencies->editar($id); 
        
      
        if ($result->num_rows > 0) {
            $incidencia = $result->fetch_assoc(); 

           
            $tipus = $incidencies->getTipus();
            $prioritats = $incidencies->getPrioritats();

            // Carregar la vista d'edició
            require "views/incidencia/editar.php";
        } else {
            // Si no es troba la incidència, redirigir
            header("Location: incidencies.php");
            exit();
        }

    }
    public function afegir() {
        
        if (!isset($_SESSION['usuari'])) {
            
            header('Location: views/layout/login.php');
            exit();
        }
        $incidencies = new incidencia();

        $prioritats = $incidencies->getPrioritats();
        $tipus = $incidencies->getTipus();
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

            if ($this->model->afegirIncidencia($nom, $descripcio, $tipus_id, $prioritat_id, $data_incidencia, $id_usuari, $arxiusAdjunts)) {
                header("Location: incidencies.php");
                exit();
            } else {
                echo "Error al afegir la incidència.";
            }
        }

        
    }
    public function actualitzar() {
        $this->incidencies->actualitzar();
        header("Location: index.php?controller=incidencia&action=mostrar");
        exit();
        
    }
    public function borrar() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=incidencia&action=mostrar");
            exit();
        }

        $id = $_GET['id'];
        if ($this->incidencies->borrar($id)) {
            header("Location: index.php?controller=incidencia&action=mostrar");
            exit();
        } else {
            echo "Error al borrar la incidència.";
        }
    }
}
?>
