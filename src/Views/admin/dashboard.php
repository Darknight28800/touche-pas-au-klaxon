<?php
/** @var int $usersCount */
/** @var int $agenciesCount */
/** @var int $tripsCount */
?>

<?php require __DIR__ . '/../_partials/header_admin.php'; ?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Tableau de bord administrateur</h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Carte utilisateurs -->
        <div class="col-md-4">
            <div class="saas-card text-center p-4 h-100">
                <h5 class="fw-semibold mb-2">Utilisateurs</h5>
                <p class="display-5 fw-bold mb-3"><?= $usersCount ?></p>
                <a href="/admin/users" class="btn btn-outline-primary w-100">
                    Gérer les utilisateurs
                </a>
            </div>
        </div>

        <!-- Carte agences -->
        <div class="col-md-4">
            <div class="saas-card text-center p-4 h-100">
                <h5 class="fw-semibold mb-2">Agences</h5>
                <p class="display-5 fw-bold mb-3"><?= $agenciesCount ?></p>
                <a href="/admin/agencies" class="btn btn-outline-primary w-100">
                    Gérer les agences
                </a>
            </div>
        </div>

        <!-- Carte trajets -->
        <div class="col-md-4">
            <div class="saas-card text-center p-4 h-100">
                <h5 class="fw-semibold mb-2">Trajets</h5>
                <p class="display-5 fw-bold mb-3"><?= $tripsCount ?></p>
                <a href="/admin/trips" class="btn btn-outline-primary w-100">
                    Gérer les trajets
                </a>
            </div>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
