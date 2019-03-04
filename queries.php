<?php 
include("globals.inc.php");
print headerDBW("Queries");
print navbar('Queries');
//$url = get_url();
//$_COOKIE['history'][] = $url;
?>

    <div class="container text-center">
      <!-- Main component for a primary marketing message or call to action -->
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#epitopeSearch">Epitope Search</a></li>
          <li><a data-toggle="tab" href="#idSearch">ID Search</a></li>
          <li><a data-toggle="tab" href="#proteosome">Proteosome</a></li>
      </ul>
      <div class="tab-content"> 
        <div id="epitopeSearch" class="tab-pane fade in active text-left">      
          <b> Please choose between Epitope Sequence or EPitope ID:</b>
          <form method="GET" name="sequenceForm" action="queryManager.php">
            <div class="form-group text-left">  
                <label>Epitope sequence </label>
                <input type="text" name="sequenceName" placeholder="ex:AADLTQIFE" size="11" minlength="9" maxlength="10"/> 
                <br>
                <label>Epitope ID </label>
                <input type="text" name="idEpitope" placeholder="ex:24" size="11" />  
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
           <div class="row">             
            <div class="text-left" >
              <form method="GET" action="epitope.php">
                <div class="form-group">
                  <label>Epitope ID </label>
                  <input type="text" name="idEpitope" placeholder="ex:24" size="11" required/>
                  <button type="submit" class="btn btn-primary"> Submit </button>
                </div>
              </form>
            </div>
            <div class="text-left">
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
                <button type="submit" class="btn btn-primary"> Submit </button>      
              </form>
            </div>
          </div>
          <hr class="featurette-divider">
          <div class="row text-left">  
            <div class="col-sm-4"> 
              <form method="GET"  action="organism.php">
              <label>Organism </label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idOrganism" placeholder="ex:11520" rows="2" cols="10" minlength="4" maxlength="15" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php" >
                <div class="form-group">
                <b>Name </b>
                  <input type="text" name="nameOrganism" placeholder="ex:Influenza B virus" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="protein.php">
              <label>Protein</label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idProtein" placeholder="ex:22164631" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET" action="queryManager.php">
                <div class="form-group">
                  <b>Name </b>
                  <input type="text" name="nameProtein" placeholder="ex:EVM026" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
            <div class="col-sm-4">
              <form method="GET"  action="antigen.php">
              <label>Antigen</label>
                <div class="form-group">
                  <b>ID </b>
                  <input type="text" name="idAntigen" placeholder="ex:2124409A" rows="2" cols="10" minlength="4" maxlength="30" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
              <form method="GET"  action="queryManager.php">
                <div class="form-group">
                <b>Name </b>
                  <input type="text" name="nameAntigen" placeholder="ex:RNA polymerase" rows="2" cols="10" minlength="0" maxlength="100" required/> 
                </div>
                <button type="submit" class="btn btn-primary"> Submit </button>
              </form> 
            </div>
          </div> 
          <button onClick="return clearData()" type="reset" name="clearData" value="Clear data" class="btn btn-primary">Clear data</button>

        </div> <!--id Search-->
                      
        <div id="proteosome" class="tab-pane fade">
          <form method="POST" name="proteosomeForm" action="proteosomeManager.php" enctype="multipart/form-data">
            <div class="form-group text-left">
              <label>Sequence in FASTA format</label>
              <textarea class="form-control" rows="5" value="" type="text" name="proteosomeText"></textarea>
              <input name="uploadFile" type="file"><br>
              <label>Or NCBI id: </label><input name="ncbiId" type="text"><br>
            </div>
            <div class="form-check text-left">
              <div class="radio">
                <label><input type="radio" checked name="in_dna" value="1">DNA/RNA</label>
              </div>
              <label>Minimal ORF length (nt): </label>
              <select name="orfminLength">
                <option value="30">30</option>
                <option value="75">75</option>
                <option value="150">150</option>
                <option value="300">300</option>
                <option value="600">600</option>
              </select><br>
              <label>Genetic code: </label>
              <select name="geneticTable">
                <option value="1">1. The Standard Code</option>
                <option value="2">2. The Vertebrate Mitochondrial Code</option>
                <option value="3">3. The Yeast Mitochondrial Code</option>
                <option value="4">4. The Mold, Protozoan, and Coelenterate Mitochondrial Code and the Mycoplasma/Spiroplasma Code</option>
                <option value="6">6. The Ciliate, Dasycladacean and Hexamita Nuclear Code</option>
                <option value="9">9. The Echinoderm and Flatworm Mitochondrial Code</option>
                <option value="10">10. The Euplotid Nuclear Code</option>
                <option selected value="11">11. The Bacterial, Archaeal, Plant Plastid and Viral Code</option>
                <option value="12">12. The Alternative Yeast Nuclear Code</option>
                <option value="13">13. The Ascidian Mitochondrial Code</option>
                <option value="14">14. The Alternative Flatworm Mitochondrial Code</option>
                <option value="16">16. Chlorophycean Mitochondrial Code</option>
                <option value="21">21. Trematode Mitochondrial Code</option>
                <option value="22">22. Scenedesmus obliquus Mitochondrial Code</option>
                <option value="23">23. Thraustochytrium Mitochondrial Code</option>
                <option value="24">24. Pterobranchia Mitochondrial Code</option>
                <option value="25">25. Candidate Division SR1 and Gracilibacteria Code</option>
                <option value="26">26. Pachysolen tannophilus Nuclear Code</option>
                <option value="27">27. Karyorelict Nuclear Code</option>
                <option value="28">28. Condylostoma Nuclear Code</option>
                <option value="29">29. Mesodinium Nuclear Code</option>
                <option value="30">30. Peritrich Nuclear Code</option>
                <option value="31">31. Blastocrithidia Nuclear Code</option>
                <option value="33">33. Cephalodiscidae Mitochondrial UAA-Tyr Code</option>
              </select>
              <div class="radio">
                <label><input type="radio" name="in_dna" value="0">Protein</label>
              </div>
              <label>Epitope length: </label><br>
              <div class="radio">
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