<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afegir Nova Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Afegir Nova Incidència</h1>

        <form action="../../index.php?controller=incidencia&action=insertar" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="col-md-12">
                <label for="descripcio" class="form-label">Descripció</label>
                <textarea class="form-control" id="descripcio" name="descripcio" rows="4" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="tipus" class="form-label">Tipus</label>
                <select class="form-select" id="tipus" name="tipus" required>
                    <?php foreach ($tipus as $t): ?>
                        <option value="<?php echo $t['id']; ?>"><?php echo $t['nom_tipus']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="prioritat" class="form-label">Prioritat</label>
                <select class="form-select" id="prioritat" name="prioritat" required>
                    <?php foreach ($prioritats as $p): ?>
                        <option value="<?php echo $p['id']; ?>"><?php echo $p['nom_prioritat']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="data_incidencia" class="form-label">Data de la Incidència</label>
                <input type="date" class="form-control" id="data_incidencia" name="data_incidencia" required>
            </div>
            <div class="col-md-6">
                <label for="arxius_adjunts" class="form-label">Arxius Adjunts</label>
                <input type="file" class="form-control" id="arxius_adjunts" name="arxius_adjunts">
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Afegir Incidència</button>
            </div>
        </form>
    </div>
</body>
</html>
