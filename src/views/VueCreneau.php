<?php

namespace epicerie\views;

use epicerie\models\Role;
use epicerie\models\User as User;
use Slim\Slim;
use Symfony\Component\Translation\Loader\IniFileLoader;

class VueCreneau
{

    const FORMULAIRE_AJOUT_CRENEAU = 1;

    const AFFICHAGE_CRENEAUX = 2;

    const AFFICHER_TOUT_CRENEAU = 3;


    /**
     * L'item
     */
    private $creneauAffiche;

    private $permanencesAffiche;

    /**
     * vueItem constructor.
     * @param $arr : objet à afficher
     * @param $rq : requete
     * @param $index : container
     */

    public function __construct($arr, $perms = null)
    {
        $this->creneauAffiche = $arr;
        $this->permanencesAffiche = $perms;
    }


    public function afficherFormulaireAjoutCreneau($erreur){

        $res = "";

        switch ($erreur){
            case(1) :
                $res .=  "<p class='text-danger'> ERREUR DANS LE CHEVAUCHEMENT DES CRENEAUX </p>";
                break;
            default :
                break;
        }
        $cre = Slim::getInstance()->urlFor('ajouterCreneau');
        $res .= <<<END
        <form class="col-12" method="post" action="$cre" enctype="multipart/form-data">
          <div class="form-group col-12">
            <label class="col-2">Jour</label>
            <select class="col-2 custom-select" name="jour">
              <option selected value="1">Lundi</option>
              <option value="2">Mardi</option>
              <option value="3">Mercredi</option>
              <option value="4">Jeudi</option>
              <option value="5">Vendredi</option>
              <option value="6">Samedi</option>
              <option value="7">Dimanche</option>

            </select>
            </div>
            <div class="form-group col-12">
              <label class="col-2">Semaine</label>
              <select class="col-2 custom-select" name="semaine">
                <option selected value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
            <div class="form-group col-12">
              <label class="col-2">Heure de début</label>
              <select class="col-2 custom-select" name="deb">
                <option selected value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
              </select>
            </div>
            <div class="form-group col-12">
              <label class="col-2">Heure de fin</label>
              <select class="col-2 custom-select" name="fin">
                <option selected value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
              </select>
            </div>
            <button type="submit" class="btn col-4 btn-primary">Valider</button>
          </form>
END;
        return $res;
    }

    public function adapt($path)
    {
        $html = "";
        $content = "";
        $ancienJour=0;
        $compJour = 0;
        $passageUnique = true;
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex)-1];
        foreach ($this->creneauAffiche as $key) {
            if ($key->semaine == $sem) {
                $jour = $key->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                if ($key->jour !== $ancienJour) {
                    $j = $this->jour($ancienJour);
                    $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                    $content = "";
                    $compJour = 0;
                    $ancienJour = $jour;
                }


                $deb = $key->hDeb . ":00";
                $fin = $key->hFin . ":00";

                if($key->estactif==0){
                  $class="c8";
                }else{
                  $class="c7";
                }


                $x=null;
                for($i=0; $i<count($key->estAssure->toArray());$i++){
                    if($key->estAssure->toArray()[$i]!=null){
                        if($key->estAssure->toArray()[$i]['idUtil']==$_SESSION['id_connect'] && $key->estAssure->toArray()[$i]['idCreneau']==$key->id){
                            $x=$key->estAssure->toArray()[$i]['id'];
                        }
                    }
                }

                $urlCreneau= Slim::getInstance()->urlFor('creneauSpe',["sem"=>$sem,"id"=>$x]);
                $content .= <<<END
<div class="col-12" style="padding:0px">
            <div id = $key->id class="overview-item overview-item--$class aModifier" style="padding:20px;margin-bottom:10px">

              <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right aModifier2 fa fa-refresh"></i></p>
              <div class="overview__inner">
                <div class="overview-box clearfix" style="width:auto">
                  <div class="text">
                    <span style="font-size:1.2rem">De</span>
                    <h2 style="font-size:1.2rem;font-weight:bold">$deb</h2>
                    <span style="font-size:1.2rem">à</span>
                    <h2 style="font-size:1.2rem;font-weight:bold">$fin</h2>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button onclick="window.location.href=''" type="button" style="margin-top:15px" class="btn btn-block btn-info btn-sm"><a href="$urlCreneau" style="color: inherit"><i class="fa fa-list"></i>&nbsp; Voir les tâches</button></a>
              </div>
            </div>
          </div>
          <script type="text/javascript" src="$path/js/toggle.js"> </script>
END;

                $compJour++;


            }
        }
        $j = $this->jour($ancienJour);
        $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;

        return $html;
    }

    public function jour($num)
    {
        $res = "";
        switch ($num) {
            case 1:
                $res .= "Lundi";
                break;
            case 2:
                $res .= "Mardi";
                break;
            case 3:
                $res .= "Mercredi";
                break;
            case 4:
                $res .= "Jeudi";
                break;
            case 5:
                $res .= "Vendredi";
                break;
            case 6:
                $res .= "Samedi";
                break;
            case 7:
                $res .= "Dimanche";
                break;
        }
        return $res;
    }


    public function afficherCreneaux(){
        $html = "";
        $content = "";
        $ancienJour=0;
        $compJour = 0;
        $passageUnique = true;
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex)-1];
        foreach ($this->creneauAffiche as $key) {
            if ($key->creneau->semaine == $sem) {
                $jour = $key->creneau->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                if ($key->creneau->jour !== $ancienJour) {
                    $j = $this->jour($ancienJour);
                    $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                    $content = "";
                    $compJour = 0;
                    $ancienJour = $jour;
                }
                $label = $key->role->label;
                $inscr = $key->user->nom;

                $content .= <<<END
<div class="col-12" style="padding:0px">
            <div class="overview-item overview-item--c3"style="padding:20px;margin-bottom:10px">

              <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-times"></i></p>
              <div class="overview__inner">
                <div class="overview-box clearfix" style="width:auto">
                  <div class="text col-12">
                    <div class="row">

                      <div class="col"><h2 style="font-size:1.2rem">Poste : $label</h2></div>
                      <div class="col"><h2 style="font-size:1.2rem">Inscrit : $inscr</h2></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
END;

                $compJour++;


            }
        }

        return $html;
    }



    public function render($const, $erreur = -1){
        $app = Slim::getInstance();
        $content = '';
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $cre="";
        $user = User::where("id","=",$_SESSION["id_connect"])->first();
        $center="";
        switch ($const){
            case (self::FORMULAIRE_AJOUT_CRENEAU):
                $content = $this->afficherFormulaireAjoutCreneau($erreur);
                $user->droit = 1;
                $center="text-center";
                break;
            case (self::AFFICHAGE_CRENEAUX):
                $content = $this->afficherCreneaux();
                $sem = $ex[count($ex)-1];
                $cre = "Créneau n° ".$sem;
                break;
            case (self::AFFICHER_TOUT_CRENEAU):
                $content = $this->adapt($app->urlFor('racine') . "/Bootstrap");
                $sem = $ex[count($ex)-1];
                $cre = "Créneaux de la semaine ".$sem;
                break;
        }

        $admin ="";
        $ajoutCreneau=$app->urlFor('formulaireCreneau');
        if ($user->droit !=1) {
            $admin = <<<END
<div class="col-md-12" style="margin-left:20px;margin-bottom:20px">
          <a href="$ajoutCreneau"><button type="button" class="btn btn-outline-primary btn-lg">Créer un créneau</button></a>
        </div>
END;
        }

        $html =<<<END
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row $center">
        <div class="col-md-12 text-center"><h2 class="h1" style="font-weight:bold">$cre</h2></div>
        $admin
    $content

      </div>
      <div class="w-100"></div>
    </div>
  </div>
</div>
<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->
</div>

</div>
END;

       echo VuePermanence::getHeader(Slim::getInstance(),"Créneaux").$html.VuePermanence::getFooter(Slim::getInstance());
    }





}
