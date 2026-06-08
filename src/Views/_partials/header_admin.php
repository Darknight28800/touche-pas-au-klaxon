<?php
$user = $_SESSION['user'] ?? null;
$router = $GLOBALS['router'];
?>

<!DOCTYPE html>
<html lang="fr" data-theme="<?= $_SESSION['theme'] ?? 'light' ?>">
<head>
    <meta charset="UTF-8">
    <title>Admin — Touche Pas Au Klaxon</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Style global -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Style admin -->
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>

<?php if ($user && $user['role'] === 'admin'): ?>
<nav class="navbar navbar-expand-lg premium-nav shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= $router->generate('admin-dashboard') ?>">
            Admin — TPAK
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>"
                       href="<?= $router->generate('admin-dashboard') ?>">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/admin/users') ? 'active' : '' ?>"
                       href="<?= $router->generate('admin-users') ?>">
                        <i class="bi bi-people me-1"></i> Utilisateurs
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/admin/agencies') ? 'active' : '' ?>"
                       href="<?= $router->generate('admin-agencies') ?>">
                        <i class="bi bi-building me-1"></i> Agences
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/admin/trips') ? 'active' : '' ?>"
                       href="<?= $router->generate('admin-trips') ?>">
                        <i class="bi bi-car-front me-1"></i> Trajets
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav flex-row align-items-center gap-3">

                <li class="nav-item">
                    <button id="themeToggle" class="btn btn-light rounded-circle p-2">
                        <i class="bi bi-moon"></i>
                    </button>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('home') ?>">
                        <i class="bi bi-arrow-left-circle me-1"></i> Retour au site
                    </a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm" href="<?= $router->generate('logout') ?>">
                        <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>
<?php endif; ?>

<div class="container py-4">
