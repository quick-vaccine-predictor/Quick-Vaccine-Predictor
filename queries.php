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
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#epitopeSearch">Epitope Search</a></li>
          <li><a data-toggle="tab" href="#idSearch">ID Search</a></li>
          <li><a data-toggle="tab" href="#genomeSearch">Genome</a></li>
      </ul>
      <div class="tab-content"> 
        <div id="epitopeSearch" class="tab-pane fade in active">      
          <b>EPITOPE SEARCH</b>
          <form method="GET" name="sequenceForm" action="search.php">
            <div class="form-group">  
                <label>Epitope sequence </label>
                <input type="text" name="sequenceName" value="" size="11" minlength="9" maxlength="10"/> 
                <br>
                <label>Epitope ID </label>
                <input type="text" name="idEpitope" value="24" size="11" />  
              </div> 
            <div class="form-group">
              <label>HLA selection:</label> <br>
              <select name="hla" multiple size="8">
                      <?php
                      foreach (array_keys($hlaTypeArray) as $idHlaType) {?>
                      <option selected name="idHlaType[<?php print $idHlaType ?>]"><?php print $hlaTypeArray[$idHlaType]. "\n"?></option>
                      <?php }
                      ?>
              </select>
            </div>
            <div class="form-group">
              <p>
                <label>Threshold for strong binder (nMAff) </label>
                <input type="text" name="sbaff" value="0.5" size="5"/>
                <label>Threshold for strong binder (logAff)</label>
                <input type="text" name="sblog" value="50" size="5"/>
              </p>        
              <p>
                <label>Threshold for weak binder (nMAff)</label>
                <input type="text" name="wbaff" value="2" size="5"/> 
                <label>Threshold for weak binder (logAff)</label>
                <input type="text" name="wblog" value="500" size="5"/> 
              </p>
            </div>  
            <button type="submit" class="btn btn-primary"> Submit </button>
            <button type="reset" value="Clear data" class="btn btn-primary">Clear data</button>
          </form>
        </div> <!--epitope search-->

        <div id="idSearch" class="tab-pane fade">
          <b>ID SEARCH</b>
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#idEpitope">Epitope</a></li>
            <li><a data-toggle="tab" href="#hla">HLA</a></li>
            <li><a data-toggle="tab" href="#organism">Organism</a></li>
            <li><a data-toggle="tab" href="#protein">Protein</a></li>
            <li><a data-toggle="tab" href="#antigen">Antigen</a></li>
        </ul>
        <div class="tab-content"> 
          <div id="idEpitope" class="tab-pane fade in active">      
            <form method="GET" action="epitope.php">
              <div class="form-group">
                <label>Epitope ID </label>
                <input type="text" name="idEpitope" value="24" size="11" />
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form>
          </div>
          <div id="hla" class="tab-pane fade">
            <form method="GET" action="search.php">
            <label>HLA</label><br>
              <select name="hla" multiple size="8">
                <?php
                  foreach (array_keys($hlaTypeArray) as $idHlaType) {?>
                  <option name="idHlaType[<?php print $idHlaType ?>]"><?php print $hlaTypeArray[$idHlaType]. "\n"?></option>
                  <?php }
                  ?>
              </select><br>
              <button type="submit" class="btn btn-primary"> Submit </button>      
            </form>
            </div>
          <div id="organism" class="tab-pane fade">
            <form method="GET" action="search.php">
            <label>Organism </label>
              <div class="form-group">
              <b>ID </b>
                <input type="text" name="idOrganism" value="" size="20" minlength="4" maxlength="15"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
            <form method="GET" action="search.php">
              <div class="form-group">
              <b>Name </b>
                <input type="text" name="nameOrganism" value="" rows="2" size="50" minlength="0" maxlength="100"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
          </div>
          <div id="protein" class="tab-pane fade">
            <form method="GET"  action="search.php">
            <label>Protein</label>
              <div class="form-group">
              <b>ID </b>
                <input type="text" name="idProtein" value="" rows="2" size="15" minlength="4" maxlength="30"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
            <form method="GET" action="search.php">
              <div class="form-group">
              <b>Name </b>
                <input type="text" name="nameProtein" value="" rows="2" size="50" minlength="0" maxlength="100"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
          </div>
          <div id="antigen" class="tab-pane fade">
            <form method="GET" action="search.php">
            <label>Antigen ID </label>

              <div class="form-group">
              <b>ID </b>
                <input type="text" name="idAntigen" value="" rows="2" size="15" minlength="4" maxlength="30"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
            <form method="GET" action="search.php">
              <div class="form-group">
              <b>Name </b>
                <input type="text" name="nameAntigen" value="" rows="2" size="50" minlength="0" maxlength="100"/> 
              </div>
              <button type="submit" class="btn btn-primary"> Submit </button>
            </form> 
          </div>
        </div> <!--id Search-->
        
        <div id="genomeSearch" class="tab-pane fade">
          <b>GENOME</b>
          <form method="POST" name="proteosomeForm" action="proteosome.php">
            <div class="form-group">
              <label>Whole viral Genome Sequence </label>
              <textarea class="form-control" rows="5" value="" type="text" name="proteosomeText"></textarea>
              <input name="uploadFile" type="file"><br>
            </div>
            <div class="form-check">
              <div class="radio">
                <label><input type="radio" name="in_dna" value="2">RNA</label>
              </div>
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
              <button type="reset" value="Clear data" class="btn btn-primary">Clear data</button>
            </div>
          </form>
        </div> <!---genomeSearch-->
      </div> <!--tab-content--->
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="css/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="css/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="css/ie10-viewport-bug-workaround.js"></script>
    <!-- to write or epitope sequence or ID, not both -->
    <script type="text/javascript">
      $("input[name=sequenceName]").focus(function() {
        $("input[name=idEpitope]").val('');
      });

      $("input[name=idEpitope]").focus(function() {
        $("input[name=sequenceName]").val('');
      });
    </script>
  

</body></html>