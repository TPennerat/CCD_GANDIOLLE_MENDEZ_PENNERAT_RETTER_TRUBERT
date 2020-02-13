<?php


namespace epicerie\views;


use Slim\Slim;

class VuePersonne
{
    const AFFICHER_TOUT_MONDE = 1;
    const AFFICHER_PERS = 2;
    private $personnes;


    public function __construct($pers){
        $this->personnes = $pers;
    }

    public function afficherUsers(){
        $app = Slim::getInstance();
        $path = $app->request()->getRootUri();

        $res = <<<END
        <div class="main-content">
          <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
            <div class="container-fluid">
              <div class="row">
END;
        foreach ($this->personnes as $pers){
            $url = $app->urlFor('afficher1User', ['id'=>$pers->id]);
            $res .= <<<END

            <div class="col-sm-6 col-lg-3">
              <div class="overview-item overview-item--c7" style="padding:40px">
                <div class="overview__inner">
                  <div class="overview-box clearfix">
                    <div class="text-center col-12" style="padding:0px">
                      <img src="$path/web/img/$pers->urlimage" class="img-fluid" style="padding:0px;border-radius:5px" alt="user">
                      <h2 class="col-6" style="display:inline-block;font-size:1.3rem;color:white">$pers->nom</h2>
                    </div>
                    <div class="text-center">
                      <button onclick="window.location.href='$url'" type="button" style="margin-top:15px" class="btn btn-block btn-info btn-sm"><i class="fas fa-sign-in-alt"></i>&nbsp; Voir les détails</button>
                    </div>
                  </div>
              </div>
            </div>
            </div>
END;
        }

        return $res;
    }

    public function afficher1User(){
        $app = Slim::getInstance();
        $path = $app->request()->getRootUri();
        $res =<<<END
        <div class="main-content">
          <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
            <div class="container-fluid">
              <div class="row">
        <div class="col-12">
					<div class="overview-item overview-item--c1" style="padding:40px">
						<div class="overview__inner">
							<div class="overview-box clearfix">
								<div class="text-center col-12" style="padding:0px">
									<img src="$path/web/img/{$this->personnes->urlimage}" class="img-fluid" style="padding:0px;border-radius:5px" alt="user">
									<h2 class="col-6" style="display:inline-block;font-size:1.3rem;color:white">{$this->personnes->nom}</h2>
								</div>
							</div>
					</div>
				</div>
			</div>
END;
        return $res;
    }


    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case self::AFFICHER_TOUT_MONDE:
                $content = $this->afficherUsers();
                break;
            case self::AFFICHER_PERS:
                $content = $this->afficher1User();
                break;
        }
        $html = VuePermanence::getHeader($app,null) . $content . VuePermanence::getFooter($app,null);
        echo $html;
    }
}
