<?php

namespace epicerie\controlers;

use epicerie\models\AssurePermanence;
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



    public function ajouterCreneau(Request $rq, Response $rs){

        $vue = new vueCreneau('');

        $deb = htmlspecialchars(filter_var($rq->getParams()['hdeb'], FILTER_SANITIZE_STRING ));
        $fin = htmlspecialchars(filter_var($rq->getParams()['hfin'], FILTER_SANITIZE_STRING ));

        $creneauxIncorrects1 = Creneau::where('hdeb', '>=', $deb, 'hfin', '>=', $deb)->first();

        $creneauxIncorrects2 = Creneau::where('hdeb', '<=', $fin, '&&', 'hfin', '>=', $fin)->first();

        $creneauxIncorrects3 = Creneau::where('hdeb', '>=', $deb, '&&', 'hfin', '<=', $fin)->first();

        if($creneauxIncorrects1 != null || $creneauxIncorrects2 != null || $creneauxIncorrects3!= null){
            $html = $vue->render(vueCreneau::FORMULAIRE_AJOUT_CRENEAU, 1);
            $rs->getBody()->write($html);
            return $rs;
        }


        $creneau = new Creneau();
        $creneau->hDeb = $deb;
        $creneau->hFin = $fin;
        $creneau->jour = $_POST['jour'];
        $creneau->semaine = $_POST['semaine'];
        $creneau->cycle = 0;
        $creneau->save();


        $vue = new VueCreneau('');
        $vue->render(VueCreneau::AFFICHAGE_CRENEAUX);

        /**
        $lien =$this->index->router->pathFor('racine');
        return $rs->withRedirect("$lien",301);
         * */

    }


    public function afficherCreneaux(){
        $creneaux = Creneau::get();
        $vue = new VueCreneau($creneaux);
        $vue->render(VueCreneau::AFFICHAGE_CRENEAUX);
    }


    public function changerEtat($id, $etat){

        $cr = Creneau::where('id', '=', $id)->first();
        $cr->estActif = $etat;

        $vue = new VueCreneau('');
        $vue->render(VueCreneau::AFFICHAGE_CRENEAUX);

    }

    public function  afficherTout($idCreneau){

        $cren = Creneau::where('id', '=', $idCreneau)->first();
        $permanences = AssurePermanence::where('idCreneau', '=', $idCreneau)->get();

        $vue = new VueCreneau($cren, $permanences);


        $vue->render(VueCreneau::AFFICHER_TOUT);

    }


}
