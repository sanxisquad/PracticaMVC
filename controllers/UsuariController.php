<?php
class UsuariController {
    private $conn;
    private $usuari;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        require_once __DIR__ . '/../models/Usuari.php';
        $database = new Database();
        $this->conn = $database->connect();
        $this->usuari = new Usuari($this->conn);
    }

    public function registre() {
        $error = null; // Variable para el error

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validar y sanitizar entradas
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $contrasenya = filter_var($_POST['contrasenya'], FILTER_SANITIZE_STRING);
            $confirmarContrasenya = filter_var($_POST['confirmar_contrasenya'], FILTER_SANITIZE_STRING);

            // Verificar que las contraseñas coincidan
            if ($contrasenya !== $confirmarContrasenya) {
                $error = "Les contrasenyes no coincideixen.";
            } else {
                $this->usuari->nom = $nom;
                $this->usuari->email = $email;
                $this->usuari->contrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);

                if ($this->usuari->registre()) {
                    header("Location: ../index.php?controller=Usuari&action=login");
                    exit();
                } else {
                    $error = "Error al registrar l'usuari.";
                }
            }
        }

        
        require_once '../views/incidencia/registrar.php';
    }

    public function login() {
        session_start(); 
        $error = null; 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validar y sanitizar entradas
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $contrasenya = filter_var($_POST['contrasenya'], FILTER_SANITIZE_STRING);

            $this->usuari->email = $email;
            $this->usuari->contrasenya = $contrasenya;
            $user = $this->usuari->login();

            if ($user) {
                $_SESSION['usuari'] = $user['nom']; 
                $_SESSION['codi_usuari'] = $user['id']; 
                header("Location: ../index.php?controller=incidencia&action=mostrar");
                exit(); 
            } else {
                $error = "Credenciales incorrectas.";
            }
        }

        // Incluir la vista de login con la variable $error
        require_once '../views/layout/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ../views/layout/login.php');
        exit();
    }
}
if (isset($_GET['action']) && method_exists('UsuariController', $_GET['action'])) {
    $controller = new UsuariController();
    $action = $_GET['action'];
    $controller->$action();
} else {
    echo "Acción no válida.";
}