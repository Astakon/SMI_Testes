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
    <body style="background-color:#f8f9fd">
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

        $queryString = "SELECT * FROM `smi_final`.`utilizador`";

        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

        if ($queryResult) {
            ?>
            <section class = "ftco-section">
                <div class = "container">
                    <div class = "row justify-content-center">
                        <div class = "col-md-6 text-center mb-5">
                            <h2 class = "heading-section">Gestão de Utilizadores</h2>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "table-wrap">
                                <table class = "table">
                                    <thead class = "thead-dark">
                                        <tr>
                                            <th>ID Utilizador</th>
                                            <th>Nome de Utilizador</th>
                                            <th>Tipo Utilizador</th>
                                            <th>Email</th>
                                            <th>Data Nascimento</th>
                                            <th>Tipo Utilizador</th>
                                            <th>Bloquear/Desbloquear</th>
                                            <th>Apagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($registo = mysqli_fetch_array($queryResult)) {
                                            $idUsera = $registo['idUtilizador'];
                                            $usernamea = $registo['username'];
                                            $idTipo = $registo['idTipoUtilizador'];
                                            $Email = $registo['email'];
                                            $dataHora = $registo['data_nascimento'];
                                            $ativo = $registo['ativo'];
                                            ?>
                                            <tr class="alert" role="alert">
                                                <td><?php echo $idUsera ?></td>
                                                <td><?php echo $usernamea ?></td>
                                                <td><?php  if($idTipo ==1){
                                                            echo "Utilizador";
                                                        }
                                                        else if($idTipo == 2){
                                                            echo "Simpatizante";
                                                        }
                                                        else{
                                                            echo "Administrador";
                                                        }
                                                            ?> </td>
                                                <td><?php echo $Email ?></td>
                                                <td><?php echo $dataHora ?></td>

                                                <td><form action="updateUserType.php">
                                                        <input list="aa" name="NTipo" >
                                                        <datalist id="aa">
                                                            <option value="1">Utilizador</option>
                                                            <option value="2">Simpatizante</option>
                                                            <option value="3">Administrador</option>
                                                        </datalist>
                                                        <input type="hidden" name="idUser" value=<?php echo $idUsera ?> />
                                                        <input type="submit" value="Atualizar" />
                                                    </form></td>

                                                <td><form action="updateUser.php">
                                                        <input type="submit" value=<?php  if($ativo ==1){
                                                            echo "Desbloqueado";
                                                        }
                                                        else{
                                                            echo "Bloqueado";
                                                        }
                                                            ?> />
                                                        <input type="hidden" name="idUser" value=<?php echo $idUsera ?> />
                                                        <input type="hidden" name="ativo" value=<?php echo $ativo ?> />
                                                    </form></td>

                                                <td><form action="deleteUser.php">
                                                        <input type="submit" value="Apagar" />
                                                        <input type="hidden" name="idUser" value=<?php echo $idUsera ?> />

                                                    </form></td>

                                            </tr>    

                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
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