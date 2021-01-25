<?php


namespace http;
use services\DatabaseConnector;

class AdminController {
    protected \Twig\Environment $twig;
    protected \Doctrine\DBAL\Connection $db;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $this->db = DatabaseConnector::getConnection();
    }

    public function AdminLoginOverview() {
        echo $this->twig->render('pages/admin.twig', [

        ]);
    }

    public function AdminLogin() {
        $errors = [];
        $uname = isset($_POST['admin-uname']) ? trim($_POST['admin-uname']) : '';
        $password = isset($_POST['admin-password']) ? trim($_POST['admin-password']) : '';
        $stmt = $this->db->prepare('SELECT * FROM Users WHERE UserName = :uname AND UserRole = \'admin\'');
        $stmt->bindValue(':uname', $uname);
        $stmt->execute();
        if ($stmt->rowCount() != 1) $errors[0] = 'You are not recognised in our system.';
        else {
            $user = $stmt->fetchAssociative();
            if (password_verify($password, $user['Password'])) {
                echo $this->twig->render('pages/workspace.twig', [

                ]);
            }
            else $errors[1] = 'Wrong password.';
        }
        if (count($errors) > 0) {
            echo $this->twig->render('pages/admin.twig', [
                'uname' => $uname
            ]);
        }
    }
}