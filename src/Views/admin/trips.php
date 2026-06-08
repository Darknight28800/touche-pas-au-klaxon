<?php
/** @var array $trips */
?>

<?php require __DIR__ . '/../_partials/header_admin.php'; ?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color:#111827;">Trajets</h1>

        <div class="d-flex gap-2">
            <a href="/admin/trips/create" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Créer un trajet
            </a>

            <a href="/admin/trips/export" class="btn btn-outline-secondary">
                <i class="bi bi-filetype-csv me-1"></i> CSV
            </a>

            <a href="/admin/export/trips" class="btn btn-outline-secondary">
                <i class="bi bi-file-earmark-excel me-1"></i> Excel
            </a>

            <a href="/admin/trips/pdf" class="btn btn-outline-secondary">
                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
        </div>
    </div>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="saas-card p-4">

        <h5 class="fw-semibold mb-3">Liste des trajets</h5>

        <?php if (empty($trips)): ?>
            <div class="alert alert-info shadow-sm">Aucun trajet enregistré.</div>
        <?php else: ?>

            <!-- AJOUT ICI -->
            <div class="admin-table table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Départ</th>
                            <th>Arrivée</th>
                            <th>Date départ</th>
                            <th>Date arrivée</th>
                            <th>Places</th>
                            <th>Conducteur</th>
                            <th class="text-end" width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($trips as $t): ?>
                            <tr>
                                <td><?= $t['id'] ?></td>

                                <td><?= htmlspecialchars($t['departure_agency_name']) ?></td>

                                <td><?= htmlspecialchars($t['arrival_agency_name']) ?></td>

                                <td><?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?></td>

                                <td><?= date('d/m/Y H:i', strtotime($t['arrival_datetime'])) ?></td>

                                <td><?= $t['seats_available'] ?>/<?= $t['seats_total'] ?></td>

                                <td>
                                    <?php if (!empty($t['driver_firstname'])): ?>
                                        <?= htmlspecialchars($t['driver_firstname']) ?>
                                        <?= htmlspecialchars($t['driver_lastname']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Aucun</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-end">

                                    <a href="/admin/trips/<?= $t['id'] ?>/edit"
                                       class="btn btn-outline-secondary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="/admin/trips/<?= $t['id'] ?>/delete"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce trajet ?');">
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
