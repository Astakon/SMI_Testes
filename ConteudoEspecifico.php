<?php
include 'header.php';
require_once( "db.php" );
require_once( "lib.php" );

$idConteudo = $_GET["id"]; //Receber id do conteudo aqui
if (isset($_SESSION["id"])) {
    $idUserSession = $_SESSION["id"];
}

$gestaoDeConteudosFile = ""; //nome do file para a gestao de conteudos


$flags[] = FILTER_NULL_ON_FAILURE;

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPortSSL = 443;
$serverPort = 80;

$name = webAppName();

$gestaoDeConteudosFile = "https://" . $serverName . ":" . $serverPortSSL . $name . $gestaoDeConteudosFile;

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$utilizadorArray;
$conteudoArray;
$subANDcategoryArray;

$queryConteudo = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE conteudo.idConteudo = $idConteudo";
$conteudoResult = mysqli_query($GLOBALS['ligacao'], $queryConteudo);

if ($conteudoResult) {
    $conteudoArray = mysqli_fetch_array($conteudoResult);
    $idUtilizador = $conteudoArray['idUtilizador'];
    $queryUtilizador = "SELECT * FROM `$dataBaseName`.`utilizador` WHERE utilizador.idUtilizador = $idUtilizador";
    $utilizadorResult = mysqli_query($GLOBALS['ligacao'], $queryUtilizador);

    if ($utilizadorResult) {
        $utilizadorArray = mysqli_fetch_array($utilizadorResult);
    } else {
        echo "Erro ao carregar utilizadores em ConteudoEspecifico.php";
        exit();
    }


    $queryComentarios = "SELECT * FROM `$dataBaseName`.`comentario` WHERE idConteudo = $idConteudo";
    $comentariosResult = mysqli_query($GLOBALS['ligacao'], $queryComentarios);
    if (!$comentariosResult) {
        echo "Erro ao carregar comentarios em ConteudoEspecifico.php";
        exit();
    }

    if (isset($_SESSION["id"])) {
    $classificacaoString = "SELECT * FROM `$dataBaseName`.`classificacao` WHERE idUtilizador = $idUserSession AND idConteudo = $idConteudo";
    $classificacaoResult = mysqli_query($GLOBALS['ligacao'], $classificacaoString);
    if (!$classificacaoResult) {
        echo "Erro ao carregar classificacao em ConteudoEspecifico.php";
        exit();
    }
    }
    $querySubCat = "SELECT subcategoria.nome AS subnome, categoria.nome AS catnome
    FROM `$dataBaseName`.`conteudo`
    JOIN `$dataBaseName`.`conteudo_sub_categoria`, `$dataBaseName`.`subcategoria`, `$dataBaseName`.`categoria`
    WHERE conteudo.idConteudo = $idConteudo AND conteudo_sub_categoria.idConteudo = conteudo.idConteudo AND 
    conteudo_sub_categoria.idSubCategoria = subcategoria.idSubCategoria AND 
    subcategoria.idCategoria = categoria.idCategoria";

    $subCatResult = mysqli_query($GLOBALS['ligacao'], $querySubCat);

    if ($subCatResult) {
        $subANDcategoryArray = mysqli_fetch_array($subCatResult);
    } else {
        echo "Erro ao carregar sub ou categoria";
        exit();
    }


    $queryProfile = "SELECT * FROM `$dataBaseName`.`utilizador` WHERE idUtilizador = $idUtilizador";
    $querySubs = "SELECT count(*) AS `value` FROM `$dataBaseName`.`subscricao_utilizador` WHERE idPublicador= $idUtilizador";

    $profileResult = mysqli_query($GLOBALS['ligacao'], $queryProfile);
    $subsResult = mysqli_query($GLOBALS['ligacao'], $querySubs);
} else {
    echo "Erro ao carregar conteudo";
    exit();
}
?>


<html>
    <style>
#box {
  font-size: 2.5rem;
}
.gradient-border {
  --borderWidth: 3px;
  background: #eaeaea;
  position: relative;
  border-radius: var(--borderWidth);
}
.gradient-border:after {
  content: '';
  position: absolute;
  top: calc(-1 * var(--borderWidth));
  left: calc(-1 * var(--borderWidth));
  height: calc(100% + var(--borderWidth) * 2);
  width: calc(100% + var(--borderWidth) * 2);
  background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
  border-radius: calc(2 * var(--borderWidth));
  z-index: -1;
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 300% 300%;
}


@keyframes animatedgradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
<?php include 'CSS.css'; ?>
<?php
include 'BStrap.css';
include 'profileStyle.css';
?>

    </style>
    <head>
        <script type="text/javascript" src="functions.js"></script>

        <meta charset="UTF-8">
        <title>SMI exemplos</title>


    <h1  style="text-align: center; margin-top:20px;margin-bottom:20px">
        <?php
        echo $conteudoArray['titulo'];
        ?>
    </h1>
</head>
<body>
    <div class="container">
        <div id="content" class="content p-0">
            <div class="profile-header">
                <div class="profile-header-cover"></div>

                <div class="profile-header-content">
                    <div class="profile-header-img gradient-border">
                        <?php
                        $profile = mysqli_fetch_array($profileResult);
                        $foto = $profile["path"];
                        $username = $profile["username"];
                        ?>
                        <a href="PerfilPublico.php?id=<?php echo $utilizadorArray["idUtilizador"] ?>"><img class="profilePicture" src="<?php echo $foto ?>" alt="My test image"  style="width:100%;height: 100%"></a>
                    </div>

                    <div class="profile-header-info">
                        <a href="PerfilPublico.php?id=<?php echo $utilizadorArray["idUtilizador"] ?>"><h4 class="m-t-sm username text-light"><?php echo $username ?></h4></a>
                        <?php
                        $subsResults = mysqli_fetch_array($subsResult);
                        $subscritores = $subsResults["value"];
                        ?>
                        <p class="m-b-sm"><?php echo $subscritores; ?> Subscritores</p>
                        <?php
                        if (isset($_SESSION["id"])) {
                            
                            if ($idUtilizador == $idUserSession) {
                                
                                ?>
                                <button class="btn btn-xs btn-light mb-4" >Subscrito</button>
                                <?php
                            } else {
                                $idPublicador = $utilizadorArray['idUtilizador'];
                                $querySubscricao = "SELECT * FROM `$dataBaseName`.`subscricao_utilizador` WHERE idSubscritor = $idUserSession AND idPublicador = $idPublicador";
                                $subcricaoResult = mysqli_query($GLOBALS['ligacao'], $querySubscricao);
                                if (mysqli_num_rows($subcricaoResult) == 0) {
                                    ?> 
                                    <button class="btn btn-xs btn-info mb-4" onclick="subscribeFunction(1, <?php echo $idUserSession ?>, <?php echo $idPublicador ?>)">Subscrever</button>
                                <?php } else {
                                    ?>
                                    <button class="btn btn-xs btn-light mb-4" onclick="subscribeFunction(0, <?php echo $idUserSession ?>, <?php echo $idPublicador ?>)">Subscrito</button>
                                    <?php
                                }
                            }
                        }
                        ?>

                    </div>
                </div>

                <ul class="profile-header-tab nav nav-tabs">
                    <li class="nav-item"><a href="#profile-post" class="nav-link active show" data-toggle="tab">Publicado por</a></li>
                </ul>
            </div>

            <main>

                <br>

                <div style="text-align: center"> 
                    <?php
#Audio
                    if ($conteudoArray['idTipoConteudo'] == 1) {
                        echo "<audio controls autoplay style='width:400px'>"
                        . "<source src='" . $conteudoArray['path'] . "'</source>"
                        . "</audio>";
                    }
#Foto
                    else if ($conteudoArray['idTipoConteudo'] == 2) {
                        echo "<img src='" . $conteudoArray['path'] . "' style='width:auto; max-width:100%;'>";
                    }
#Video
                    else if ($conteudoArray['idTipoConteudo'] == 3) {
                        echo "<video controls style='width:100%;max-width:100%;'>"
                        . "<source src='" . $conteudoArray['path'] . "'</source>"
                        . "</video>";
                    }
                    ?>

                    </div>
                    <br><br><br>
                    <div style="margin:auto"> 
                    <div class="gradient-border" id="box" style=" padding: 20px">
                        <div style="">
                        <h3 style="display: inline-block; color: gray; width:10%">Descricao: </h3>
                        <h3 style="display: inline-block ; width:50%"><?php echo $conteudoArray['descricao'] ?></h3>
                        <div style="float:right">
                            <h3 style="display: inline-block; color: gray">Classificação: </h3>
                        <?php
                        if (isset($_SESSION["id"])) {
                            if (mysqli_num_rows($classificacaoResult) > 0) {
                                if (mysqli_fetch_array($classificacaoResult)["gostou"]) {
                                    echo "<button id='likeBtn'  onclick='changeClassification(1, $idUserSession, $idConteudo )'><i class='fa fa-thumbs-up' style='color: blue'></i></button>";
                                    echo "<button id='dislikeBtn' onclick='changeClassification(-1, $idUserSession, $idConteudo)'><i class='fa fa-thumbs-down'></i></button>";
                                } else {
                                    echo "<button id='likeBtn' onclick='changeClassification(1, $idUserSession, $idConteudo)'><i class='fa fa-thumbs-up'></i></button>";
                                    echo "<button id='dislikeBtn'  onclick='changeClassification(-1, $idUserSession, $idConteudo)'><i class='fa fa-thumbs-down' style='color: blue'></i></button>";
                                }
                            } else {
                                echo "<button id='likeBtn' onclick='changeClassification(1, $idUserSession, $idConteudo)'><i class='fa fa-thumbs-up'></i></button>";
                                echo "<button id='dislikeBtn'onclick='changeClassification(-1, $idUserSession, $idConteudo)'><i class='fa fa-thumbs-down'></i></button>";
                            }
                        } else {
                            echo "<button id='likeBtn' ><i class='fa fa-thumbs-up'></i></button>";
                            echo "<button id='dislikeBtn'><i class='fa fa-thumbs-down'></i></button>";
                        }
                        ?>

                        <h3 id="classificacao" style="display: inline-block"> <?php echo $conteudoArray['classificacao'] ?></h3>
                    </div></div>
                   </div><br><div class="gradient-border" id="box" style=" padding: 20px">
                        <div style="">
                    
                        <h3 style="display: inline-block; color: gray">Categoria: </h3>
                        <h3 style="display: inline-block"><?php echo $subANDcategoryArray["catnome"] ?></h3>
                    

                    <div style="float:right">
                        <h3 style="display: inline-block; color: gray">Sub-Categoria: </h3>
                        <h3 style="display: inline-block"><?php echo $subANDcategoryArray["subnome"] ?></h3>
                    </div></div></div><br>
                    <div class="gradient-border" id="box" style=" padding: 20px">
                        <div>
                        <h3 style="display: inline-block; color: gray">Publicado a: </h3>
                        <h3 style="display: inline-block"><?php echo $conteudoArray['dataHora'] ?></h3>
                    </div>
                       </div> 
                    <br><br>
                    
                    <div>
                        
                        <h3 style="display: inline-block; color: gray">Comentários: </h3>
                        <div id="addComentInput">
                            <br>
                            <?php if (isset($_SESSION["id"])) { ?>

                                <input type="text" id="newComent">
                                <?php
                                echo "<input type='button' value='Adicionar' onclick='editComment(1, $idUserSession , $idConteudo, -1)'";
                            }
                            ?>

                        </div>
                        <?php
                        while ($registo = mysqli_fetch_array($comentariosResult)) {
                            $idUtilizador = $registo['idUtilizador'];
                            $idComentario = $registo['idComentario'];
                            $texto = $registo['texto'];
                            $publico = $registo['publico'];
                            if (!$publico)
                                continue;
                            $queryUtilizador = "SELECT `username` FROM `$dataBaseName`.`utilizador` WHERE idUtilizador = $idUtilizador";
                            $utilizadorResult = mysqli_query($GLOBALS['ligacao'], $queryUtilizador);
                            if ($utilizadorResult) {
                                $username = mysqli_fetch_array($utilizadorResult)["username"];

                                if (isset($_SESSION["id"]) && $idUtilizador == $idUserSession) {
                                    echo "<p>$username: $texto</p><button onclick='editComment(0, $idUserSession , $idConteudo, $idComentario)'><i class='fa fa-trash'></i></button>";
                                } else {
                                    echo "<p>$username: $texto</p>";
                                }
                            } else {
                                echo "Erro ao carregar utilizador em ConteudoEspecifico.php";
                                exit();
                            }
                        }
                        ?>
                    </div>
<br>
                    <?php
                    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    $nomeConteudo = $conteudoArray['titulo'];
                    ?>
<h3 style=" color: gray">Partilhar no Twitter</h3>
                    <a href="#" onclick="shareTwitter('<?php echo $CurPageURL ?>', '<?php echo $nomeConteudo ?>')" ><i class='fa fa-2x fa-twitter'></i></a>
                </div>
<br>
<br>
</main>
    </div>
</div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                <?php include 'footer.php'; ?>
                </body>


                </html>