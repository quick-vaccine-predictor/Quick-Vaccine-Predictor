<?php 
include("globals.inc.php");
print headerDBW("Queries");
print navbar('Queries');


$url = get_url();
$_COOKIE['history'][] = $url;
  
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
           
          <a href="#" data-toggle="tooltip" data-placement="top" title="Limit search results by epitope id or sequence "><b>EPITOPE SEARCH</b></a>
          <br>
          <b> Please choose between Epitope Sequence or Epitope ID:</b>
          <form method="GET" name="sequenceForm" action="queryManager.php">
            <div class="form-group">  
                <label>Epitope sequence: </label>
                <input type="text" name="sequenceName" value="" size="11" minlength="9" maxlength="10"/> 
                <a href="#" data-toggle="tooltip" data-placement="top" title="The epitope sequence must be between 9 and 10 aminoacids.">?</a>
                <br>
                <label>Epitope ID: </label>
                <input type="text" name="idEpitope" value="24" size="11" />  
                <a href="#" data-toggle="tooltip" data-placement="top" title="ID from IEDB.">?</a>

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
              <b>Threshold settings: 
              <a href="#" data-toggle="tooltip" data-placement="top" title="Two different types of thresholds can be set: based on the binding affinity giving in nM IC50 values or based on % Rank obtained using the method on 200.000 random natural peptides.">?</a>
              </b>
              <p>
                <label>Threshold for strong binder (nMAff): </label>
                <input type="text" name="sbaff" value="0.5" size="5" required/>
                <a href="#" data-toggle="tooltip" data-placement="top" title="The peptide will be identified as a strong binder if the binding affinity (IC50) is below the specified threshold for the strong binders.">?</a>
                <label>Threshold for strong binder (logAff):</label>
                <input type="text" name="sblog" value="50" size="5" required/>
                <a href="#" data-toggle="tooltip" data-placement="top" title="The peptide will be identified as a strong binder if the % Rank is below the specified threshold for the strong binders.">?</a>
              </p>        
              <p>
                <label>Threshold for weak binder (nMAff):</label>
                <input type="text" name="wbaff" value="2" size="5"required/> 
                <a href="#" data-toggle="tooltip" data-placement="top" title="The peptide will be identified as a weak binder if the binding affinity (IC50) is above the threshold of the strong binders but below the specified threshold for the weak binders.">?</a>
                <label>Threshold for weak binder (logAff):</label>
                <input type="text" name="wblog" value="500" size="5" required/> 
                <a href="#" data-toggle="tooltip" data-placement="top" title="The peptide will be identified as a weak binder if the % Rank is above the threshold of the strong binders but below the specified threshold for the weak binders.">?</a>
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
                  <label>Epitope ID: </label>
                  <input type="text" name="idEpitope" value="24" size="11" required/>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="ID from IEDB.">?</a>
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
              <a href="#" data-toggle="tooltip" data-placement="top" title="Limit the search results by the epitope's source organism.">?</a>
                <div class="form-group">
                  <b>ID:</b>
                  <input type="text" name="idOrganism" value="" rows="2" cols="10" minlength="4" maxlength="15" required/> 
                  <a href="#" data-toggle="tooltip" data-placement="top" title="ID's from the NCBI taxonomy database.">?</a>
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php" >
                <div class="form-group">
                <b>Name:</b>
                  <input type="text" name="nameOrganism" value="cat" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="protein.php">
              <label>Protein</label>
                <div class="form-group">
                  <b>ID:</b>
                  <input type="text" name="idProtein" value="" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                  <a href="#" data-toggle="tooltip" data-placement="top" title="ID's from the NCBI database.">?</a>
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET" action="queryManager.php">
                <div class="form-group">
                  <b>Name:</b>
                  <input type="text" name="nameProtein" value="" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="antigen.php">
              <label>Antigen</label>
              <a href="#" data-toggle="tooltip" data-placement="top" title="Limit the search results by the epitope's source antigen">?</a>
                <div class="form-group">
                  <b>ID:</b>
                  <input type="text" name="idAntigen" value="" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                  <a href="#" data-toggle="tooltip" data-placement="top" title="ID's from the NCBI database.">?</a>
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php">
                <div class="form-group">
                <b>Name:</b>
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
          <form method="POST" name="proteosomeForm" action="proteosomeManager.php" enctype="multipart/form-data">
            <div class="form-group">
              <label>Proteosome simulator</label>
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
            <div>
              <label>Start Codon </label>
              <select name="startCodons[]" multiple="">
                <option selected value="0">ATG/AUG</option>
                <option value="1">CTG/CUG</option>
                <option value="2">TTG/UUG</option>
              </select>
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
