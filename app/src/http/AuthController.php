<?php

namespace http;
use services\DatabaseConnector;
use \DateTime;
use \DateTimeZone;



class AuthController {
    protected \Twig\Environment $twig;
    protected \Doctrine\DBAL\Connection $db;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $this->db = DatabaseConnector::getConnection();
    }

    public function RegisterNewPerson() {
        if (isset($_POST['register'])) {
            $errors = [];
            $userName = isset($_POST['userId']) ? trim($_POST['userId']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $conf = isset($_POST['confPassword']) ? trim($_POST['confPassword']) : '';
            if ($password != $conf) $errors[0] = 'Passwords do not match.';
            $stmt = $this->db->prepare('SELECT COUNT(username) AS username FROM Users WHERE UserName = :username');
            $stmt->bindValue(':username', $userName);
            $stmt->execute();
            $rowCount = $stmt->fetchAssociative();
            if ($rowCount['username'] > 0) $errors[1] = 'Username already in use.';
            $stmt = $this->db->prepare('SELECT COUNT(email) AS email FROM Users WHERE Email = :email');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $rowCount = $stmt->fetchAssociative();
            if ($rowCount['email'] > 0) $errors[2] = 'Email already in use.';
            if (count($errors) == 0) {
                $crypPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare('INSERT INTO Users (UserName, Password, Email, TimesLoggedIn) 
                                                VALUES (:username, :password, :email, 0)');
                $stmt->bindValue(':username', $userName);
                $stmt->bindValue(':password', $crypPassword);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                if ($stmt) header('Location: /login');
            }
            else {
                echo $this->twig->render('pages/costumer-pages/login.twig', [
                    'uname' => $userName,
                    'email' => $email,
                    'pas1' => $password,
                    'pas2' => $conf,
                    'errors' => $errors,
                    'source' => 'register'
                ]);
            }
        }
    }

    public function LoginPerson() {
        if (isset($_POST['login'])) {
            $errors = [];
            $userName = isset($_POST['userId']) ? trim($_POST['userId']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $stmt = $this->db->prepare('SELECT * FROM Users WHERE UserName = :username');
            $stmt->bindValue(':username', $userName);
            $stmt->execute();
            if ($stmt->rowCount() != 1) $errors[0] = 'You are not recognised in our system.';
            else {
                $user = $stmt->fetchAssociative();
                if (password_verify($password, $user['Password'])) {
                    $stmt = $this->db->prepare('UPDATE Users SET TimesLoggedIn = TimesLoggedIn + 1');
                    $stmt->execute();
                    $_SESSION['logged'] = $user;
                    $date = new DateTime('now', new DateTimeZone('Europe/Brussels'));
                    setcookie('login-time', 'Last-login-by-' . $user['UserName'] . '-made-on-' . $date->format('d-m-y\-\a\t\-H-i'),
                        time() + 60 * 60 * 24 * 7);
                    header('Location: /home');
                    exit();
                }
                else $errors[1] = 'Wrong password.';
            }
            if (count($errors) > 0) {
                echo $this->twig->render('pages/costumer-pages/login.twig', [
                    'unameLog' => $userName,
                    'pas1Log' => $password,
                    'errors' => $errors,
                    'source' => 'login'
                ]);
            }
        }
    }

    public function LogoutPerson() {
        foreach ($_SESSION as $key => $v) {
            unset($_SESSION[$key]);
        }
        session_destroy();
        header('Location: /home');
        exit();
    }
}