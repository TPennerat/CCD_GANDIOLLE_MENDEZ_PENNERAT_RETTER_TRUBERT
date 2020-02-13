<?php

namespace epicerie\views;

class VueComptes {


  public static function getHeader($app) {

    $path = $app->router->pathFor('route_index') + "/Bootstrap";

    return <<<END
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen">
        <meta name="keywords" content="au theme template">

        <!-- Title Page-->
        <title>Login</title>

        <!-- Fontfaces CSS-->
        <link href="$path/css/font-face.css" rel="stylesheet" media="all">
        <link href="$path/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="$path/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="$path/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="$path/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="$path/vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="$path/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="$path/css/theme.css" rel="stylesheet" media="all">

    </head>
END;

  }

  public footer($app) {

    return <<<END
    <!-- Jquery JS-->
    <script src="$path/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="$path/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="$path/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="$path/vendor/slick/slick.min.js">
    </script>
    <script src="$path/vendor/wow/wow.min.js"></script>
    <script src="$path/vendor/animsition/animsition.min.js"></script>
    <script src="$path/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="$path/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="$path/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="$path/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="$path/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="$path/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="$path/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="$path/js/main.js"></script>

</body>

</html>
END;
  }

  public renderConnexion($app,$type,$erreur) {

  }

  $url = $app->router->pathFor("route_index");

  switch($type) {
    case "con":
    $envoie = $app->router->pathFor("connexion");
    $intitule = "Connexion";
    break;
    case "auth":
    $intitule = "Enregistrement";
    $envoie = $app->router->pathFor("enregistrement");
    break;
  }

  $html = self::getHeader($app) . <<<END

  <div id="zone">
  <center>
  <h1>
  $intitule
  </h1>
  <form action="$envoie" method="post">

  Login :
  <input type="text" name="login">
  Mot de passe :
  <input type="password" name="password">

  <input type="submit" value="Valider" </input>
  </br>
  $erreur

  </form>
  </center>
  </div>
  </body>
  END;

  $html = $html . self::getFooter();

  return $html;

}

}
