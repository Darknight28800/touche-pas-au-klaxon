<?php
$breadcrumb = [
    ['label' => 'Admin', 'url' => '/admin'],
    ['label' => 'Trajets', 'url' => '/admin/trips'],
    ['label' => 'Modifier un trajet']
];

require_once __DIR__ . '/../partials/header.php';

?>

<div class="container mt-4">

    <h1 class="mb-4">Modifier le trajet</h1>

    <!-- 🟢 Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST" action="/admin/trips/update/<?= $trip['id'] ?>" class="row g-3">

                <!-- CSRF -->
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <!-- AGENCES -->
                <div class="col-md-6">
                    <label class="form-label">Agence de départ</label>
                    <select name="departure_agency_id" class="form-select" required>
                        <?php foreach ($agencies as $agency): ?>
                            <option value="<?= $agency['id'] ?>"
                                <?= $agency['id'] == $trip['departure_agency_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agency['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Agence d'arrivée</label>
                    <select name="arrival_agency_id" class="form-select" required>
                        <?php foreach ($agencies as $agency): ?>
                            <option value="<?= $agency['id'] ?>"
                                <?= $agency['id'] == $trip['arrival_agency_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agency['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- DATES -->
                <div class="col-md-6">
                    <label class="form-label">Date et heure de départ</label>
                    <input type="datetime-local" name="departure_datetime" class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_datetime'])) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date et heure d'arrivée</label>
                    <input type="datetime-local" name="arrival_datetime" class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($trip['arrival_datetime'])) ?>" required>
                </div>

                <!-- PLACES -->
                <div class="col-md-6">
                    <label class="form-label">Places totales</label>
                    <input type="number" name="seats_total" class="form-control"
                        value="<?= $trip['seats_total'] ?>" min="1" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Places disponibles</label>
                    <input type="number" name="seats_available" class="form-control"
                        value="<?= $trip['seats_available'] ?>" min="0" required>
                </div>

                <!-- CONDUCTEUR -->
                <div class="col-12">
                    <label class="form-label">Conducteur</label>
                    <select name="driver_id" class="form-select" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"
                                <?= $user['id'] == $trip['driver_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary w-100">Mettre à jour</button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
