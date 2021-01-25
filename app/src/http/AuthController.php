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
            $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
            $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $city = isset($_POST['city']) ? trim($_POST['city']) : '';
            $street = isset($_POST['street']) ? $_POST['street'] : '';
            $hnum = isset($_POST['houseNum']) ? $_POST['houseNum'] : '';
            $postal = isset($_POST['postal']) ? $_POST['postal'] : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $conf = isset($_POST['confPassword']) ? trim($_POST['confPassword']) : '';
            if ($password != $conf) $errors[0] = 'Passwords do not match.';
            $stmt = $this->db->prepare('SELECT COUNT(email) AS mail FROM users WHERE Email = :email;');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $rowCount = $stmt->fetchAssociative();
            if ($rowCount['mail'] > 0) $errors[1] = 'Email already in use.';
            if (count($errors) == 0) {
                $crypPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare('INSERT INTO users (FirstName, LastName, Email, City, Street, HouseNumber, PostalCode, Password) 
                                                VALUES (:fname, :lname, :email, :city, :street, :houseNumber, :postalCode, :password)');
                $stmt->bindValue(':fname', $fname);
                $stmt->bindValue(':lname', $lname);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':city', $city);
                $stmt->bindValue(':street', $street);
                $stmt->bindValue(':houseNumber', $hnum);
                $stmt->bindValue(':postalCode', $postal);
                $stmt->bindValue(':password', $crypPassword);
                $stmt->execute();
                $stmt = $this->db->prepare('INSERT INTO userrole (Role_Id, Users_Id) VALUES (1, :id)');
                $stmt->bindValue(':id', (int) $this->db->lastInsertId());
                $stmt->execute();
                if ($stmt) header('Location: /login');
            }
            else {
                echo $this->twig->render('pages/costumer-pages/login.twig', [
                    'fname' => $fname,
                    'lname' => $lname,
                    'email' => $email,
                    'city' => $city,
                    'street' => $street,
                    'hnum' => $hnum,
                    'postal' => $postal,
                    'errors' => $errors,
                    'source' => 'register'
                ]);
            }
        }
    }

    public function LoginPerson() {
        if (isset($_POST['login'])) {
            $errors = [];
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $stmt = $this->db->prepare('SELECT * FROM Users WHERE Email = :email');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() != 1) $errors[0] = 'You are not recognised in our system.';
            else {
                $user = $stmt->fetchAssociative();
                if (password_verify($password, $user['Password'])) {
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
                    'email' => $email,
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