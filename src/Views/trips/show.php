<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4" style="color:#111827;">
        Trajet : <?= htmlspecialchars($trip['departure_agency_name']) ?> → <?= htmlspecialchars($trip['arrival_agency_name']) ?>
    </h1>

    <div class="saas-card p-4 mb-4">

        <!-- SECTION 1 : Infos principales -->
        <h5 class="fw-semibold mb-3">Informations générales</h5>

        <div class="row mb-3">

            <div class="col-md-6 mb-3">
                <label class="text-muted fw-semibold">Départ</label>
                <div class="fs-5 fw-bold">
                    <?= htmlspecialchars($trip['departure_agency_name']) ?>
                </div>
                <div class="text-muted">
                    <?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted fw-semibold">Arrivée</label>
                <div class="fs-5 fw-bold">
                    <?= htmlspecialchars($trip['arrival_agency_name']) ?>
                </div>
                <div class="text-muted">
                    <?= date('d/m/Y H:i', strtotime($trip['arrival_datetime'])) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- SECTION 2 : Conducteur -->
        <h5 class="fw-semibold mb-3">Conducteur</h5>

        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                 style="width: 55px; height: 55px; font-size: 1.3rem;">
                <?= strtoupper(substr($trip['driver_firstname'], 0, 1)) ?>
            </div>

            <div>
                <div class="fw-bold fs-5">
                    <?= htmlspecialchars($trip['driver_firstname'] . ' ' . $trip['driver_lastname']) ?>
                </div>
                <div class="text-muted">
                    <?= htmlspecialchars($trip['driver_email']) ?>
                </div>
                <div class="text-muted">
                    <?= htmlspecialchars($trip['driver_phone']) ?>
                </div>
            </div>
        </div>

        <hr>

        <!-- SECTION 3 : Places -->
        <h5 class="fw-semibold mb-3">Places</h5>

        <div class="d-flex align-items-center gap-3 mb-3">
            <span class="badge bg-primary fs-6 px-3 py-2">
                <?= $trip['seats_available'] ?> / <?= $trip['seats_total'] ?> disponibles
            </span>
        </div>

        <hr>

        <!-- SECTION 4 : Actions -->
        <div class="d-flex gap-3 mt-4">

    <a href="/admin/trips" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <?php if ($user && ($user['role'] === 'admin' || $user['id'] == $trip['driver_id'])): ?>
        
        <a href="/admin/trips/<?= $trip['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>

        <form action="/admin/trips/<?= $trip['id'] ?>/delete" method="POST"
                onsubmit="return confirm('Supprimer ce trajet ?');">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button class="btn btn-danger">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </form>

    <?php endif; ?>

</div>


    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
