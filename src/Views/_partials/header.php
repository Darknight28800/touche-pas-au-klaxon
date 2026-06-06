<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="fr" data-theme="<?= $_SESSION['theme'] ?? 'light' ?>">
<head>
    <meta charset="utf-8">
    <title>Touche Pas Au Klaxon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<header class="main-header">
    <nav class="navbar navbar-expand-lg premium-nav">
        <div class="container">

            <!-- LOGO / NOM -->
            <a class="navbar-brand fw-bold" 
               href="<?= isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin' ? '/admin' : '/' ?>">
                Touche Pas Au Klaxon
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">

                <!-- MENU PUBLIC -->
                <?php if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'): ?>
                    <ul class="navbar-nav mx-auto gap-4">
                        <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="/trips">Trajets</a></li>
                        <li class="nav-item"><a class="nav-link" href="/agencies">Agences</a></li>
                        <li class="nav-item"><a class="nav-link" href="/about">À propos</a></li>
                    </ul>
                <?php endif; ?>

                <!-- MENU ADMIN HORIZONTAL -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <ul class="navbar-nav ms-auto gap-4">
                        <li class="nav-item"><a class="nav-link fw-semibold" href="/admin/users">Utilisateurs</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="/admin/agencies">Agences</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="/admin/trips">Trajets</a></li>
                        <li class="nav-item"><a class="nav-link text-danger fw-semibold" href="/logout">Déconnexion</a></li>
                    </ul>
                <?php else: ?>

                    <!-- BOUTON MODE SOMBRE + MENU UTILISATEUR -->
                    <div class="d-flex align-items-center gap-3">

                        <button id="themeToggle" class="btn btn-light rounded-circle p-2">
                            <i class="bi bi-moon"></i>
                        </button>

                        <?php if (!isset($_SESSION['user'])): ?>
                            <a class="btn btn-primary px-3" href="/login">Connexion</a>

                        <?php else: ?>
                            <a href="/trip/create" class="btn btn-outline-primary fw-semibold">Créer un trajet</a>

                            <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle fw-semibold" data-bs-toggle="dropdown">
                                    <?= htmlspecialchars($_SESSION['user']['firstname']) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/profile">Profil</a></li>
                                    <li><a class="dropdown-item text-danger" href="/logout">Déconnexion</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>
    </nav>
</header>

< class="py-4">
    <div class="container">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
    </div>