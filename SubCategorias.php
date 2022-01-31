<?php include 'header.php'; ?>
<?php
$fotoPerfil = "images/profile.jpg";
$videoBlob = "images/video.png";
$audioBlob = "images/audio.png";
$fotoBlob = "images/foto.png";

$username = "Username";
$categoria ="GTA V";
$subCategoria ="Geral";
$numSubCategorias = 5;

$numVideos = 10;
$numAudios = 7;
$numFotos = 10;
?>

<!doctype html>

<html lang="en">
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>SMI exemplos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.83.1">
       
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

 
  <section class="py-5 text-center container">
      <h1  class="fw-light" style="text-align: center;padding-top:30px"><?php echo $categoria?> - <?php echo $subCategoria?> </h1>
       <div style="text-align: center; margin-top: 30px">
        <div class="dropdown">
            <button class="dropbtn">Tipo</button>
            <div class="dropdown-content">

                
                <a href="#">Vídeos</a>
                <a href="#">Áudios</a>
                <a href="#">Fotos</a>
                <a href="#">Todos</a>

            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Sub-Categorias</button>
            <div class="dropdown-content">
                <?php
                for ($i = 0; $i < $numSubCategorias; $i++) {
                    echo ' <a href="#">Sub-Categoria ' . $i . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
  </section>
 

  <div class="album py-5 bg-light" >
    <div class="container">
 <h2 class="fw-light" >Vídeos</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
        
    for ($i = 0; $i < $numVideos; $i++) {
       echo ' <div class="col">
          <div class="card shadow-sm">
          <h3 class="fw-light">Título</h3>
            <img class="card-img-top" src="'.$videoBlob.'"width="100%" height="225" « xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img>

            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
    </div>';}
       ?>
   
      </div>
    </div>
  </div>
<div class="album py-5 bg-light">
    <div class="container">
  <h2 class="fw-light">Áudios</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
        
    for ($i = 0; $i < $numAudios; $i++) {
       echo ' <div class="col">
          <div class="card shadow-sm">
          <h3 class="fw-light">Título</h3>
            <img class="card-img-top" src="'.$audioBlob.'"width="100%" height="225" « xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img>

            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
    </div>';}
       ?>
   
      </div>
    </div>
  </div>
 <div class="album py-5 bg-light">
    <div class="container">
   <h2 class="fw-light">Fotos</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
        
    for ($i = 0; $i < $numFotos; $i++) {
       echo ' <div class="col">
          <div class="card shadow-sm">
          <h3 class="fw-light">Título</h3>
            <img class="card-img-top" src="'.$fotoBlob.'"width="100%" height="225" « xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img>

            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
    </div>';}
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


    <script src="bootstrap.bundle.min.js"></script>

      
  </body>
</html>
