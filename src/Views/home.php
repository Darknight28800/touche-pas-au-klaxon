<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
$agencies = $agencies ?? [];
$trips = $trips ?? [];
?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4" style="color:#111827;">Trajets disponibles</h1>

    <!-- 🔵 FILTRES PUBLICS -->
    <div class="saas-card p-4 mb-4">

        <h5 class="fw-semibold mb-3">Rechercher un trajet</h5>

        <form method="GET" action="/" class="row g-3 search-form">

            <!-- Départ -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Départ</label>
                <select name="departure" class="form-select">
                    <option value="">Toutes destinations</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>"
                            <?= ($_GET['departure'] ?? '') == $agency['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agency['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Arrivée -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Arrivée</label>
                <select name="arrival" class="form-select">
                    <option value="">Toutes destinations</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>"
                            <?= ($_GET['arrival'] ?? '') == $agency['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agency['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date</label>
                <input type="date" name="date" class="form-control"
                       value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
            </div>

            <!-- Boutons -->
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button class="btn btn-primary w-100 fw-semibold">Filtrer</button>
                <a href="/" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>

        </form>

    </div>

    <!-- 🟢 LISTE DES TRAJETS -->
    <div class="row">

        <?php if (empty($trips)): ?>

            <div class="col-12">
                <div class="alert alert-info">Aucun trajet disponible pour le moment.</div>
            </div>

        <?php else: ?>

            <?php foreach ($trips as $trip): ?>
                <div class="col-md-4 mb-4">
                    <div class="trip-card shadow-sm h-100">

                        <div class="card-body">

                            <h5 class="fw-bold mb-2">
                                <?= htmlspecialchars($trip['departure_agency_name']) ?>
                                →
                                <?= htmlspecialchars($trip['arrival_agency_name']) ?>
                            </h5>

                            <p class="mb-1 text-muted">
                                <strong>Départ :</strong><br>
                                <?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?>
                            </p>

                            <p class="mb-1 text-muted">
                                <strong>Arrivée :</strong><br>
                                <?= date('d/m/Y H:i', strtotime($trip['arrival_datetime'])) ?>
                            </p>

                            <p class="mb-1 text-muted">
                                <strong>Conducteur :</strong><br>
                                <?= htmlspecialchars($trip['driver_firstname'] . ' ' . $trip['driver_lastname']) ?>
                            </p>

                            <p class="mb-3 text-muted">
                                <strong>Places disponibles :</strong>
                                <?= $trip['seats_available'] ?> / <?= $trip['seats_total'] ?>
                            </p>

                            <a href="/trip/<?= $trip['id'] ?>" class="btn btn-primary w-100 fw-semibold">
                                Voir le trajet
                            </a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <!-- 🔵 PAGINATION -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-4">

                <!-- Précédent -->
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                        Précédent
                    </a>
                </li>

                <!-- Pages -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link"
                           href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Suivant -->
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                        Suivant
                    </a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
