<?php 
include("globals.inc.php");
print headerDBW("Queries");
print navbar('Queries');


?>

    <div class="container text-center">
      <!-- Main component for a primary marketing message or call to action -->
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#epitopeSearch">Epitope Search</a></li>
          <li><a data-toggle="tab" href="#idSearch">ID Search</a></li>
          <li><a data-toggle="tab" href="#proteosome">Proteosome</a></li>
      </ul>
      <div class="tab-content"> 
        <div id="epitopeSearch" class="tab-pane fade in active">      
          <b>EPITOPE SEARCH</b> <br>
          <b> Please choose between Epitope Sequence or EPitope ID:</b>
          <form method="GET" name="sequenceForm" action="queryManager.php">
            <div class="form-group">  
                <label>Epitope sequence </label>
                <input type="text" name="sequenceName" value="" size="11" minlength="9" maxlength="10"/> 
                <br>
                <label>Epitope ID </label>
                <input type="text" name="idEpitope" value="24" size="11" />  
              </div> 
            <div class="form-group">
              <label>HLA selection:</label> <br>
              <select name="hla[]" multiple size="8">
                      <?php
                      $conn = connectSQL();
                      $sql = "SELECT idHLA, nameHLA from HLA;";
                      $hlaTable = $conn->query($sql);
                      $conn->close();
                      foreach ($hlaTable as $hlarow) {
                          $idHLA = $hlarow["idHLA"];
                          $nameHLA = $hlarow["nameHLA"];
                        ?>
                      <option selected value="<?php print $idHLA ?>"><?php print $nameHLA. "\n"?></option>
                      <?php }
                      ?>
              </select>
            </div>
            <div class="form-group">
              <p>
                <label>Threshold for strong binder (nMAff) </label>
                <input type="text" name="sbaff" value="0.5" size="5" required/>
                <label>Threshold for strong binder (logAff)</label>
                <input type="text" name="sblog" value="50" size="5" required/>
              </p>        
              <p>
                <label>Threshold for weak binder (nMAff)</label>
                <input type="text" name="wbaff" value="2" size="5"required/> 
                <label>Threshold for weak binder (logAff)</label>
                <input type="text" name="wblog" value="500" size="5" required/> 
              </p>
            </div>  
            <button type="submit" class="btn btn-primary"> Submit </button>
            <button type="reset" value="Clear data" class="btn btn-primary">Clear data</button>
          </form>
        </div> <!--epitope search-->

        <div id="idSearch" class="tab-pane fade">
          <b>ID SEARCH</b>
           <div class="row">             
            <div class="col-sm-6" >
              <form method="GET" action="epitope.php">
                <div class="form-group">
                  <label>Epitope ID </label>
                  <input type="text" name="idEpitope" value="24" size="11" required/>
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form>
            </div>
            <div class="col-sm-6">
              <form method="GET" action="hla.php">
                <label>HLA ID </label>
                <br>
                <select name="idHLA" size="8">
                  <?php
                      foreach ($hlaTable as $hlarow) {
                          $idHLA = $hlarow["idHLA"];
                          $nameHLA = $hlarow["nameHLA"];
                    ?>
                    <option value="<?php print $idHLA ?>"><?php print $nameHLA. "\n"?></option>
                    <?php }
                    ?>
                </select>
                <br>
                <button type="submit" class="btn btn-primary"> Submit </button>      
              </form>
            </div>
          </div>

          <div class="row">  
            <div class="col-sm-4"> 
              <form method="GET"  action="organism.php">
              <label>Organism </label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idOrganism" value="" rows="2" cols="10" minlength="4" maxlength="15" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php" >
                <div class="form-group">
                <b>Name </b>
                  <input type="text" name="nameOrganism" value="cat" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="protein.php">
              <label>Protein</label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idProtein" value="" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET" action="queryManager.php">
                <div class="form-group">
                  <b>Name </b>
                  <input type="text" name="nameProtein" value="" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="antigen.php">
              <label>Antigen</label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idAntigen" value="" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php">
                <div class="form-group">
                <b>Name </b>
                  <input type="text" name="nameAntigen" value="" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
          </div> 
          <button onClick="return clearData()" type="reset" name="clearData" value="Clear data" class="btn btn-primary">Clear data</button>

        </div> <!--id Search-->
                      
        <div id="proteosome" class="tab-pane fade">
          <b>Proteosome</b>
          <form method="POST" name="proteosomeForm" action="proteosome.php">
            <div class="form-group">
              <label>Proteosome simulator</label>
              <textarea class="form-control" rows="5" value="" type="text" name="proteosomeText" required></textarea>
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
        </div>
      </div> <!--tab-content--->
    </div> <!-- /container -->
    <script type="text/javascript">
      $("input[name=sequenceName]").focus(function() {
        $("input[name=idEpitope]").val('');
      });

      $("input[name=idEpitope]").focus(function() {
        $("input[name=sequenceName]").val('');
      });
    </script>
    <!--script to clear all ID search formas at once -->
    <script>

    </script>
    <script type="text/javascript">
    function clearData() {
      $("input[name=idEpitope]").val("");
      $("input[name=idOrganism]").val("");
      $("input[name=nameOrganism]").val("");
      $("input[name=idProtein]").val("");      
      $("input[name=nameProtein]").val("");
      $("input[name=idAntigen]").val("");
      $("input[name=nameAntigen]").val("");
      $("select").val(""); 
    }
    </script>
<?php print footerDBW();?>
