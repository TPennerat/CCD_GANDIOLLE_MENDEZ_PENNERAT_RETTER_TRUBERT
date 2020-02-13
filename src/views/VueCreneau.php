<?php

namespace epicerie\views;

use epicerie\models\Role;

class VueCreneau
{

    const FORMULAIRE_AJOUT_CRENEAU = 1;

    const AFFICHAGE_CRENEAUX = 2;

    const AFFICHER_TOUT = 3;

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



    public function afficherCreneaux(){
        $res = "";
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

    public function afficherTout(){

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
                $content = $this->afficherCreneaux();
                break;
            case (self::AFFICHER_TOUT):
                $content = $this->afficherTout();
                break;
        }
        echo $content;
    }





}