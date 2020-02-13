<?php

namespace CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN\www;
/*https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/*/
session_start();

use controlers\ControleurCreneau;
use \Illuminate\Database\Capsule\Manager as DB;
use \epicerie\controlers\ControleurComptes as ControleurComptes;

use Slim\Slim;

require_once('vendor/autoload.php');

$app = new Slim();

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//affichage de la racine
$app->get('/',function () {

  $cont = new ControleurComptes();
  $cont->afficherConnexion();

})->name('racine');


$app->get('/creneau/ajouterCreneau', function () {

    $c = new ControleurCreneau($this);
    return $c->afficherFormulaireCreneau($rq,$rs);

})->name('formulaireCreneau');


$app->post('/creneau/ajouterCreneau', ControleurCreneau::class.':ajouterCreneau');



$app->run();
