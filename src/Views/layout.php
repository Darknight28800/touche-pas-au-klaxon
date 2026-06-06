<?php
/** @var string $content */
?>

<?php
$user   = $_SESSION['user'] ?? null;
$router = $GLOBALS['router'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Touche Pas Au Klaxon') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="<?= ($_COOKIE['theme'] ?? 'light') === 'dark' ? 'dark-mode' : '' ?>">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= $router->generate('home') ?>">
            Touche Pas Au Klaxon
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= $router->generate('home') ?>">Accueil</a></li>

                <?php if ($user): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $router->generate('trip-create') ?>">Créer un trajet</a></li>
                <?php endif; ?>

                <?php if ($user && $user['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $router->generate('admin-dashboard') ?>">Admin</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <button id="darkModeToggle" class="btn btn-outline-light btn-sm">🌙 Mode sombre</button>
                </li>

                <?php if ($user): ?>
                    <li class="nav-item"><span class="navbar-text me-3">Bonjour, <?= htmlspecialchars($user['firstname']) ?></span></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm" href="<?= $router->generate('logout') ?>">Déconnexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-light btn-sm" href="<?= $router->generate('login') ?>">Connexion</a></li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

<div class="container mt-4">
    <?= $content ?>
</div>

<footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
        © <?= date('Y') ?> — Touche Pas Au Klaxon
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const body = document.body;
    const btn  = document.getElementById('darkModeToggle');

    const saved = localStorage.getItem('theme') || 'light';
    body.classList.toggle('dark-mode', saved === 'dark');

    btn?.addEventListener('click', () => {
        const isDark = body.classList.toggle('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
})();
</script>


</body>
</html>
