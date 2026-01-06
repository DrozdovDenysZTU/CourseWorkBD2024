<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByCredentials($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                if ($user['Role'] === 'admin') {
                    header('Location: ' . base_url('admin/products'));
                    exit;
                } else {
                    header('Location: ' . base_url('profile'));
                    exit;
                }
            } else {
                $_SESSION['error'] = "Невірний логін або пароль.";
                header('Location: ' . base_url('login'));
                exit;
            }
        } else {
            include_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'country' => $_POST['country'],
                'postalcode' => $_POST['postalcode']
            ];

            $userModel = new UserModel();

            try {
                if ($userModel->registerUser($data)) {
                    $_SESSION['message'] = 'Реєстрація успішна! Тепер ви можете увійти.';
                    header("Location: " . BASE_URL . "login");
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: " . BASE_URL . "register");
                exit;
            }
        }

        include(__DIR__ . '/../views/auth/register.php');
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }
}
