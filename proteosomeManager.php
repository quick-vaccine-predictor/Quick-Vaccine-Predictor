<?php
require("globals.inc.php");
require("codonTables.php");
$epitopeLen = $_POST["length"];
$table = $_POST["geneticTable"];
$orfminLength = $_POST["orfminLength"];
$in_dna = $_POST["in_dna"];
print headerDBW("Proteosome");
print navbar('Proteosome');
$ncbiId = $_POST["ncbiId"];
if (strlen($ncbiId) != 0){
	$tempFile = "tmp/" . uniqId('proteosome');
	$command = 'curl "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=sequences&id='.$ncbiId.'&rettype=fasta&retmode=text" > '.$tempFile;
	exec($command);
}
if (intval($in_dna) == 1) {
if ($_FILES['uploadFile']['size'] != 0){
	$proteosomeText = file_get_contents($_FILES['uploadFile']['tmp_name']);
}elseif (strlen($_REQUEST['proteosomeText']) != 0) {
	$proteosomeText = $_REQUEST['proteosomeText'];
}elseif (file_exists($tempFile)) {
	$proteosomeText = file_get_contents($tempFile);
	unlink($tempFile);
}
$p = strpos($proteosomeText, '>');
if (!$p and ( $p !== 0)) { // strpos returns False if not found and "0" if first character in the string
    // When is not already FASTA, add header + new line
    $proteosomeText = ">User provided sequence\n" . $proteosomeText;
}
$tempFile =  "tmp/" . uniqId('proteosome');
$ff = fopen($tempFile . ".query.fasta", 'wt');
fwrite($ff, $proteosomeText);
fclose($ff);
exec("/usr/bin/python3 orf_finder.py ".$tempFile . ".query.fasta"." ".$table." ".$orfminLength, $raw_output, $err);
if (file_exists($tempFile . ".query.fasta"))
    unlink($tempFile . ".query.fasta");
$output = array();
$translator = array("1" => "+", "-1" => "-");
foreach ($raw_output as $key => $value) {
	$row = explode(",", $value);
	$strand = $translator[$row[0]];
	$frame = $row[1];
	$length = $row[2];
	$coords = $row[3];
	$seq = $row[4];
	$output[$strand.$frame][$coords] = $seq;
}
$_SESSION["proteosome"] = $output;
}
else {
if ($_FILES['uploadFile']['size'] != 0){
	$proteosomeText = file_get_contents($_FILES['uploadFile']['tmp_name']);
}elseif (strlen($_REQUEST['proteosomeText']) != 0) {
	$proteosomeText = $_REQUEST['proteosomeText'];
}elseif (file_exists($tempFile)) {
	$proteosomeText = file_get_contents($tempFile);
	unlink($tempFile);
}
$p = strpos($proteosomeText, '>');
if (!(!$p and ( $p !== 0))) { 
	$seq_arr = explode("\n", $proteosomeText);
	array_shift($seq_arr);
    $proteosomeText = "";
    foreach ($seq_arr as $value) {
    	$proteosomeText .= trim($value);
    }
}
else {
	$seq_arr = explode("\n", $proteosomeText);
	$proteosomeText = "";
    foreach ($seq_arr as $value) {
    	$proteosomeText .= trim($value);
    }
}
$_SESSION["proteosome"] = array("+0" => array("0:".strval(strlen($proteosomeText)) => $proteosomeText));
header("Location: proteosome.php?frame=".urlencode("+0")."&epitopeLen=".urlencode($epitopeLen));
}
?>
<div>
	<h2>ORF search results:</h2>
	<? foreach ($output as $frame => $cords_arr) { ?>
	<h2>Frame <?php echo $frame ?> <a href="proteosome.php?frame=<?php echo urlencode($frame)."&epitopeLen=".urlencode($epitopeLen) ?>" target="_blank" class="btn btn-info btn-sm">Run Query</a></h2>
	<table class="table table-striped table-sm table-responsive text-center display">
		<thead>
			<tr>
				<th class="text-center">Length</th>
				<th class="text-center">Range</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
				<? foreach ($cords_arr as $coords => $seq) { ?>
				<tr>
					<td><?php echo strlen($seq) ?></td>
					<td><?php echo $coords ?></td>
					<td><a href="getFasta.php?coords=<?php echo $coords."&"."frame=".urlencode($frame) ?>" target="_blank" class="btn btn-info btn-sm">Download FASTA</a></td>
				</tr>
				<?php } ?>
			
		</tbody>
	</table>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    	$('table.display').DataTable();
	} );
</script>

<?php print footerDBW();?>
