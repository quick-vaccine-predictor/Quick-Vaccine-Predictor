<?php
include("globals.inc.php");
print headerDBW("QVVP");
print navbar('Home');
?>
    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron text-justify" style="background:transparent !important">
        <div>
          <h1>Welcome to Quick Vaccine Predictor</h1>
        </div>  
          <p>QVVP is a public application designed to help speed up the generation of new viral vaccines. 
              It is a student's project from the Mc in Bioinformatics in Health Science from Universitat Pompeu Fabra (UPF).
              QVP contains a database with information of more than 41.000 viral epitopes from IEDB. Furthermore, it contains
              already calculated binding simulations for each epitope using netMHCcons, a reliable binding prediction software from DTU Bioinformatics (Denmark).
          </p>
          <p></p>
      </div>
      <hr class="featurette-divider">
      <br>
    </div> <!-- /container -->

    <div class="row jumbotron" style="background:transparent !important">
        <h2 class="featurette-heading">The concept. <span class="text-muted">How can we speed up vaccine production?</span></h2>
        <p class="lead">The problem with vaccine design is that, for each new viral protein there can be L - k + 1 potentialy useful epitopes (where L is the length of the protein and k the length of the epitope). Thus, in a simple protein of 500 aa and with epitopes of 9 aa, 492 epitopes should be tested in assays to determine if they could be used in a vaccine.</p>
        <div class ='text-center'>
        <img class="img-rounded img-responsive center-block" src="png/qvvp_idea.png" width="500"><br><br>
        </div>
        <p class="lead">To speed this expensive and time consuming process, we selected all viral epitopes of 9 and 10 aa from IEDB which we then performed time-consuming computer simulations of epitope binding and finally stored the results in our database.<br>
        With this novel data, researchers can perform several queries to determine which epitopes show more potential to perform in a vaccine.</p>
    </div>

    <hr class="featurette-divider">

        <div class="container marketing">
    <div class="row">
          <h2 class="text-center">Authors</h2>
          <br>
          <div class="col-lg-4 text-center">
            <img class="img-circle" src="png/altair.jpeg" width="140" height="140">
            <h2>Altair Chinchilla</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw27/" target="_blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 text-center">
            <img class="img-circle" src="png/natalia.jpeg" width="140" height="140">
            <h2>Natàlia Segura</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw12/" target="_blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 text-center">
            <img class="img-circle" src="png/pau.jpg" width="140" height="140">
            <h2>Pau Badia i Mompel</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw13/" target="blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div>

<?php print footerDBW();?>