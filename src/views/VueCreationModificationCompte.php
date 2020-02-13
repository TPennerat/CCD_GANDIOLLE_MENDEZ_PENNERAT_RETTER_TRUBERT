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

        $res = "";
        if($erreur == 1) {
            $res .= "<p class=erreur>
                        Les mots de passe de sont pas identiques
                        </p>";
        }
        $res.= <<<END
        <div class="main-content">
        	<div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
        		<div class="container-fluid">
        			<div class="row text-center">
        <form class="col-12" method="post" action="creerCompte" enctype="multipart/form-data">
          <div class="form-group col-12">
            <label class="col-2">Nom d'utilisateur</label>
            <input style="display:inline-block" class="form-control col-2" type="text" name="username" placeholder="">
          </div>

            <div class="form-group col-12">
              <label class="col-2">Type du compte : </label>

              <div style="display:inline-block" class="col-2">
                <div class="col-12">
                  <input class="form-check-input" type="radio" name="type" value="admin" checked="">
                  <label for="Admin">Admin</label>
                </div>

                <div class="col-12">
                  <input class="form-check-input" type="radio" name="type" value="utilisateur" checked="">
                  <label for="utilisateur">Utilisateur</label>
                </div>
              </div>
            </div>
          <div class="custom-file col-12" style="margin-bottom:10px">
            <input style="display:inline-block" class="custom-file-input col-2" type="file" name="avatar" accept='.png, .jpeg'>
            <label style="display:inline-block" class="offset-sm-4 col-4 custom-file-label" for="customFile">Choose file</label>
          </div>

          <button type="submit" class="btn col-4 btn-primary">Submit</button>
        </form>
END;
        return $res;

    }


    public function afficherFormulaireCreation($erreur){

        $res = "";
        if($erreur == 1) {
            $res .= "<p class=erreur>
                        Les mots de passe de sont pas identiques
                        </p>";
        }
        $res.= <<<END
        <div class="main-content">
        	<div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
        		<div class="container-fluid">
        			<div class="row text-center">
        <form class="col-12" method="post" action="creerCompte" enctype="multipart/form-data">
          <div class="form-group col-12">
            <label class="col-2">Nom d'utilisateur</label>
            <input style="display:inline-block" class="form-control col-2" type="text" name="username" placeholder="">
          </div>

          <div class="form-group col-12">
            <label class="col-2">Mot de passe</label>
            <input style="display:inline-block" class="form-control col-2" type="password" name="mdp1" required="" placeholder="">
          </div>

          <div class="form-group col-12">
            <label class="col-2">Saisir à nouveau</label>
            <input style="display:inline-block" class="form-control col-2" type="password" name="mdp2" required="" placeholder="">
          </div>

            <div class="form-group col-12">
              <label class="col-2">Type du compte : </label>

              <div style="display:inline-block" class="col-2">
                <div class="col-12">
                  <input class="form-check-input" type="radio" name="type" value="admin" checked="">
                  <label for="Admin">Admin</label>
                </div>

                <div class="col-12">
                  <input class="form-check-input" type="radio" name="type" value="utilisateur" checked="">
                  <label for="utilisateur">Utilisateur</label>
                </div>
              </div>
            </div>
          <div class="custom-file col-12" style="margin-bottom:10px">
            <input style="display:inline-block" class="custom-file-input col-2" type="file" name="avatar" accept='.png, .jpeg'>
            <label style="display:inline-block" class="offset-sm-4 col-4 custom-file-label" for="customFile">Choose file</label>
          </div>

          <button type="submit" class="btn col-4 btn-primary">Submit</button>
        </form>
END;

        return $res;

    }

    public function render($i, $erreur = -1){
        $content = "";
        $app = Slim::getInstance();
        $page="";
        switch ($i){
            case (self::AFFICHER_FORMULAIRE_MODIFICATION) :
                $content = $this->afficherFormulaireModification($erreur);
                $page.="Modification compte";
                break;
            case (self::FORMULAIRE_CREATION) :
                $content = $this->afficherFormulaireCreation($erreur);
                $page.="Création compte";
        }

        $html = VuePermanence::getHeader($app,$page) . $content . VuePermanence::getFooter($app);
        echo $html;
    }

}
