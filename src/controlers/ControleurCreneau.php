<?php

namespace epicerie\controlers;

use epicerie\models\AssurePermanence;
use epicerie\models\AssurePermanence as Permanence;
use epicerie\models\Creneau;
use Slim\Http\Request;
use Slim\Http\Response;
use epicerie\views\VueCreneau;

class ControleurCreneau
{


    public function afficherFormulaireCreneau(){

        $vue = new VueCreneau('');
        $vue->render(vueCreneau::FORMULAIRE_AJOUT_CRENEAU);
    }

    public function desactiverCreneau($id) {
        $cre = Creneau::where("id","=",$id)->first();
        $cre->estactif = $cre->estactif == 1 ? 0 : 1;
        $cre->save();
    }

    public function ajouterCreneau(){

        $vue = new vueCreneau('');

        $deb = htmlspecialchars(filter_var($_POST['hDeb'], FILTER_SANITIZE_STRING ));
        $fin = htmlspecialchars(filter_var($_POST['hFin'], FILTER_SANITIZE_STRING ));

        $creneauxIncorrects1 = Creneau::where('hDeb', '>=', $deb)->get();
        $exc = false;
        foreach ($creneauxIncorrects1 as $c1){
            if($c1->hFin >= $deb){
                $exc = true;
            }
        }

        $creneauxIncorrects2 = Creneau::where('hDeb', '<=', $fin)->get();
        foreach ($creneauxIncorrects2 as $c2){
            if($c2->hFin >= $fin){
                $exc = true;
            }
        }


        $creneauxIncorrects3 = Creneau::where('hDeb', '>=', $deb);
        foreach ($creneauxIncorrects3 as $c3){
            if($c3->hFin <= $fin){
                $exc = true;
            }
        }


        if($exc){
            $vue->render(vueCreneau::FORMULAIRE_AJOUT_CRENEAU, 1);
        }else{
            $creneau = new Creneau();
            $creneau->hDeb = $deb;
            $creneau->hFin = $fin;
            $creneau->jour = $_POST['jour'];
            $creneau->semaine = $_POST['semaine'];
            $creneau->cycle = 0;
            $creneau->save();

            $vue->render(VueCreneau::FORMULAIRE_AJOUT_CRENEAU);
        }




    }


    public function afficherCreneaux($sem){
        $creneaux =  Creneau::where('semaine', '=', $sem)->orderBy('jour','asc')->orderBy('hDeb','asc')->get();
        $vue = new VueCreneau($creneaux);
        $vue->render(VueCreneau::AFFICHER_TOUT_CRENEAU);
    }

    public function afficherUnCreneaux($id){
        $creneaux =  Permanence::where('id','=',$id)->get();
        $vue = new VueCreneau($creneaux);
        $vue->render(VueCreneau::AFFICHAGE_CRENEAUX);
    }


}
