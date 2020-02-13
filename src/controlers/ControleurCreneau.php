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

    public function ajouterItem(Request $rq, Response $rs){

        $vue = new vueItem('', $rq,$this->index);


        $item = new Item();
        $token = $_COOKIE['tokenListeMessage'];
        $liste = Liste::where('token', '=', $token)->first();
        $item->liste_id = $liste->no;
        $item->nom = htmlspecialchars(filter_var($rq->getParams()['nom'], FILTER_SANITIZE_STRING ));
        $item->descr = htmlspecialchars(filter_var($rq->getParams()['descr'], FILTER_SANITIZE_STRING ));
        $item->url = htmlspecialchars(filter_var($rq->getParams()['link'], FILTER_SANITIZE_STRING ));

        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["photo"]["name"];
            $filetype = $_FILES["photo"]["type"];
            $filesize = $_FILES["photo"]["size"];

            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)){

                $html = $vue->render(vueItem::FORMULAIRE_AJOUT_ITEM, null, null, null, null, 1);
                $rs->getBody()->write($html);
                return $rs;

            }

            // Vérifie la taille du fichier - 5Mo maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize){

                $html = $vue->render(vueItem::FORMULAIRE_AJOUT_ITEM, null, null, null, null, 2);
                $rs->getBody()->write($html);
                return $rs;

            }

            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){
                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists("img/" . $_FILES["photo"]["name"])){
                    $item->img = $_FILES["photo"]["name"];
                } else{
                    move_uploaded_file($_FILES["photo"]["tmp_name"], "img/" . $_FILES["photo"]["name"]);
                    $item->img = $_FILES["photo"]["name"];
                }
            } else{
                $html = $vue->render(vueItem::FORMULAIRE_AJOUT_ITEM, null, null, null, null, 3);
                $rs->getBody()->write($html);
                return $rs;
            }

        } else{
            $html = $vue->render(vueItem::FORMULAIRE_AJOUT_ITEM, null, null, null, null, 4);
            $rs->getBody()->write($html);
            return $rs;
        }


        $item->tarif = htmlspecialchars($rq->getParams()['tarif']);
        $item->etat = 'Disponible';
        $item->save();
        $token = $liste->token;

        $lien =$this->index->router->pathFor('racine');
        return $rs->withRedirect("$lien",301);


    }


}
