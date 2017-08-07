<?php
// Définitions des constantes modèles pour l'accès au datatore
define('GDS_ACCOUNT', ' !! your service account name here !! ');
define('GDS_KEY_FILE', dirname(__FILE__) . '/key.p12');
define('POST_LIMIT', 10);

// Inclusion pour notre lib
require_once('../vendor/autoload.php');

// Pour rafraîchir la page à chaque 7 seconde
// $page = $_SERVER['PHP_SELF'];
// $sec = "30";

?>

<!DOCTYPE html>
<html lang="fr">

<!-- head -->
<head>
    <meta charset="utf-8">
    <title>Détéction de pollution</title>
    <!-- <meta http-equiv = "refresh" content = "<?php echo $sec ?> ; URL ='<?php echo $page ?>' " charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/demo.css">
    <meta name="author" content="Yvon Benahita">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- end head -->

<body>
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    </header>
        <div class="container">  <!-- Pour tout le contenu de notre site -->

            <!-- ===========================Le logo et le titre============================ -->
            <div class="row">
                <div class="col-md-12">
                    <h1><img src="/img/datastore-logo.png" id="gds-logo" /> PHP & <span class="hidden-xs">Google</span> Cloud Datastore</h1>
                </div>
            </div>
            <!-- ====================================================================== -->

            <!-- =====================La définition et la Réssource===================== -->
            <div class="row">
                <div class="col-md-8">
                    <h2>Qu'est-ce que c'est?</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla est purus,<br> ultrices in porttitor
                    in, accumsan non quam. Nam consectetur porttitor rhoncus.<br> Curabitur eu est et leo feugiat
                    auctor vel quis lorem.</p>
                    <p>Ut et ligula dolor, sit amet consequat lorem. Aliquam porta eros sed
                    velit imperdiet egestas.</p>
                </div>
                <!-- ============== -->
                <div class="col-md-4">
                    <h2>Resources</h2>
                    <p><a href="https://github.com/YvonB/demo-mems-v1" target="_blank"><span aria-hidden="true" class="glyphicon glyphicon-new-window"></span> Pollution detection demo (Ce site web)</a></p>
                </div>
            </div>
            <!-- ========================================================================== -->

            <!-- Le map -->
            <div>
                <h2>Où se trouve nos capteurs ?</h2>
                <div class="map" align="center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d963367.6427555117!2d46.800975397000194!3d-19.40571407254446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21fa8238a95a8965%3A0xe11f2e914a20ec99!2sEcole+Sup%C3%A9rieur+Polytechnique+d&#39;Antananarivo!5e0!3m2!1sfr!2sfr!4v1501594670727" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <!-- =======================Pour visualiser les résultats====================== -->
            <div class="row">
                <div class="col-md-8" >
                    <h2>Results</h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
                                try 
                                    {   
                                        // On crée un objet de type Repository.
                                        $obj_repo = new \GDS\Demo\Repository();
                                        // Chercher les dernières valeurs insérées
                                        $arr_posts = $obj_repo->getRecentPosts();

                                        // Les afficher
                                        foreach ($arr_posts as $obj_post) 
                                        {

                                            // Effectuez une belle chaîne d'affichage de date et heure
                                            $int_posted_date = strtotime($obj_post->posted);
                                            $int_date_diff = time() - $int_posted_date;

                                            if ($int_date_diff < 3600) 
                                            {
                                                $str_date_display = round($int_date_diff / 60) . ' minute(s)';
                                            } 
                                            else if ($int_date_diff < (3600 * 24)) 
                                            {
                                                $str_date_display = round($int_date_diff / 3600) . ' heure(s)';
                                            } 
                                            else 
                                            {
                                                $str_date_display = date('\a\t jS M Y, H:i', $int_posted_date);
                                            }

                                            echo '<div class="post">';
                                            if(isset($obj_post->co2) AND !empty($obj_post->co2))
                                                {
                                                    echo '<div class="gas">Taux de CO2: <strong>', htmlspecialchars($obj_post->co2),'</strong><em>ppm</em>    ', '</div>';
                                                }
                                            if(isset($obj_post->co) AND !empty($obj_post->co))
                                                {
                                                    echo '<div class="gas">Taux de CO: <strong>', htmlspecialchars($obj_post->co),'</strong><em>ppm</em>    ', '</div>';
                                                }
                                            if(isset($obj_post->nh3) AND !empty($obj_post->nh3))
                                                {
                                                    echo '<div class="gas">Taux de NH3: <strong>', htmlspecialchars($obj_post->nh3), '</strong><em>ppm</em>    ', '<br><span class="time">', $str_date_display, '</span></div>';
                                                }
                                            echo '</div>';
                                        }

                                        $int_posts = count($arr_posts);

                                        echo '<div class="post"><em>Showing last ', $int_posts, '</em></div>';

                                    } 
                                catch (\Exception $obj_ex)
                                {
                                    syslog(LOG_ERR, $obj_ex->getMessage());
                                    echo '<em>Whoops, something went wrong!</em>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========================================================================== -->

            <!-- ===========================Espace connexion ============================== -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Voir plus de contenu</h2>
                    <p>Dans ce cas, connectez-vous.</p>
                </div>
            </div> 
            <!-- ============= -->
            <div class="row">
                <div class="col-md-4" id="login_btn">
                    <div class="well">
                        <form method="POST" action="/login">
                            <button type="submit" class="btn btn-primary" align="center">Se Connecter</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ========================================================================== -->

        </div> <!-- fin de container de la page --> 
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    </body>
</html>