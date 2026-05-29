<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – Touche Pas Au Klaxon</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style global -->
    <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">

    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<header class="admin-header">
    <div class="admin-header-left">
        <span class="admin-title">Touche Pas Au Klaxon</span>

        <nav class="admin-nav">
            <a href="/admin/users" class="admin-link">Utilisateurs</a>
            <a href="/admin/agencies" class="admin-link">Agences</a>
            <a href="/admin/trips" class="admin-link">Trajets</a>
        </nav>
    </div>

    <div class="admin-header-right">
        <span class="admin-user">
            Bonjour <?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?>
        </span>

        <a href="/logout" class="admin-logout">Déconnexion</a>
    </div>
</header>

<div class="container mt-4">
