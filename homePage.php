
<?php
require_once( "db.php" );
require_once( "lib.php" );

include 'header.php';

if (isset($_SESSION['id'])) {
    $idUserSession = $_SESSION["id"];
}
 else {
    $idUserSession = -1;
}

$idAudio = 1;
$idFoto = 2;
$idVideo = 3;

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$queryContent = "SELECT * FROM `$dataBaseName`.`conteudo` ORDER BY conteudo.dataHora DESC";
$contentResult = mysqli_query($GLOBALS['ligacao'], $queryContent);

$queryAudio = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE conteudo.idTipoConteudo = $idAudio ORDER BY conteudo.dataHora DESC";
$audioResult = mysqli_query($GLOBALS['ligacao'], $queryAudio);

$queryFoto = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE conteudo.idTipoConteudo = $idFoto ORDER BY conteudo.dataHora DESC";
$fotoResult = mysqli_query($GLOBALS['ligacao'], $queryFoto);

$queryVideo = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE conteudo.idTipoConteudo = $idVideo ORDER BY conteudo.dataHora DESC";
$videoResult = mysqli_query($GLOBALS['ligacao'], $queryVideo);

if (!($contentResult)) {
    echo "Erro ao carregar conteudos";
    exit();
}


$flags[] = FILTER_NULL_ON_FAILURE;

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPortSSL = 443;
$serverPort = 80;

$name = webAppName();

$conteudoEspecificoUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "ConteudoEspecifico.php?id=";
?>

<!doctype html>

<html lang="en">
    <head>
        
        
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.83.1">

        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">



        <!-- Bootstrap core CSS -->

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>


    </head>
    <body>


        <main>
            <h1  class="fw-light" style="text-align: center;padding-top:30px;padding-bottom:30px">Navegar</h1>


            <div class="album py-5 bg-light" >
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
<?php
while ($registo = mysqli_fetch_array($contentResult)) {
    $idUtilizador = $registo["idUtilizador"];
    $publico = $registo["publico"];
    if (!$publico && $idUtilizador != $idUserSession)
        continue;
    $thumbnailPath = $registo["thumbnailPath"];
    $descricao = $registo["descricao"];
    $titulo = $registo["titulo"];
    $dataHora = $registo["dataHora"];
    $id = $registo["idConteudo"];
    echo ' <div class="col">
          <div class="card shadow-sm">
          <h3 class="fw-light" style="min-height:100px;max-height:100px;text-align:center">' . $titulo . '</h3>
            <a href="' . $conteudoEspecificoUrl . $id . '"><img class="card-img-top" src="' . $thumbnailPath . '"width="100%" height="225" « xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a>

            <div class="card-body" style="min-height:150px;max-height:150px">
              <p class="card-text">' . $descricao . '</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="' . $conteudoEspecificoUrl . $id . '"><button type="button"  class="btn btn-sm btn-outline-secondary">Ver</button></a>
                            </div>
                            <small class = "text-muted">' . $dataHora . '</small>
                            </div>
                            </div>
                            </div>
                            </div>';
}
?>

                    </div>
                </div>
            </div>
        </main>

        <footer class="text-muted py-5">
            <div class="container">
                <p class="float-end mb-1">
                    <a class="" style="text-decoration: none" href="#"><i class='fa fa-2x fa-arrow-up text-dark' style='color: blue'></i></a>
                </p>
            </div>
        </footer>


<?php include 'footer.php'; ?>


    </body>
</html>
