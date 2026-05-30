<?php require_once __DIR__ . '/../partials/header.php'; ?>

<?php
/** @var array $agencies */
?>


<div class="container mt-5" style="max-width: 700px;">

    <h2 class="text-center mb-4">Proposer un trajet</h2>

    <!-- 🔴 Message d’erreur -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- 🟢 Message de succès -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="/trip/create" method="POST" class="card p-4 shadow-sm">

        <h5 class="mb-3">Vos informations</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" value="<?= $_SESSION['user']['firstname'] ?>" disabled>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" value="<?= $_SESSION['user']['lastname'] ?>" disabled>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?= $_SESSION['user']['email'] ?>" disabled>
        </div>

        <div class="mb-4">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" value="<?= $_SESSION['user']['phone'] ?>" disabled>
        </div>

        <hr>

        <h5 class="mb-3">Informations du trajet</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Agence de départ</label>
                <select name="departure_agency_id" class="form-select" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>">
                            <?= $agency['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Agence d'arrivée</label>
                <select name="arrival_agency_id" class="form-select" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>">
                            <?= $agency['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date et heure de départ</label>
                <input type="datetime-local" name="departure_datetime" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Date et heure d'arrivée</label>
                <input type="datetime-local" name="arrival_datetime" class="form-control" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Nombre total de places</label>
            <input type="number" name="seats_total" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Créer le trajet</button>

    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
