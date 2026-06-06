<?php

namespace App\Controllers;

use App\Models\AgencyModel;

/**
 * Class AgencyController
 *
 * Gère l'affichage de la liste des agences.
 * Accessible à tous les utilisateurs.
 */
class AgencyController extends CoreController
{
    /**
     * Affiche la liste complète des agences.
     *
     * @return void
     */
    public function index(): void
    {
        $agencyModel = new AgencyModel();
        $agencies = $agencyModel->getAll();

        $this->render('agencies', [
            'agencies' => $agencies
        ]);
    }
}
