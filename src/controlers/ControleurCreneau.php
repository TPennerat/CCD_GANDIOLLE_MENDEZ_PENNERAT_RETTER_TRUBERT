<?php

namespace epicerie\controlers;

use \epicerie\models\Creneau;
use Slim\Http\Request;
use Slim\Http\Response;
use \epicerie\views\VueCreneau;

class ControleurCreneau
{


    public function afficherFormulaireCreneau(){

        $vue = new VueCreneau('');
        $vue->render(vueCreneau::FORMULAIRE_AJOUT_CRENEAU);
    }



    public function ajouterCreneau(Request $rq, Response $rs){

        $vue = new vueCreneau('');


        $dernierCreneau = Creneau::tail();


        $creneau = new Creneau();
        $creneau->id = $dernierCreneau->idCreneau+1;
        $creneau->hDeb = htmlspecialchars(filter_var($rq->getParams()['hdeb'], FILTER_SANITIZE_STRING ));
        $creneau->hFin = htmlspecialchars(filter_var($rq->getParams()['hfin'], FILTER_SANITIZE_STRING ));
        $creneau->jour = htmlspecialchars(filter_var($rq->getParams()['jour'], FILTER_SANITIZE_STRING ));
        $creneau->semaine = htmlspecialchars(filter_var($rq->getParams()['semaine'], FILTER_SANITIZE_STRING ));
        $creneau->cycle = null;


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

        $creneau->save();

        $lien =$this->index->router->pathFor('listeToken');
        return $rs->withRedirect("$lien",301);



    }


}
