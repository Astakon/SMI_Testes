
<?php
require_once( "db.php" );
require_once( "lib.php" );

include 'header.php';

if (isset($_SESSION["id"])) {
    $idUserSession = $_SESSION["id"];
}

$idAudio = 1;
$idFoto = 2;
$idVideo = 3;

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

if (isset($_GET["categoria"])) {
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];

        $categoriaAux = $_GET["categoria"];
        $queryCategoria = "SELECT `nome` FROM `$dataBaseName`.`categoria` WHERE categoria.idCategoria = $categoriaAux ";
        $categoriaResult = mysqli_fetch_array(mysqli_query($GLOBALS['ligacao'], $queryCategoria));
        $categoria = $categoriaResult[0];

        $queryContent = "SELECT CONTEUDO.idConteudo, categoria.nome AS categoria, subcategoria.nome AS subcategoria, conteudo.idTipoConteudo,CONTEUDO.idUtilizador, CONTEUDO.titulo, CONTEUDO.dataHora, CONTEUDO.descricao, conteudo.thumbnailPath,CONTEUDO.publico
    FROM `$dataBaseName`.`conteudo`
    INNER JOIN `$dataBaseName`.`conteudo_sub_categoria`
    ON conteudo.idConteudo = conteudo_sub_categoria.idConteudo
    INNER JOIN `$dataBaseName`.`subcategoria`
    ON subcategoria.idSubCategoria = conteudo_sub_categoria.idSubCategoria
    INNER JOIN `$dataBaseName`.`categoria`
    ON categoria.idCategoria = subcategoria.idCategoria
    WHERE categoria.nome = '$categoria' AND idTipoConteudo = $tipo";
        $contentResult = mysqli_query($GLOBALS['ligacao'], $queryContent);
        
        $queryTipo = "SELECT `tipo` FROM `$dataBaseName`.`tipo_conteudo` WHERE idTipoConteudo = $tipo ";
        $tipoResult = mysqli_fetch_array(mysqli_query($GLOBALS['ligacao'], $queryTipo));
        $tipoName = $tipoResult[0];
        
    } else {
        $tipo = "";
        $categoriaAux = $_GET["categoria"];
        $queryCategoria = "SELECT `nome` FROM `$dataBaseName`.`categoria` WHERE categoria.idCategoria = $categoriaAux";
        $categoriaResult = mysqli_fetch_array(mysqli_query($GLOBALS['ligacao'], $queryCategoria));
        $categoria = $categoriaResult[0];
        $tipoName = "Todos";
        $queryContent = "SELECT CONTEUDO.idConteudo, categoria.nome AS categoria, subcategoria.nome AS subcategoria, conteudo.idTipoConteudo,CONTEUDO.idUtilizador, CONTEUDO.titulo, CONTEUDO.dataHora, CONTEUDO.descricao, conteudo.thumbnailPath,CONTEUDO.publico
    FROM `$dataBaseName`.`conteudo`
    INNER JOIN `$dataBaseName`.`conteudo_sub_categoria`
    ON conteudo.idConteudo = conteudo_sub_categoria.idConteudo
    INNER JOIN `$dataBaseName`.`subcategoria`
    ON subcategoria.idSubCategoria = conteudo_sub_categoria.idSubCategoria
    INNER JOIN `$dataBaseName`.`categoria`
    ON categoria.idCategoria = subcategoria.idCategoria
    WHERE categoria.nome = '$categoria'";
        $contentResult = mysqli_query($GLOBALS['ligacao'], $queryContent);
    }
} else {
    if (isset($_GET["tipo"])) {
        $categoria = "";
        $tipo= $_GET["tipo"];
        $queryTipo = "SELECT `tipo` FROM `$dataBaseName`.`tipo_conteudo` WHERE idTipoConteudo = $tipo ";
        $tipoResult = mysqli_fetch_array(mysqli_query($GLOBALS['ligacao'], $queryTipo));
        $tipoName = $tipoResult[0];

        $queryContent = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE idTipoConteudo = $tipo ORDER BY conteudo.dataHora DESC";
        $contentResult = mysqli_query($GLOBALS['ligacao'], $queryContent);
    }
}


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
        <script type="text/javascript" src="functions.js"></script>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">



        <!-- Bootstrap core CSS -->

        <style>
<?php include 'CSS.css'; ?>
<?php include 'BStrap.css'; ?>
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
            <div style="text-align:center">
<h1  class="fw-light" style="text-align:center;padding-top:10px;padding-bottom:30px;display:inline-block"><?php echo $categoria ?> - <?php echo $tipoName ?></h1>
<?php if(isset($_GET["categoria"])){
 
                        if (isset($_SESSION["id"])) {
                            
                            
                                $querySubscricao = "SELECT * FROM `$dataBaseName`.`subscricao_categoria` WHERE idSubscritor = $idUserSession AND idCategoria = $categoriaAux";
                                
                                $subcricaoResult = mysqli_query($GLOBALS['ligacao'], $querySubscricao);
                                
                                if (mysqli_num_rows($subcricaoResult) == 0) {
                                    ?> 
                                    <button style="margin-bottom:0.8rem !important;margin-left:30px;" class="btn btn-xs btn-info mb-4" onclick="subscribeFunction2(1, <?php echo $idUserSession ?>, <?php echo $categoriaAux ?>)">Subscrever</button>
                                <?php } else {
                                    ?>
                                    <button style="margin-bottom:0.8rem !important;margin-left:30px;" class="btn btn-xs btn-dark mb-4" onclick="subscribeFunction2(0, <?php echo $idUserSession ?>, <?php echo $categoriaAux ?>)">Subscrito</button>
                                    <?php
                                
                            }
                        }
                        
}
?>
            </div>
            
                
                <?php if (strlen($categoria)>0){?>
                <div style="text-align: center; margin-top: 10px">
                    <div class="dropdown">
                        <button class="dropbtn">Tipo</button>
                        <div class="dropdown-content">


                            <a href="Categorias.php?categoria=<?php echo $categoriaAux ?>&tipo=3">Vídeos</a>
                            <a href="Categorias.php?categoria=<?php echo $categoriaAux ?>&tipo=1">Áudios</a>
                            <a href="Categorias.php?categoria=<?php echo $categoriaAux ?>&tipo=2">Fotos</a>
                            <a href="Categorias.php?categoria=<?php echo $categoriaAux ?>">Todos</a>

                        </div>
                    </div>
                </div>
                <?php }?>
            

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
                    <a href="#">Back to top</a>
                </p>
            </div>
        </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php include 'footer.php'; ?>


    </body>
</html>

