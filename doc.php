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
	<h2>Documentation</h2>
		<br>
	<div class="container text-justify">
		<h3><b>Index</b></h3>
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
			<p>
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

		<h3 id="C3"><b>3. QVVP In Action</b></h3>	
		<br>
		<p>
			This website is designed in order to be intuitive and self-guied. This field is dedicated to explain how to 
			get around in all the different tools.
		</p>

		<h4><b>Queries</b></h4>
            <p>
            From here, users can perform three different queries: <br>
            1.<b>Epitope Search</b>: Epitope or/and HLA affinity results with thresholds.<br>
            2.<b>ID Search</b>: Id or name search of Epitopes, HLA alleles, Organisms, Proteins and Antigens.<br>
            3.<b>Proteosome</b>: Proteosome simulator that detects if a given protein contains any known epitope. If a DNA/RNA sequence is given, different ORF are calculated.
            </p> <br>
			<h5><b>Epitope Search</b></h5> 

            <br>
			<h5><b>ID Search</b></h5>
                <p>
                Eight different searches can be done either by the name or ID from Epitope, HLA, Organism, Protein, and Antigen.
                All the ID stored in our databes are from NCBI, so you can easily put a NCBI ID and perform the search.
                </p>
                <p>When search is done by <b>Epitope ID</b>, QVVP will redirect you into its Epitope page. Here is an example of the Epitope page when the Epitope ID is 24:
                <img class="img-responsive" src="png/epitope1.png" width="700" height="500" alt="output-example">
                <img class="img-responsive" src="png/epitope2.png" width="700" height="500" alt="output-example">
                
                On the upper rigth there is a graphic shouing the distribution of all epitopes with that ID from the QVVP database. On the x-axis it shows the logaritmic affinity and on the y-axis its shows the binding affinity (IC50) of each epitope.<br>
                On the upper left of the page it shows information regarding the name ID of that epitope, it's sequence, length of the sequence, immunogenicity score, antigen id and name, protein id and name and organism name. 
                All the ID's acts as a link to other pages. The id goes to its IEDB epitope summary page. The antigen ID goes to the Antigen page of QVVP. The protein ID goes to the Protein page of QVVP. And the organism goes to the Organism page of QVVP. <br>
                The ring graph shows the aminoacid properties of each sequence aminoacid. In light-green the polar, in dark-green the non-polar, in red the positive charged, and in blue the negative-charged amino acids. <br>
                The second half of the page shows a Binding Affinities table. It shows information about the Epitope ID name, each HLA with the affinities in terms of logarithmic (log) and binding affinities (nM) for each of the 27 HLA that QVVP database have.<br>
                Finally it also have 2 buttons one to add this Epitope ID into the User's MyVaccine site, only allowed if the user is registered and has an account. The other is to export the binding affinites into CSV format.
                </p>
                <p>When search is done by <b>HLA</b>, QVVP will redirect you into its HLA page.There are 27 different HLA into QVVP database, there are the most common and well-documented. In these selector you can only select one of them. Here is an example of the HLA page when the HLA-A01:01 is selected:
                    <img class="img-responsive" src="png/hla1.png" width="700" height="500" alt="output-example">
                    <img class="img-responsive" src="png/hla2.png" width="700" height="500" alt="output-example">
                On the upper rigth there is a graphic shouing the distribution of all epitopes with that hla from the QVVP database. On the x-axis it shows the logaritmic affinity and on the y-axis its shows the binding affinity (IC50) of each epitope.<br>
                On the upper left of the page it shows information regarding the hla ID of that hla, it's name, an image of the hla structure and a link to the PDB crystal structure information. Not all the hla's have a crystalized structure.<br>
                The second half of the page shows a Binding Affinities table. It shows information about the Epitope ID name, each HLA with the affinities in terms of logarithmic (log) and binding affinities (nM) for each of the 27 HLA that QVVP database have. Finally there is a button to export the binding affinites into CSV format.<br>
                <p> 
                For each search done in QVVP, in the history you will see its type ( epitope, hla, antigen, protein, organism,), it's id that will redirect to the page looked previously, and the date time
                when the page was looked. 
                </p>
                <p>
                When search is done by <b>Organism</b> you can specify either its ID or name.
                If the search is done by its <b>Organism ID</b>. QVVP will redirect you into its Organism page. Here is an example of the Organism page by 11520 ID:
                <img class="img-responsive" src="png/organism.png" width="700" height="500" alt="output-example">
                On the upper left of the page it shows information regarding the ID of that Organism and it's name. The organism ID act's as a link to the NCBI Taxonomy Browser<br>
                The second half of the page shows an Antigens table. It shows information about the Antigen ID, Antigen name, and Protein ID. Each ID acts as a link to the corresponding QVVP page.Finally there is a button to export the Antigen table into CSV format.<br>
                If the search is done by its <b>Organism name</b>. QVVP will redirect you into an intermediate page where a result list of all organisms with that name, and the corresponding organism ID. the ID acts as a link into the organism page previously explained (<b>Figure XXXX</b>). Here is an example of the Organism name by vaccinia virus:
                <img class="img-responsive" src="png/organism2.png" width="700" height="500" alt="output-example">
                </p>
                <p>
                When search is done by <b>Protein</b> you can specify either its ID or name.
                If the search is done by its <b>Protein ID</b>. QVVP will redirect you into its Protein page. Here is an example of the Protein page 22164631 ID:
                <img class="img-responsive" src="png/protein1.png" width="700" height="500" alt="output-example">
                On the upper left of the page it shows information regarding the ID of that Protein and it's name. The organism ID act's as a link to the NCBI Protein Browser. There is also the option of finding an homolog either in Swissprot or Protein Data Bank (PDB) and finding more epitopes using the Proteosome tool choosing it's epitope length (9, 10 or both)<br>
                The second half of the page shows an Antigens table. It shows information about the Antigen ID, Antigen name, and Organism ID. Each ID acts as a link to the corresponding QVVP page.Finally there is a button to export the Antigen table into CSV format.<br>
                This is an example if a Swissprot homolog search is done.
                <img class="img-responsive" src="png/blast1.png" width="700" height="500" alt="output-example">
                <img class="img-responsive" src="png/blast2.png" width="700" height="500" alt="output-example">
                There are three main parts in this page. It follows the results of a blastp query. The first is one is a general view of the alignment scores with the query and the matches founded by Blast. The scoring can be seen depending of the Maximum score or by the E-values. Each bar respresents a match and if you move the mouse over it will show defline and scores, and if you click it will show the alignments. You can download it as PNG or JPEG image.<br>
                The second part is a table with a ranked list of matches starting from the closest to the farthest. For each match it gives a brief description of the virues, the maximum score, the total score, the query coverage, the E-value, and finally the % of identity. All these table can be downloaded as CSV, PNG Or JPEG. If you click in any of the matches it will redirect you to the third part.<br>
                The third part it shows an alignment with the query sequence and the matched one. Also it gives a brief description of the matched virus, the alignment score, the E-value, the % of identity, the % of positives and % of gaps. The amino acid color code is the standard. You can downlad this alignment as PNG or JPEG image. 
                If a PDB homolog search is done it will give the same result format but it will use the data from the PDB database instead of the Swissprot one.<br>
                If what you want to do is to find more epitopes for this specific protein you can make a direct query only chosing the epitope length (9, 10, or both). Here is an example is a 9 and 10 length epitope search is submitted:
                <img class="img-responsive" src="png/moreepitopes.png" width="700" height="500" alt="output-example">
                As in the protein page you can also male an homology search, either by Swissprot or PDB, and it will give the same result format as <b>Figure XXXX</b>. It also give you a table with a list of all epitopes founded in that sequence. It describes it's epitope ID, epitope sequence, HLA, logarithmic and nM affinities and an option to add this epitope into My Vaccine User page. The epitope ID acts as a link to its QVVP epitope page. Finally you can download the sequence into FASTA format.
                If the search is done by its <b>Protein name</b>. QVVP will redirect you into an intermediate page where a result list of all proteins with that name, and the corresponding protein ID. The ID acts as a link into the protein page previously explained (<b>Figure XXXX</b>). Here is an example of the Protein name polyprotein:
                <img class="img-responsive" src="png/protein2.png" width="700" height="500" alt="output-example">
                </p>
                <p>
                When search is done by <b>Antigen</b> you can specify either its ID or name.
                If the search is done by its <b>Antigen ID</b>. QVVP will redirect you into its Antigen page. Here is an example of the Antigen page 2124409A ID:
                <img class="img-responsive" src="png/antigen1.png" width="700" height="500" alt="output-example">
                <img class="img-responsive" src="png/antigen2.png" width="700" height="500" alt="output-example">
                On the upper left of the page it shows information regarding the ID of that Antigen, it's name, the organism name, the protein name (in this case is unknow and if we ckick it will ). And as the Protein page it can search for an homolog into the Swissprot or PDB database and find more epitopes for these antigen with length 9, 10, or both. The Antigen ID act's as a link to the NCBI Protein Browser, the organism name acts as a link to the QVVP organism page and the protein name to the QVVP protein page. There is also the option of finding an homolog either in Swissprot or Protein Data Bank (PDB) and finding more epitopes using the Proteosome tool choosing it's epitope length (9, 10 or both).<br>
                The second half of the page shows an Antigens table. It shows information about the Epitope ID, Epitope sequence, immunogenecity score and the start and end positions of that antigen. The Epitope ID acts as a link to the corresponding QVVP page.<br>
                If the search is done by its <b>Antigen name</b>. QVVP will redirect you into an intermediate page where a result list of all antigens with that name, and the corresponding antigen ID. The ID acts as a link into the antigen page previously explained (<b>Figure XXXX</b>). Here is an example of the Antigen name neuraminidase:
                <img class="img-responsive" src="png/protein3.png" width="700" height="500" alt="output-example">

			<h5><b>Proteosome</b></h5>
		    <h4><b>History</b></h4>
                <p>
                The history feature requires your web browser to be set to accept cookies. The history will be lost after 30 days of    beeing stored in your browser. The maximum number of searches available in History is 25. Once the maximum number is   reached, QVVP will remove the oldest search from history and add the most current search. You don't need to be logged     to see your history of searches.
                </p>
                <p>
                The history is created for each browser. If in the same browser you login with different users
                the history will be merged together. This will not happen if the logins are done in different browsers.
                If a new search is the same as a previous search, QVVP will create a new record in the search database with different   date time. Here is an image of a history example:
                </p>
                <img class="img-responsive" src="png/history.png" width="700" height="500" alt="output-example">



</div>

<?php print footerDBW();?>
