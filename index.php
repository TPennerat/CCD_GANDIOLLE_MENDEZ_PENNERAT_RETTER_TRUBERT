<?php

namespace CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN\www;
/*https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/*/
session_start();

use epicerie\controlers\ControleurBesoin;
use \epicerie\controlers\ControleurCreneau;
use epicerie\controlers\ControleurPersonne;
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

$app->get('/changerActivitee/:id',function ($id) {


   $c = new ControleurCreneau();
   $c->desactiverCreneau($id);

});

$app->get('/deconnexion', function() {
    $c = new ControleurComptes();
    $c->seDeconnecter();
})->name('deco');

$app->get('/afficherBesoins/:sem', function () {
    $c = new ControleurPermanence();
    $c->afficherToutesLesPermanences();
})->name('besoin');

$app->get('/afficherCreneaux/:sem/:id',function($sem,$id) {

    $c = new ControleurCreneau();
    $c->afficherUnCreneaux($id);

})->name('creneauSpe');

$app->get('/afficherCreneaux/:sem',function($sem) {

    $c = new ControleurCreneau();
    $c->afficherCreneaux($sem);

})->name('creneau');



$app->get('/mesPermanences/:sem', function($sem) {
    $cont = new ControleurPermanence();
    $cont->afficherMesPermanences($sem);
})->name('aff');


$app->get('/graphique' , function () {

})->name('graphique');



$app->get('/creneau/:id/modifierCreneau/:etat', function($id, $etat){

    $c = new ControleurCreneau();
    $c->changerEtat($id, $etat);
});

$app->get('/creerBesoin', function() {
    $c = new ControleurPermanence();
    $c->afficherCreationBesoin();
})->name('creerbes');

$app->post('/creerBesoin', function() {
    $c = new ControleurPermanence();
    $c->creerBesoin();
})->name('creerBesoin');

$app->get('/inscriptionBesoin/:id', function($id) {
    $c = new ControleurPermanence();
    $c->inscrireBesoin($id);
})->name('inscrBes');


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



$app->post('/ajouterCreneau', function () {
    $c = new ControleurCreneau();
    $c->ajouterCreneau();
})->name('ajouterCreneau');


$app->post('/connexion',function () {

    $cont = new ControleurComptes();
    $cont->verifierConnexion();

})->name('co');




$app->get('/modifierCompte', function (){
    $c = new ControleurComptes();
    $c->afficherFormulaireModificationCompte();
})->name('modifierCompte');


$app->post('/modifierCompte', function (){
    $c = new ControleurComptes();
    $c->modifierCompte();
})->name('modifier');

$app->get('/creerCompte', function (){
    $c = new ControleurComptes();
    $c->afficherFormulaireCreationCompte();
})->name('creerC');


$app->post('/creerCompte', function (){
    $c = new ControleurComptes();
    $c->creerCompte();
})->name('creerCompte');


$app->get('/afficherUsers', function (){
    $c = new ControleurPersonne();
    $c->afficherToutLeMonde();
})->name('afficherUsers');


$app->get('/afficherUser/:id', function ($id){
    $c = new ControleurPersonne();
    $c->afficherUser($id);
})->name('afficher1User');

$app->run();
