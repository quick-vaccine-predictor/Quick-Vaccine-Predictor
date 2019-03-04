<?php
include("globals.inc.php");
$title = "Blast";
print headerDBW($title);

$blastDB = "/home/dbw00/blast/DBS/";
$blastPATH = "/home/dbw00/blast/bin/blastp";
$tmpFile = "/home/dbw13/public_html/qvvp/tmp/".uniqId('seq').'.fa';
$db = $_REQUEST["db"];
$id = $_REQUEST["id"];
if (strlen($id) == 0) {
    $coords = $_REQUEST["coords"];
    $fasta = ">".$coords."\n".$_SESSION["proteosome"][$_REQUEST["frame"]][$_REQUEST["coords"]];
    $file = fopen($tmpFile, "w");
    fwrite($file, $fasta);
    fclose($file);
} else{
$command = 'curl "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=sequences&id='.$id.'&rettype=fasta&retmode=text" > '.$tmpFile;
    exec($command);
}
$blastCommand = $blastPATH.' -query '.$tmpFile.' -db '.$blastDB.$db.' -evalue 0.001 -max_target_seqs 50 > '.$tmpFile.'.out';
exec($blastCommand);
$blastFile = file_get_contents($tmpFile.'.out');
print navbar('Blast');
?>
<h3>Blast query: <?php echo $id ?></h3>
<button onclick="goBack()">Go Back</button>
<div id="blast-multiple-alignments"></div>
<div id="blast-alignments-table"></div>
<div id="blast-single-alignment"></div>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script type="text/javascript" src="js/blaster.min.js"></script>
<script type="text/javascript">
        var alignments = <?php echo json_encode($blastFile)?>;
           
        var blasterjs = require("biojs-vis-blasterjs");
        var instance  = new blasterjs({
            string: alignments,
            multipleAlignments: "blast-multiple-alignments",
            alignmentsTable: "blast-alignments-table",
            singleAlignment: "blast-single-alignment"
        });
        function goBack() {
  			window.history.back();
		} 
</script>
<?php 
if (file_exists($tmpFile)){
	unlink($tmpFile);
}
if (file_exists($tmpFile.'.out')){
	unlink($tmpFile.'.out');
}
print footerDBW();
?>