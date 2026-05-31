<?php
require_once '../app/models/Database.php';
require_once '../app/models/User.php';

class AuthController {

    public function register() {
        require_once '../app/views/auth/register.php';
    }

    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';


            if ($password !== $passwordConfirm) {
                $this->addErrorMessage('Zadaná hesla se neshodují.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password)) {
                $this->addErrorMessage('Heslo musí mít alespoň 8 znaků, a obsahovat velké i malé písmeno a číslici.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            $db = (new Database())->getConnection();
            $userModel = new User($db);

            if ($userModel->register($username, $email, $password)) {
                $this->addSuccessMessage('Registrace úspěšná. Nyní se můžete přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            } else {
                $this->addErrorMessage('Uživatel s tímto e-mailem již existuje.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
        }
    }

    public function login() {
        require_once '../app/views/auth/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $db = (new Database())->getConnection();
            $userModel = new User($db);
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_role'] = $user['role']; // 'user' nebo 'admin'

                $this->addSuccessMessage('Vítejte zpět, ' . $_SESSION['user_name'] . '!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nesprávný e-mail nebo heslo.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        $this->addSuccessMessage('Byli jste úspěšně odhlášeni.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    protected function addSuccessMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => $message];
    }
    protected function addErrorMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => $message];
    }
}
?>