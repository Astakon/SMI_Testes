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
    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
        $id = $_SESSION['id'];
        $userType = $_SESSION['userType'];  
    }
    
    require_once( "db.php" );
    require_once( "lib.php" );
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    if($_SESSION['login'] != TRUE){
        //REDIRECIONAR
    }


$username = "Username";
$notificacoes = ["Notificação 1", "Notificação 2", "Notificação 3"];
$videoBlob = "images/video.png";
$desc = "This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.";
$time = "9 mins";
$titulo = "O meu jogo";

?>


<html>

    <style>
<?php include 'CSS.css'; ?>

    </style>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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

    <!-- Bootstrap core CSS -->

    <style>
        <?php include 'BStrap.css'; ?>
        
    </style>
    
</head>
<body>
        <h1  style="text-align: center">Notificações</h1>
        
        <div class="album py-5 bg-light" >
            <div class="container" style="text-align:center">
      
          <?php
          $queryString = "SELECT * FROM `smi_final`.`notificacao` WHERE idUtilizador ='$id' AND seen = '0'";
    
          $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );
          $count = 0;
          if($queryResult){
              while ($registo = mysqli_fetch_array($queryResult)) {
                  $idCont = $registo['idConteudo'];
                  $queryStringCont = "SELECT * FROM `smi_final`.`conteudo` WHERE idConteudo = '$idCont'";
                  $queryResultNot = mysqli_query( $GLOBALS['ligacao'], $queryStringCont );
                  if($queryResultNot){
                      while ($registoCont = mysqli_fetch_array($queryResultNot)) {
                          $count++;
                          $titulo = $registoCont['titulo'];
                          $thumbnail = $registoCont['thumbnailPath'];
                          $desc = $registoCont['descricao'];
                          $time = $registoCont['dataHora'];
                          echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" > 
           <div class="col coluna" style="margin-bottom:25px;">
          <div class="card shadow-sm">
          <div >
          <h3 style="display:inline-flex;" class="fw-light">' .$titulo .'</h3>
          <a href="seenNotification.php?idCont='. $idCont.'&idUser='. $id .'" style="color:black;" ><i style="float:right;margin:5px;" class="fa fa-times-circle text-danger" style=""></i></a>
            </div>
            <a href="ConteudoEspecifico.php?id='.$idCont.'"><img class="card-img-top" src="'.$thumbnail.'"width="100%" height="225" « xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a>

            <div class="card-body">
              <p class="card-text">'.$desc .'</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="ConteudoEspecifico.php?id='.$idCont.'"><button type="button" class="btn btn-sm btn-outline-secondary">Ver</button></a>
                </div>
                <small class="text-muted">'.$time . '</small>
              </div>
            </div>
          </div>
    </div> </div>';
                      }
                  }
                  
              }
          }
          if($count == 0)
              echo "<h1>Não tem notificações de momento!</h1>"
        ?>
   
     
    </div>
  </div>
                 
            
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <?php include 'footer.php'; ?>
</body>


</html>