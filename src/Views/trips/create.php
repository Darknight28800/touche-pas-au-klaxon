<?php
/** @var array $agencies */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-5">

    <div class="saas-card">

        <h2 class="fw-bold mb-4">Créer un trajet</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="/trip/create">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Agence de départ</label>
                    <select name="departure_agency_id" class="form-select modern-input" required>
                        <?php foreach ($agencies as $a): ?>
                            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Agence d’arrivée</label>
                    <select name="arrival_agency_id" class="form-select modern-input" required>
                        <?php foreach ($agencies as $a): ?>
                            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date de départ</label>
                    <input type="datetime-local" name="departure_datetime" class="form-control modern-input" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date d’arrivée</label>
                    <input type="datetime-local" name="arrival_datetime" class="form-control modern-input" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Places totales</label>
                    <input type="number" name="seats_total" class="form-control modern-input" min="1" required>
                </div>

            </div>

            <button class="btn btn-primary w-100 mt-4 py-2">Créer le trajet</button>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
