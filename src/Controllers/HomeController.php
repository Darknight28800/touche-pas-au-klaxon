<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\AgencyModel;

class HomeController
{
    public function index()
    {
        $tripModel = new TripModel();
        $agencyModel = new AgencyModel();

        /* -----------------------------------------
            🔵 1) Récupération des filtres GET
        ----------------------------------------- */
        $filters = [
            'departure' => $_GET['departure'] ?? '',
            'arrival'   => $_GET['arrival'] ?? '',
            'date'      => $_GET['date'] ?? ''
        ];

        /* -----------------------------------------
            🔵 2) Pagination
        ----------------------------------------- */
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 6; // 6 trajets par page
        $offset = ($page - 1) * $limit;

        /* -----------------------------------------
            🔵 3) Récupération des trajets filtrés
        ----------------------------------------- */
        $trips = $tripModel->getFilteredTripsPublic($filters, $limit, $offset);

        /* -----------------------------------------
            🔵 4) Nombre total de trajets filtrés
        ----------------------------------------- */
        $totalTrips = $tripModel->countFilteredPublicTrips($filters); 
        $totalPages = max(1, ceil($totalTrips / $limit));

        /* -----------------------------------------
            🔵 5) Récupération des agences
        ----------------------------------------- */
        $agencies = $agencyModel->getAll();

        // 🔵 Ajouter une destination globale
        array_unshift($agencies, [
            'id' => '',
            'name' => 'Toutes destinations'
        ]);

        /* -----------------------------------------
            🔵 6) Envoi à la vue
        ----------------------------------------- */
        require_once __DIR__ . '/../Views/home.php';
    }
}
