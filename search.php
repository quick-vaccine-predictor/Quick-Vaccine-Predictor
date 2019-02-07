

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="Quick Vaccine Predictor" content="">
    <meta name="QVP" content="">
    <link rel="icon" href="">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <title><?php if (isset($_GET["idEpitope"])){echo $_GET['idEpitope'];}?></title>
    <!-- Minified Bootstrap 3 CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!--Minified jQuery 3 JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--Latest Bootstrap 3 JS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src=https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>
  </head>

<?php
    $servername = "localhost";
    $username = "qvp";
    $password = "qvp";
    $db = "qvp";
    
    // Create connection to db
    $conn = new mysqli($servername, $username, $password, $db);

    $sequence = $_GET["sequenceName"];
    
    $sql = "SELECT idEpitope, seqEpitope, Immunogenecity_score FROM Epitope WHERE seqEpitope LIKE '%".$sequence."%'";

    $result = $conn->query($sql); /* the search is done here */
        
    $conn->close();


?>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">QVP</a>
        </div>
        <div id="myNavbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.html">Home</a></li>
            <li><a href="myvaccine.html">MyVaccine</a></li>
            <li><a href="queries.php">Queries</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="signin.html"> Sign Up</a></li>
            <li><a href="login.html"> Login</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">

  </div>
    <div class="container">
      <div class="row">
        <h2>Epitopes</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>idEpitope</th>
              <th>Sequence</th>
              <th>Immunogenecity score</th>
            </tr>
          </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <th scope='row' id="idEpitope"><?php echo $row['idEpitope'] ?></th>
            <td class='text-center' id="seq"><?php echo $row['seqEpitope'] ?></td>
            <td class='text-center' id="iScore"><?php echo $row['Immunogenecity_score'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    </div>
    </div> <!-- /container -->
    <footer class="text-muted">
        <div class="container">
            <p>QVP © 2019 <a href="#">Back to top</a></p>
         </div>
    </footer>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        
      });
    </script>

</html>