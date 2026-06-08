<?php
/** @var array $agencies */
/** @var array $filters */
/** @var array $trips */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container py-5">

    <h1 class="fw-bold mb-4">Tous les trajets</h1>

    <div class="saas-card mb-4">
        <form method="GET" class="row g-3">

            <div class="col-md-4">
                <label class="form-label fw-semibold">Départ</label>
                <select name="departure" class="form-select modern-input">
                    <option value="">Toutes</option>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= ($filters['departure'] == $a['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Arrivée</label>
                <select name="arrival" class="form-select modern-input">
                    <option value="">Toutes</option>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= ($filters['arrival'] == $a['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Date</label>
                <input type="date" name="date" class="form-control modern-input"
                       value="<?= htmlspecialchars($filters['date']) ?>">
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100 py-2">Filtrer</button>
            </div>

        </form>
    </div>

    <div class="row g-4">
        <?php foreach ($trips as $t): ?>
            <div class="col-md-4">
                <div class="saas-card p-4 h-100 d-flex flex-column justify-content-between">

                    <div>
                        <h5 class="fw-bold mb-2">
                            <?= htmlspecialchars($t['departure_agency_name']) ?>
                            →
                            <?= htmlspecialchars($t['arrival_agency_name']) ?>
                        </h5>

                        <p class="mb-1"><strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($t['departure_datetime'])) ?></p>
                        <p class="mb-1"><strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['arrival_datetime'])) ?></p>
                        <p class="mb-1"><strong>Places :</strong> <?= $t['seats_available'] ?>/<?= $t['seats_total'] ?></p>
                    </div>

                    <a href="/trip/<?= $t['id'] ?>" class="btn btn-primary w-100 mt-3">Voir le trajet</a>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($trips)): ?>
        <p class="text-center text-muted mt-4">Aucun trajet trouvé.</p>
    <?php endif; ?>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
