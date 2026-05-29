<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4" style="color:#111827;">Créer un trajet</h1>

    <div class="saas-card p-4 mb-4">

        <!-- Messages -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="/trip/create" method="POST" class="row g-3">

            <!-- Départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence de départ</label>
                <select name="departure_agency_id" class="form-select" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>">
                            <?= htmlspecialchars($agency['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Agence d'arrivée</label>
                <select name="arrival_agency_id" class="form-select" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>">
                            <?= htmlspecialchars($agency['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date départ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure de départ</label>
                <input type="datetime-local" name="departure_datetime" class="form-control" required>
            </div>

            <!-- Date arrivée -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date et heure d'arrivée</label>
                <input type="datetime-local" name="arrival_datetime" class="form-control" required>
            </div>

            <!-- Places totales -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre total de places</label>
                <input type="number" name="seats_total" class="form-control" min="1" required>
            </div>

            <!-- Places disponibles -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Places disponibles</label>
                <input type="number" name="seats_available" class="form-control" min="0" required>
            </div>

            <!-- Boutons -->
            <div class="col-12 d-flex gap-3 mt-3">

                <a href="/" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>

                <button type="submit" class="btn btn-primary fw-semibold">
                    <i class="bi bi-check-circle"></i> Créer le trajet
                </button>

            </div>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
