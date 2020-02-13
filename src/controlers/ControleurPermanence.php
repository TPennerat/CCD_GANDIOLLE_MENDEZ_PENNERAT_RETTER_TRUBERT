<?php
namespace epicerie\controlers;

use epicerie\models\AssurePermanence;
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

    public function inscrireBesoin($idBesoin){

        if (isset($_SESSION['id_connect'])) {

            $user = $_SESSION['id_connect'];

            $permanence = AssurePermanence::where('id', '=', $idBesoin)->first();

            $assurePerma = AssurePermanence::where('idCreneau', '=', $permanence->idCreneau, '&&', 'idUtil', '=', $user);

            if($assurePerma == null){

                $permanence->idUtil = $user;
            }
        }

        $view = new VuePermanence();
        $view->render(1);
    }




}
