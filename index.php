<?php
session_start(); // Iniciar la sesión si no está iniciada

// Verificar si la sesión del usuario está establecida
if (!isset($_SESSION['usuari'])) {
    // Redirigir al usuario a la página de login si no está autenticado
    header('Location: views/layout/login.php');
    exit();
}

include "views/layout/header.php"; ?>
<div class="row">
  <div class="side">
  
  </div>
  <div class="main">
    <?php
    require_once "autoload.php";
    if(isset($_GET["controller"])){
        $controller = $_GET["controller"] . "Controller"; 
        if(class_exists($controller)){
            $controller = new $controller();
            if(isset($_GET["action"])){
                $action=$_GET["action"];
                if(method_exists($controller,$action)){
                    $controller->$action();
                }
                else{
                    echo "No existeix el metode";
                }
            }
        }
        else{
            echo "No existeix el controlador";
        }
    }

    if (isset($_GET['controller']) && $_GET['controller'] == 'incidencia' && isset($_GET['method']) && $_GET['method'] == 'mostrar') {
        
        $incidencies = new incidencia();
        $result = $incidencies->mostrar(); 
        require "views/incidencia/mostrar.php";
    }

?>

  </div>
</div>

<?php include "views/layout/footer.php"; ?>