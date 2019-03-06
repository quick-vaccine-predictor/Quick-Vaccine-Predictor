<?php
include("globals.inc.php");
$title = "";
print headerDBW($About);
//Conection to the DB if needed
//$conn = connectSQL();
//$conn->close();


print navbar('About');
?>
<div class="container">
	<h2>Documentation</h2>
		<h4>Introduction</h4>
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
			<p> IEDB </p>
			<h5> Quines dades hem agafat?  </h5>
			<h5> D'on hem agafat les dades? </h5>
			<h5> Què hem fet amb les dades? </h5>

		<h4>Web Site</h4>
			<h5> Binding Search System</h5>
			- Distribució de la cerca: queries, ids, proteosoma
			<h5></h5>
			<h5></h5>
		<h4>Introduction</h4>
		<h4>Introduction</h4>
		<h4>Introduction</h4>




</div>

<?php print footerDBW();?>