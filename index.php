<?php

namespace CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN\www;
/*https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/*/
session_start();

use epicerie\controlers\ControleurBesoin;
use \epicerie\controlers\ControleurCreneau;
use \Illuminate\Database\Capsule\Manager as DB;
use \epicerie\controlers\ControleurComptes as ControleurComptes;

use Slim\Http\Request;
use Slim\Http\Response;
use \epicerie\controlers\ControleurPermanence as ControleurPermanence;
use \epicerie\controlers\ControleurAffichage as ControleurAffichage;
use Slim\Slim;

require_once('vendor/autoload.php');

$app = new Slim();

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//affichage de la racine
$app->get('/',function () {

    $cont = new ControleurAffichage();
    $cont->racine();

})->name('racine');


$app->get('/connexion',function () {

  $cont = new ControleurComptes();
  $cont->afficherConnexion();

})->name('connexion');


$app->get('/afficherMesPermanences/:id', function($id) {
    $cont = new ControleurPermanence();
    $cont->afficherMesPermanences($id);
})->name('aff');

$app->get('/afficherCreneaux',function() {

    $c = new ControleurCreneau();
    $c->afficherCreneaux();

});

$app->get('/creneau/:id/modifierCreneau/:etat', function($id, $etat){

    $c = new ControleurCreneau();
    $c->changerEtat($id, $etat);
});



$app->get('/creerBesoin', function() {

});

$app->post('/creerBesoin', function() {

});

$app->get('/inscriptionBesoin/:id', function($id) {

    $c = new ControleurPermanence();
    $c->inscrireBesoin($id);

});

$app->post('/inscriptionBesoin/:id', function($id) {

});


$app->notFound(function () {
    $cont = new ControleurAffichage();
    $cont->err();
});


$app->get('/creneau/ajouterCreneau', function () {

    $c = new ControleurCreneau();
    $c->afficherFormulaireCreneau();

})->name('formulaireCreneau');



$app->get('/creneau/listeCreneaux/{id}/modifierEtat/{etat}', function (Request $rq, Response $rs, array $args){

    $id = $args['id'];
    $etat = $args['etat'];
    $c = new ControleurCreneau($this);
    return $c->modifierEtatCreneau($id, $rq, $rs, $etat);

})->name('modifierEtatCreneau');


$app->post('/creneau/ajouterCreneau', function (){
    $c = new ControleurCreneau($this);

    $c->ajouterCreneau(null, null);
});


$app->post('/connexion',function () {

    $cont = new ControleurComptes();
    $cont->verifierConnexion();

})->name('co');


//Question 18
$app->get('affichagePermanences/:idCreneau', function ($idCreneau){

    $c= new ControleurCreneau();
    $c->afficherTout($idCreneau);
});


$app->run();
