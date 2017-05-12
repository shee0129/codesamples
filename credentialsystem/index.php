<!----
+-------------------------------------------------------------------------------------+
 | File Name: index.php		                                                          |
 | Page name: Gopher Athletics Season Working Credentials Home Page                   |
 | Author: Krista Sheely                                                              |
 | Written: 05/2014                                                                   |
 | Tables: none												                          |
 | Description: Main landing page for credential system						 		  |		
 |  																                  |
 | Updates: 												                          |
 |  																                  |
 |														                              |
+-------------------------------------------------------------------------------------+
--->
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Gopher Athletics Season Working Credentials</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link href="/include/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="/include/bootstrap/js/bootstrap.min.js"></script>


    <style>
        body
        {
            background-color: #761e2e;
            margin:0;
            font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size:14px;
            line-height:1.42857143;
            color:#333;
        }

        .container
        {
            background-color:#ffffff;

        }

        html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}
    </style>
    
<body>
<div class="container">

    <div class="page-header">

        <h1><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> Gopher Athletics Credential Requests</h1>
    </div>

    <style>
        a, a.list-group-item
        {
            color: #761e2e;
        }
    </style>

    <p>The following system allows users to request <strong>Non-Media</strong> Game Day and Season Passes. If you need to request <strong>Media</strong> passes, please <a href="media/index.php">click here</a>. </p>
    <div class="list-group" style="width: 50%; margin: 15px 0;">
        <a href="#" class="list-group-item disabled">
            Single Game Requests
        </a>
        <a href="singlegame.php" class="list-group-item">Submit a Single Game Credential Request</a>
    </div>
    <div class="list-group" style="width: 50%; margin: 15px 0;">
        <a href="#" class="list-group-item disabled">
            Season Working Requests
        </a>
        <a href="season.php" class="list-group-item">Submit a Season Working Credential Request</a>
    </div>
    <div style="clear:both;"></div>

    <div style="padding: 50px;"><a href="https://www.athletics.umn.edu/credentials/private/admin.php"> <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>  Admin Page</a></div>



</div>
</body>
</html>  