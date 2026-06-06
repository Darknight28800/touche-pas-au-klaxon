<?php
/** @var array $users */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-4">Utilisateurs</h1>

    <div class="saas-card">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['lastname']) ?></td>
                            <td><?= htmlspecialchars($u['firstname']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['role']) ?></td>
                            <td class="text-end">
                                <a href="/admin/users/<?= $u['id'] ?>" class="btn btn-sm btn-primary">
                                    Détails / Rôle
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun utilisateur.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
