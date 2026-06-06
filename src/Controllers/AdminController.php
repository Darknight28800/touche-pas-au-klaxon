<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgencyModel;
use App\Models\TripModel;

/**
 * Class AdminController
 *
 * Gère l'ensemble des fonctionnalités administrateur :
 * - tableau de bord
 * - gestion des utilisateurs
 * - gestion des agences
 * - gestion des trajets
 *
 * Toutes les actions nécessitent un rôle administrateur.
 */
class AdminController extends CoreController
{
    /**
     * Constructeur : vérifie que l'utilisateur est administrateur.
     */
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . $this->router->generate('login'));
            exit;
        }
    }

    /**
     * Stocke un message flash dans la session.
     *
     * @param string $type success|error
     * @param string $message Message à afficher
     * @return void
     */
    private function flash(string $type, string $message): void
    {
        $_SESSION[$type] = $message;
    }

    /* ============================
       DASHBOARD
       ============================ */

    /**
     * Affiche le tableau de bord administrateur avec :
     * - nombre d'utilisateurs
     * - nombre d'agences
     * - nombre de trajets
     *
     * @return void
     */
    public function dashboard(): void
    {
        $userModel   = new UserModel();
        $agencyModel = new AgencyModel();
        $tripModel   = new TripModel();

        $this->render('admin/dashboard', [
            'usersCount'    => $userModel->countAll(),
            'agenciesCount' => $agencyModel->countAll(),
            'tripsCount'    => $tripModel->countAll(),
        ]);
    }

    /* ============================
       UTILISATEURS
       ============================ */

    /**
     * Liste tous les utilisateurs.
     *
     * @return void
     */
    public function users(): void
    {
        $users = (new UserModel())->getAll();
        $this->render('admin/users', ['users' => $users]);
    }

    /**
     * Affiche les détails d'un utilisateur.
     *
     * @param int $id ID de l'utilisateur
     * @return void
     */
    public function showUser(int $id): void
    {
        $user = (new UserModel())->getById($id);

        if (!$user) {
            $this->flash('error', "Utilisateur introuvable.");
            header('Location: ' . $this->router->generate('admin-users'));
            exit;
        }

        $this->render('admin/users_show', ['user' => $user]);
    }

    /**
     * Met à jour le rôle d'un utilisateur.
     *
     * @param int $id ID de l'utilisateur
     * @return void
     */
    public function updateUserRole(int $id): void
    {
        $role = $_POST['role'] ?? null;

        if (!in_array($role, ['user', 'admin'], true)) {
            $this->flash('error', "Rôle invalide.");
            header('Location: ' . $this->router->generate('admin-user-show', ['id' => $id]));
            exit;
        }

        (new UserModel())->updateRole($id, $role);

        $this->flash('success', "Rôle mis à jour.");
        header('Location: ' . $this->router->generate('admin-user-show', ['id' => $id]));
        exit;
    }

    /* ============================
       AGENCES
       ============================ */

    /**
     * Liste toutes les agences.
     *
     * @return void
     */
    public function agencies(): void
    {
        $agencies = (new AgencyModel())->getAll();
        $this->render('admin/agencies', ['agencies' => $agencies]);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @return void
     */
    public function createAgency(): void
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            $this->flash('error', "Nom requis.");
            header('Location: ' . $this->router->generate('admin-agencies'));
            exit;
        }

        (new AgencyModel())->create($name);

        $this->flash('success', "Agence ajoutée.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    /**
     * Affiche le formulaire d'édition d'une agence.
     *
     * @param int $id ID de l'agence
     * @return void
     */
    public function editAgencyForm(int $id): void
    {
        $agency = (new AgencyModel())->getById($id);

        if (!$agency) {
            $this->flash('error', "Agence introuvable.");
            header('Location: ' . $this->router->generate('admin-agencies'));
            exit;
        }

        $this->render('admin/agencies_edit', ['agency' => $agency]);
    }

    /**
     * Met à jour une agence existante.
     *
     * @param int $id ID de l'agence
     * @return void
     */
    public function updateAgency(int $id): void
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            $this->flash('error', "Nom requis.");
            header('Location: ' . $this->router->generate('admin-agency-edit', ['id' => $id]));
            exit;
        }

        (new AgencyModel())->update($id, $name);

        $this->flash('success', "Agence mise à jour.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    /**
     * Supprime une agence.
     *
     * @param int $id ID de l'agence
     * @return void
     */
    public function deleteAgency(int $id): void
    {
        (new AgencyModel())->delete($id);

        $this->flash('success', "Agence supprimée.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    /* ============================
       TRAJETS
       ============================ */

    /**
     * Liste tous les trajets.
     *
     * @return void
     */
    public function trips(): void
    {
        $trips = (new TripModel())->getAll();
        $this->render('admin/trips', ['trips' => $trips]);
    }

    /**
     * Affiche le formulaire de création d'un trajet.
     *
     * @return void
     */
    public function createTripForm(): void
    {
        $agencies = (new AgencyModel())->getAll();
        $this->render('admin/trips_create', ['agencies' => $agencies]);
    }

    /**
     * Crée un nouveau trajet.
     *
     * @return void
     */
    public function createTrip(): void
    {
        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);
        $seatsAvail  = (int) ($_POST['seats_available'] ?? $seatsTotal);

        // Contrôles
        if ($departure === $arrival) {
            $this->flash('error', "L'agence de départ et d'arrivée doivent être différentes.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $this->flash('error', "La date d'arrivée doit être postérieure à la date de départ.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        if ($seatsTotal < 1 || $seatsAvail < 0 || $seatsAvail > $seatsTotal) {
            $this->flash('error', "Nombre de places incohérent.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id'   => $arrival,
            'departure_datetime'  => $dateDepart,
            'arrival_datetime'    => $dateArrivee,
            'seats_total'         => $seatsTotal,
            'seats_available'     => $seatsAvail,
            'driver_id'           => $_POST['driver_id'] ?? null,
        ];

        (new TripModel())->create($data);

        $this->flash('success', "Trajet créé.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }

    /**
     * Affiche le formulaire d'édition d'un trajet.
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function editTripForm(int $id): void
    {
        $trip = (new TripModel())->getById($id);

        if (!$trip) {
            $this->flash('error', "Trajet introuvable.");
            header('Location: ' . $this->router->generate('admin-trips'));
            exit;
        }

        $agencies = (new AgencyModel())->getAll();

        $this->render('admin/trips_edit', [
            'trip'     => $trip,
            'agencies' => $agencies,
        ]);
    }

    /**
     * Met à jour un trajet existant.
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function updateTrip(int $id): void
    {
        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);
        $seatsAvail  = (int) ($_POST['seats_available'] ?? 0);

        // Contrôles
        if ($departure === $arrival) {
            $this->flash('error', "L'agence de départ et d'arrivée doivent être différentes.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $this->flash('error', "La date d'arrivée doit être postérieure à la date de départ.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        if ($seatsTotal < 1 || $seatsAvail < 0 || $seatsAvail > $seatsTotal) {
            $this->flash('error', "Nombre de places incohérent.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id'   => $arrival,
            'departure_datetime'  => $dateDepart,
            'arrival_datetime'    => $dateArrivee,
            'seats_total'         => $seatsTotal,
            'seats_available'     => $seatsAvail,
        ];

        (new TripModel())->update($id, $data);

        $this->flash('success', "Trajet mis à jour.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function deleteTrip(int $id): void
    {
        (new TripModel())->delete($id);

        $this->flash('success', "Trajet supprimé.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }
}
