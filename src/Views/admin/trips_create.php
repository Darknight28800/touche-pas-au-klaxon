<?php
/** @var array $agencies */
require __DIR__ . '/../_partials/header_admin.php';
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Créer un trajet</h1>

    <div class="saas-card p-4">

        <form action="/admin/trips/create" method="POST" class="row g-3">

            <!-- Agence départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence de départ</label>
                <select name="departure_agency_id" class="form-select modern-input" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Agence arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence d’arrivée</label>
                <select name="arrival_agency_id" class="form-select modern-input" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure de départ</label>
                <input type="datetime-local" name="departure_datetime" class="form-control modern-input" required>
            </div>

            <!-- Date arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure d’arrivée</label>
                <input type="datetime-local" name="arrival_datetime" class="form-control modern-input" required>
            </div>

            <!-- Places totales -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Places totales</label>
                <input type="number" name="seats_total" class="form-control modern-input" min="1" required>
            </div>

            <!-- Places disponibles -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Places disponibles</label>
                <input type="number" name="seats_available" class="form-control modern-input" min="0" required>
            </div>

            <!-- Conducteur -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">ID conducteur</label>
                <input type="number" name="driver_id" class="form-control modern-input" min="1" required>
            </div>

            <div class="col-12 mt-3 d-flex gap-2">
                <button class="btn btn-primary">Créer</button>
                <a href="/admin/trips" class="btn btn-light">Annuler</a>
            </div>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
