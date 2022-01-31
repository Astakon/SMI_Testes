<?php 

require_once( "db.php" );
require_once( "lib.php" );

session_start();
if (!isset($_SESSION['username'])) {
    $nextUrl = "formLogin.php";
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    $serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPort = 80;

    $name = webAppName();

    $baseUrl = "http://" . $serverName . ":" . $serverPort;

    $baseNextUrl = $baseUrl . $name;

    header("Location: " . $baseNextUrl . $nextUrl);
}
include 'header.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.83.1">
       
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

    

    <!-- Bootstrap core CSS -->

    <style>
        <?php include 'CSS.css'; ?>
        <?php include 'BStrap.css'; ?>
        </style>
        <script>
            function download3() {
                  var xmlhttp = new XMLHttpRequest();
                  xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('my_iframe').src = this.responseText;
                            
                    }
                  };
                  xmlhttp.open("GET","database_processing.php?database=Backup",true);
                  xmlhttp.send();
                
            }
        </script>
    </head>
    <body>
        
        <?php
            //include 'navbarPerfilLogout.php';
            //include 'tradutorGoogle.html';
        ?>

        <div style="text-align:center; margin-top:30px">
            <h1>Painel de controlo - Admin</h1>
        </div>
        <div id="content" style="text-align: center; margin-top:50px; padding:30px 0 30px 0" class="bg-light">
            
            <form method="POST" action='database_processing.php'  name="vform" required>
                <div class="content2">
                    <label for="reiniciar" style="display:block;"> Reiniciar base de dados</label>
                    <p class="info"> Este botão, servirá para apagar (<i class="material-icons" style="font-size:18px;color:red">warning</i>) a base dados e iniciar a base de dados vazia. </p>
                        
                            <p>Incluirá só um administrador como utilizador inicial.</p>
                    
                    
                    <input id="reiniciar" type="submit" name="database"  value="Reiniciar">
                </div>
            </form>
            
            <hr>
            <br>
            
            <div class="content2">
                <iframe id="my_iframe" style="display:none;"></iframe>
                <label for="reiniciar" style="display:block;">Backup da base de dados</label>
                <p class="info"> Download do ficheiro backup.sql (Backup da base de dados).</p>                
                <input onclick="download3();" id="reiniciar" type="submit" value="Exportar">
            </div>
            
            <hr>
            <br>
            
            <form method="POST" action='database_processing.php' enctype="multipart/form-data">
                <div class="content2">
                    <label for="reiniciar" style="display:block;">Importar backup</label>
                    <p  style="display:block;">Insira o nome da base dados e o ficheiro a importar.</p>
                    <div style="display: block; margin-bottom: 20px; margin-top: 15px;">
                        <input type="text" name="namedb" style="display: inline-block;">
                        <input type="file" name="myfile2" accept=".sql" style="display: inline-block;">
                    </div>
                    <input id="reiniciar" type="submit" name="database" value="Importar" >
                </div>
            </form>     
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

