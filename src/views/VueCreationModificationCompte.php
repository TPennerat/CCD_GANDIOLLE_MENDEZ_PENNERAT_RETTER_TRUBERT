<?php


namespace epicerie\views;



use epicerie\models\User;
use Slim\Slim;

class VueCreationModificationCompte
{

    const AFFICHER_FORMULAIRE_MODIFICATION = 1;
    const FORMULAIRE_CREATION = 2;

    private $username;

    public function __construct($username = null)
    {

        $this->username = $username;
    }

    public function afficherFormulaireModification($erreur = -1){

        $res = "<h1>Modification compte</h1>";
        if($erreur == 1) {
            $res .= "<p class=erreur>
                        Les mots de passe de sont pas identiques
                        </p>";
        }
        $res .= "<form method='post' action='modifierCompte'>
                <label>Nom : </label>
                <input type='text' name='username' placeholder=$this->username>
                <label>Mot de passe : </label>
               <input type='password' name='mdp1' required>
                <label>Saisir à nouveau : </label>
               <input type='password' name='mdp2' required>           
               <input type='submit' class='btn' value='Modifier'>
               </form>";


        return $res;

    }


    public function afficherFormulaireCreation($erreur){

        $res = "<h1>Modification compte</h1>";
        if($erreur == 1) {
            $res .= "<p class=erreur>
                        Les mots de passe de sont pas identiques
                        </p>";
        }
        $res.= "<form method='post' action='creerCompte'>
                <label>Nom : </label>
                <input type='text' name='username' placeholder=$this->username>
                <label>Mot de passe : </label>
               <input type='password' name='mdp1' required>
                <label>Saisir à nouveau : </label>
               <input type='password' name='mdp2' required>           
               <input type='submit' class='btn' value='Creer'>
               </form>";

        return $res;

    }

    public function render($i, $erreur = -1){
        $content = "";
        $app = Slim::getInstance();
        switch ($i){
            case (self::AFFICHER_FORMULAIRE_MODIFICATION) :
                $content = $this->afficherFormulaireModification($erreur);
                break;
            case (self::FORMULAIRE_CREATION) :
                $content = $this->afficherFormulaireCreation($erreur);
        }

        $html = VuePermanence::getHeader($app) . $content . VuePermanence::getFooter($app);
        echo $html;
    }

}