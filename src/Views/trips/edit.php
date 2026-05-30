<?php require_once __DIR__ . '/../partials/header.php'; ?>

<?php
/** @var array $trip */
/** @var array $agencies */
?>


<div class="container" style="max-width: 750px;">

    <div class="saas-card fade-in mb-4">

        <h2 class="mb-3">Modifier le trajet</h2>
        <p class="text-muted mb-4">Modifie les informations du trajet puis enregistre les changements.</p>

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

        <form action="/trip/<?= $trip['id'] ?>/edit" method="POST">

            <h5 class="mb-3">Informations du trajet</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Agence de départ</label>
                    <select name="departure_agency_id" class="form-select" required>
                        <?php foreach ($agencies as $agency): ?>
                            <option value="<?= $agency['id'] ?>"
                                <?= $agency['id'] == $trip['departure_agency_id'] ? 'selected' : '' ?>>
                                <?= $agency['name'] ?>
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
                                <?= $agency['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date et heure de départ</label>
                    <input type="datetime-local"
                        name="departure_datetime"
                        class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_datetime'])) ?>"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date et heure d'arrivée</label>
                    <input type="datetime-local"
                        name="arrival_datetime"
                        class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($trip['arrival_datetime'])) ?>"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nombre total de places</label>
                    <input type="number"
                        name="seats_total"
                        class="form-control"
                        min="1"
                        value="<?= $trip['seats_total'] ?>"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Places disponibles</label>
                    <input type="number"
                        name="seats_available"
                        class="form-control"
                        min="0"
                        max="<?= $trip['seats_total'] ?>"
                        value="<?= $trip['seats_available'] ?>"
                        required>
                </div>

            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/trip/<?= $trip['id'] ?>" class="btn btn-outline-secondary">
                    Retour
                </a>

                <button type="submit" class="btn btn-primary">
                    Enregistrer les modifications
                </button>
            </div>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
