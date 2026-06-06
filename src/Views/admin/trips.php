<?php
/** @var array $trips */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold">Trajets</h1>
        <div class="d-flex gap-2">
            <a href="/admin/trips/create" class="btn btn-primary btn-sm">Créer un trajet</a>
            <a href="/admin/trips/export/csv" class="btn btn-outline-light btn-sm">CSV</a>
            <a href="/admin/trips/export/excel" class="btn btn-outline-light btn-sm">Excel</a>
            <a href="/admin/trips/export/pdf" class="btn btn-outline-light btn-sm">PDF</a>
        </div>
    </div>

    <div class="saas-card">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Départ (date)</th>
                        <th>Places</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trips as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= htmlspecialchars($t['departure_agency']) ?></td>
                            <td><?= htmlspecialchars($t['arrival_agency']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?></td>
                            <td><?= $t['seats_available'] ?>/<?= $t['seats_total'] ?></td>
                            <td class="text-end">
                                <a href="/admin/trips/<?= $t['id'] ?>/edit" class="btn btn-sm btn-warning">
                                    Modifier
                                </a>
                                <a href="/admin/trips/<?= $t['id'] ?>/delete"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer ce trajet ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($trips)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun trajet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
