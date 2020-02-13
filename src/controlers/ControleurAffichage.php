<?php


namespace epicerie\controlers;


use epicerie\views\VueComptes as VueComptes;
use epicerie\views\VuePermanence;
use Slim\Slim;

class ControleurAffichage
{
    public function racine() {
        if (isset($_SESSION['id_connect'])) {
            Slim::getInstance()->redirect(Slim::getInstance()->urlFor('aff',['sem'=>VuePermanence::changeSem($_SESSION['id_connect'])]));
        } else {
            Slim::getInstance()->redirect(Slim::getInstance()->urlFor('connexion'));
        }
    }

    public function err() {
        echo "Page introuvable";
    }
}
