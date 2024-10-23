<?php
// Tancar sessió
if (isset($_POST['tancar_sessio'])) {
    session_destroy();
    header("Location: login.php"); // Redirigeix a la pàgina de login
    exit();
}

require_once 'models/incidencia.php';

$incidencies = new incidencia();
$result = $incidencies->mostrar(); 
$tipus = $incidencies->getTipus();
$prioritats = $incidencies->getPrioritats();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Incidències</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="index.php?controller=incidencia&action=afegir" class="btn btn-success">Afegir Incidència</a>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="filterTipus">Filtrar per Tipus:</label>
            <select id="filterTipus" class="form-control">
                <option value="">Tots</option>
                <?php foreach ($tipus as $t) : ?>
                    <option value="<?= $t['nom_tipus'] ?>"><?= $t['nom_tipus'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="filterPrioritat">Filtrar per Prioritat:</label>
            <select id="filterPrioritat" class="form-control">
                <option value="">Tots</option>
                <?php foreach ($prioritats as $p) : ?>
                    <option value="<?= $p['nom_prioritat'] ?>"><?= $p['nom_prioritat'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <table id="incidenciesTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Descripció</th>
                <th>Tipus</th>
                <th>Data de la Incidència</th>
                <th>Prioritat</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcio']); ?></td>
                    <td><?php echo htmlspecialchars($row['nom_tipus']); ?></td>
                    <td><?php echo htmlspecialchars($row['data_incidencia']); ?></td>
                    <td><?php echo htmlspecialchars($row['nom_prioritat']); ?></td>
                    <td>
                        <div class="button-container">
                            <a href="../../index.php?controller=incidencia&action=editar&id=<?php echo htmlspecialchars($row['codi_incidencia']); ?>" class="btn btn-primary">Editar</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hi ha incidències per mostrar.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#incidenciesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ca.json"
            }
        });

        $('#filterTipus').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#filterPrioritat').on('change', function() {
            table.column(4).search(this.value).draw();
        });
    });
</script>
</body>
</html>