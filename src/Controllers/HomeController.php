<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\AgencyModel;

/**
 * Class HomeController
 *
 * Gère l'affichage de la page d'accueil et des trajets publics.
 */
class HomeController extends CoreController
{
    /**
     * Constructeur : initialise les protections globales (CoreController).
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche la page d'accueil avec :
     * - la liste des trajets publics disponibles
     * - la liste des agences
     *
     * @return void
     */
    public function index(): void
    {
        $tripModel   = new TripModel();
        $agencyModel = new AgencyModel();

        $trips    = $tripModel->getAllTripsPublic();
        $agencies = $agencyModel->getAll();

        $this->render('home', [
            'trips'    => $trips,
            'agencies' => $agencies
        ]);
    }
}
