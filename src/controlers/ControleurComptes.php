<?php
namespace epicerie\controlers;

use epicerie\models\User;
use \epicerie\views\VueComptes as VueComptes;
use \epicerie\controlers\Authentification as Authentification;
use epicerie\views\VueCreationModificationCompte;
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

    public function seDeconnecter(){
        unset($_SESSION['id_connect']);
        Slim::getInstance()->redirect(Slim::getInstance()->urlFor('racine'));
    }


    public function afficherFormulaireModificationCompte(){

        $username = User::where('id', '=', $_SESSION['id_connect'])->first();
        $vue = new VueCreationModificationCompte($username);
        $vue->render(VueCreationModificationCompte::FORMULAIRE_MODIFICATION);


    }

    public function modifierCompte(){

        $newName = htmlspecialchars(filter_var($_POST['username'], FILTER_SANITIZE_STRING ));
        $compte = User::where('id', '=', $_SESSION['id_connect'])->first();
        if($newName != $this->username){
            $compte->nom = $newName;
        }
        $mdp1 = htmlspecialchars(filter_var($_POST['mdp1'], FILTER_SANITIZE_STRING ));
        $mdp2 = htmlspecialchars(filter_var($_POST['mdp2'], FILTER_SANITIZE_STRING ));
        if($mdp1 == $mdp2){
            if(!password_verify($mdp1, $compte->mdp)){
                $compte->mdp = password_hash($mdp1, PASSWORD_BCRYPT);
                if($_POST['type'] == 'admin'){
                    $compte->droit = 2;
                }else{
                    $compte->droit = 1;
                }

                if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $_FILES["photo"]["name"];
                    $filetype = $_FILES["photo"]["type"];
                    $filesize = $_FILES["photo"]["size"];

                    // Vérifie l'extension du fichier
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

                    // Vérifie la taille du fichier - 5Mo maximum
                    $maxsize = 5 * 1024 * 1024;
                    if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

                    // Vérifie le type MIME du fichier
                    if(in_array($filetype, $allowed)){
                        $compte->urlimage = $filename.".".$filetype;
                    } else{
                        die("Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.");
                    }
                } else{
                    die("Error: " . $_FILES["photo"]["error"]);
                }

                $compte->save();
                Slim::getInstance()->redirect(Slim::getInstance()->urlFor('racine'));
            }
        }else{
            $vue = new VueCreationModificationCompte($compte->nom);
            $vue->render(VueCreationModificationCompte::AFFICHER_FORMULAIRE_MODIFICATION, 1);
        }



    }



    public function afficherFormulaireCreationCompte(){

        $vue = new VueCreationModificationCompte();
        $vue->render(VueCreationModificationCompte::FORMULAIRE_CREATION);
    }

    public function creerCompte(){

        $compte = new User();
        $mdp1 = htmlspecialchars(filter_var($_POST['mdp1'], FILTER_SANITIZE_STRING ));
        $mdp2 = htmlspecialchars(filter_var($_POST['mdp2'], FILTER_SANITIZE_STRING ));
        if($mdp1 == $mdp2){
            $compte->mdp = password_hash($mdp1, PASSWORD_BCRYPT);
            if($_POST['type'] == 'admin'){
                $compte->droit = 2;
            }else{
                $compte->droit = 1;
            }
            $compte->nom =  htmlspecialchars(filter_var($_POST['username'], FILTER_SANITIZE_STRING ));

            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = $_FILES["photo"]["name"];
                $filetype = $_FILES["photo"]["type"];
                $filesize = $_FILES["photo"]["size"];

                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)){
                    $compte->urlimage = $filename.".".$filetype;
                } else{
                    die("Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.");
                }
            } else{
                die("Error: " . $_FILES["photo"]["error"]);
            }

            $compte->save();
            Slim::getInstance()->redirect(Slim::getInstance()->urlFor('racine'));

        }else{
            $vue = new VueCreationModificationCompte();
            $vue->render(VueCreationModificationCompte::FORMULAIRE_CREATION, 1);
        }

    }





}
