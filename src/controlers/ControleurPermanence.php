<?php
namespace epicerie\controlers;

use \epicerie\models\AssurePermanence as Permanence;

use epicerie\views\VuePermanence;
use \Exception;
use Slim\Slim;


class ControleurPermanence {
  //Affiche la page de création d'un besoin
  function afficherCreationBesoin() {

    $view = new VuePermanence();
    $view->render(1);
  }

  function creerBesoin() {

     $view = new VuePermanence();
     

  }


  function afficherMesPermanences($id) {
    $perms = Permanence::where('idUtil','=',$id)->get();
    $view = new VuePermanence($perms);
    $view->render(2);
  }
}
