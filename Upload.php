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
include 'header.php';
dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$queryCategories = "SELECT * FROM `$dataBaseName`.`categoria`";
$categoriesResult = mysqli_query($GLOBALS['ligacao'], $queryCategories);

$querySubCategories = "SELECT * FROM `$dataBaseName`.`subcategoria`";
$subCategoriesResult = mysqli_query($GLOBALS['ligacao'], $querySubCategories);

$queryIdiomas = "SELECT * FROM `$dataBaseName`.`tipo_idioma`";
$idiomasResult = mysqli_query($GLOBALS['ligacao'], $queryIdiomas);

$queryTipoConteudo = "SELECT * FROM `$dataBaseName`.`tipo_conteudo`";
$tipoConteudoResult = mysqli_query($GLOBALS['ligacao'], $queryTipoConteudo);

$flags[] = FILTER_NULL_ON_FAILURE;

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPortSSL = 443;
$serverPort = 80;

$name = webAppName();

$nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "ProcessUpload.php";
?>


<html>

    
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.83.1">
       
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
        
    
    <script type="text/javascript" src="functions.js"></script>


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
        
        <style>
        <?php include 'BStrap.css'; ?>

    </style>
</head>
<body>
    
    
    
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <a href="formLogin.php"><i class="fa fa-long-arrow-left fa-2x" style="color:white;margin-left:2%"aria-hidden="true"></i></a>
                    <h2 class="title" style="text-align:center">Publicar novo conteúdo</h2>
                </div>
                <div class="card-body">
                    <form id="formParent" action="<?php echo $nextUrl ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="name">Título</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="text" id="title" name="title"><br><br>
                                    <span id="uname_response"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Descrição</div>
                            <div class="value">
                                <div class="input-group">
                                    <textarea class="input--style-5" required style="border:0" rows="3" cols="60" id="description" name="description"></textarea><br><br>
                                    <span id="email_response"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Categorias:</div>
                            <div class="value">
                                <div class="input-group">
                                   <select style="border:0" class="input--style-5"
                onchange="SelectCategoryChange(this)" 
                name="categories" 
                id="categories" 
                required>

                <?php
                if ($categoriesResult) {
                    echo "<option value=\"0\">Selecione uma categoria</option>\n";
                    while ($registo = mysqli_fetch_array($categoriesResult)) {
                        $nome = $registo['nome'];
                        $id = $registo['idCategoria'];
                        echo "<option value=\"$id\">$nome</option>\n";
                    }
                } else {
                    echo "<option value=\"-1\">Não existem categorias</option>\n";
                }
                ?>
            </select><br><br>
            
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Sub Categoria:</div>
                            <div class="value">
                                <div class="input-group">
                                    <div id="addSubInput" style="border:0; display: none"  >
                    <input type="text" class="input--style-5" id="newSubCategory">
                    <br>
                    <input type="button" value="Adicionar" onclick="addSubCategory(this)">
            </div>
            <select style="border:0" class="input--style-5" name="subcategories" id="subcategories">

            </select><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Idioma:</div>
                            <div class="value">
                                <div class="input-group">
                                    <select style="border:0" class="input--style-5" name="idioma" id="idioma">
                <?php
                if ($idiomasResult) {
                    while ($registo = mysqli_fetch_array($idiomasResult)) {
                        $id = $registo['idTipoIdioma'];
                        $tipo = $registo['tipo'];
                        echo "<option value=\"$id\">$tipo</option>\n";
                    }
                } else {
                    echo "<option value=\"-1\">Não existem idiomas</option>\n";
                }
                ?>
            </select><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Tipo de Conteúdo</div>
                            <div class="value">
                                <div class="input-group">
                                    <select style="border:0" class="input--style-5"
                name="tipoConteudo" 
                id="tipoConteudo" 
                onchange="contentTypeHandler()" >
                    <?php
                    if ($tipoConteudoResult) {

                        while ($registo = mysqli_fetch_array($tipoConteudoResult)) {
                            $id = $registo['idTipoConteudo'];
                            $tipo = $registo['tipo'];
                            echo "<option value=\"$id\">$tipo</option>\n";
                        }
                    } else {
                        echo "<option value=\"-1\">Não existem tipos de conteudos</option>\n";
                    }
                    ?>
            </select ><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Carregar Thumbnail</div>
                            <div class="value">
                                <div class="input-group">
                                   <input type="file" id="thumbnailUpload" name="thumbnailUpload[]" multiple="multiple"><br><br>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="name">Carregar Conteúdo</div>
                            <div class="value">
                                <div class="input-group">
                                   <input type="file" id="fileUpload" name="fileUpload[]" multiple="multiple" required><br><br>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="name">Visibilidade Pública</div>
                            <div class="value">
                                <div class="input-group">
                                   <input type="checkbox" id="publico" name="publico" value="true">
                                </div>
                            </div>
                        </div>
                        
                        
                        
                       
                    </form>
                    <div id="publicarButton" style="text-align:center">
                            
                            <input style="width:15%;padding:5px;" class="btn btn-success" type="submit" value="Publicar" form="formParent">
                        </div>
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

        <!-- Main JS-->
        <script src="js/global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <?php include 'footer.php'; ?>
</body>


</html>