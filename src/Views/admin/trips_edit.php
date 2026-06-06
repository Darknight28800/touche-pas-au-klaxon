<?php
/** @var array $trip */
/** @var array $agencies */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-3">Modifier le trajet #<?= $trip['id'] ?></h1>

    <div class="saas-card">
        <form method="POST" action="/admin/trips/<?= $trip['id'] ?>/update" class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence de départ</label>
                <select name="departure_agency_id" class="form-select modern-input">
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"
                            <?= $trip['departure_agency_id'] == $a['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence d’arrivée</label>
                <select name="arrival_agency_id" class="form-select modern-input">
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"
                            <?= $trip['arrival_agency_id'] == $a['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Date de départ</label>
                <input type="datetime-local" name="departure_datetime" class="form-control modern-input"
                       value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_datetime'])) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Date d’arrivée</label>
                <input type="datetime-local" name="arrival_datetime" class="form-control modern-input"
                       value="<?= date('Y-m-d\TH:i', strtotime($trip['arrival_datetime'])) ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Places totales</label>
                <input type="number" name="seats_total" class="form-control modern-input"
                       value="<?= $trip['seats_total'] ?>" min="1">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Places disponibles</label>
                <input type="number" name="seats_available" class="form-control modern-input"
                       value="<?= $trip['seats_available'] ?>" min="0">
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="/admin/trips" class="btn btn-light ms-2">Annuler</a>
            </div>

        </form>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
