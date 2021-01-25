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
        echo $this->twig->render('pages/admin-pages/admin.twig', [

        ]);
    }

    public function AdminLogin() {
        $errors = [];
        $email = isset($_POST['admin-email']) ? trim($_POST['admin-email']) : '';
        $password = isset($_POST['admin-password']) ? trim($_POST['admin-password']) : '';
        $stmt = $this->db->prepare('SELECT * FROM users LEFT JOIN userrole ON users.Id = userrole.Users_Id
                                        WHERE userrole.Role_Id > 1 AND users.Email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() != 1) die('You are not recognised in our system.');
        else {
            $user = $stmt->fetchAssociative();
            if (password_verify($password, $user['Password'])) {
                $_SESSION['admin'] = $user;
                header('Location: /admin/workspace');
                exit();
            }
            else die('Wrong password.');
        }
    }

    public function WorkspaceOverview() {
        if (!isset($_SESSION['admin'])) {
            echo $this->twig->render('pages/admin-pages/admin.twig', [

            ]);
        }
        else {
            echo $this->twig->render('pages/admin-pages/workspace.twig', [
                'user' => $_SESSION['admin']
            ]);
        }
    }

    public function AddClothingOverview() {
        if (!isset($_SESSION['admin'])) {
            echo $this->twig->render('pages/admin-pages/admin.twig', [

            ]);
        }
        else {
            echo $this->twig->render('pages/admin-pages/add-clothing.twig', [

            ]);
        }
    }

    public function EditClothingOverview() {

    }

    public function DeleteClothingOverview() {

    }

    public function SearchOrderOverview() {

    }

    public function EditOrderOverview() {

    }

    public function AddPersonelOverview() {
        echo $this->twig->render('pages/admin-pages/add-personel.twig', [

        ]);
    }

    public function AddPersonel() {
        if ($_SESSION['admin']['Role_Id'] != 3) die('You have no permittion to add personel.');
        else {
            $errors = [];
            $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
            $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $city = isset($_POST['city']) ? trim($_POST['city']) : '';
            $street = isset($_POST['street']) ? $_POST['street'] : '';
            $hnum = isset($_POST['houseNum']) ? $_POST['houseNum'] : '';
            $postal = isset($_POST['postal']) ? $_POST['postal'] : '';
            $role = isset($_POST['role']) ? $_POST['role'] : '';
            $password = isset($_POST['pas1']) ? trim($_POST['pas1']) : '';
            $conf = isset($_POST['pas2']) ? trim($_POST['pas2']) : '';
            if ($password != $conf) die('Passwords do not match.');
            $stmt = $this->db->prepare('SELECT COUNT(email) AS mail FROM users WHERE Email = :email;');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $rowCount = $stmt->fetchAssociative();
            if ($rowCount['mail'] > 0) die('Email already in use.');
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
                $stmt = $this->db->prepare('INSERT INTO userrole (Role_Id, Users_Id) VALUES (:role, :id)');
                $stmt->bindValue(':role', (int)$role);
                $stmt->bindValue(':id', (int)$this->db->lastInsertId());
                $stmt->execute();
            }
        }
    }
}