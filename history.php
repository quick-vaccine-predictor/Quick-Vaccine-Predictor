<?php
include("globals.inc.php");
print headerDBW("History");

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}

if(isset($_SESSION["idUser"]) && isset($_SESSION["idUser"])) { ?>
	<?php 
	print_r($_COOKIE['history']); 
	die; 

print navbar('myVaccine');
	?>


	<div class="container">
		<h3>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your personal History.</h3>
		<table class="table table-striped table-sm table-responsive" align="text-center" id="affTable">
			<tr>
				<th scope="col">User Id</th>
				<th scope="col">Visit Url</th>
				<th scope="col">Date Time</th>
			</tr>
		<tbody>
	        <?php if(count($history) > 0)
	        { 	print_r($history); die;
	        	foreach (array($result) as $key)
	         { ?>
	          <tr>
	            <td  id="idUser"><?php echo $_SESSION['idUser']; ?></td>
	            <td  id="email"><?php echo $key[0];?></td>
	            <td  id="visit"><?php echo $key[1];?></td>
	            <td  id="Date"><?php echo $key[2];?></td>
	          </tr>
	        <?php } 
	    }
	    } ?>
	    </tbody>
	  	</table>
    </div>

    <!--</div> -->
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        
      });
    </script>


<?php print footerDBW();?>