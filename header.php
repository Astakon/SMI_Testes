<?php
require_once( "db.php" );
require_once( "lib.php" );
dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

if (session_status() == PHP_SESSION_NONE)
    session_start();
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $id = $_SESSION['id'];
    $userType = $_SESSION['userType'];
}
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" typr="text/css" href="CSS.css">
                <link rel="stylesheet" typr="text/css" href="BStrap.css">
                    <script>
                        $(document).ready(function(){
                        $('#logout').click(function() {
                        $.ajax({
                        type: "POST",
                                url: "logout.php"
                        }).done(function(msg) {
                        });
                        });</script>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    <script>
                                $(document).ready(function () {

                        $("#pesquisa").keyup(function () {

                        var pesquisa = $(this).val().trim();
                                if (pesquisa != '') {

                        $.ajax({
                        url: 'pesquisaAjax.php',
                                type: 'post',
                                data: {pesquisa: pesquisa},
                                success: function (response) {

                                var searchList = document.getElementById("conteudos");
                                        searchList.options.length = 0;
                                        var categories = JSON.parse(response);
                                        var options = "";
                                        for (i = 0; i < categories.length; i++) {
                                var currentCat = categories[i];
                                        var id = currentCat["id"];
                                        var titulo = currentCat["titulo"];
                                        console.log(id, titulo);
                                        options += '<option value="' + id + '">' + titulo + '</option>';
                                }
                                searchList.innerHTML = options;
                                }



                        });
                        } else {
                        var searchList = document.getElementById("conteudos");
                                searchList.options.length = 0;
                        }

                        });
                        });
                    </script>

                    <script>

                                $(document).ready(function () {
                        document.getElementById("pesquisa").addEventListener("input", function (e) {


                        if (e.target.value.includes("http")) {
                        window.location.href = e.target.value;
                        }

                        }, false);
                        });
                    </script>
                    </head>

                    <header class="p-3 bg-dark text-white">
                        <div class="container">
                            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                                <a <?php
                                if (isset($_SESSION['username'])) {
                                    echo("href='Feed.php'");
                                } else {
                                    echo("href='homePage.php'");
                                }
                                ?> class="text-white navbar-brand d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                    <strong>GameAlong</strong>
                                </a>


                                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">



                                    <li class="nav-item">
                                        <a class="text-white nav-link" href="homePage.php"
                                           id="navbarDarkDropdownMenuLink" role="button" aria-expanded="false">
                                            Navegar
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="text-white nav-link dropdown-toggle" href="Categorias.php" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Tipo de Conteúdo
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                            <li><a class="dropdown-item" href="Categorias.php?tipo=3">Vídeos</a></li>
                                            <li><a class="dropdown-item" href="Categorias.php?tipo=1">Áudios</a></li>
                                            <li><a class="dropdown-item" href="Categorias.php?tipo=2">Fotografias</a></li>
                                            <li><a class="dropdown-item" href="homePage.php">Todos</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="text-white nav-link dropdown-toggle" href="SubCategorias.php" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Jogos
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                            <?php
                                            $queryCategoria = "SELECT * FROM `$dataBaseName`.`categoria`";
                                            $categoriaResult = mysqli_query($GLOBALS['ligacao'], $queryCategoria);
                                            while ($categorias = mysqli_fetch_array($categoriaResult)) {
                                                ?>
                                                <li><a class="dropdown-item" href="Categorias.php?categoria=<?php echo $categorias["idCategoria"] ?>"> <?php echo $categorias["nome"] ?> </a></li>
                                                <?php
                                            }
                                            ?>

                                        </ul>
                                    </li>
                                    <?php
                                    if (isset($_SESSION['username']) && $userType > 1) {
                                        ?>
                                        <li><a href="upload.php" class="nav-link px-2 text-white">Publicar</a></li>
                                    <?php } ?>

                                </ul>

                                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">

                                    <input autocomplete="off" list="conteudos" type="search" name="pesquisa" id="pesquisa" class="form-control form-control-dark" placeholder="Procurar..." aria-label="Search"/>


                                </form>

                                <datalist id="conteudos"" >

                                </datalist>


                                <div class="text-end">
                                    <?php
                                    if (!isset($_SESSION['username'])) {
                                        ?>

                                        <a href="formLogin.php"><button type="button"style="    text-transform: inherit;" class="btn btn-outline-light me-2">Login</button></a>
                                        <a href="formRegister.php"> <button type="button" style="    text-transform: inherit;"class="btn btn-warning">Registo</button></a>
                                    </div>
                                    <?php
                                } else {
                                    dbConnect(ConfigFile);
                                    $dataBaseName = $GLOBALS['configDataBase']->db;

                                    $queryProfile = "SELECT * FROM `$dataBaseName`.`utilizador` WHERE idUtilizador = $id";

                                    $profileResult = mysqli_query($GLOBALS['ligacao'], $queryProfile);
                                    $profile = mysqli_fetch_array($profileResult);
                                    $foto = $profile["path"];
                                    ?>
                                    <a href="logout.php"><button id="logout" name="logout" type="button"style="    text-transform: inherit;" class="btn btn-outline-light me-2" >Logout</button></a>

                                    <li class="nav-item dropdown">
                                        <a class="text-white nav-link dropdown-toggle"style="padding:0" href="" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                           
                                            <img  src ="<?php echo $foto ?>"style="font-size: 1.6em; margin-left:5px; width:30px" aria-hidden="true"></img>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                            <?php if ($userType > 1) { ?>
                                                <li><a class="dropdown-item" href="PerfilPublico.php?id=<?php echo $id ?>">Meu Perfil</a></li>
                                            <?php } ?>

                                            <li><a class="dropdown-item" href="ConfiguracaoPerfil.php">Definições de Conta</a></li>
                                            <?php if ($userType > 1) { ?>

                                                <li><a class="dropdown-item" href="contentManagement.php">Gerir Conteúdos</a></li>
                                                <li><a class="dropdown-item" href="downloadManagement.php">Descarregar Conteúdos em Massa</a></li>
                                                <?php if ($userType == 3) { ?>
                                                    <li><a class="dropdown-item" href="userManagement.php">Gerir Utilizadores</a></li>
                                                    <li><a class="dropdown-item" href="database_handler.php">Definições de Sistema</a></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <a class="text-white" href="Notificacoes.php">
                                        <i class="fa fa-bell" style="font-size: 1.3em; margin-left:5px" aria-hidden="true"></i>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </header>