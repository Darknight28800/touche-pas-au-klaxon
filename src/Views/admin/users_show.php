<?php
/** @var array $user */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-3">Utilisateur #<?= $user['id'] ?></h1>

    <div class="saas-card mb-4">
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['lastname']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['firstname']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone'] ?? 'N/A') ?></p>
        <p><strong>Rôle actuel :</strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>

    <div class="saas-card">
        <h2 class="fw-bold mb-3">Modifier le rôle</h2>

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

<?php require __DIR__ . '/../_partials/footer.php'; ?>
