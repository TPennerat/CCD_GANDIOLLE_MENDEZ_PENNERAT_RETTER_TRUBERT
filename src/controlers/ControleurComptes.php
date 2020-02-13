<?php
namespace epicerie\controlers;

use \epicerie\views\VueComptes as VueComptes;
use \epicerie\views\VueAccueil as VueAccueil;
use \epicerie\models\Authentification as Authentification;
use \epicerie\models\User as User;
use \Exception;
use Slim\Slim;


class ControleurComptes {


  //Affiche la page de connexion
  function afficherConnexion() {

    $view = new VueComptes();
    $view->renderConnexion(Slim::getInstance(), "");

  }

  //Affiche la page d'inscription
  function afficherEnregistrement() {

    $view = new VueComptes();
    return $rs->getBody()->write($view->render($app, ""));
  }

  //Verifie l'inscription
  function verifierEnregistrement() {
      $data = $rq->getParsedBody();
      if(isset($data["password"]) && isset($data["login"]) && !empty($data["password"]) && !empty($data["login"])) {

        $login = filter_var($data["login"],FILTER_SANITIZE_STRING);
        $password = $data["password"];

        if($login != $data["login"]) {

          $view = new VueComptes();
          return $rs->getBody()->write($view->render($app, "Le login contient des caracteres non autorisés
          (chiffres et lettres majuscules/minuscules avec ou sans accent)"));

        }

        try {
          Authentification::createUser($login,$password);
          $url = $app->router->pathFor('route_index');
          return $rs->withRedirect($url);
        } catch (\Exception $e){
          $view = new VueComptes();
          return $rs->getBody()->write($view->render($app, $e->getMessage()));
        }
      } elseif (empty($data["password"] || empty($data["login"]))) {

          $view = new VueComptes();
          return $rs->getBody()->write($view->render($app, "Login ou mot de passe vide"));

      }

      return $rs->withRedirect($app->router->pathFor("enregistrement"));

  }

  //Verifie la connexion d'un utilisateur
  function verifierConnexion() {
      $data = $rq->getParsedBody();
      if(isset($data["password"]) && isset($data["login"]) && !empty($data["password"]) && !empty($data["login"])) {

          $login = filter_var($data["login"],FILTER_SANITIZE_STRING);

          if($login != $data["login"]) {

            $view = new VueComptes();
            return $rs->getBody()->write($view->render($app, "Le login contient des caracteres non autorisés
            (chiffres et lettres majuscules/minuscules avec ou sans accent)"));

          }

          $password = $data["password"];

          try {
            Authentification::seConnecter($login,$password);
            $url = $app->router->pathFor('route_index');
            return $rs->withRedirect($url);
          } catch (\Exception $e){
            $view = new VueComptes();
            return $rs->getBody()->write($view->render($app, $e->getMessage()));
          }


      } elseif ($data["password"] == "" || $data["login"] == "") {

          $view = new VueComptes();
          return $rs->getBody()->write($view->render($app, "Champs vides"));

      } else {
        $url = $app->router->pathFor('connexion');
        return $rs->withRedirect($url);
      }
  }

}
