<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Authors" content="Altair Chinchilla, Natalia Segura, Pau Badia i Mompel"> 
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="Quick Vaccine Predictor" content="">
    <meta name="QVP" content="">
    <link rel="icon" href="">

    <title>Quick Vaccine Predictor</title>

    <!-- Minified Bootstrap 3 CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!--Minified jQuery 3 JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--Latest Bootstrap 3 JS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src=https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>

  </head>

  <body>
    <?php include "hlaTypeArray.php" ?>
    

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">QVP</a>
        </div>
        <div id="myNavbar" class="navbar-collapse collapse" >
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="myvaccine.html">MyVaccine</a></li>
            <li class="active"><a href="#">Queries</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="signin.html"> Sign Up</a></li>
            <li><a href="login.html"> Login</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container text-center">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
        <div class="col-sm-4">
          <p>Sequence form</p>
          <form method="GET" name="sequenceForm" action="search.php">
            <div class="form-group">
              <label>Sequence </label>
              <input type="text" name="sequenceName" value="" size="11" minlength="9" maxlength="10"/> 
            </div>
            <div class="form-group">
              <label>HLA</label>
              <div class="form-check">
                <?php
                  foreach (array_keys($hlaTypeArray) as $idHlaType) {?>
                    <table>
                    <td><input class="form-check-input" type="checkbox" checked name="idHlaType[<?php print $idHlaType ?>]"/> <?php print $hlaTypeArray[$idHlaType]. "\n"?></td>
                  <?php }
                ?>
                    </table>
              </div>
            </div>  
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form>
        </div>
        <div class="col-sm-4">
          <p>Epitope ID search</p>
          <form method="GET" name="idForm" action="epitope.php">
          <div class="form-group">
            <label>Sequence </label>
            <input type="text" name="idEpitope" value="24" size="11" />
          </div>
          <button type="submit" class="btn btn-primary"> Submit </button>
        </form>
        </div>      
        <div class="col-sm-4">
          <p>Proteosome</p>
          <form method="POST" name="proteosomeForm" action="proteosome.php">
            <div class="form-group">
              <label>Sequence </label>
              <textarea class="form-control" rows="5" value="" type="text" name="proteosomeText"></textarea>
            </div>
            <div class="form-check">
              <div class="radio">
              <label><input type="radio" checked name="in_dna" value="1">DNA</label>
              </div>
              <div class="radio">
              <label><input type="radio" name="in_dna" value="0">Protein</label>
              </div>
              <div class="radio">
              <p>Word length</p>
              <label><input type="radio" checked name="length" value="0">9</label>
              </div>
              <div class="radio">
              <label><input type="radio" name="length" value="1">10</label>
              </div>
              <div class="radio">
              <label><input type="radio" name="length" value="2">Both</label>
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </div>
          </form>
        </div>
        <p>HLA ID search</p>
          <form method="GET" name="idForm" action="hla.php">
          <div class="form-group">
            <label>Sequence </label>
            <input type="text" name="idHLA" value="HLA00001" size="11" />
          </div>
          <button type="submit" class="btn btn-primary"> Submit </button>
        </form>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="css/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="css/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="css/ie10-viewport-bug-workaround.js"></script>
  

</body></html>