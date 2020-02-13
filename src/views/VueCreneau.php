<?php

namespace epicerie\views;

use epicerie\models\Role;
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
                $res .=  "<h2 class=erreur> ERREUR DANS LE CHEVAUCHEMENT DES CRENEAUX </h2>";
                break;
            default :
                break;
        }

        $res .= "<section>
                  <label>Ajouter un creneau  : </label>
                 <form id=formulaireAjout method=post action =ajouterCreneau enctype=multipart/form-data>
               
               <div class='form-group'>
                                <label for='selection'>Jour : </label>
                                <select id='selection' class='form-control' name='jour'>
                              
                                
                                <option value=1>Lundi</option>
                            <option value=2>Mardi</option>
                             <option value=3>Mercredi</option>
                        <option value=4>Jeudi</option>
                         <option value=5>Vendredi</option>
                         <option value=6>Samedi</option>
                         <option value=7>Dimanche</option>
                       
                    </select>
                    </div>
                  
                    
                            <div class='form-group'>

                     <label>Semaine : </label>

                    <select  id='selection' class='form-control' name=semaine>
                         <option value=A>A</option>
                            <option value=B>B</option>
                             <option value=C>C</option>
                        <option value=D>D</option>
        
                    </select>
                    </div>
                    
                    <label>
                    Heure de debut : 
                    </label>
                    <input type='number' name='hDeb' required>
                 
                    
                    <label>
                    Heure de fin : 
                    </label>
                    <input type='number' name='hFin' required>
           
                 
 
                 <input type=submit class=btn value=Ajouter>          
        
                 </form>
                 </section>";
        return $res;
    }

    public function adapt()
    {
        $html = "";
        $content = "";
        $ancienJour=0;
        $compJour = 0;
        $passageUnique = true;
        $passageUnique2 = true;
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex)-1];
        foreach ($this->creneauAffiche as $key) {
            if ($key->semaine == $sem) {
                $jour = $key->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                $deb = $key->hDeb . ":00";
                $fin = $key->hFin . ":00";

                if ($compJour !== 0) {
                    $jour = "";
                }
                $content .= <<<END
<div class="col-12" style="padding:0px">
            <div class="overview-item overview-item--c7" style="padding:20px;margin-bottom:10px">

              <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-refresh"></i></p>
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
                <button onclick="window.location.href='uncreneau.html'" type="button" style="margin-top:15px" class="btn btn-block btn-info btn-sm"><i class="fa fa-list"></i>&nbsp; Voir les tâches</button>
              </div>
            </div>
          </div>
END;

                $compJour++;
                echo "$jour\n\n";
                if ($jour !== $ancienJour) {
                    if ($passageUnique2) {
                        $j = $this->jour($ancienJour);
                        $passageUnique2 = false;

                    } else {
                        $j = $this->jour($jour);

                    }
                    $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                    $content = "";
                    $compJour = 0;
                }
            }
        }

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
        $res = "";
        $html="";
        foreach ($this->creneauAffiche as $creneau){
            $res .= "Jour : $creneau->jour <br>
                     Semaine : $creneau->semaine <br>
                     Heure de debut : $creneau->hDeb <br>
                     Heure de fin : $creneau->hFin <br>";
            if($creneau->estActif == 0){
                $res .= "Etat : Incatif";
            }else{
                $res .= "Etat : Actif";
            }
            $res .= "<br>";
        }

        return $res;
    }

    public function afficherToutCreneau(){

        $res = $this->afficherCreneaux();
        foreach ($this->permanencesAffiche as $perm){

            // A changer, car faire des requettes dans une vue c'est horrible

            $role = Role::where('id', '=', $perm->idRole)->first();

            $res .= "Role : $role->label <br>";

            if($perm->idUtil == null){
                //mettre un code couleur
                $res .= "Assure par personne <br>";
            }
        }
        return $res;
    }


    public function render($const, $erreur = -1){

        $content = '';
        switch ($const){
            case (self::FORMULAIRE_AJOUT_CRENEAU):
                $content = $this->afficherFormulaireAjoutCreneau($erreur);
                break;
            case (self::AFFICHAGE_CRENEAUX):
                $content = $this->adapt();
                break;
            case (self::AFFICHER_TOUT_CRENEAU):
                $content = $this->afficherToutCreneau();
                break;
        }
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex)-1];
        $html =<<<END
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center"><h2 class="h1" style="font-weight:bold">Créneaux de la semaine $sem</h2></div>
        <div class="col-md-12" style="margin-left:20px;margin-bottom:20px">
          <a href="#"><button type="button" class="btn btn-outline-primary btn-lg">Créer un créneau</button></a>
        </div>
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