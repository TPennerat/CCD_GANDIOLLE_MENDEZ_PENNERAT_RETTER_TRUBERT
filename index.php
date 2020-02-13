<?php

/*https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/*/
session_start();

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

$app->run();
