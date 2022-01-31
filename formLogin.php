<!DOCTYPE html>
<?php include 'header.php'; ?>
<?php
    require_once( "lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormLogin.php";
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.83.1">
       
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

        <!-- Icons font CSS-->
        <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <!-- Font special for pages-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

        <!-- Vendor CSS-->
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="css/main.css" rel="stylesheet" media="all">

    <!-- Bootstrap core CSS -->

    <style>
        <?php include 'BStrap.css'; ?>
    </style>
    
    <body>
        
         <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <a href="feed.php"><i class="fa fa-long-arrow-left fa-2x" style="color:white;margin-left:2%"aria-hidden="true"></i></a>
                    <h2 class="title" style="text-align:center">Login</h2>
                </div>
                <div class="card-body">
                    <form action="<?php echo $nextUrl ?>" method="POST">
                        <div class="form-row">
                            <div class="name">Nome de utilizador</div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="text" required class="input--style-5" name="username" placeholder="Escreva o seu nome de utilizador">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="name">Palavra Passe</div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="password" required class="input--style-5"  name="password" placeholder="Escreva a sua palavra-passe">
                                </div>
                            </div>
                        </div>
                        <?php 
        if(isset($_SESSION['error']) ){?>
                        <div class="error" ><strong><?php echo($_SESSION['error']) ?></strong></div><br>
          
            
        <?php 
        unset($_SESSION['error']);
        
        }
        
        
        ?>
                        <div style="text-align:center">
                            <input style="width:15%;padding:5px; text-align: center" type="submit" value="Login"><br><br>
                            <a href="formRegister.php" style="    text-transform: inherit;" class="btn btn-warning" role="button">Não tenho conta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
                
        <!-- Jquery JS-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <!-- Vendor JS-->
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/datepicker/moment.min.js"></script>
        <script src="vendor/datepicker/daterangepicker.js"></script>

       <?php include 'footer.php'; ?>
    </body>
</html>
