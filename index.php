<?php
include("globals.inc.php");
print headerDBW("QVVP");

print navbar('Home');
?>
    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div style="color:darkblue">
          <h1>Welcome to Quick Vaccine Predictor</h1>
        </div>  
          <p> The <abbr title="Quick Vaccine Predictor">QVP</abbr> is a public application designed to help speed up the generation of new vaccines. 
              It is a student's project from the Mc in Bioinformatics in Health Science from Universitat Pompeu Fabra (UPF).
              QVP contains a database with information of more than 41.000 viral epitopes from IEDB. Furthermore, it contains
              already calculated binding simulations for each epitope using netMHCcons, a reliable binding prediction software
          </p>
          <p></p>
      </div>

    </div> <!-- /container -->
    <div class="container marketing">
    <div class="row">
        
          <div class="col-lg-4">
            <img class="rounded-circle" src="png/altair.jpeg" width="140" height="140">
            <h2>Altair Chinchilla</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw27/" target="_blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="png/natalia.jpeg" width="140" height="140">
            <h2>Natàlia Segura</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw12/" target="_blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="png/pau.jpg" width="140" height="140">
            <h2>Pau Badia i Mompel</h2>
            <p></p>
            <p><a class="btn btn-secondary" href="http://mmb.irbbarcelona.org/formacio/~dbw13/" target="blank" role="button">Go to page &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
      </div>
      
<?php print footerDBW();?>
