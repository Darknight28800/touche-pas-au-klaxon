<?php
/** @var int $usersCount */
/** @var int $agenciesCount */
/** @var int $tripsCount */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4">Tableau de bord administrateur</h1>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="saas-card text-center">
                <h3 class="fw-bold">Utilisateurs</h3>
                <p class="display-5 fw-bold"><?= $usersCount ?></p>
                <a href="/admin/users" class="btn btn-outline-primary btn-sm">Voir la liste</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="saas-card text-center">
                <h3 class="fw-bold">Agences</h3>
                <p class="display-5 fw-bold"><?= $agenciesCount ?></p>
                <a href="/admin/agencies" class="btn btn-outline-primary btn-sm">Gérer</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="saas-card text-center">
                <h3 class="fw-bold">Trajets</h3>
                <p class="display-5 fw-bold"><?= $tripsCount ?></p>
                <a href="/admin/trips" class="btn btn-outline-primary btn-sm">Gérer</a>
            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
