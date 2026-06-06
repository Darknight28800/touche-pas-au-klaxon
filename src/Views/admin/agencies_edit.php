<?php
/** @var array $agency */
?>

<?php require __DIR__ . '/../_partials/header.php'; ?>

<div class="container mt-4">

    <h1 class="fw-bold mb-3">Modifier l'agence</h1>

    <div class="saas-card">
        <form method="POST" action="/admin/agencies/<?= $agency['id'] ?>/update">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nom</label>
                <input type="text" name="name" class="form-control modern-input"
                       value="<?= htmlspecialchars($agency['name']) ?>" required>
            </div>

            <button class="btn btn-primary">Enregistrer</button>
            <a href="/admin/agencies" class="btn btn-light ms-2">Annuler</a>
        </form>
    </div>

</div>

<?php require __DIR__ . '/../_partials/footer.php'; ?>
