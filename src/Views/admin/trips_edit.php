<?php
/** @var array $trip */
/** @var array $agencies */
require __DIR__ . '/../_partials/header_admin.php';
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">
        Modifier le trajet #<?= $trip['id'] ?>
    </h1>

    <div class="saas-card p-4">

        <form action="/admin/trips/<?= $trip['id'] ?>/edit" method="POST" class="row g-3">

            <!-- Agence départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence de départ</label>
                <select name="departure_agency_id" class="form-select modern-input" required>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"
                            <?= ($trip['departure_agency_id'] == $a['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Agence arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence d’arrivée</label>
                <select name="arrival_agency_id" class="form-select modern-input" required>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"
                            <?= ($trip['arrival_agency_id'] == $a['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure de départ</label>
                <input type="datetime-local" name="departure_datetime"
                       value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_datetime'])) ?>"
                       class="form-control modern-input" required>
            </div>

            <!-- Date arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure d’arrivée</label>
                <input type="datetime-local" name="arrival_datetime"
                       value="<?= date('Y-m-d\TH:i', strtotime($trip['arrival_datetime'])) ?>"
                       class="form-control modern-input" required>
            </div>

            <!-- Places totales -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Places totales</label>
                <input type="number" name="seats_total" min="1"
                       value="<?= $trip['seats_total'] ?>"
                       class="form-control modern-input" required>
            </div>

            <!-- Places disponibles -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Places disponibles</label>
                <input type="number" name="seats_available" min="0"
                       value="<?= $trip['seats_available'] ?>"
                       class="form-control modern-input" required>
            </div>

            <!-- Conducteur -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">ID conducteur</label>
                <input type="number" name="driver_id" min="1"
                       value="<?= $trip['driver_id'] ?>"
                       class="form-control modern-input" required>
            </div>

            <div class="col-12 mt-3 d-flex gap-2">
                <button class="btn btn-warning">Enregistrer</button>
                <a href="/admin/trips" class="btn btn-light">Annuler</a>
            </div>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
