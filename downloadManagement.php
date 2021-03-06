<?php 

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
include 'header.php'; 
?>

<html>

    <head>
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
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


        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="BStrap.css">
        <!-- Bootstrap core CSS -->


    </head>
    <body>
        <?php
        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
            $id = $_SESSION['id'];
            $userType = $_SESSION['userType'];
        }

        require_once( "db.php" );
        require_once( "lib.php" );

        dbConnect(ConfigFile);
        $dataBaseName = $GLOBALS['configDataBase']->db;
        mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

        if ($_SESSION['login'] != TRUE) {
            //REDIRECIONAR
        }

        $queryString;

        if ($userType == 3) {
            $queryString = "SELECT * FROM `smi_final`.`conteudo`";
        } else {
            $queryString = "SELECT * FROM `smi_final`.`conteudo` WHERE idUtilizador = $id";
        }

        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

        if ($queryResult) {
            ?> 
            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mb-5">
                            <h2 class="heading-section">Descarregar Conte??dos em Massa</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-wrap">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID Conte??do</th>
                                            <th>Utilizador</th>
                                            <th>Tipo Conte??do</th>
                                            <th>T??tulo</th>
                                            <th>Data Publica????o</th>
                                            <th>Descarregar</th>    
                                        </tr>
                                    </thead>
                                    
                                    <form action="downloadContent.php" method="post">
                                        <?php
                                        while ($registo = mysqli_fetch_array($queryResult)) {
                                            $idconteudo = $registo['idConteudo'];
                                            $usernamePublicador = getUserName($registo['idUtilizador']);
                                            $idTipoConteudo = getContentType($registo['idTipoConteudo']);
                                            $titulo = $registo['titulo'];
                                            $dataHora = $registo['dataHora'];
                                            $publico = $registo['publico']
                                            ?>
                                            <tr class="alert" role="alert">
                                                <td><?php echo $idconteudo ?></td>
                                                <td><?php echo $usernamePublicador ?></td>
                                                <td><?php echo $idTipoConteudo ?></td>
                                                <td><?php echo $titulo ?></td>
                                                <td><?php echo $dataHora ?></td>

                                                <td>
                                                    <input type="checkbox" name="check_list[]" value=<?php echo $idconteudo ?> />
                                                </td>
                                            </tr>    

                                            <?php
                                        }
                                    }
                                    ?>
                                            </table>
                                </div>
                            <br>
                                            <div style="text-align: center" ><input type="submit" value="Descarregar" /></div>
                                    </form>  
                            
                        
                    </div>
                </div>
            </div>
        </section>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <?php include 'footer.php'; ?>
    </body>





</html>