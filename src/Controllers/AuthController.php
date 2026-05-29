<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController
{
    public function loginForm()
    {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function login()
    {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        $userModel = new UserModel();
        $user = $userModel->getByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Identifiants incorrects";
            header('Location: /login');
            exit;
        }

        $_SESSION['user'] = $user;
        header('Location: /');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
