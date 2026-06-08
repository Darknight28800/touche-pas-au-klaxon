<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Class AuthController
 *
 * Gère l'authentification des utilisateurs :
 * - affichage du formulaire de connexion
 * - traitement de la connexion
 * - déconnexion
 */
class AuthController extends CoreController
{
    /**
     * Initialise les protections globales via CoreController.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function loginForm(): void
    {
        $this->render('auth/login');
    }

    /**
     * Traite la tentative de connexion.
     *
     * Vérifie :
     * - que les champs sont remplis
     * - que l'utilisateur existe
     * - que le mot de passe est correct
     *
     * Redirige :
     * - admin → tableau de bord
     * - utilisateur → accueil
     *
     * @return void
     */
    public function login(): void
    {
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: ' . $this->router->generate('login'));
            exit;
        }

        $userModel = new UserModel();
        $user      = $userModel->getByEmail($email);


        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Identifiants incorrects.";
            header('Location: ' . $this->router->generate('login'));
            exit;
        }

        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header('Location: ' . $this->router->generate('admin-dashboard'));
            exit;
        }

        header('Location: ' . $this->router->generate('home'));
        exit;
    }

    /**
     * Déconnecte l'utilisateur et détruit la session.
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: ' . $this->router->generate('home'));
        exit;
    }
}
