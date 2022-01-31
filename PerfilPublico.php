<?php include 'header.php'; ?>
<?php

require_once( "db.php" );
require_once( "lib.php" );

$idAudio = 1;
$idFoto = 2;
$idVideo = 3;

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

if (isset($_SESSION["id"])) {
    $idUser = $_SESSION["id"];
}
if (isset($_GET["id"])) {
    $tipo = $_GET["id"];
    $queryContent = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE idUtilizador = $tipo ORDER BY conteudo.dataHora DESC";
    $queryProfile = "SELECT * FROM `$dataBaseName`.`utilizador` WHERE idUtilizador = $tipo";
    $querySubs = "SELECT count(*) AS `value` FROM `$dataBaseName`.`subscricao_utilizador` WHERE idPublicador= $tipo";
}

$contentResult = mysqli_query($GLOBALS['ligacao'], $queryContent);
$profileResult = mysqli_query($GLOBALS['ligacao'], $queryProfile);
$subsResult = mysqli_query($GLOBALS['ligacao'], $querySubs);

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

        <!-- Vendor CSS-->
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="css/main.css" rel="stylesheet" media="all">
        <script type="text/javascript" src="functions.js"></script>

    <!-- Bootstrap core CSS -->
    <style>
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
<?php 
include 'profileStyle.css';include 'CSS.css';
?>
<?php include 'BStrap.css'; 
?>
    </style>

    
    
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
                    <img class="profilePicture" src="<?php echo $foto ?>" alt="My test image" style="width:100%;height: 100%">
                </div>
    
                <div class="profile-header-info">
                    <h4 class="m-t-sm username"><?php echo $username ?></h4>
                    <?php 
                    $subsResults = mysqli_fetch_array($subsResult); 
                    $subscritores = $subsResults["value"];
                    ?>
                    <p class="m-b-sm"><?php echo $subscritores;?> Subscritores</p>
                    <?php
                    if (isset($_SESSION["id"])) {
            if ($tipo == $idUser ) {?>
                <button class="btn btn-xs btn-light mb-4" >Subscrito</button>
                <?php
            } else {
                $idPublicador = $tipo;
                $querySubscricao = "SELECT * FROM `$dataBaseName`.`subscricao_utilizador` WHERE idSubscritor = $idUser AND idPublicador = $tipo";
                $subcricaoResult = mysqli_query($GLOBALS['ligacao'], $querySubscricao);
                if (mysqli_num_rows($subcricaoResult) == 0) {
                    ?> 
                    <button class="btn btn-xs btn-info mb-4" onclick="subscribeFunction(1, <?php echo $idUser ?>, <?php echo $tipo ?>)">Subscrever</button>
                    <?php
                } else {?>
                    <button class="btn btn-xs btn-light mb-4" onclick="subscribeFunction(0, <?php echo $idUser ?>, <?php echo $tipo ?>)">Subscrito</button>
                    <?php
            }}
            }
            ?>
                    
                </div>
            </div>
    
            <ul class="profile-header-tab nav nav-tabs">
                <li class="nav-item"><a href="#profile-post" class="nav-link active show" data-toggle="tab">Feed</a></li>
            </ul>
        </div>
    
        <main>

 
 

  <div class="album py-5 bg-light" >
    <div class="container">
 <h2 class="fw-light" >Conteúdo</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
        while ($registo = mysqli_fetch_array($contentResult)) {
    $idUtilizador = $registo["idUtilizador"];
    $publico = $registo["publico"];
    if (!$publico && $idUtilizador != $idUser)
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
    </div>
</div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include 'footer.php'; ?>
</body>


</html>