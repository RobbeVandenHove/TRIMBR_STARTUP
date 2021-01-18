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
}