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
    <title>Error</title>
    <!-- Minified Bootstrap 3 CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!--Minified jQuery 3 JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--Latest Bootstrap 3 JS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src=https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="static/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>
  </head>
  <body>


      <!-- Main component for a primary marketing message or call to action -->
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Something went wrong...</h1>
      <p class="lead">There was an error and the page couldn't load up, please go back.</p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" onclick="goBack()" role="button">Go back</a>
      </p>
    </div> <!-- /container -->
  </div>
    
    <footer class="text-muted">
        <div class="container">
            <p>QVP © 2019 <a href="#">Back to top</a></p>
         </div>
    </footer>

  <script>
  function goBack() {
    window.history.back();
  }
  </script>

</html>