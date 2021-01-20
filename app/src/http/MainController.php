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
    }

    public function HomeOverview() {
        echo $this->twig->render('pages/index.twig', [
            'homePage' => 'active'
        ]);
    }

    public function AboutOverview() {
        echo $this->twig->render('pages/about.twig', [
            'aboutPage' => 'active'
        ]);
    }

    public function ShopOverview() {
        echo $this->twig->render('pages/shop.twig', [
            'shopPage' => 'active'
        ]);
    }

    public function JeansOverview() {
        echo $this->twig->render('pages/jeans.twig', [
            'jeansPage' => 'active'
        ]);
    }

    public function ShoesOverview() {
        echo $this->twig->render('pages/shoes.twig', [
            'shoesPage' => 'active'
        ]);
    }

    public function ContactOverview() {
        echo $this->twig->render('pages/contact.twig', [
            'contactPage' => 'active'
        ]);
    }

    public function LoginOverview() {
        echo $this->twig->render('pages/login.twig', [
            'loginPage' => 'active'
        ]);
    }

    public function PageNotFoundOverview() {
        echo $this->twig->render('pages/pageNotFound.twig', [

        ]);
    }
}