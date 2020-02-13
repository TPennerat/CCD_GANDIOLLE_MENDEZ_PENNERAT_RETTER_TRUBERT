<?php

namespace epicerie\views;

class VueCreneau
{

    const FORMULAIRE_AJOUT_CRENEAU = 1;

    const AFFICHAGE_CRENEAUX = 2;

    /**
     * L'item
     */
    private $creneauAffiche;

    /**
     * vueItem constructor.
     * @param $arr : objet à afficher
     * @param $rq : requete
     * @param $index : container
     */

    public function __construct($arr)
    {
        $this->creneauAffiche = $arr;
        $this->rq= $rq;
        $this->index=$index;
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
                  <h1>Ajouter un creneau  : </h1>
                 <form id=formulaireAjout method=post action =ajouterCreneau enctype=multipart/form-data>
                       
                 <label for=formulaire1>Jour du creneau : </label>           
                 <input type=number step=1 name=jour placeholder=1-2-3-... required> 
                 
                  <label for=formulaire1>Semaine du creneau : </label>     
                   <input type=text name=semaine  placeholder=A-B-C-... required>                    
                        
                  
                    <label for=formulaire1>Heure de debut : </label>           
                    <input type=number  name=hdeb placeholder=8-10-12-... required> 
                 
                   <label for=formulaire1>Heure de fin : </label>           
                 <input type=number  name=hfin placeholder=16-17-18-... required> 
              
                 <input type=submit class=btn value=Ajouter>          
                    
                   
                 </form>
                 </section>";
        return $res;
    }


    public function ajouterCreneau(){

    }

    public function afficherCreneaux(){
        $res = "";
        foreach ($this->creneauAffiche as $creneau){
            $res .= "Jour : $creneau->jour <br>
                     Semaine : $creneau->semaine <br>
                     Heure de debut : $creneau->hdeb <br>
                     Heure de fin : $creneau->hfin <br>";
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
        }

       echo $content;
    }





}