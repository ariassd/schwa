<?php
  require_once('service-oxford.php');
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);
  $word = NULL;  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Schwa Dictionary</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="statics/schwa.jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top nav-bar-bg">
        <a class="navbar-brand" href="">
          <i class="material-icons">translate</i>
          {&#601;} ʃwɑː
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!--<div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
        -->
      </nav>
    </header>
    
    <div class="container">
      
      <div class="row justify-content-md-center">
        <div class="col-md-2 col-lg-2 col-sm-1"></div>
        <div class="col-md-8 col-lg-8 col-sm-10">
          <h1>
            {&#601;} ʃwɑː dictionary
          </h1>
        </div>
        <div class="col-md-2 col-lg-2 col-sm-1"></div>
      </div>
      
      <div class="row justify-content-md-center">
        <div class="col-md-2 col-lg-2 col-sm-1"></div>
        <div class="col-md-8 col-lg-8 col-sm-10">
          <form method="POST">
        		<div class="form-group">
        			<!--<label for="text-search"></label>-->
        			<input type="text" class="form-control" id="text-search" name="text-search" aria-describedby="text-search-help" placeholder="Write a word here">
        			<small id="text-search-help" class="form-text text-muted"><i>Write a word in english and click search button</i></small>
        		</div>
            <div class="row">
              <div class="col-6">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
              </div>
              <div class="col-6">
                <button type="reset" class="btn btn-secondary btn-block">Clear</button>
              </div>
            </div>
        	</form>
        </div>
        <div class="col-md-2 col-lg-2 col-sm-1"></div>
      </div>
      <br/>
      <div class="row justify-content-md-center">
        <?php
          global $word;
          if (!empty($_POST["text-search"]))
          {
            $query = $_POST["text-search"];
            $word = GetWord($query);
            //echo $result->audio;
            //echo $word->phonetic;
          }
          if (!empty($_GET["word"]))
          {
            $query = $_GET["word"];
            $word = GetWord($query);
            //echo $result->audio;
            //echo $word->phonetic;
          }
          ?>
        <div class="col-md-2 col-lg-2 col-sm-1"></div>
          <div class="col-md-8 col-lg-8 col-sm-10">
            <?php if (isset($word) ) { ?>
            <div class="card bg-light mb-3" style="">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    
                    <h3><?php echo $word->word ?></h3>
                  </div>
                  <div class="col-1">
                    <?php if ( $word->status == "ok" && isset($word->audio) ) { ?>
                      <span class="material-icons pronounce-for-me"
                        onclick="document.getElementById('pronun').play()">volume_up</span>
                      <audio id="pronun">
                        <source src="<?php echo $word->audio ?>" type="audio/mpeg">
                        Your browser does not support audio.
                      </audio>
                    <?php }  ?>
                  </div>
                  <div class="col-5">
                    <?php if ( $word->status == "ok" ) { ?>
                      <h3><?php echo $word->phonetic ?></h3>
                    <?php }  ?>
                  </div>
                </div>
                
              </div>
              <div class="card-body">
                <?php if ( $word->status != "ok" ) {  
                  echo "Not results"; 
                } ?>
                <p class="card-text">
                  <?php if ( $word->status == "ok" ) { ?>
                    <?php foreach ($word->definitions as $def) { ?>
                      <img src="statics/flag-usa-icon.png" width='40px' />
                      <b><?php echo $def["definitions"][0] ?></b>
                      <p>
                        <?php if (isset($def["examples"])) { ?>
                            Examples:
                          <ul>
                            <?php foreach ($def["examples"] as $ex) { ?>
                            <li><?php echo $ex["text"] ?></li>
                            <?php } ?>
                          </ul>
                        <?php } ?>
                        <?php //var_dump($def["examples"]) ?>
                      </p>
                      <hr/>
                    <?php } ?>
                  <?php } ?>
                </p>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="col-md-2 col-lg-2 col-sm-1"></div>
      </div>
      <div class="row justify-content-md-center">
        <!-- Begin BidVertiser code -->
        <!--<SCRIPT data-cfasync="false" SRC="//bdv.bidvertiser.com/BidVertiser.dbm?pid=805269&bid=1937474" TYPE="text/javascript"></SCRIPT>-->
        <!-- End BidVertiser code --> 
      </div>
      
    </div>
    
    <br/>
    
    <br/>
    <br/>
    <br/>
    <footer class="footer">
      <div class="container  justify-content-md-center">
        Based on <a href="https://en.oxforddictionaries.com">Oxford dictionary</a> © 2018 Oxford University<br/>
        © 2018 Copyright <a href="http://luisarias.esy.es">Luis Arias</a> 
        <br/>
      </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118327270-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-118327270-1');
    </script>
  </body>
</html>


