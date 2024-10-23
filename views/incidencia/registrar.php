<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registre</h1>
        <form action="../../controllers/UsuariController.php?action=registre" method="POST" class="mt-4" onsubmit="return verificarContrasenya()">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="contrasenya">Contrasenya:</label>
                <input type="password" class="form-control" id="contrasenya" name="contrasenya" required>
            </div>

            <div class="form-group">
                <label for="confirmar_contrasenya">Confirmar Contrasenya:</label>
                <input type="password" class="form-control" id="confirmar_contrasenya" name="confirmar_contrasenya" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <?php if (isset($error)) : ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function verificarContrasenya() {
            var contrasenya = document.getElementById("contrasenya").value;
            var confirmarContrasenya = document.getElementById("confirmar_contrasenya").value;
            if (contrasenya !== confirmarContrasenya) {
                alert("Les contrasenyes no coincideixen.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>