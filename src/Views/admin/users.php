<?php
$breadcrumb = [
    ['label' => 'Admin', 'url' => '/admin'],
    ['label' => 'Utilisateurs']
];

require_once __DIR__ . '/_partials/header_admin.php';
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4" style="color:#111827;">Utilisateurs</h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>


    <!-- Liste des utilisateurs -->
    <div class="saas-card p-4">

        <h5 class="fw-semibold mb-3">Liste des utilisateurs</h5>

        <?php if (empty($users)): ?>

            <div class="alert alert-info shadow-sm">Aucun utilisateur enregistré.</div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th width="240">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= intval($user['id']) ?></td>

                                <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>

                                <td><?= htmlspecialchars($user['email']) ?></td>

                                <td>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-primary">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Utilisateur</span>
                                    <?php endif; ?>
                                </td>

                                <td class="d-flex gap-2">

                                    <!-- Changer rôle -->
                                    <form 
                                        action="/admin/users/<?= intval($user['id']) ?>/role" 
                                        method="POST"
                                        class="d-flex flex-grow-1 gap-2">

                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                                        <select name="role" class="form-select form-select-sm" required>
                                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>

                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    <!-- Supprimer -->
                                    <form 
                                        action="/admin/users/<?= intval($user['id']) ?>/delete" 
                                        method="POST"
                                        onsubmit="return confirm('Supprimer cet utilisateur ?');">

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
