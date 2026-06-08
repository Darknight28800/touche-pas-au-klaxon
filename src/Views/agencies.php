<?php require __DIR__ . '/_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4">Nos agences</h1>

    <div class="saas-card p-4">
        <h2 class="fw-semibold mb-3">Liste des agences</h2>

        <div class="public-table table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($agencies)): ?>
                        <?php foreach ($agencies as $a): ?>
                            <tr>
                                <td><?= $a['id'] ?></td>
                                <td><?= htmlspecialchars($a['name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3">
                                Aucune agence enregistrée.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/_partials/footer.php'; ?>
