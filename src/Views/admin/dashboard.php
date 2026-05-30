<?php require_once __DIR__ . '/_partials/header_admin.php'; ?>

<?php
/** @var array $stats */
/** @var array $latestTrips */
?>


<div class="container py-4">

    <h1 class="mb-4 fw-bold">Tableau de bord</h1>

    <!-- 📊 Cartes statistiques -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="saas-card p-4 text-center fade-in">
                <div class="text-primary saas-stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="text-muted">Utilisateurs</h5>
                <div class="display-5 fw-bold"><?= $stats['users'] ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="saas-card p-4 text-center fade-in">
                <div class="text-success saas-stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h5 class="text-muted">Agences</h5>
                <div class="display-5 fw-bold"><?= $stats['agencies'] ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="saas-card p-4 text-center fade-in">
                <div class="text-danger saas-stat-icon">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <h5 class="text-muted">Trajets</h5>
                <div class="display-5 fw-bold"><?= $stats['trips'] ?></div>
            </div>
        </div>

    </div>

    <!-- ⚡ Actions rapides -->
    <div class="saas-card mt-5 p-4 fade-in">
        <h4 class="mb-3 fw-semibold">Actions rapides</h4>

        <div class="d-flex flex-wrap gap-3">

            <a href="/admin/agencies" class="btn btn-outline-primary">
                <i class="bi bi-building"></i> Gérer les agences
            </a>

            <a href="/admin/trips" class="btn btn-outline-primary">
                <i class="bi bi-car-front"></i> Gérer les trajets
            </a>

            <a href="/admin/users" class="btn btn-outline-primary">
                <i class="bi bi-people"></i> Gérer les utilisateurs
            </a>

            <a href="/admin/trips/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau trajet
            </a>

        </div>
    </div>

    <!-- 🚌 Derniers trajets -->
    <div class="saas-card mt-5 p-4 fade-in">
        <h4 class="mb-3 fw-semibold">Derniers trajets</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date</th>
                        <th>Conducteur</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestTrips as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['departure_agency_name']) ?></td>
                            <td><?= htmlspecialchars($t['arrival_agency_name']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?></td>
                            <td><?= htmlspecialchars($t['driver_name']) ?></td>
                            <td>
                                <a href="/trip/<?= $t['id'] ?>" class="btn btn-sm btn-primary">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/_partials/footer_admin.php'; ?>
