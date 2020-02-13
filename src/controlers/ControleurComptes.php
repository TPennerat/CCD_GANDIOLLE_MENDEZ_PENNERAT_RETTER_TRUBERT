<?php
namespace epicerie\controlers;

use \epicerie\views\VueComptes as VueComptes;
use \epicerie\controlers\Authentification as Authentification;
use Slim\Slim;


class ControleurComptes {


  //Affiche la page de connexion
  function afficherConnexion() {
    if (isset($_SESSION['id_connect'])) {
        Slim::getInstance()->redirect(Slim::getInstance()->urlFor('racine'));
    } else {
        $view = new VueComptes();
        $view->renderConnexion(Slim::getInstance(), "");
    }


  }

  //Affiche la page d'inscription
  function afficherEnregistrement() {

    $view = new VueComptes();
    return $rs->getBody()->write($view->render($app, ""));
  }

  //Verifie l'inscription
  function verifierEnregistrement() {
      $app = Slim::getInstance();
      if(isset($_POST["password"]) && isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["login"])) {

        $login = filter_var($_POST["login"],FILTER_SANITIZE_STRING);
        $password = $_POST["password"];

        if($login != $_POST["login"]) {

          $view = new VueComptes();
          $view->renderConnexion($app,"Le login contient des caracteres non autorisés
          (chiffres et lettres majuscules/minuscules avec ou sans accent)");

        }

        try {
          Authentification::createUser($login,$password);
          $url = $app->urlFor('accueil');
          $app->redirect($url);
        } catch (\Exception $e){
          $view = new VueComptes();
          $view->renderConnexion($app, $e->getMessage());
        }
      } elseif (empty($_POST["password"] || empty($_POST["login"]))) {

          $view = new VueComptes();
          $view->renderConnexion($app, "Login ou mot de passe vide");

      }

  }

  //Verifie la connexion d'un utilisateur
  function verifierConnexion() {
      $app = Slim::getInstance();
      if(isset($_POST["password"]) && isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["login"])) {

          $login = filter_var($_POST["login"],FILTER_SANITIZE_STRING);

          if($login != $_POST["login"]) {

            $view = new VueComptes();
            $view->renderConnexion($app, "Le login contient des caracteres non autorisés
            (chiffres et lettres majuscules/minuscules avec ou sans accent)");

          }

          $password = $_POST["password"];

          try {
            Authentification::seConnecter($login,$password);
            $url = $app->urlFor('racine');
            $app->redirect($url);
          } catch (\Exception $e){
            $view = new VueComptes();
            $view->renderConnexion($app, $e->getMessage());
          }


      } elseif ($_POST["password"] == "" || $_POST["login"] == "") {

          $view = new VueComptes();
          $view->renderConnexion($app, "Champs vides");

      } else {
        $url = $app->urlFor('connexion');
        $app->redirect($url);
      }
  }

}
