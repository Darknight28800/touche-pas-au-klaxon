<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\AgencyModel;
use App\Core\Auth;

class TripController
{
    /**
     * Page d'accueil : liste + filtres + pagination
     */
    public function index()
    {
        $tripModel = new TripModel();
        $agencyModel = new AgencyModel();

        // 🔵 Filtres
        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'date'      => $_GET['date'] ?? null
        ];

        // 🔵 Pagination
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 6;
        $offset = ($page - 1) * $limit;

        // 🔵 Récupération trajets + total
        $trips = $tripModel->getFilteredPublicTrips($filters, $limit, $offset);
        $totalTrips = $tripModel->countFilteredPublicTrips($filters);

        // 🔵 Nombre total de pages
        $totalPages = ceil($totalTrips / $limit);

        // 🔵 Agences pour les filtres
        $agencies = $agencyModel->getAll();

        require_once __DIR__ . '/../Views/home.php';
    }

    /**
     * Affichage d'un trajet
     */
    public function show($id)
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $trip = $tripModel->getById($id);

        require_once __DIR__ . '/../Views/trips/show.php';
    }

    /**
     * Formulaire de création
     */
    public function createForm()
    {
        Auth::requireLogin();

        $agencyModel = new AgencyModel();
        $agencies = $agencyModel->getAll();

        require_once __DIR__ . '/../Views/trips/create.php';
    }

    /**
     * Création d'un trajet
     */
    public function create()
    {
        Auth::requireLogin();

        // 🔵 Récupération des données
        $departure = $_POST['departure_agency_id'];
        $arrival = $_POST['arrival_agency_id'];
        $dateDepart = $_POST['departure_datetime'];
        $dateArrivee = $_POST['arrival_datetime'];
        $seatsTotal = intval($_POST['seats_total']);

        // 🔴 Contrôles de cohérence
        if ($departure == $arrival) {
            $_SESSION['error'] = "L'agence de départ et d'arrivée doivent être différentes.";
            header('Location: /trip/create');
            exit;
        }

        if (strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $_SESSION['error'] = "La date d'arrivée doit être postérieure à la date de départ.";
            header('Location: /trip/create');
            exit;
        }

        if ($seatsTotal < 1) {
            $_SESSION['error'] = "Le nombre de places doit être supérieur à 0.";
            header('Location: /trip/create');
            exit;
        }

        // 🔵 Données finales
        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id' => $arrival,
            'departure_datetime' => $dateDepart,
            'arrival_datetime' => $dateArrivee,
            'seats_total' => $seatsTotal,
            'seats_available' => $seatsTotal,
            'driver_id' => $_SESSION['user']['id']
        ];

        $tripModel = new TripModel();
        $tripModel->create($data);

        $_SESSION['success'] = "Trajet créé avec succès.";
        header('Location: /');
        exit;
    }

    /**
     * Formulaire d'édition
     */
    public function editForm($id)
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $agencyModel = new AgencyModel();

        $trip = $tripModel->getById($id);
        $agencies = $agencyModel->getAll();

        require_once __DIR__ . '/../Views/trips/edit.php';
    }

    /**
     * Mise à jour d'un trajet
     */
    public function update($id)
    {
        Auth::requireLogin();

        $data = [
            'departure_agency_id' => $_POST['departure_agency_id'],
            'arrival_agency_id' => $_POST['arrival_agency_id'],
            'departure_datetime' => $_POST['departure_datetime'],
            'arrival_datetime' => $_POST['arrival_datetime'],
            'seats_total' => $_POST['seats_total'],
            'seats_available' => $_POST['seats_available']
        ];

        $tripModel = new TripModel();
        $tripModel->update($id, $data);

        $_SESSION['success'] = "Trajet modifié avec succès.";
        header('Location: /');
        exit;
    }

    /**
     * Suppression d'un trajet
     */
    public function delete($id)
    {
        Auth::requireLogin();

        $tripModel = new TripModel();
        $tripModel->delete($id);

        $_SESSION['success'] = "Trajet supprimé.";
        header('Location: /');
        exit;
    }
}
