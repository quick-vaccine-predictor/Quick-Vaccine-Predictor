<?php 
include "hlaTypeArray.php";
include("globals.inc.php");
print headerDBW("Queries");
print navbar('Queries');
?>
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
          <form method="GET" action="epitope.php">
            <div class="form-group">
              <label>Epitope ID </label>
              <input type="text" name="idEpitope" value="24" size="11" />
            </div>
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form>
          <div class="row" style="border-bottom: solid 1px"></div>
          <form method="GET" action="search.php">
            <label>HLA ID </label>
            <br>
            <select name="hla" multiple size="8">
              <?php
                foreach (array_keys($hlaTypeArray) as $idHlaType) {?>
                <option name="idHlaType[<?php print $idHlaType ?>]"><?php print $hlaTypeArray[$idHlaType]. "\n"?></option>
                <?php }
                ?>
            </select>
            <br>
            <button type="submit" class="btn btn-primary"> Submit </button>      
          </form>
          <div class="row" style="border-bottom: solid 1px"></div>
          <form method="GET"  action="search.php">
          <label>Organism </label>
            <div class="form-group">
              <b>ID </b>
              <input type="text" name="idOrganism" value="" size="20" minlength="4" maxlength="15"/> 
            </div>
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form> 
          <form method="GET"  action="search.php">
            <div class="form-group">
            <b>Name </b>
              <input type="text" name="nameOrganism" value="" rows="2" size="50" minlength="0" maxlength="100"/> 
            </div>
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form> 
          <div class="row" style="border-bottom: solid 1px"></div>
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
          <div class="row" style="border-bottom: solid 1px"></div>
          <form method="GET"  action="search.php">
          <label>Antigen ID </label>
            <div class="form-group">
              <b>ID </b>
              <input type="text" name="idAntigen" value="" rows="2" size="15" minlength="4" maxlength="30"/> 
            </div>
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form> 
          <form method="GET"  action="search.php">
            <div class="form-group">
            <b>Name </b>
              <input type="text" name="nameAntigen" value="" rows="2" size="50" minlength="0" maxlength="100"/> 
            </div>
            <button type="submit" class="btn btn-primary"> Submit </button>
          </form> 
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
    <script type="text/javascript">
      $("input[name=sequenceName]").focus(function() {
        $("input[name=idEpitope]").val('');
      });

      $("input[name=idEpitope]").focus(function() {
        $("input[name=sequenceName]").val('');
      });
    </script>
<?php print footerDBW();?>