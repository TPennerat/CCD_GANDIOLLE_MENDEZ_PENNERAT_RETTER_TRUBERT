<?php
namespace epicerie\controlers;

use \epicerie\views\VueComptes as VueComptes;
use \epicerie\views\VueAccueil as VueAccueil;
use \epicerie\models\Authentification as Authentification;
use \epicerie\models\User as User;
use \epicerie\models\AssurePermanence as Permanence;

use \Exception;
use Slim\Slim;


class ControleurPermanence {
    //Affiche la page de création d'un besoin
    function afficherCreationBesoin() {

        $view = new VuePermanence();
        $view->render(1);
    }

    function afficherMesPermanences($id) {
        $perms = Permanence::where('idUtil','=',$id)->get();
        $view = new VuePermanence($perms);
        $view->render(2);
    }
}
