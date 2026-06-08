<?php
/** @var array $users */
?>

<?php require __DIR__ . '/../_partials/header_admin.php'; ?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Utilisateurs</h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="saas-card p-4">

        <h5 class="fw-semibold mb-3">Liste des utilisateurs</h5>

        <?php if (empty($users)): ?>
            <div class="alert alert-info shadow-sm">Aucun utilisateur enregistré.</div>
        <?php else: ?>

            <!-- AJOUT ICI : admin-table -->
            <div class="admin-table table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Rôle</th>
                            <th class="text-end" width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>

                                <td>
                                    <?= htmlspecialchars($u['firstname']) ?>
                                    <?= htmlspecialchars($u['lastname']) ?>
                                </td>

                                <td><?= htmlspecialchars($u['email']) ?></td>

                                <td><?= htmlspecialchars($u['phone'] ?? 'Non renseigné') ?></td>

                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Utilisateur</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-end">

                                    <a href="/admin/users/<?= $u['id'] ?>" 
                                       class="btn btn-outline-secondary btn-sm me-1">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if ($u['role'] !== 'admin'): ?>
                                        <a href="/admin/user/delete/<?= $u['id'] ?>"
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('Supprimer cet utilisateur ?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>

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
