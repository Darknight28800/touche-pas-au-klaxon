<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TripController;
use App\Controllers\AdminController;

session_start();

$router = new AltoRouter();


// -------------------------------
// ROUTES PUBLIQUES
// -------------------------------

// Accueil
$router->map('GET', '/', function () {
    (new HomeController())->index();
});

// Connexion (formulaire)
$router->map('GET', '/login', function () {
    (new AuthController())->loginForm();
});

// Connexion (traitement)
$router->map('POST', '/login', function () {
    (new AuthController())->login();
});

// Déconnexion
$router->map('GET', '/logout', function () {
    (new AuthController())->logout();
});


// -------------------------------
// ROUTES UTILISATEUR CONNECTÉ
// -------------------------------

$router->map('GET', '/trip/[i:id]', function ($id) {
    (new TripController())->show($id);
});

$router->map('GET', '/trip/create', function () {
    (new TripController())->createForm();
});

$router->map('POST', '/trip/create', function () {
    (new TripController())->create();
});

$router->map('GET', '/trip/[i:id]/edit', function ($id) {
    (new TripController())->editForm($id);
});

$router->map('POST', '/trip/[i:id]/edit', function ($id) {
    (new TripController())->update($id);
});

$router->map('GET', '/trip/[i:id]/delete', function ($id) {
    (new TripController())->delete($id);
});


// -------------------------------
// ROUTES ADMIN
// -------------------------------

$router->map('GET', '/admin', function () {
    (new AdminController())->dashboard();
});

$router->map('GET', '/admin/users', function () {
    (new AdminController())->users();
});

$router->map('GET', '/admin/agencies', function () {
    (new AdminController())->agencies();
});

$router->map('POST', '/admin/agencies/create', function () {
    (new AdminController())->createAgency();
});

$router->map('POST', '/admin/agencies/[i:id]/edit', function ($id) {
    (new AdminController())->updateAgency($id);
});

$router->map('POST', '/admin/agencies/[i:id]/delete', function ($id) {
    (new AdminController())->deleteAgency($id);
});

$router->map('GET', '/admin/trips', function () {
    (new AdminController())->trips();
});

$router->map('GET', '/admin/trips/create', function () {
    (new AdminController())->createTripForm();
});

$router->map('POST', '/admin/trips/create', function () {
    (new AdminController())->createTrip();
});

$router->map('GET', '/admin/trips/[i:id]/edit', function ($id) {
    (new AdminController())->editTripForm($id);
});

$router->map('POST', '/admin/trips/[i:id]/edit', function ($id) {
    (new AdminController())->updateTrip($id);
});

$router->map('POST', '/admin/trips/[i:id]/delete', function ($id) {
    (new AdminController())->deleteTrip($id);
});

// EXPORTS
$router->map('GET', '/admin/trips/export', function () {
    (new AdminController())->exportTripsCSV();
});

$router->map('GET', '/admin/export/trips', function () {
    (new AdminController())->exportTripsExcel();
});

$router->map('GET', '/admin/trips/pdf', function () {
    (new AdminController())->exportTripsPDF();
});


// -------------------------------
// DISPATCH
// -------------------------------

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
