<?php
$user = $_SESSION['user'] ?? null;
$router = $GLOBALS['router'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Touche Pas Au Klaxon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= $router->generate('admin-dashboard') ?>">
            Admin — TPAK
        </a>

        <ul class="navbar-nav flex-row">

            <li class="nav-item me-3">
                <a class="nav-link" href="<?= $router->generate('home') ?>">Retour au site</a>
            </li>

            <li class="nav-item">
                <a class="btn btn-outline-light btn-sm" href="<?= $router->generate('logout') ?>">Déconnexion</a>
            </li>

        </ul>

    </div>
</nav>

<div class="container py-4">
