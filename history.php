<?php
include("globals.inc.php");
print headerDBW("History");
$history = json_decode($_COOKIE["history"]);
print navbar('History');
?>
<div class="container">
	<h3>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your personal History.</h3>
	<table class="table table-striped table-sm table-responsive" align="text-center" id="hisTable">
		<thead>
			<tr>
				<th scope="col">Type</th>
				<th scope="col">Id</th>
				<th scope="col">Date Time</th>
			</tr>
		</thead>
		<tbody>
	        <?php if(count($history) > 0){   
	        	foreach ($history as $key){ 
	        		$url = $key[0];
	        		$dateTime = $key[1];
	        		$id = explode("=", $url)[1];
	        		$type = explode(".", $url)[0];
	        		?>
	        <tr>
	        	<td  id="Type"><?php echo $type;?></td>
	            <td  id="Id"><a href="<?php echo $url?>"><?php echo $id;?></a></td>
	            <td  id="Date"><?php echo $dateTime;?></td>
	        </tr>
	        <?php } 
	    }
	     ?>
	    </tbody>
	</table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    $('#hisTable').DataTable( {
    	"order": []
    	} );
    });
</script>
<?php print footerDBW();?>
