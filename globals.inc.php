<?php

function connectSQL() {
	$servername = "localhost";
	$dbname = "qvvp";
	$username = "qvvp";
	$password = "Qvvp_121327";
	$conn = new mysqli($servername, $username, $password, $dbname);
	return $conn;
}

function headerDBW($title) {
    return "
<!DOCTYPE html>
<html lang=\"en\">
<head>
<meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>$title</title>
       <!-- Bootstrap styles -->
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
  
    <!-- IE 8 Support-->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]--> 
        <link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css\"/>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js\"></script>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
        <script type=\"text/javascript\" src=\"https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
        <script type=\"text/javascript\" src=\"https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js\"></script>
    <style>
		body {min-height: 2000px;
  			  padding-top: 70px;}
  	</style>
</head>
<body bgcolor=\"#ffffff\">
<div class= \"container\">
";
}

function footerDBW() {
    return '
</div>
  <footer class="text-muted">
    <div class="container">
      <p>QVVP © 2019 <a href="#">Back to top</a></p>
    </div>
  </footer>
</body>
</html>';
}

function navbar($page){
  $navbar = '<nav class="navbar navbar-inverse navbar-fixed-top">
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
            <ul class="nav navbar-nav">';
  if ($page == "Home"){
    $navbar .= '            <li class="active"><a href="index.php">Home</a></li>';
  }
  else {
    $navbar .= '            <li><a href="index.php">Home</a></li>';
  }
  if ($page == "MyVaccine"){
    $navbar .= '            <li class="active"><a href="myvaccine.html">MyVaccine</a></li>';
  }
  else {
    $navbar .= '            <li><a href="myvaccine.html">MyVaccine</a></li>';
  }
  if ($page == "Queries"){
    $navbar .= '            <li class="active"><a href="queries.php">Queries</a></li>';
  }
  else {
    $navbar .= '            <li><a href="queries.php">Queries</a></li>';
  }
  $navbar .= '          </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="signin.html"> Sign Up</a></li>
              <li><a href="login.html"> Login</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>';
  return $navbar;
  }

?>