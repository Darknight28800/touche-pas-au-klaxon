<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\AgencyModel;
use App\Core\Auth;

/**
 * Class TripController
 *
 * Gère toutes les opérations liées aux trajets :
 * - liste publique filtrée
 * - affichage d'un trajet
 * - création
 * - modification
 * - suppression
 *
 * Les actions sensibles nécessitent une authentification.
 */
class TripController extends CoreController
{
    /**
     * Initialise les protections globales via CoreController.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche la liste des trajets publics filtrés.
     *
     * Filtres possibles :
     * - departure (ID agence)
     * - arrival (ID agence)
     * - date (YYYY-MM-DD)
     *
     * @return void
     */
    public function index(): void
    {
        $tripModel   = new TripModel();
        $agencyModel = new AgencyModel();

        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'date'      => $_GET['date'] ?? null,
        ];

        $trips    = $tripModel->getFilteredTripsPublic($filters);
        $agencies = $agencyModel->getAll();

        $this->render('trips/list', [
            'trips'    => $trips,
            'agencies' => $agencies,
            'filters'  => $filters
        ]);
    }

    /**
     * Affiche les détails d'un trajet.
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function show(int $id): void
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $trip      = $tripModel->getById($id);

        if (!$trip) {
            $_SESSION['error'] = "Trajet introuvable.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        $this->render('trips/show', ['trip' => $trip]);
    }

    /**
     * Affiche le formulaire de création d'un trajet.
     *
     * @return void
     */
    public function createForm(): void
    {
        Auth::requireLogin();

        $agencyModel = new AgencyModel();
        $agencies    = $agencyModel->getAll();

        $this->render('trips/create', ['agencies' => $agencies]);
    }

    /**
     * Traite la création d'un trajet.
     *
     * Effectue les contrôles :
     * - agences différentes
     * - dates cohérentes
     * - nombre de places valide
     *
     * @return void
     */
    public function create(): void
    {
        Auth::requireLogin();

        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);

        // Contrôles de cohérence
        if ($departure === $arrival) {
            $_SESSION['error'] = "L'agence de départ et d'arrivée doivent être différentes.";
            header('Location: ' . $this->router->generate('trip-create'));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $_SESSION['error'] = "La date d'arrivée doit être postérieure à la date de départ.";
            header('Location: ' . $this->router->generate('trip-create'));
            exit;
        }

        if ($seatsTotal < 1) {
            $_SESSION['error'] = "Le nombre de places doit être supérieur à 0.";
            header('Location: ' . $this->router->generate('trip-create'));
            exit;
        }

        // Données finales
        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id'   => $arrival,
            'departure_datetime'  => $dateDepart,
            'arrival_datetime'    => $dateArrivee,
            'seats_total'         => $seatsTotal,
            'seats_available'     => $seatsTotal,
            'driver_id'           => $_SESSION['user']['id'],
        ];

        (new TripModel())->create($data);

        $_SESSION['success'] = "Trajet créé avec succès.";
        header('Location: ' . $this->router->generate('home'));
        exit;
    }

    /**
     * Affiche le formulaire d'édition d'un trajet.
     *
     * Vérifie :
     * - que le trajet existe
     * - que l'utilisateur est l'auteur ou admin
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function editForm(int $id): void
    {
        Auth::requireLogin();

        $tripModel   = new TripModel();
        $agencyModel = new AgencyModel();

        $trip = $tripModel->getById($id);

        if (!$trip) {
            $_SESSION['error'] = "Trajet introuvable.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        if ($trip['driver_id'] != $_SESSION['user']['id'] && !Auth::isAdmin()) {
            $_SESSION['error'] = "Vous ne pouvez modifier que vos propres trajets.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        $agencies = $agencyModel->getAll();

        $this->render('trips/edit', [
            'trip'     => $trip,
            'agencies' => $agencies,
        ]);
    }

    /**
     * Met à jour un trajet existant.
     *
     * Vérifie :
     * - cohérence des agences
     * - cohérence des dates
     * - cohérence des places
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function update(int $id): void
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $trip      = $tripModel->getById($id);

        if (!$trip) {
            $_SESSION['error'] = "Trajet introuvable.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        if ($trip['driver_id'] != $_SESSION['user']['id'] && !Auth::isAdmin()) {
            $_SESSION['error'] = "Vous ne pouvez modifier que vos propres trajets.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);
        $seatsAvail  = (int) ($_POST['seats_available'] ?? 0);

        // Contrôles
        if ($departure === $arrival) {
            $_SESSION['error'] = "L'agence de départ et d'arrivée doivent être différentes.";
            header('Location: ' . $this->router->generate('trip-edit', ['id' => $id]));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $_SESSION['error'] = "La date d'arrivée doit être postérieure à la date de départ.";
            header('Location: ' . $this->router->generate('trip-edit', ['id' => $id]));
            exit;
        }

        if ($seatsTotal < 1 || $seatsAvail < 0 || $seatsAvail > $seatsTotal) {
            $_SESSION['error'] = "Nombre de places incohérent.";
            header('Location: ' . $this->router->generate('trip-edit', ['id' => $id]));
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

        $tripModel->update($id, $data);

        $_SESSION['success'] = "Trajet modifié avec succès.";
        header('Location: ' . $this->router->generate('home'));
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * Vérifie :
     * - que le trajet existe
     * - que l'utilisateur est l'auteur ou admin
     *
     * @param int $id ID du trajet
     * @return void
     */
    public function delete(int $id): void
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $trip      = $tripModel->getById($id);

        if (!$trip) {
            $_SESSION['error'] = "Trajet introuvable.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        if ($trip['driver_id'] != $_SESSION['user']['id'] && !Auth::isAdmin()) {
            $_SESSION['error'] = "Vous ne pouvez supprimer que vos propres trajets.";
            header('Location: ' . $this->router->generate('home'));
            exit;
        }

        $tripModel->delete($id);

        $_SESSION['success'] = "Trajet supprimé.";
        header('Location: ' . $this->router->generate('home'));
        exit;
    }
}
