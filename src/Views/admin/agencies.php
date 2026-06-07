<?php
/** @var array $agencies */
?>

<?php require __DIR__ . '/../_partials/header_admin.php'; ?>

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

        <form method="POST" action="/admin/agencies/create" class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nom de l'agence</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control modern-input" 
                    placeholder="Ex : Paris Gare de Lyon" 
                    required
                >
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary">Ajouter</button>
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
                            <th class="text-end" width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($agencies as $a): ?>
                            <tr>
                                <td><?= $a['id'] ?></td>

                                <td><?= htmlspecialchars($a['name']) ?></td>

                                <td class="text-end">

                                    <!-- Modifier -->
                                    <a href="/admin/agencies/<?= $a['id'] ?>/edit" 
                                       class="btn btn-outline-secondary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- Supprimer -->
                                    <a href="/admin/agencies/<?= $a['id'] ?>/delete"
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Supprimer cette agence ?');">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
