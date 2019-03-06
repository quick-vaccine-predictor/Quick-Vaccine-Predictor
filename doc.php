<?php
include("globals.inc.php");
$title = "About";
print headerDBW($title);

//Conection to the DB if needed
//$conn = connectSQL();
//$conn->close();


print navbar('About');
?>

<div class="container">
	<h2>Documentation</h2>
		<h3><b>Introduction</b></h3>
		<p>
			A brief introduction??
		</p>
			<h4><b> Scope </b></h4> 
			<p>
			The main scope oh this web application is to develope a viral vaccine generator based in the 
			viral epitope data extracted from the IEDB (Immune Epitope Database And Analysis Resuource). 
			Taking advantage from the NetMHCcons peptide-binding predictor to MHC-I molecules we create a
			database of more than 41.000 viral epitopes and the binding affinity prediction to each of the 
			HLA (Human Leukocyte Antigen) alelles present in the IEDB database, allowing to researchers who
			wants to build a vaccine *de novo* to check which epitope could bind with more affinity to a given 
			HLA alelle.

			On the following documentation we briefly explain how our website works.
			</p>

		<h3><b>Data</b></h3>
			<h4><b>HLA & Epitope aquirement: IEDB</b></h4>

			<p> IEDB is the <a href="https://www.iedb.org/" target="_blank">Immune Epitope Database</a> that freely provide information about anitbody and T cell epitopes based in experimental data, as well as immunoassay tools to assist in the prediction 
				and analysis of epitopes. Within these tools, the T Cell Epitope - MHC binding prediction can
				foretell IC50 values for peptides binding to specific MHC molecules. 

				Besides, the predictor can determine, among other options, the ability of an aminoacid subsequence 
				to bind to a specific MHC class I molecule, using a large collection of the most common human HLA alleles, 
				specifically 27 HLA alleles (<a href="https://help.iedb.org/hc/en-us/articles/114094151851-HLA-allele-frequencies-and-reference-sets-with-maximal-population-coverage" target="_blank">Click
				here fore more information</a>). In order to predict these specific interactions, IEDB has different softwares
				based on Artificial Neural Networks or Stabilized Matrix methods, among others, and a set of libraries that, 
				based in a very large amount of data produce a very accurate results.  

				However, although predictions can be made in a very easy way, the required time to obtain binding affinities between
				a large collection of epitopes (as can be all curated viral epitopes) and the most common HLA molecules can take a lot
				of time. 

				Taking into account this premise, in this project we performed a serie of predictions between a lage set
				of viral epitopes and HLA molecules with the purpose of generate a useful database that can serve to generate vaccines
				based in these specific interaction data.   
			</p>

			<h4><b> Prediction: NetMHCcons </b></h4>

			<p>
				Taking advantage of the tools offered by IEDB, we proceed to download a collection of almost 41.300 viral epitopes and the set of 27 HLA allels, with the aim of persue a set of binding predictions between these two molecules. In order to do so, we use the free binding predictor method <a href="http://www.cbs.dtu.dk/services/NetMHCcons/" target="_blank">NetMHCcons</a>. This consensus method for MHC I predictions integrate three softwares to give more accurate predictions:
				NetMHC and NetMHCpan, that are artificial neural network methods allele-specific and based in more than 115,000 quantitative binding data; and PickPocket method based on receptor-pocket similarities between MHC molecules. Also, NetMHCcons server can produce predictions for peptides of 8-15 aminoacids in length, for which we made predictions 
				only for epitopes of 9 or 10 aminoacid length.

				Predictions benckmarks were around 180 - 200 minutes for HLA - Epitope interactions with 9 aminoacid of length, and 
				150 - 180 minutes for epitoes with 10 aminoacid of length. Results where obtained in a prediction output table, as the
				following:
			</p>
				<br><br><br>
				
					<img class="img-responsive" src="png/out_HLA_example.png" width="700" height="500" alt="output-example">
					<h4><b>Figure 1</b></h4> <h4>MHC-I Binding Prediction Results:</h4><p>Each row corresponds to one epitope binding prediction. The columns contain the <b>allele</b> the prediction was made for, the <b>epitope sequence</b>, the identity number for this sequence, two columns refered to the <b>affinity</b>, the <b>percentile rank</b> and the <b>Binding Level</b> for each interactions, based in the IC50 and %Rank. </p>

				<br><br>

			<h4><b> Process & Filter Result Data</b></h4>	

			<p>
				




			</p>


				



	


			

			<br><br><br>
		<h4><b>Queries</b></h4>
            <p>
            From here, users can perform three different queries: <br>
            - <u>Epitope Search</u>: Epitope or/and HLA affinity results with thresholds.<br>
            - <u>ID Search</u>: Id or name search of Epitopes, HLA alleles, Organisms, Proteins and Antigens.<br>
            - <u>Proteosome</u>: Proteosome simulator that detects if a given protein contains any known epitope. If a DNA/RNA sequence is given, different ORF are calculated.
            </p>
			<h5><b>Epitope Search</b></h5>
			<h5><b>ID Search</b></h5>
                <p>
                You can do 8 different searches either by the name or ID from Epitope, HLA, Organism, Protein, and Antigen.
                All the ID stored in our databes are from NCBI, so you can easily put a NCBI ID and perform the search .
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
                The second half of the page shows a Binding Affinities table. It shows information about the Epitope ID name, each HLA with the affinities in terms of logarithmic (log) and binding affinities (nM) for each of the 27 HLA that QVVP database have.<br>

			<h5><b>Proteosome</b></h5>
		<h4>Introduction</h4>
		<h4>Introduction</h4>
		<h4><b>History</b></h4>
            <p>
            The history feature requires your web browser to be set to accept cookies. The history will be lost after 30 days of beeing stored in your browser. The maximum number of searches available in History is 25. Once the maximum number is reached, QVVP will remove the oldest search from history and add the most current search. You don't need to be logged to see your history of searches.
            </p>
            <p>
            The history is created for each browser. If in the same browser you login with different users
            the history will be merged together. This will not happen if the logins are done in different browsers.
            If a new search is the same as a previous search, QVVP will create a new record in the search database with different date time. Here is an image of a history example:
            </p>
            <img class="img-responsive" src="png/history.png" width="700" height="500" alt="output-example">
            <p> 
             For each search done in QVVP, in the history you will see its type ( epitope, hla, antigen, protein, organism,), it's id that will redirect to the page looked previously, and the date time
            when the page was looked. 
            </p>

</div>

<?php print footerDBW();?>
