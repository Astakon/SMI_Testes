<?php
require_once( "db.php" );
require_once( "lib.php" );

include 'header.php';

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


if (isset($_SESSION["id"])) {
    $idUserSession = $_SESSION["id"];
}
dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$queryProfile = "SELECT * FROM `$dataBaseName`.`utilizador` WHERE idUtilizador = $idUserSession";

$profileResult = mysqli_query($GLOBALS['ligacao'], $queryProfile);
$profile = mysqli_fetch_array($profileResult);
$foto = $profile["path"];
$name = $profile["username"];
?>


<html>

    <style>
<?php include 'CSS.css'; ?>

    </style>
    <head>

        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <link rel="stylesheet" typr="text/css" href="CSS.css">
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
        <script type="text/javascript" src="scripts.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {

                $("#username").keyup(function () {

                    var username = $(this).val().trim();

                    if (username != '') {

                        $.ajax({
                            url: 'ajaxfile.php',
                            type: 'post',
                            data: {field: 'username', value: username},
                            success: function (response) {
                                if (response == 1) {
                                    $('#uname_response').html("Username already in use");
                                    document.getElementById('saveName').disabled = true;
                                    document.getElementById('uname_response').style.color = 'red';
                                }
                                else{
                                    document.getElementById('saveName').disabled = false;
                                }


                            }
                        });
                    } else {
                        $("#uname_response").html("");
                        document.getElementById('saveName').disabled = false;
                    }

                });

            });
        </script>

        <!-- Bootstrap core CSS -->
        <style>
<?php include 'BStrap.css'; ?>
        
        </style>

    </head>
    <body>


        <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
            <h1 class="title text-white" style="text-align:center">Bem Vindo <?php echo $name?></h1><br>
            <div class="wrapper wrapper--w790">
                <div class="card card-5">
                    <div class="card-heading">
                        <a href="feed.php"><i class="fa fa-long-arrow-left fa-2x" style="color:white;margin-left:2%"aria-hidden="true"></i></a>
                        <h2 class="title" style="text-align:center">Configuração Perfil</h2>
                    </div>
                    <div class="card-body">
                        
                        <form action="updateProfilePicture.php" method="POST" enctype="multipart/form-data">
                            <h4 class="title text-dark" style="text-align:center">Mudar Foto de Perfil</h4><br>
                            <div class="form-row">
                                <div class="name">Foto de Perfil</div><br>
                                <div class="value">
                                    <div class="input-group">
                                        <img class="profilePicture" src="<?php echo $foto ?>" alt="My test image" style="width:100px">
                                        <input id="fileUpload" name="fileUpload" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center">
                                <input id="savePhoto" style="width:15%;padding:5px; text-align: center" type="submit" value="Guardar">
                            </div><br><br>
                        </form>
                        <form action="updateUsername.php" method="POST">
                            <h4 class="title text-dark" style="text-align:center">Mudar Nome de Utilizador</h4><br>
                            <div class="form-row">
                                <div class="name">Nome de utilizador</div>
                                <div class="value">
                                    <div class="input-group">
                                        <input type="text" required class="input--style-5" id="username" name="username" placeholder="Escreva o seu nome de utilizador novo" onkeyup="UsernameValidator2(this.value);">
                                        <span id="uname_response"></span>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center">
                                <input id="saveName" style="width:15%;padding:5px; text-align: center" type="submit" value="Guardar">
                            </div><br><br>
                        </form>
                        <form action="updatePassword.php" method="POST">
                            <h4 class="title text-dark" style="text-align:center">Mudar palavra-passe</h4><br>
                            <div class="form-row">
                                <div class="name">Palavra Passe</div>
                                <div class="value">
                                    <div class="input-group">
                                        <input type="password" required class="input--style-5"  name="password" placeholder="Escreva a sua palavra-passe nova" onkeyup="PasswordValidator2(this.value);">
                                        <span id='passwordReg'></span>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center">
                                <input id="savePw" style="width:15%;padding:5px; text-align: center" type="submit" value="Guardar">
                            </div><br><br>
                        </form>
<?php if (isset($_SESSION['error'])) { ?>
                            <div class="error" ><strong><?php echo($_SESSION['error']) ?></strong></div><br>


    <?php
    unset($_SESSION['error']);
}
?>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php include 'footer.php'; ?>
    </body>


</html>