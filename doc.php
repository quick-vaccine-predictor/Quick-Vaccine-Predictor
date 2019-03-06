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
		<h4><b>Introduction</b></h4>
		<p>
			A brief introduction??
		</p>
			<h5> Scope  </h5> 
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

		<h4>Data</h4>
			<h5> Data Aquirement: IEDB  </h5>
			<p> IEDB is the Immune Epitope Database that freely provide information about anitbody and T cell 
				epitopes based in experimental data, as well as immunoassay tools to assist in the prediction 
				and analysis of epitopes. It provide al large collection of 

			<a href="http://tools.iedb.org/mhci/help/" target="_blank">MHC-I binding prediction</a>
			<a href="https://help.iedb.org/hc/en-us/articles/114094151851" target="_blank">HLA allele frequencies</a>
			<a href="https://www.ncbi.nlm.nih.gov/pubmed/16789818?dopt=AbstractPlus" target="_blank">benchmarking predictions of peptide binding to MHC-H molecules</a>


			</p>


			<h5> Quines dades hem agafat?  </h5>
			<h5> D'on hem agafat les dades? </h5>
			<h5> Què hem fet amb les dades? </h5>

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
			<h5><b>Proetosome</b></h5>
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
            <img class="img-rounded img-responsive center-block" src="png/history.png" width="1000"><br><br>
            <p> 
             For each search done in QVVP, in the history you will see its type ( epitope, hla, antigen, protein, organism,), it's id that will redirect to the page looked previously, and the date time
            when the page was looked. 
            </p>




</div>

<?php print footerDBW();?>