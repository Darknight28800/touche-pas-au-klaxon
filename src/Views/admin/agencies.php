<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4">Agences</h1>

    <!-- Formulaire d'ajout -->
    <div class="saas-card mb-4 p-4">
        <h2 class="fw-semibold mb-3">Ajouter une agence</h2>

        <form method="POST" action="/admin/agencies/create" class="row g-3">
            <div class="col-md-8">
                <input 
                    type="text" 
                    name="name" 
                    class="form-control modern-input" 
                    placeholder="Nom de l'agence" 
                    required
                >
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Liste des agences -->
    <div class="saas-card p-4">
        <h2 class="fw-semibold mb-3">Liste des agences</h2>

        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($agencies)): ?>
                        <?php foreach ($agencies as $a): ?>
                            <tr>
                                <td><?= $a['id'] ?></td>
                                <td><?= htmlspecialchars($a['name']) ?></td>

                                <td class="text-end">
                                    <a href="/admin/agencies/<?= $a['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        Modifier
                                    </a>

                                    <a href="/admin/agencies/<?= $a['id'] ?>/delete"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Supprimer cette agence ?');">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                Aucune agence enregistrée.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
