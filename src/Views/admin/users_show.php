<?php
/** @var array $user */
?>

<?php require __DIR__ . '/../_partials/header_admin.php'; ?>

<div class="container py-5">

    <h1 class="fw-bold mb-4">Utilisateur #<?= $user['id'] ?></h1>

    <!-- Messages flash -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Informations utilisateur -->
    <div class="saas-card p-4 mb-4">

        <h5 class="fw-semibold mb-3">Informations générales</h5>

        <p><strong>Nom :</strong> <?= htmlspecialchars($user['lastname']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['firstname']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone'] ?? 'Non renseigné') ?></p>

        <p>
            <strong>Rôle actuel :</strong>
            <?php if ($user['role'] === 'admin'): ?>
                <span class="badge bg-danger">Administrateur</span>
            <?php else: ?>
                <span class="badge bg-primary">Utilisateur</span>
            <?php endif; ?>
        </p>

    </div>

    <!-- Modification du rôle -->
    <div class="saas-card p-4">

        <h5 class="fw-semibold mb-3">Modifier le rôle</h5>

        <form method="POST" action="/admin/users/<?= $user['id'] ?>/role">

            <div class="mb-3">
                <label class="form-label fw-semibold">Rôle</label>
                <select name="role" class="form-select modern-input">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                </select>
            </div>

            <button class="btn btn-primary">Mettre à jour</button>
            <a href="/admin/users" class="btn btn-light ms-2">Retour</a>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../_partials/footer_admin.php'; ?>
