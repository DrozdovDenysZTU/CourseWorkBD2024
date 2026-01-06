<?php
require_once __DIR__ . '/../models/UserModel.php';

class ProfileController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: login');
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['user']['UserID']);

        if (!$user) {
            session_destroy();
            header('Location: login');
            exit;
        }

        include __DIR__ . '/../views/profile.php';
    }
}
