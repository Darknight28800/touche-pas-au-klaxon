document.addEventListener("DOMContentLoaded", () => {

    const html = document.documentElement;
    const toggleBtn = document.getElementById("themeToggle");

    if (!toggleBtn) return;

    // Mettre à jour l'icône au chargement
    updateIcon();

    toggleBtn.addEventListener("click", () => {

        const current = html.getAttribute("data-theme");
        const next = current === "dark" ? "light" : "dark";

        // Appliquer le thème
        html.setAttribute("data-theme", next);

        // Sauvegarder côté serveur
        fetch("/theme", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ theme: next })
        });

        updateIcon();
    });

    function updateIcon() {
        const isDark = html.getAttribute("data-theme") === "dark";
        toggleBtn.innerHTML = isDark
            ? '<i class="bi bi-sun"></i>'
            : '<i class="bi bi-moon"></i>';
    }
});
