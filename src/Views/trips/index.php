<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4">Tous les trajets</h1>

    <div class="row g-4">

        <?php if (!empty($trips)): ?>
            <?php foreach ($trips as $t): ?>
                <div class="col-md-4">
                    <div class="saas-card p-4 h-100">

                        <h5 class="fw-bold mb-2">
                            <?= htmlspecialchars($t['departure_agency']) ?>
                            →
                            <?= htmlspecialchars($t['arrival_agency']) ?>
                        </h5>

                        <p><strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?></p>
                        <p><strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['arrival_datetime'])) ?></p>
                        <p><strong>Conducteur :</strong> <?= htmlspecialchars($t['driver_firstname']) ?> <?= htmlspecialchars($t['driver_lastname']) ?></p>

                        <a href="/trip/<?= $t['id'] ?>" class="btn btn-primary w-100 mt-3">
                            Voir le trajet
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Aucun trajet disponible.</p>
        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
