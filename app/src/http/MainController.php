<?php

namespace http;
use \services\DatabaseConnector;


class MainController {
    protected \Twig\Environment $twig;
    protected \Doctrine\DBAL\Connection $db;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $this->db = DatabaseConnector::getConnection();
        if (!isset($_SESSION['logged'])) {
            $_SESSION['logged'] = '';
        }
    }

    public function HomeOverview() {
        echo $this->twig->render('pages/index.twig', [
            'homePage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function AboutOverview() {
        echo $this->twig->render('pages/about.twig', [
            'aboutPage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function ShopOverview() {
        echo $this->twig->render('pages/shop.twig', [
            'shopPage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function JeansOverview() {
        echo $this->twig->render('pages/jeans.twig', [
            'jeansPage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function ShoesOverview() {
        echo $this->twig->render('pages/shoes.twig', [
            'shoesPage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function ContactOverview() {
        echo $this->twig->render('pages/contact.twig', [
            'contactPage' => 'active',
            'user' => $_SESSION['logged']
        ]);
    }

    public function LoginOverview() {
        echo $this->twig->render('pages/login.twig', [

        ]);
    }

    public function PageNotFoundOverview() {
        echo $this->twig->render('pages/pageNotFound.twig', [
            'user' => $_SESSION['logged']
        ]);
    }
}