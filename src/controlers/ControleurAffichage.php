<?php


namespace epicerie\controlers;


use epicerie\views\VueComptes as VueComptes;
use Slim\Slim;

class ControleurAffichage
{
    public function racine() {
        if (isset($_SESSION['id_connect'])) {
            echo "cc";
            var_dump($_SESSION['id_connect']);
        } else {
            Slim::getInstance()->redirect(Slim::getInstance()->urlFor('connexion'));
        }
    }

    public function err() {
        echo "Page introuvable";
    }
}