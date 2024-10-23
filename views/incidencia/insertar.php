<div class="container mt-5">
        <h1 class="text-center mb-4">Afegir Nova Incidència</h1>

        <form action="afegir.php" method="POST" enctype="multipart/form-data" class="row g-3">
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
            <div class="col-12 text-center">
                <a href="incidencies.php" class="btn btn-secondary">Tornar</a>
        </form>
    </div>