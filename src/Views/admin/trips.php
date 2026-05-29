<?php
$breadcrumb = [
    ['label' => 'Admin', 'url' => '/admin'],
    ['label' => 'Trajets']
];

require_once __DIR__ . '/_partials/header_admin.php';
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Trajets</h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>


    <!-- Filtres -->
    <div class="saas-card p-4 mb-4">

        <h5 class="fw-semibold mb-3">Filtres</h5>

        <form method="GET" action="/admin/trips" class="row g-3">

            <!-- Départ -->
            <div class="col-md-3">
                <label class="form-label">Agence de départ</label>
                <select name="departure" class="form-select">
                    <option value="">Toutes</option>
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
                <label class="form-label">Agence d'arrivée</label>
                <select name="arrival" class="form-select">
                    <option value="">Toutes</option>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency['id'] ?>"
                            <?= ($_GET['arrival'] ?? '') == $agency['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agency['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Conducteur -->
            <div class="col-md-3">
                <label class="form-label">Conducteur</label>
                <select name="driver" class="form-select">
                    <option value="">Tous</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>"
                            <?= ($_GET['driver'] ?? '') == $user['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date -->
            <div class="col-md-3">
                <label class="form-label">Date de départ</label>
                <input type="date" name="date" class="form-control"
                       value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
            </div>

            <!-- Boutons -->
            <div class="col-md-12 d-flex gap-2 mt-3">
                <button class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filtrer
                </button>
                <a href="/admin/trips" class="btn btn-outline-secondary">Réinitialiser</a>
            </div>

        </form>

    </div>


    <!-- Liste des trajets -->
    <div class="saas-card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold m-0">Liste des trajets</h5>

            <a href="/admin/trips/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau trajet
            </a>
        </div>


        <!-- Export -->
        <div class="mb-3">
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Exporter
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item"
                           href="/admin/trips/export?<?= htmlspecialchars(http_build_query($_GET)) ?>">
                            Export CSV
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="/admin/export/trips?<?= htmlspecialchars(http_build_query($_GET)) ?>">
                            Export Excel
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="/admin/trips/pdf?<?= htmlspecialchars(http_build_query($_GET)) ?>">
                            Export PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <?php if (empty($trips)): ?>

            <div class="alert alert-info shadow-sm">Aucun trajet enregistré.</div>

        <?php else: ?>

            <?php 
                function sortLink($column) {
                    $order = ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc';
                    return '?'.http_build_query(array_merge($_GET, ['sort' => $column, 'order' => $order]));
                }
            ?>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><a href="<?= sortLink('id') ?>">ID</a></th>
                            <th><a href="<?= sortLink('departure') ?>">Départ</a></th>
                            <th><a href="<?= sortLink('arrival') ?>">Arrivée</a></th>
                            <th><a href="<?= sortLink('date') ?>">Date départ</a></th>
                            <th><a href="<?= sortLink('driver') ?>">Conducteur</a></th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($trips as $trip): ?>
                            <tr>
                                <td><?= $trip['id'] ?></td>
                                <td><?= htmlspecialchars($trip['departure_agency_name']) ?></td>
                                <td><?= htmlspecialchars($trip['arrival_agency_name']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?></td>
                                <td><?= htmlspecialchars($trip['driver_firstname'] . ' ' . $trip['driver_lastname']) ?></td>

                                <td class="d-flex gap-2">

                                    <a href="/trip/<?= $trip['id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="/admin/trips/<?= $trip['id'] ?>/delete"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer ce trajet ?');">

                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>


            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center mt-4">

                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link"
                               href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                Précédent
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link"
                                   href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link"
                               href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                Suivant
                            </a>
                        </li>

                    </ul>
                </nav>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>

<?php require_once __DIR__ . '/_partials/footer_admin.php'; ?>
