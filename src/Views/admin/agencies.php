<?php
$breadcrumb = [
    ['label' => 'Admin', 'url' => '/admin'],
    ['label' => 'Agences']
];

require_once __DIR__ . '/_partials/header_admin.php';
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Agences</h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>


    <!-- Formulaire d'ajout -->
    <div class="saas-card p-4 mb-4">

        <h5 class="fw-semibold mb-3">Ajouter une agence</h5>

        <form action="/admin/agencies/create" method="POST" class="row g-3">

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="col-md-8">
                <input 
                    type="text" 
                    name="name" 
                    class="form-control"
                    placeholder="Nom de l'agence"
                    required>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>

        </form>

    </div>


    <!-- Liste des agences -->
    <div class="saas-card p-4">

        <h5 class="fw-semibold mb-3">Liste des agences</h5>

        <?php if (empty($agencies)): ?>
            
            <div class="alert alert-info shadow-sm">Aucune agence enregistrée.</div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($agencies as $agency): ?>
                            <tr>
                                <td><?= intval($agency['id']) ?></td>

                                <td><?= htmlspecialchars($agency['name']) ?></td>

                                <td class="d-flex gap-2">

                                    <!-- Modification -->
                                    <form 
                                        action="/admin/agencies/<?= intval($agency['id']) ?>/edit" 
                                        method="POST"
                                        class="d-flex flex-grow-1 gap-2">

                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                                        <input 
                                            type="text" 
                                            name="name" 
                                            class="form-control"
                                            value="<?= htmlspecialchars($agency['name']) ?>"
                                            required>

                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </form>

                                    <!-- Suppression -->
                                    <form 
                                        action="/admin/agencies/<?= intval($agency['id']) ?>/delete" 
                                        method="POST"
                                        onsubmit="return confirm('Supprimer cette agence ?');">

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

        <?php endif; ?>

    </div>

</div>

<?php require_once __DIR__ . '/_partials/footer_admin.php'; ?>
