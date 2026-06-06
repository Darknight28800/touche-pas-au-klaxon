<?php require_once __DIR__ . '/../_partials/header.php'; ?>

<div class="login-wrapper d-flex justify-content-center align-items-center" style="min-height: 70vh;">

    <div class="login-card saas-card p-4" style="max-width: 420px; width: 100%;">

        <h1 class="text-center mb-4 fw-bold">Connexion</h1>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">

            <div class="mb-3">
                <label class="form-label fw-semibold">Adresse email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control modern-input" 
                    placeholder="exemple@entreprise.com"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control modern-input" 
                    placeholder="Votre mot de passe"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Se connecter
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../_partials/footer.php'; ?>
