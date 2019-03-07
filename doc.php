<?php
include("globals.inc.php");
$title = "About";
print headerDBW($title);
//Conection to the DB if needed
//$conn = connectSQL();
//$conn->close();
print navbar('About');
?>

<div class="container text-left">
	<h2 class="text-center"><b>Documentation</b></h2>
		<br>
	<div class="container text-justify">
		<h3><b>Index</b></h3>
		<br><br>
		<ul style="list-style-type:none;">
			<li><h4><a href="#C1"><b>1. Introduction</b></a></h4></li>
			<ul style="list-style-type:none;">
				<li><h4><a href="#C11"><b> App Scope</b></a></h4></li>
			</ul>
			<li><h4><a href="#C2"><b>2. Data</b></a></h4></li>
			<ul style="list-style-type:none;">
				<li><h4><a href="#C21"><b>HLA & Epitope aquirement: IEDB</b></a></h4></li>
				<li><h4><a href="#C22"><b>Prediction: NetMHCcons </b></a></h4></li>
				<li><h4><a href="#C23"><b>Process & Filter Result Data</b></a></h4></li>
				<li><h4><a href="#C24"><b>Database and Data Model</b></a></h4></li>
			</ul>
			<li><h4><a href="#C3"><b>3. QVVP In Action</b></a></h4></li>
            <ul style="list-style-type:none;">
				<li><h4><a href="#C31"><b>3.1. Epitope Search</b></a></h4></li>
                <ul style="list-style-type:none;">
				    <li><h5><a href="#C311"><b>Epitope sequence or ID</b></a></h5></li>
				    <li><h5><a href="#C312"><b>HLA </b></a></h5></li>
				    <li><h5><a href="#C313"><b>Threshold parameters</b></a></h5></li>
			    </ul>
				<li><h4><a href="#C32"><b>3.2. ID Search </b></a></h4></li>
                <ul style="list-style-type:none;">
				    <li><h5><a href="#C321"><b>Epitope ID</b></a></h5></li>
				    <li><h5><a href="#C322"><b>HLA </b></a></h5></li>
				    <li><h5><a href="#C323"><b>Organism</b></a></h5></li>
                    <li><h5><a href="#C324"><b>Protein</b></a></h5></li>
				    <li><h5><a href="#C325"><b>Antigen</b></a></h5></li>
			    </ul>
				<li><h4><a href="#C33"><b>3.3. Proteosome</b></a></h4></li>
			</ul>
            <li><h4><a href="#C4"><b>4. History</b></a></h4></li>
		</ul>
	</div>
	<div class="container text-left">
		<h3 id="C1"><b>1. Introduction</b></h3>
		<div class="container text-justify">
			<h4 id="C11"><b> App Scope </b></h4> 
			<p>
			The main scope oh this web application is to develope a viral vaccine generator based in the 
			viral epitope data extracted from the IEDB (Immune Epitope Database And Analysis Resuource). 
			Taking advantage from the NetMHCcons peptide-binding predictor to MHC-I molecules we create a
			database of more than 41.000 viral epitopes and the binding affinity prediction to each of the 
			HLA (Human Leukocyte Antigen) alelles present in the IEDB database, allowing to researchers who
			wants to build a vaccine <i>de novo</i> to check which epitope could bind with more affinity to a given 
			HLA alelle.</p>
			<p>
			On the following documentation we briefly explain how our website works.
			</p>
		</div>

		<hr>
		
		<h3 id="C2"><b>2. Data</b></h3>
		<div class="container text-justify">
			<h4 id="C21"><b>HLA & Epitope aquirement: IEDB</b></h4>

			<p> 
				IEDB is the <a href="https://www.iedb.org/" target="_blank">Immune Epitope Database</a> that freely provide information about anitbody and T cell epitopes based in experimental data, as well as immunoassay tools to assist in the prediction 
				and analysis of epitopes. Within these tools, the T Cell Epitope - MHC binding prediction can
				foretell IC50 values for peptides binding to specific MHC molecules. 
			</p>
			<p>
				Besides, the predictor can determine, among other options, the ability of an aminoacid subsequence 
				to bind to a specific MHC class I molecule, using a large collection of the most common human HLA alleles, 
				specifically 27 HLA alleles (<a href="https://help.iedb.org/hc/en-us/articles/114094151851-HLA-allele-frequencies-and-reference-sets-with-maximal-population-coverage" target="_blank">Click
				here fore more information</a>). In order to predict these specific interactions, IEDB has different softwares
				based on Artificial Neural Networks or Stabilized Matrix methods, among others, and a set of libraries that, 
				based in a very large amount of data produce a very accurate results.
			</p>
			<p>
				However, although predictions can be made in a very easy way, the required time to obtain binding affinities between
				a large collection of epitopes (as can be all curated viral epitopes) and the most common HLA molecules can take a lot
				of time. 
			</p>
			<p>
				Taking into account this premise, in this project we performed a serie of predictions between a lage set
				of viral epitopes and HLA molecules with the purpose of generate a useful database that can serve to generate vaccines
				based in these specific interaction data.   
			</p>
		</div>
		<div class="container text-justify">
			<h4 id="C22"><b> Prediction: NetMHCcons </b></h4>
			<p>
				Taking advantage of the tools offered by IEDB, we proceed to download a collection of almost 41.300 viral epitopes and the set of 27 HLA allels, with the aim of persue a set of binding predictions between these two molecules. In order to do so, we use the free binding predictor method <a href="http://www.cbs.dtu.dk/services/NetMHCcons/" target="_blank">NetMHCcons</a>. This consensus method for MHC I predictions integrate three softwares to give more accurate predictions:
				NetMHC and NetMHCpan, that are artificial neural network methods allele-specific and based in more than 115,000 quantitative binding data; and PickPocket method based on receptor-pocket similarities between MHC molecules. Also, NetMHCcons server can produce predictions for peptides of 8-15 aminoacids in length, for which we made predictions 
				only for epitopes of 9 or 10 aminoacid length.
			</p>
			<p>
				Predictions benckmarks were around 180 - 200 minutes for HLA - Epitope interactions with 9 aminoacid of length, and 
				150 - 180 minutes for epitoes with 10 aminoacid of length. Results where obtained in a prediction output table, as the
				following:
			</p>
			<br><br><br>
					
					<div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
					        <img src="png/out_HLA_example.png" alt="output-example" style="width:600px;height:500px">
					          <div class="caption">
					            <h4><b>Figure 1</b>.MHC-I Binding Prediction Results:</h4>
					            <p>
					            	Each row corresponds to one epitope binding prediction. The columns contain the <b>allele</b> the prediction was made for, the <b>epitope sequence</b>, the identity number for this sequence, two columns refered to the <b>affinity</b>(Prediction score called 1-log50k and IC50 value in nM), the <b>percentile rank of prediction score</b> and the <b>Binding Level(SB=> Strong Binder / WB=> Weak Binder</b> for each interactions. The epitope will be identified as a SB or WB if the % Rank OR binding affinity (IC50) is above or below the specified threshold for the strong binders and weak binders based in the IC50 and %Rank. 
					            </p>
					          </div>
					      </div>
					    </div>
				</div>
					
				<br><br>
		</div>
		<div class="container text-justify">
			<h4 id="C23"><b> Process & Filter Result Data</b></h4>	
			<p>
				Once the data was obtained in the output shown above, we proceed to filter only those characteristics of the binding 
				we were interested in. In the following image it can be seen the final data that compose the <b>Affinity table</b> of our database:
			</p>
			<br><br>
					<div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
					        <img src="png/filter_data.png" alt="filtered_data_affinity" style="width:320px;height:300px">
					          <div class="caption">
					            <h4><b>Figure 2</b></h4><h4>MHC-I Binding Prediction Filtered Results:</h4>
					            <p> In this case the output results are organized in four columns. As before, each row corresponds to one epitope binding prediction. The columns contain the <b>Epitope Id from the IEDB</b>, the <b>HLA type molecule</b>, the <b>Prediction Score</b> in a logarithmic scale and the <b>Affinity</b>, that represents the IC50 value in nM.
					            </p>
					          </div>
					      </div>
					    </div>
					<div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
					        <img src="png/affinity_sql.png" alt="affinity_table" style="width:400px;height:300px">
					          <div class="caption">
					            <h4><b>Figure 3</b></h4><h4>Affinity Table in Database(MySQL)</h4>
					            <p> This is the final table of the Affinity table in the Database. It can be seen that it follows the
					            	same structure as the filtered output shown in the <b>Figure 2</b>. 
					            </p>
					            <br><br>
					          </div>
					      </div>
					    </div>
					</div>
				</div>
			<p id="Fig5">
				In the same way we filtered the data related to the <b>Antigen</b> and <b>Epitope </b> that was also
				extracted from the IEDB. 
			</p>
			<br>
					<div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
					        <img src="png/antigen_db.png" alt="antigen_table" style="width:700px;height:300px">
					          <div class="caption">
					            <h4><b>Figure 4</b>.Antigen table in Database(MySQL)</h4>
					            <p> 				            	
					            </p>
					          </div>
					      </div>
					    </div>
					<div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
					        <img src="png/epitope_db.png" alt="epitope_table" style="width:600px;height:300px">
					          <div class="caption">
					            <h4><b>Figure 5</b>.Epitope Table in Database(MySQL)</h4>
					            <p> 
					            </p>
					          </div>
					      </div>
					    </div>
					</div>
				</div>
			<p>

				Once the data was correctly filtered we proceed to build the data model of our database, that whould allow us 
				build a broad set of query searches with tha last scope of build a vaccine.
			</p>
		</div>
		<div class="container text-justify">
			<h4 id="C24"><b> Database and Data Model</b></h4>
			<br>	
			<p>
				We used MySQL Workbench in order to build our <b>Data Model</b>, it is, the structure of our database organized 
				in tables.
			</p>
				<div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
					        <img src="png/data_model.png" alt="data model" style="width:600px;height:500px">
					          <div class="caption">
					            <h4><b>Figure 6</b>.Data Model(MySQL WorkBench)</h4>
					            <p> 
					            	As it can be seen in this data model, the main tables are situated in the middle (<b>Antigen</b>, <b>Epitope</b>, <b>Affinity</b> and <b>HLA</b>). All the data downloaded from IEDB and filtered was uploaded to this database with SQL queries.
					            </p>
					          </div>
					      </div>
					    </div>
				</div>		
			<p>
				Finally, we checked that all these tables were correctly linked with the correct foreign keys.
			</p>
		</div>
		<br><br>

		<hr>

		<h3 id="C3"><b>3. QVVP In Action</b></h3>	
        <div class="container text-justify">
		<p>
			This website is designed in order to be intuitive and self-guied. This field is dedicated to explain how to 
			get around in all the different tools.

            From here, users can perform three different queries: <br>
            1.<a href="#C31"><b>Epitope Search</b></a>. Epitope or/and HLA affinity results with thresholds.<br>
            2.<a href="#C32"><b>ID Search </b></a>. ID or name search of Epitopes, HLA alleles, Organisms, Proteins and Antigens.<br>
            3.<a href="#C23"><b>Proteosome</b></a>. Proteosome simulator that detects if a given protein contains any known epitope. If a DNA/RNA sequence is given, different ORF are calculated.
            We will see eacho of them in more detail.
            </p> 
        </div>
			<h4 id="C31"><b>3.1. Epitope Search</b></h4> 
            <div class="container text-justify">
                <p>
                The main search focus of the Epitope Search is to search information about a specific epitope via its sequence or ID query. 
                </p>
                <h5 id="C311"><b>Epitope sequence or ID.</b></h5>
                Whether the search is done using the Epitope sequence or its ID, the results will lead into the same results page.
                <div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
                          <img src="png/sequence.png" alt="data model" style="width:400px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 7</b>. Results page where the Epitope sequence is AADLTQIFEV, all the HLA were selected and the threshold parameters weren't modified.</h4>
                                <p>This results page give you a table with a list of all epitopes founded in that sequence. It describes it's epitope ID, epitope sequence, HLA, logarithmic and nM affinities and an option to add this epitope into My Vaccine User page. The epitope ID acts as a link to its QVVP epitope page. Finally you can download the table into CSV format.
                                </p>
					          </div>
					      </div>
					    </div>
				</div>
                <div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
                          <img src="png/epitope.png" alt="data model" style="width:600px;height:500px">
					          <div class="caption">
					            <h4><b>Figure 8</b>.Epitope page where the Epitope ID is 24</h4>
					            <p> 
                                On the upper rigth there is a graphic showing the distribution of all epitopes with that ID from the QVVP database. On the x-axis it shows Prediction score called 1-log50k and on the y-axis its shows the binding affinity (IC50) value in nM of each epitope.<br>
                                On the upper left of the page it list information regarding the name ID of that epitope, it's sequence and length, the immunogenicity score, antigen ID and name, protein ID and name and organism name. 
                                All the IDs acts as a link to other pages. The ID goes to its IEDB epitope summary page. The antigen ID goes to the Antigen page of QVVP. The protein ID goes to the Protein page of QVVP. And the organism goes to the Organism page of QVVP. <br>
                                The ring graph shows the aminoacid properties of each aminoacid sequence. In light-green the polar, in dark-green the non-polar, in red the positive charged, and in blue the negative-charged amino acids. <br>
                                The second half of the page shows the Binding Affinities table. Each row has information about the Epitope ID name, each allele with the affinities in terms of logarithmic (log) and binding affinities (nM) for each of the 27 HLA alleles that QVVP database have.<br>
                                Finally, it also have two buttons: one to add this Epitope ID into the User's MyVaccine site (only allowed if the user is registered and has an account). The other is to export the binding affinites table into CSV format.
					            </p>
					          </div>
					      </div>
					    </div>
				</div>
                <h4 id="C312"><b>HLA selection</b></h4>
                Whether the search is done using the Epitope sequence or its ID, you can choose which alleles the query will target. More than one is allowed. By default all HLAs are selected. There is also the option of only doing the epitope search chosing the alleles and the threshold paramenters.
                <div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
                          <img src="png/sequence.png" alt="data model" style="width:400px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 9</b>. Results page where the  HLA selected were HLA-A01:01, HLA-A02:01, HLA-A02:03 and HLA-A02:06. The threshold parameters were the default ones.</h4>
                                <p>This results page give you a table with a list of all epitopes founded in that sequence. It describes it's epitope ID, epitope sequence, HLA, logarithmic and nM affinities and an option to add this epitope into My Vaccine User page. The epitope ID acts as a link to its QVVP epitope page. Finally you can download the table into CSV format.
                                </p>
					          </div>
					      </div>
					    </div>
				</div>
            </div>
            <h4 id="C313"><b>Threshold parameters</b></h4>
            <p>
            The prediction values are given in nM IC50 values and as logarithmic affinity. The user has a choice of setting the threshold for defining strong and weak binders based on predicted affinity (nMAff) or logarithmic affinity (logAff). Strong and weak binding peptides will be indicated in the output. The output can also be sorted based on predicted binding affinity as well as filtered on the user-specified thresholds. 
            </p>
            <br>
			<h4 id="C32"><b>3.2. ID Search</b></h4>
            <div class="container text-justify">
                <p>
                Eight different searches can be done;  either by name or ID from Epitope, HLA, Organism, Protein, and Antigen.
                All the IDs stored in our databes are from NCBI, so you can easily put a NCBI ID and perform the search.
                </p><br>
                <h5 id="C321"><b>Epitope ID</b></h5>
                <p>When search is done by <b>Epitope ID</b>, QVVP will redirect you into its Epitope page (<b> Figure 8</b>). </p>

                <br>
                <h5 id="C322"><b>HLA</b></h5>                
                <p>When search is done by <b>HLA</b>, QVVP will redirect you into its HLA page.There are 27 different HLA alleles into QVVP database, there correspond to the most common and well-documented alleles. In the HLA selector you can only select one of them. </p>
                <div class="row">
				    <div class="col-md-12">
				      <div class="thumbnail">
                      <img src="png/hla.png" alt="data model" style="width:600px;height:500px">
				          <div class="caption">
				            <h4><b>Figure 10</b>.HLA page where the HLA selected is HLA-A01:01</h4>
				            <p> 
                            On the upper rigth there is a graphic showing the distribution of all epitopes with that HLA from the QVVP database. On the x-axis it shows Prediction score called 1-log50k and on the y-axis its shows the binding affinity (IC50) value in nM of each epitope.<br>
                            The upper left side of the page lists information regarding the HLA ID, it's name, an image of the HLA structure and a link to the PDB crystal structure information. Not all the hla's have a crystalized    structure.<br>
                            The second half of the page shows the Binding Affinities table. Each row has information about the Epitope ID name, each HLA with the affinities in terms of logarithmic (log) and binding affinities (nM). Finally there is a button to export the binding affinites into CSV format.</p>
				          </div>
				      </div>
				    </div>
				</div>
                <h4 id="C323"><b>Organism</b></h4>
                <p>When search is done by <b>Organism</b> you can specify either its ID or name.If the search is done by its <b>Organism ID</b>. QVVP will redirect you into its Organism page. If the search is done by its <b>Organism name</b>. QVVP will redirect you into an intermediate page where a result list of all organisms with that name, and its organims ID.</p>
                <div class="row">
					<div class="col-md-6">
					  <div class="thumbnail">
                      <img src="png/organism.png" alt="data model" style="width:700px;height:250px">
					      <div class="caption">
					        <h4><b>Figure 11</b>. Organism page where the Organism ID is 11520:</h4>
					        <p> 
                            On the upper left of the page it shows information regarding the Organism ID and it's name. TheOrganism ID act's as a link to the NCBI Taxonomy Browser<br>
                            The second half of the page shows the Antigens table. Each row has information about the AntigenID and name, and Protein ID. Each ID acts as a link to the corresponding QVVP page.<br>
                            Finally there is a button to export the Antigen table into CSV format.
					        </p>
					      </div>
                        </div>
					</div>  
					<div class="col-md-6">
					  <div class="thumbnail">
                      <img src="png/organism2.png" alt="data model" style="width:450px;height:150px">
					      <div class="caption">
					        <h4><b>Figure 12</b>. Organism intermediate page where the name searched is vaccinia virus.</h4>
					        <p> 
                           
					        </p>
					      </div>
					  </div>
					</div>
				</div>
                <br>
                <h4 id="C324"><b>Protein</b></h4>
                <p>When search is done by <b>Protein</b> you can specify either its ID or name.If the search is done by its <b>Protein ID</b>. QVVP will redirect you into its Protein page.</p>                
                <div class="row">
				    <div class="col-md-12">
				      <div class="thumbnail">
                      <img src="png/protein1.png" alt="data model" style="width:600px;height:350px">
				          <div class="caption">
				            <h4><b>Figure 13</b>. Protein page where the Protein ID is 22164631</h4>
				            <p> 
                            On the upper left of the page it shows information regarding the ID of that Protein and it's name. The organism ID act's as a link to the NCBI Protein Browser. There is also the option of finding an homolog either in Swissprot or Protein Data Bank (PDB) and finding more epitopes using the Proteosome tool choosing it's epitope length (9, 10 or both).
                            The second half of the page shows an Antigens table. Each row describes each the Antigen ID, Antigen name, and Organism ID results. Each ID acts as a link to the corresponding QVVP page.Finally there is a button to export the Antigen table into CSV format.
				            </p>
				          </div>
				      </div>
				    </div>
				</div>
                <div class="row">
					    <div class="col-md-6">
					      <div class="thumbnail">
                          <img src="png/blast1.png" alt="data model" style="width:500px;height:250px">
                          <img src="png/blast2.png" alt="data model" style="width:500px;height:250px">
					          <div class="caption">
					            <h4 id="Fig14"><b>Figure 14</b>. <b>Swissprot</b> homolog search is done by Protein ID 22164631.</h4>
					            <p> 
                                It follows the results of a blastp query. There are three main parts in this page. The first is one is a general view of the alignment scores with the query and the matches founded by BLAST. The scoring can be seen depending of the Maximum score or by the E-values. Each bar respresents a match and if you move the mouse over, it will show defline and scores. If you click them, it will show the alignments. You can download it as PNG or JPEG image.<br>
                                The second part is a table with a ranked list of matches starting from the closest to the farthest. For each match it gives a brief description of the viruses, the maximum score, the total score, the query coverage, the E-value, and finally the % of identity. The table can be downloaded as CSV, PNG or JPEG. <br>
                                If you click in any of the matches it will redirect you to the third part. The third part it shows an alignment with the query sequence and the matched one. Also it gives a brief description of the matched virus, the alignment score, the E-value, the % of identity, the % of positives and % of gaps. The amino acid color code is the standard one. You can downlad this alignment as PNG or JPEG image. 
                                If a <b>PDB</b> homolog search is done it will give the same result format but it will use the data from the PDB database instead of the Swissprot one.
					            </p>
					          </div>
					      </div>
					    </div>
                        <div class="col-md-6">
					      <div class="thumbnail">
                          <img src="png/moreepitopes.png" alt="data model" style="width:500px;height:200px">
					          <div class="caption">
					            <h4 id="Fig15"><b>Figure 15</b>.Epitope length 9 and 10 search page is done by Protein ID 22164631.</h4>
					            <p> 
                                As in the protein page you can also make an homology search, either by Swissprot or PDB, and it will give the same result format as <b>Figure F</b>. It also give you a table with a list of all epitopes founded in that sequence. It describes it's epitope ID, epitope sequence, HLA, logarithmic and nM affinities and an option to add this epitope into My Vaccine User page. The epitope ID acts as a link to its QVVP epitope page. Finally you can download the sequence into FASTA format.
					            </p>
					          </div>
					      </div>
					    </div>
				</div>
                <br>
                If the search is done by its <b>Protein name</b>. QVVP will redirect you into an intermediate page where a result list of all proteins with that name, and the corresponding protein ID. The ID acts as a link into the protein page previously explained (<b>Figure E</b>). Here is an example of the Protein name polyprotein:
                </p>
                <div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
                          <img src="png/protein2.png" alt="data model" style="width:450px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 16</b>. Protein intermediate page where the name searched is polyprotein.</h4>
					          </div>
					      </div>
					    </div>
				</div>
                <br>
                <h4 id="C325"><b>Antigen</b></h4>
                <p>When search is done by <b>Antigen</b> you can specify either its ID or name.If the search is done by its <b>Antigen ID</b>. QVVP will redirect you into its Antigen page.If the search is done by its <b>Antigen name</b>. QVVP will redirect you into an intermediate page where a result list of all antigens with that name, and the corresponding antigen ID. The ID acts as a link into the antigen page</p>                
                <div class="row">
				    <div class="col-md-6">
                    <div class="thumbnail">
                          <img src="png/antigen1.png" alt="data model" style="width:450px;height:150px">
                          <img src="png/antigen2.png" alt="data model" style="width:450px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 17</b>. Antigen page where the Antigen ID is 2124409A</h4>
					            <p> 
                                On the upper left of the page it shows information regarding the Antigen ID and name, the organism name, the protein name. And, as the Protein page, it can search for an <b>homolog</b> into the Swissprot or PDB database and find more epitopes for these antigen with length 9, 10, or both. The Antigen ID act's as a link to the NCBI Protein Browser, the organism name acts as a link to the QVVP organism page and the protein name to the QVVP protein page.
                                The second half of the page shows the Antigens table. Each row describes each the Epitope ID, Epitope sequence, immunogenecity score and the start and end positions of that antigen. The Epitope ID acts as a link to the corresponding QVVP page.<br>
					            </p>
					          </div>
					      </div>
					    </div>
					    <div class="col-md-6">
					      <div class="thumbnail">
                          <img src="png/protein3.png" alt="data model" style="width:450px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 18</b>. Antigen intermediate page where the name searched is neuraminidase.</h4>
					          </div>
					      </div>
					    </div>
				</div>
            </div>
			<h4 id="C33"><b>3.3. Proteosome</b></h4>
			<div class="container text-justify">
				<p>
					The <b>Proteosome</b> is one of the most powerful tools of QVVP App, allowing the User to search epitopes in large DNA, RNA and Protein sequences. This supporting feature simulates the biological process once the virus has entered inside the cell. The MCH class I molecules, in order to present the diferent antigens to the extracellular environment, needs the cleavage of the viral proteins by the <b>Cellular Proteasome</b>. 
				</p>
				<p>
					To make functional this application we develope some Python scripts that could take as input:
				</p>
					<ol>
						<li>A <b>DNA</b> sequence, translate to protein (aminoacids) and generate k-mers of 9 and 10 aminoacid
						of length.</li>
						<li>A <b>RNA</b> sequence, translate to protein (aminoacids) and generate k-mers of 9 and 10 aminoacid of length.</li>
						<li>A <b>Protein</b> sequence and generate k-mers of 9 and 10 aminoacids in length.</li>
					</ol>

					<div class="row">
					    <div class="col-md-12">
					      <div class="thumbnail">
                          <img src="png/proteosome1.png" alt="Proteosome" style="width:700px;height:300px">
					          <div class="caption">
					            <h4><b>Figure 18</b>. Proteosome Query: Input</h4>
                                <p> The Proteosome simulator allows to put as input a DNA/RNA or Protein sequence, as well as a file upload by the user in FASTA format. 
                                </p>
					          </div>
					      </div>
					  	</div>
					</div>
					<div class="row">
					    <div class="row">
					    	<div class="col-md-12">
						      <div class="thumbnail">
	                          <img src="png/proteosome2.png" alt="Proteosome" style="width:700px;height:300px">
						        <div class="caption">
						            <h4><b>Figure 19</b>. Proteosome Query: Settings</h4>
	                                <p> This figure shows the settings that has to be filled before run the Proteosome simulator: frist one has to select if the input sequence is <b>DNA/RNA</b> or <b>Protein</b>. In case the input is DNA/RNA, it must be selected the <b>Minimal ORF length</b> desired to filter out the search. Finally, the resulted epitopes can be for 9 or 10 residues long. For that option the User can select only <b>Epitopes</b> of <b>9</b> or <b>10</b> aminoacids. Otherwise both options can be merged in the <i>both</i> ratio.
	                                </p>
						        </div>
						      </div>
					    	</div>
						</div>
					</div>
					<p>
					Not only the translational part for DNA and RNA sequences retrieve a protein sequence, but the Proteasome also
					gives the option to choose for which frame the User wants to run the query. It is, if the START codon is <i>ATG</i> or <i>AUG</i>, then there can be 6 possibles translations for DNA sequence (<i>Forward and Reverse strands</i>) and 3 for RNA nucleotides (<i>only the forward sense</i>). This is because, as it is well known, viruses can contain ORF coded in both forward and reverse sequences. For instance, the <a href="https://www.viprbrc.org/brc/home.spg?decorator=arena_lassa" target="_blank"><i>Lassa Virus</i></a> is a single-strand, bisegmented, ambisense RNA genome virus that retrotranscribes its genome in order to replicate and infect the cell.
					</p>
					<br>
					<div class="row">
					    <div class="row">
					    	<div class="col-md-12">
						      <div class="thumbnail">
	                          <img src="png/proteosome_orf1.png" alt="ORF" style="width:700px;height:300px">
						        <div class="caption">
						            <h4><b>Figure 20</b>. ORF Frames: +</h4>
	                                <p> The ORF Results page comes up only when the user wants to search for epitopes contained in DNA/RNA sequences. Thus, different frames can be run as query. The <b>frames</b> are: <b>0+</b> for position 0, <b>1+</b> for position 1 and <b>2+</b> for position 2 in the START codon ATG. The same for the reverse sequence (in case of DNA as input, <b>Figure 21</b>). Before running, the user can check if the sequence is good enough dowloading it as FASTA. Also the sequence range (Start/End) is given in the table.
	                                </p>
						        </div>
						      </div>
					    	</div>
						</div>
					</div>
					<div class="row">
					    <div class="row">
					    	<div class="col-md-12">
						      <div class="thumbnail">
	                          <img src="png/proteosome_orf2.png" alt="ORF" style="width:700px;height:300px">
						        <div class="caption">
						            <h4><b>Figure 21</b>. ORF Frames: -</h4>
						        </div>
						      </div>
					    	</div>
						</div>
					</div>
				<br>
				<p>
					When the ORF is select (in case of DNA/RNA), then the k-mers are generated and compared to those in the <a href="#Fig5">Database</a>. 
				</p>
				<p>
					Then the following page comes out:
				</p>
				<div class="row">
					<div class="row">
					    <div class="col-md-12">
						    <div class="thumbnail">
	                         <img src="png/proteosome_runq3.png" alt="Proteins&Epitopes" style="width:700px;height:400px">
						      	<div class="caption">
						            <h4><b>Figure 22</b>. Proteins & Epitopes</h4>
						            <p>
						            	All those epitopes found in the database of QVVP and with a clear match will apear in the table shown in this figure. As it is seen, the same table as in <a href="#Fig15"><b>Figure 15</b></a> with the same results. From that table one can be redirected to the <b>Epitope page</b> to see more about the epitope, or retrive information about the protein, antigen, organism or binding affinities with each HLA.             	
						            </p>
						      	</div>
						    </div>
					    </div>
					</div>
				</div>

				<div class="row">
					<div class="row">
					    <div class="col-md-12">
						    <div class="thumbnail">
	                          <img src="png/proteosome_runq1.png" alt="Proteins&Epitopes" style="width:700px;height:400px">
						        <div class="caption">
						            <h4><b>Figure 23</b>. Proteins & Epitopes</h4>
						            <p>
						            	In case there is no result shown in the Protein page for the search, the user can find at the top left, either in the SwissProt or in the PDB database. Thus, the user will be redirected to the BLAST output shown in <a href="#Fig14"><b>Figure 14</b></a>. 

						            </p>
						        </div>
						    </div>
					   	</div>
					</div>
				</div>
				
		    <br><br>
            <h4 id="C4"><b>4. History</b></h4>
            <div class="container text-justify">
                <p>
                The history feature requires your web browser to be set to accept cookies. The history will be lost after 30 days of beeing stored in the browser. The maximum number of searches available in History is 25. Once the maximum number is reached, QVVP will remove the oldest search from history and add the most current search. You don't need to be logged to see your history of searches.
                </p>
                <p>
                The history is created for each browser. If in the same browser you login with different users
                the history will be merged together. This will not happen if the logins are done in different browsers.
                If a new search is the same as a previous search, QVVP will create a new record in the search database with different date time. Here is an image of a history example:
                </p>
                <div class="row">
                        <div class="col-md-6">
					      <div class="thumbnail">
					        <img src="png/history.png" alt="epitope_table" style="width:450px;height:150px">
					          <div class="caption">
					            <h4><b>Figure 24</b>. History:</h4>
					            <p>                
                                For each search done in QVVP, in the history you will see its type ( epitope, hla, antigen, protein, organism,), it's id that will redirect to the page looked previously, and the date time
                                when the page was looked. 
					            </p>
					          </div>
					      </div>
					    </div>
					</div>
            </div>
	</div>
</div>
<?php print footerDBW();?>
