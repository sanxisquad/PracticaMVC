<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Incidència</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Incidència</h1>
        <form action="index.php?controller=incidencia&action=actualitzar" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?= $incidencia['codi_incidencia'] ?>">
            
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= $incidencia['nom'] ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="descripcio">Descripció:</label>
                <textarea class="form-control" id="descripcio" name="descripcio" rows="3" readonly><?= $incidencia['descripcio'] ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="tipus">Tipus:</label>
                <select class="form-control" id="tipus" name="tipus" disabled>
                    <?php foreach ($tipus as $t) : ?>
                        <option value="<?= $t['id'] ?>" <?= $t['id'] == $incidencia['tipus_id'] ? 'selected' : '' ?>><?= $t['nom_tipus'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="prioritat">Prioritat:</label>
                <select class="form-control" id="prioritat" name="prioritat" disabled>
                    <?php foreach ($prioritats as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $incidencia['prioritat_id'] ? 'selected' : '' ?>><?= $p['nom_prioritat'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="data_incidencia">Data Incidència:</label>
                <input type="text" class="form-control" id="data_incidencia" name="data_incidencia" value="<?= $incidencia['data_incidencia'] ?>" readonly>
            </div>
            
            <button type="button" class="btn btn-primary" onclick="activarEdici()">Editar</button>
            <button type="submit" class="btn btn-success" id="guardarBtn" style="display: none;">Guardar</button>
            <button type="button" class="btn btn-danger" onclick="confirmarBorrado(<?= $incidencia['codi_incidencia'] ?>)">Borrar</button>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function activarEdici() {
            document.querySelectorAll('input[type="text"]:not(#data_incidencia), textarea').forEach(function(input) {
                input.removeAttribute('readonly');
            });
            
            document.getElementById("tipus").removeAttribute("disabled");
            document.getElementById("prioritat").removeAttribute("disabled");
            
            document.getElementById("guardarBtn").style.display = "block";
        }

        function confirmarBorrado(id) {
            if (confirm("Estàs segur de que vols borrar aquesta incidència?")) {
                window.location.href = "index.php?controller=incidencia&action=borrar&id=" + id;
            }
        }
    </script>
</body>
</html>