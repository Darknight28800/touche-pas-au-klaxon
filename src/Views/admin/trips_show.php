<?php
/** @var array $trip */
/** @var \AltoRouter $router */
?>

<?php require __DIR__ . '/../_partials/header.php';?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">
        Détails du trajet
    </h1>

    <div class="saas-card p-4 mb-4">

        <h5 class="fw-semibold mb-3">Informations générales</h5>

        <div class="row mb-4">

            <div class="col-md-6">
                <div class="info-box p-3">
                    <p><strong>ID :</strong> <?= $trip['id'] ?></p>
                    <p><strong>Agence de départ :</strong> <?= htmlspecialchars($trip['departure_agency']) ?></p>
                    <p><strong>Agence d'arrivée :</strong> <?= htmlspecialchars($trip['arrival_agency']) ?></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box p-3">
                    <p><strong>Date de départ :</strong> 
                        <?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?>
                    </p>

                    <p><strong>Date d'arrivée :</strong> 
                        <?= date('d/m/Y H:i', strtotime($trip['arrival_datetime'])) ?>
                    </p>
                </div>
            </div>

        </div>

        <h5 class="fw-semibold mb-3">Places</h5>

        <div class="row mb-4">

            <div class="col-md-6">
                <div class="info-box p-3">
                    <p><strong>Places totales :</strong> <?= intval($trip['seats_total']) ?></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box p-3">
                    <p><strong>Places disponibles :</strong> <?= intval($trip['seats_available']) ?></p>
                </div>
            </div>

        </div>

        <a href="<?= $router->generate('admin-trips') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
