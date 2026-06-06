<?php
/** @var array $trip */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-5">

    <div class="saas-card">

        <h2 class="fw-bold mb-4">Détails du trajet</h2>

        <p><strong>Départ :</strong> <?= htmlspecialchars($trip['departure_agency']) ?></p>
        <p><strong>Arrivée :</strong> <?= htmlspecialchars($trip['arrival_agency']) ?></p>
        <p><strong>Date départ :</strong> <?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?></p>
        <p><strong>Date arrivée :</strong> <?= date('d/m/Y H:i', strtotime($trip['arrival_datetime'])) ?></p>
        <p><strong>Places :</strong> <?= $trip['seats_available'] ?>/<?= $trip['seats_total'] ?></p>

        <hr>

        <h4 class="fw-bold">Conducteur</h4>
        <p><strong>Nom :</strong> <?= htmlspecialchars($trip['driver_lastname'] ?? 'N/A') ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($trip['driver_firstname'] ?? 'N/A') ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($trip['driver_email'] ?? 'N/A') ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($trip['driver_phone'] ?? 'N/A') ?></p>

        <div class="mt-4 d-flex justify-content-between">
            <a href="/" class="btn btn-light">Retour</a>

            <?php if ($_SESSION['user']['id'] == $trip['driver_id'] || $_SESSION['user']['role'] === 'admin'): ?>
                <div>
                    <a href="/trip/<?= $trip['id'] ?>/edit" class="btn btn-warning">Modifier</a>
                    <a href="/trip/<?= $trip['id'] ?>/delete" class="btn btn-danger"
                       onclick="return confirm('Supprimer ce trajet ?');">
                        Supprimer
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
