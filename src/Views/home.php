<?php
/** @var array $trips */
?>

<?php require __DIR__ . '/_partials/header.php'; ?>

<div class="container py-5">

    <section class="text-center mb-5">
        <h1 class="fw-bold mb-3">Trouvez votre prochain trajet</h1>
        <p class="text-muted fs-5">Des trajets fiables, rapides et sécurisés partout en France.</p>
        <a href="/trips" class="btn btn-primary btn-lg mt-3">Voir tous les trajets</a>
    </section>

    <section class="mb-5">
        <h2 class="fw-semibold mb-4">Trajets disponibles</h2>

        <div class="row g-4">
            <?php foreach ($trips as $t): ?>
                <div class="col-md-4">
                    <div class="saas-card p-4 h-100 d-flex flex-column justify-content-between">

                        <div>
                            <h5 class="fw-bold mb-2">
                                <?= htmlspecialchars($t['departure_agency']) ?>
                                →
                                <?= htmlspecialchars($t['arrival_agency']) ?>
                            </h5>

                            <p class="mb-1">
                                <strong>Départ :</strong>
                                <?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Arrivée :</strong>
                                <?= date('d/m/Y H:i', strtotime($t['arrival_datetime'])) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Conducteur :</strong>
                                <?= htmlspecialchars($t['driver_firstname']) ?>
                                <?= htmlspecialchars($t['driver_lastname']) ?>
                            </p>

                            <p class="mb-3">
                                <strong>Places :</strong>
                                <?= $t['seats_available'] ?>/<?= $t['seats_total'] ?>
                            </p>
                        </div>

                        <?php if (isset($_SESSION['user'])): ?>
                            <button 
                                class="btn btn-outline-primary w-100 mb-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tripModal<?= $t['id'] ?>">
                                Infos
                            </button>
                        <?php endif; ?>

                        <a href="/trip/<?= $t['id'] ?>" class="btn btn-primary w-100 mt-3">
                            Voir le trajet
                        </a>

                    </div>
                </div>

                <!-- MODALE INFOS TRAJET -->
                <?php if (isset($_SESSION['user'])): ?>
                <div class="modal fade" id="tripModal<?= $t['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Informations du trajet</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <p><strong>Conducteur :</strong> 
                                    <?= htmlspecialchars($t['driver_firstname']) ?>
                                    <?= htmlspecialchars($t['driver_lastname']) ?>
                                </p>

                                <p><strong>Email :</strong> 
                                    <?= htmlspecialchars($t['driver_email'] ?? 'Non renseigné') ?>
                                </p>

                                <p><strong>Téléphone :</strong> 
                                    <?= htmlspecialchars($t['driver_phone'] ?? 'Non renseigné') ?>
                                </p>

                                <p><strong>Places totales :</strong> 
                                    <?= $t['seats_total'] ?>
                                </p>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

        <?php if (empty($trips)): ?>
            <p class="text-center text-muted mt-4">Aucun trajet disponible pour le moment.</p>
        <?php endif; ?>
    </section>

    <section class="text-center mt-5">
        <h2 class="fw-semibold mb-3">Vous êtes conducteur ?</h2>
        <p class="text-muted fs-5 mb-4">Proposez un trajet et gagnez de l’argent en partageant votre route.</p>
        <a href="/trip/create" class="btn btn-outline-primary btn-lg">Créer un trajet</a>
    </section>

</div>

<?php require __DIR__ . '/_partials/footer.php'; ?>
