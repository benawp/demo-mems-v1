<?php
// Définitions des constantes modèles pour l'accès au datatore
define('GDS_ACCOUNT', ' !! your service account name here !! ');
define('GDS_KEY_FILE', dirname(__FILE__) . '/key.p12');
define('POST_LIMIT', 10);

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
// [START user]
# Looks for current Google account session
$user = UserService::getCurrentUser();

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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/demo.css">
    <meta name="author" content="Yvon Benahita">
    <link rel="icon" type="image/png" href="/img/datastore-logo.png" />

      <!-- font -->
    <link rel="stylesheet" href="css/font-awesome/font-awesome.css">
    
    <!-- Pour le Jauge  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Fin -->

    <!-- jquery du rafraîchissement -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- end head -->

<body>
    <!--************************ Début Navigation ************************************-->
    <header>
        <nav class="navbar navbar-default navbar-fixed-top colornav">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand colortextnav" href="/"><b>SDP - IoT</b></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active colortextnav"><a href="#"><b>Welcome</b><span class="sr-only">(current)</span></a></li>
                <!-- <li class="colortextnav"><a href="#">Link</a></li>
                <li class="dropdown colortextnav">
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
                </li> -->
              </ul>
              <form class="navbar-form navbar-left">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><b>Chercher</b></button>
              </form>
              <ul class="nav navbar-nav navbar-right colortextnav">
                <!-- <li><a href="#">Link</a></li> -->
                <li class="dropdown colortextnav">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b>Options</b><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/home/co2"><b>Voir l'état de CO2</a></b></li>
                    <li><a href="/home/co"><b>Voir l'état de CO</a></b></li>
                    <li><a href="/home/nh3"><b>Voir l'état de NH3</a></b></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php 
                                    $login = "/login";
                                    $logout = "/logout";
                                    echo(isset($user) ? $logout : $login );
                                ?>">
                    <button type="submit" class="btn btn-primary" align="center"><?php echo (isset($user) ? "Deconnexion" : "Se Connecter"); ?></button></a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
    <!--****************************** Fin Navigation *****************************-->
        
        <div class="container">  <!-- Pour tout le contenu de notre site -->

            <!-- ===========================Le logo et le titre============================ -->
            <div class="row">
                <div class="col-md-12">
                    <h1><img src="/img/datastore-logo.png" id="gds-logo" /> PHP & <span class="hidden-xs">Google</span> Cloud Datastore</h1>
                </div>
            </div>
            <!-- ====================================================================== -->

            <!-- =====================La définition et le Dashboard===================== -->
            <div class="row">
                <div class="col-md-8">
                    <h2>What is it ?</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla est purus,<br> ultrices in porttitor
                    in, accumsan non quam. Nam consectetur porttitor rhoncus.<br> Curabitur eu est et leo feugiat
                    auctor vel quis lorem.</p>
                    <p>Ut et ligula dolor, sit amet consequat lorem. Aliquam porta eros sed
                    velit imperdiet egestas.</p>
                </div>
                <!-- ============== -->
                <div class="col-md-4" >
                <h3>Counter Of Gases not acceptable</h3>
                <div id="chart_div" style="width: 400px; height: 120px;">
                    <!-- <p><a href="https://github.com/YvonB/demo-mems-v1" target="_blank"><span aria-hidden="true" class="glyphicon glyphicon-new-window"></span> Pollution detection demo (Ce site web)</a></p> -->

                    <!-- Requêtes permetant d'obtenir les 10 dernières valeurs insérées -->
                    <?php

                    try
                    {
                    // On crée un objet de type Repository.
                    $obj_repo = new \GDS\Demo\Repository();
                    // Chercher tous les co2 insérées.
                    $arr_posts = $obj_repo->getAllRecentPost();

                    // au début 
                    $nbr_co2_na = 0;
                    $nbr_co_na = 0;
                    $nbr_nh3_na = 0;

                    // Tous les posts.
                    $nbr = count($arr_posts); // N
                    
                    // die();
                    foreach ($arr_posts as $obj_post) 
                    {
                        
                        // // tous les CO2 acceptables
                        // if($obj_post->co2 < 396)
                        // {   
                        //     $nbr_co2_a += 1; // si on est ici c'est qu'il des co2 acceptables, on icremente le nombre alors !
                        //     $co2_a = $obj_post->co2;
                            
                        // }
                        // else
                        if($obj_post->co2 >= 396)// tous les co2 qui dépasse ou égale à 396ppm
                        {   
                            $nbr_co2_na += 1; // si on est ici c'est qu'il y a des co2 non acceptables, on icremente le nombre $nbr_co2_na alors !
                            $n_co2 = $nbr_co2_na;
                            // $co2_na = $obj_post->co2;
                        }
                        if($obj_post->co >= 3) // tous les co qui dépasse ou égale à 3ppm
                            {
                                // si on est ici c'est qu'il y a des co non acceptables, on icremente le nombre $nbr_co_na alors !
                                $nbr_co_na += 1;
                                $n_co = $nbr_co_na;
                                // $co_na = $obj_post->co;
                            }
                        if($obj_post->nh3 >= 5) // tous les nh3 qui dépasse ou égale à 5ppm
                                {   
                                    // si on est ici c'est qu'il y a des nh3 non acceptables, on icremente le nombre $nbr_nh3_na alors !
                                    $nbr_nh3_na += 1;
                                    $n_nh3 = $nbr_nh3_na;
                                }
                        
                        
                        ?>
                    <!-- Fin requêtes -->
                    <?php 
                    }

                    // echo ' $nbr_co2_na = '.$n_co2.'<br>';
                    // echo ' $nbr_co_na = '.$n_co.'<br>';
                    // echo ' $nbr_nh3_na = '.$n_nh3.'<br>';
                    // //N
                    // echo $nbr;

                    //calculs des %
                    $pource_co2 = ($n_co2*100)/$nbr;
                    $pource_co = ($n_co*100)/$nbr;
                    $pource_nh3 = ($n_nh3*100)/$nbr;

                    // echo 'co2 na = '. $pource_co2 .' % <br>';
                    // echo 'co na = '. $pource_co .' % <br>';
                    // echo 'nh3 na = '. $pource_nh3 .' % <br>';

                    
                      
                            ?>

                                
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['gauge']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                            // des valeurs aléatoires au chargement de la page
                            var data = google.visualization.arrayToDataTable([
                              ['Label', 'Value'],                             
                              ['CO2', <?php echo rand(0, 100); ?>],
                              ['CO', <?php echo rand(0, 100); ?>],
                              ['NH3', <?php echo rand(0, 100); ?>]
                            ]);

                            var options = {
                              width: 400, height: 120,
                              redFrom: 90, redTo: 100,
                              yellowFrom:75, yellowTo: 90,
                              minorTicks: 10
                            };

                            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

                            chart.draw(data, options);

                            setInterval(function() {
                              data.setValue(0, 1, 0 + <?php echo $pource_co2; ?>);
                              chart.draw(data, options);
                            }, 4000);
                            setInterval(function() {
                              data.setValue(1, 1, 0 + <?php echo $pource_co; ?>);
                              chart.draw(data, options);
                            }, 4000);
                            setInterval(function() {
                              data.setValue(2, 1, 0 + <?php echo $pource_nh3; ?>);
                              chart.draw(data, options);
                            }, 4000);
                          }
                     
                        </script>
                        
                        <!-- actualisation automatique -->
                        <script type="text/javascript">
                        $(document).ready(function()
                            {   
                                $('#chart_div').load('main.php');
                                refresh();
                            });
                        function refresh() 
                        {   
                            setTimeout(
                                function()
                                {
                                   $('#chart_div').fadeOut('slow').load('main.php').fadeIn('slow');
                                   refresh();     
                                }, 3000
                                );
                        }
                        </script>
                        <!-- fin actu auto -->

                        <?php
                    }
                    catch(\Exception $obj_ex)
                    {
                        syslog(LOG_ERR, $obj_ex->getMessage());
                        echo '<em>Whoops, something went wrong!</em>';
                    }

                        ?>
                </div>
                </div>
            </div>
            <!-- ========================================================================== -->

            <!-- Le map -->
            <div>
                <h2>Where are our sensors?</h2>
                <div class="map" align="center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d963367.6427555117!2d46.800975397000194!3d-19.40571407254446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21fa8238a95a8965%3A0xe11f2e914a20ec99!2sEcole+Sup%C3%A9rieur+Polytechnique+d&#39;Antananarivo!5e0!3m2!1sfr!2sfr!4v1501594670727" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        <!-- =======================Pour visualiser les 10 derniéres résultats brutes ie en ppm ====================== -->
            <div class="row">
                <div class="col-md-8" >
                    <h2>Results</h2>
                    <div class="panel panel-default" id="vals_brutes" style="background-color: #D8D8D8;">
                        <div class="panel-body">
                            <?php
                                try 
                                    {   
                                        // On crée un objet de type Repository.
                                        $obj_repo = new \GDS\Demo\Repository();
                                        // Chercher les 10 dernières valeurs insérées
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
                                                    echo '<div class="gas">Taux de CO2: <strong>', htmlspecialchars($obj_post->co2),'</strong><em>cm³/m³</em>    ', '</div>';
                                                }
                                            if(isset($obj_post->co) AND !empty($obj_post->co))
                                                {
                                                    echo '<div class="gas">  |  Taux de CO: <strong>', htmlspecialchars($obj_post->co),'</strong><em>cm³/m³</em>    ', '</div>';
                                                }
                                            if(isset($obj_post->nh3) AND !empty($obj_post->nh3))
                                                {
                                                    echo '<div class="gas">  |  Taux de NH3: <strong>', htmlspecialchars($obj_post->nh3), '</strong><em>cm³/m³</em>    ', '<br><span class="time">', $str_date_display, '</span></div>';
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

            <!-- ==========================pour la courbe=========================== -->
            <!-- debut courbe brute -->
                
                
            <!-- ==========================fin courbe=============================== -->


            <!-- ===========================Espace connexion ============================== -->
            <div class="row">
                <div class="col-md-12">
                    <h2>See more content</h2>
                    <!-- <p>Dans ce cas, connectez-vous.</p> -->
                </div>
            </div> 
            <!-- ============= -->
            <div class="row">
                <div class="col-md-4" id="login_btn">
                    <div class="well">
                        <form method="POST" action="/login">
                            <button type="submit" class="btn btn-primary" align="center">
                                <?php 
                                    if(isset($user)) 
                                        {echo "Go Home<i class='fa fa-arrow-right' style='margin-left: 15px;'></i>";}
                                    else 
                                        {echo "Se Connecter";}
                                ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ========================================================================== -->

    </div> <!-- fin de container de la page --> 
       
    <!-- ******************************Footer*********************************** -->
        <footer>
            <!--footer-->
<footer class="footer1">
<div class="container">

<div class="row"><!-- row -->
            
                <div class="col-lg-3 col-md-3"><!-- widgets column left -->
                <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_nav_menu"><!-- widgets list -->
                    
                                <h1 class="title-widget">Useful links</h1>
                                
                                <ul>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i> About Us</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i> Contact Us</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i> Success Stories</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                </ul>
                    
                            </li>
                            
                        </ul>
                         
                      
                </div><!-- widgets column left end -->
                
                
                
                <div class="col-lg-3 col-md-3"><!-- widgets column left -->
            
                <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_nav_menu"><!-- widgets list -->
                    
                                <h1 class="title-widget">Useful links</h1>
                                
                                <ul>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                                    <li><a  href="#" target="_blank"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                                    
                                </ul>
                    
                            </li>
                            
                        </ul>
                         
                      
                </div><!-- widgets column left end -->
                
                
                
                <div class="col-lg-3 col-md-3"><!-- widgets column left -->
            
                <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_nav_menu"><!-- widgets list -->
                    
                                <h1 class="title-widget">Useful links</h1>
                                
                                <ul>


                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i>  LOREM IPSUM</a></li>

                                </ul>
                    
                            </li>
                            
                        </ul>
                         
                      
                </div><!-- widgets column left end -->
                
                
                <div class="col-lg-3 col-md-3"><!-- widgets column center -->
                
                   
                    
                        <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_recent_news"><!-- widgets list -->
                    
                                <h1 class="title-widget">Contact Detail </h1>
                                
                                <div class="footerp"> 
                                
                                <h2 class="title-median">Web Developper Junior</h2>
                                <p><b>Email id:</b> <a href="mailto:yvonbenahita@gmail.com">yvonbenahita@gmail.com</a></p>
                                <p><b>Helpline Numbers </b>

    <b style="color:#ffc106;">(8AM to 10PM):</b>  +91-8130890090, +91-8130190010  </p>
    
    <p><b>Corp Office / Postal Address</b></p>
    <p><b>Phone Numbers : </b>7042827160, </p>
    <p> 011-27568832, 9868387223</p>
                                </div>
                                
                                <div class="social-icons">
                                
                                    <ul class="nomargin">
                                    
                <a href="https://www.facebook.com/"><i class="fa fa-facebook-square fa-3x social-fb" id="social"></i></a>
                <a href="https://twitter.com/"><i class="fa fa-twitter-square fa-3x social-tw" id="social"></i></a>
                <a href="https://plus.google.com/"><i class="fa fa-google-plus-square fa-3x social-gp" id="social"></i></a>
                <a href="mailto:yvonbenahita@gmail.com"><i class="fa fa-envelope-square fa-3x social-em" id="social"></i></a>
                                    
                                    </ul>
                                </div>
                            </li>
                          </ul>
                       </div>
                </div>
</div>
</footer>
<!--header-->

<div class="footer-bottom">

    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="copyright">

                    © 2017, YY, All rights reserved

                </div>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="design">

                     <a href="https://github.com/YvonB">Yvon B | Web Developer</a>

                </div>

            </div>

        </div>

    </div>

</div>
        </footer> 
     

       <!--*********************************** Fin footer*************************** -->

       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    </body>

</html>