<?php
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche Pas Au Klaxon</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- TON STYLE CSS UNIFIÉ -->
    <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">

    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<?php
// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!-- FLASH MESSAGES -->
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?> text-center m-2">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<!-- NAVBAR FRONT -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="/">Touche Pas Au Klaxon</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>

                <?php if ($user): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/trip/create">Créer un trajet</a>
                    </li>
                <?php endif; ?>

                <?php if ($user && $user['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
                    </li>
                <?php endif; ?>

            </ul>

            <ul class="navbar-nav">

                <!-- DARK MODE -->
                <li class="nav-item me-3">
                    <button id="darkModeToggle" class="btn btn-outline-light btn-sm">
                        🌙 Mode sombre
                    </button>
                </li>

                <?php if ($user): ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            Bonjour, <?= htmlspecialchars($user['firstname']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="/logout">Déconnexion</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="/login">Connexion</a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- BREADCRUMB -->
    <?php if (!empty($breadcrumb)): ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumb as $item): ?>
                    <?php if (!empty($item['url'])): ?>
                        <li class="breadcrumb-item">
                            <a href="<?= $item['url'] ?>"><?= htmlspecialchars($item['label']) ?></a>
                        </li>
                    <?php else: ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($item['label']) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
    <?php endif; ?>

</div>

<!-- DARK MODE SCRIPT -->
<script>
    const body = document.body;
    const toggle = document.getElementById('darkModeToggle');

    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark');
    }

    toggle.addEventListener('click', () => {
        body.classList.toggle('dark');

        if (body.classList.contains('dark')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.removeItem('darkMode');
        }
    });
</script>
