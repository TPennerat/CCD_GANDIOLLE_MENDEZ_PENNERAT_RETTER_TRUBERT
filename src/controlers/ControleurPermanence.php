<?php
namespace epicerie\controlers;

use \epicerie\models\AssurePermanence as Permanence;
use \epicerie\models\Creneau as Creneau;
use \epicerie\models\Role as Role;
use \epicerie\models\User as User;

use epicerie\views\VuePermanence;
use epicerie\views\VueBesoins as VueBesoins;

use \Exception;
use Slim\Slim;


class ControleurPermanence {
  //Affiche la page de création d'un besoin
  function afficherCreationBesoin() {

    $creneaux = Creneau::select("*")->get();
    $roles = Role::select("*")->get();

    $tab = array();
    $tab[] = $creneaux;
    $tab[] = $roles;

    $view = new VuePermanence($tab);
    $view->render(1);

  }

  function supprimerPermanence($id,$compte) {

    $peutSupprimer = true;
    if($compte == "admin") {
      $us = User::where("id","=",$_SESSION["profile"])->first();
      $peutSupprimer = $us->droit != 1;
    }

    if($peutSupprimer) {
      echo true;
      $perm = Permanence::where("id","=",$id)->first();
      if($compte == "admin") {
        $perm->delete();
      } else {
        $perm->idUtil = null;
        $perm->save();
      }
    } else {
      echo false;
    }

  }

  function creerBesoin() {

    $creneau = $_POST["creneau"];
    $role = $_POST["role"];

    $perm = new Permanence();
    $perm->idCreneau = $creneau;
    $perm->idRole = $role;
    $perm->save();

    $view = new VuePermanence();
    $view->render(1);

  }

  public function inscrireBesoin($id) {
    $perms = Permanence::where('id',"=",$id)->first();
    $perms->idUtil =$_SESSION['id_connect'];
    $perms->save();
    Slim::getInstance()->redirect(Slim::getInstance()->urlFor('racine'));
  }


  function afficherMesPermanences($id) {

    $perms = Permanence::where('idUtil','=',$_SESSION['id_connect'])->get();
    $view = new VuePermanence($perms);
    $view->render(2);

  }

  function afficherToutesLesPermanences() {

    $perms = Permanence::where('idUtil','=',null)->get();
    $view = new VueBesoins($perms);

    $view->render(1);

  }
}
