<?php

namespace CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN\www;
/*https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/*/
session_start();

use controlers\ControleurCreneau;
use \Illuminate\Database\Capsule\Manager as DB;
use \epicerie\controlers\ControleurComptes as ControleurComptes;
use \epicerie\controlers\ControleurPermanence as ControleurPermanence;
use \epicerie\controlers\ControleurAffichage as ControleurAffichage;
use Slim\Slim;

require_once('vendor/autoload.php');

$app = new Slim();

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();


$app->get('/',function () {

    $cont = new ControleurAffichage();
    $cont->racine();

})->name('racine');


$app->get('/connexion',function () {

  $cont = new ControleurComptes();
  $cont->afficherConnexion();

})->name('connexion');

$app->post('/connexion',function () {

    $cont = new ControleurComptes();
    $cont->verifierConnexion();

})->name('co');

$app->get('/afficherMesPermanences/:id', function($id) {
    $cont = new ControleurPermanence();
    $cont->afficherMesPermanences($id);
});

$app->get('/afficherCreneaux',function() {

});

$app->get('/creerBesoin', function() {

});

$app->post('/creerBesoin', function() {

});

$app->get('/inscriptionBesoin/:id', function($id) {

});

$app->post('/inscriptionBesoin/:id', function($id) {

});


$app->notFound(function () {
    $cont = new ControleurAffichage();
    $cont->err();
});


$app->get('/creneau/ajouterCreneau', function () {

    $c = new ControleurCreneau($this);
    return $c->afficherFormulaireCreneau($rq,$rs);

})->name('formulaireCreneau');


$app->post('/creneau/ajouterCreneau', ControleurCreneau::class.':ajouterCreneau');


$app->run();
