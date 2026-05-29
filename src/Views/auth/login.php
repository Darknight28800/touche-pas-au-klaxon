<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">

    <h2 class="text-center mb-4">Connexion</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>

    </form>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
