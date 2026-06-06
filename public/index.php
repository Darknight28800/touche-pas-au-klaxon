<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TripController;
use App\Controllers\AdminController;
use App\Controllers\AgencyController;

session_start();

// -------------------------------
// ROUTEUR
// -------------------------------
$router = new AltoRouter();
$GLOBALS['router'] = $router;
$router->setBasePath('');


// -------------------------------
// ROUTES PUBLIQUES
// -------------------------------

// Accueil
$router->map('GET', '/', function () {
    (new HomeController())->index();
}, 'home');

// Page publique des agences
$router->map('GET', '/agencies', function () {
    (new AgencyController())->index();
}, 'agencies-list');

// Page publique des trajets
$router->map('GET', '/trips', function () {
    (new TripController())->index();
}, 'trips-list');

// Page À propos
$router->map('GET', '/about', function () {
    require __DIR__ . '/../src/Views/about.php';
}, 'about');

// Connexion (formulaire)
$router->map('GET', '/login', function () {
    (new AuthController())->loginForm();
}, 'login');

// Connexion (traitement)
$router->map('POST', '/login', function () {
    (new AuthController())->login();
}, 'login-post');

// Déconnexion
$router->map('GET', '/logout', function () {
    (new AuthController())->logout();
}, 'logout');


// -------------------------------
// ROUTES UTILISATEUR CONNECTÉ
// -------------------------------

// Voir un trajet
$router->map('GET', '/trip/[i:id]', function ($id) {
    (new TripController())->show($id);
}, 'trip-show');

// Créer un trajet
$router->map('GET', '/trip/create', function () {
    (new TripController())->createForm();
}, 'trip-create');

$router->map('POST', '/trip/create', function () {
    (new TripController())->create();
}, 'trip-create-post');

// Modifier un trajet
$router->map('GET', '/trip/[i:id]/edit', function ($id) {
    (new TripController())->editForm($id);
}, 'trip-edit');

$router->map('POST', '/trip/[i:id]/edit', function ($id) {
    (new TripController())->update($id);
}, 'trip-edit-post');

// Supprimer un trajet
$router->map('GET', '/trip/[i:id]/delete', function ($id) {
    (new TripController())->delete($id);
}, 'trip-delete');


// -------------------------------
// ROUTES ADMIN
// -------------------------------

// Dashboard
$router->map('GET', '/admin', function () {
    (new AdminController())->dashboard();
}, 'admin-dashboard');

// Utilisateurs
$router->map('GET', '/admin/users', function () {
    (new AdminController())->users();
}, 'admin-users');

$router->map('GET', '/admin/users/[i:id]', function ($id) {
    (new AdminController())->showUser($id);
}, 'admin-user-show');

$router->map('POST', '/admin/users/[i:id]/role', function ($id) {
    (new AdminController())->updateUserRole($id);
}, 'admin-user-role');


// -------------------------------
// ADMIN — AGENCES
// -------------------------------

$router->map('GET', '/admin/agencies', function () {
    (new AdminController())->agencies();
}, 'admin-agencies');

$router->map('POST', '/admin/agencies/create', function () {
    (new AdminController())->createAgency();
}, 'admin-agency-create');

$router->map('GET', '/admin/agencies/[i:id]/edit', function ($id) {
    (new AdminController())->editAgencyForm($id);
}, 'admin-agency-edit');

$router->map('POST', '/admin/agencies/[i:id]/edit', function ($id) {
    (new AdminController())->updateAgency($id);
}, 'admin-agency-edit-post');

$router->map('GET', '/admin/agencies/[i:id]/delete', function ($id) {
    (new AdminController())->deleteAgency($id);
}, 'admin-agency-delete');


// -------------------------------
// ADMIN — TRAJETS
// -------------------------------

$router->map('GET', '/admin/trips', function () {
    (new AdminController())->trips();
}, 'admin-trips');

$router->map('GET', '/admin/trips/create', function () {
    (new AdminController())->createTripForm();
}, 'admin-trip-create');

$router->map('POST', '/admin/trips/create', function () {
    (new AdminController())->createTrip();
}, 'admin-trip-create-post');

$router->map('GET', '/admin/trips/[i:id]/edit', function ($id) {
    (new AdminController())->editTripForm($id);
}, 'admin-trip-edit');

$router->map('POST', '/admin/trips/[i:id]/edit', function ($id) {
    (new AdminController())->updateTrip($id);
}, 'admin-trip-edit-post');

$router->map('POST', '/admin/trips/[i:id]/delete', function ($id) {
    (new AdminController())->deleteTrip($id);
}, 'admin-trip-delete');

// EXPORTS
$router->map('GET', '/admin/trips/export', function () {
    (new AdminController())->exportTripsCSV();
}, 'admin-trips-export-csv');

$router->map('GET', '/admin/export/trips', function () {
    (new AdminController())->exportTripsExcel();
}, 'admin-trips-export-excel');

$router->map('GET', '/admin/trips/pdf', function () {
    (new AdminController())->exportTripsPDF();
}, 'admin-trips-export-pdf');


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
