<!DOCTYPE html>
<?php include 'header.php'; ?>
<?php
    require_once( "lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormRegister.php";
    #$nextUrl = "http://" . $serverName . ":" . $serverPort . $name . "processFormLogin.php";
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>
        <script type="text/javascript" src="scripts.js">
     </script>
        <script>
    var check = function() {
  if (document.getElementById('password').value ===
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Passwords Match';
    document.getElementById('register').disabled = false;
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Passwords Dont Match';
    document.getElementById('register').disabled = true;
  }
};

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){

   $("#username").keyup(function(){

      var username = $(this).val().trim();

      if(username != ''){

         $.ajax({
            url: 'ajaxfile.php',
            type: 'post',
            data: {field: 'username', value: username},
            success: function(response){
                if(response == 1){
                    $('#uname_response').html("Username already in use");
                    document.getElementById('register').disabled = true;
                    document.getElementById('uname_response').style.color = 'red';
                }
                

             }
         });
      }else{
         $("#uname_response").html("");
         document.getElementById('register').disabled = false;
      }

    });

 });
</script>
<script>
$(document).ready(function(){

   $("#email").keyup(function(){

      var email = $(this).val().trim();

      if(email != ''){

         $.ajax({
            url: 'ajaxfile.php',
            type: 'post',
            data: {field: 'email', value: email},
            success: function(response){
                if(response == 1){
                    $('#email_response').html("Email already in use");
                    document.getElementById('register').disabled = true;
                    document.getElementById('email_response').style.color = 'red';
                }
                

             }
         });
      }else{
         $("#email_response").html("");
         document.getElementById('register').disabled = false;
      }

    });

 });
</script>
<script>
$(document).ready(function(){

   $("#captcha").keyup(function(){

      var captcha = $(this).val().trim();

      if(captcha != ''){

         $.ajax({
            url: 'captchaProcess.php',
            type: 'post',
            data: {captcha: captcha},
            success: function(response){
                if(response == 1){
                    $('#captcha_response').html("Captcha is incorrect");
                    document.getElementById('register').disabled = true;
                    document.getElementById('captcha_response').style.color = 'red';
                }
                else{
                    $('#captcha_response').html("Captcha is correct");
                    document.getElementById('register').disabled = false;
                    document.getElementById('captcha_response').style.color = 'green';
                }

             }
         });
      }else{
         $("#captcha_response").html("");
         document.getElementById('register').disabled = false;
      }

    });

 });
</script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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
    
    <body>
        
        
            <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <a href="formLogin.php"><i class="fa fa-long-arrow-left fa-2x" style="color:white;margin-left:2%"aria-hidden="true"></i></a>
                    <h2 class="title" style="text-align:center">Registo</h2>
                </div>
                <div class="card-body">
                    <form action="<?php echo $nextUrl ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="name">Nome de utilizador</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="text" name="username" id="username" placeholder="Nome de utilizador" onkeyup="UsernameValidator(this.value);">
                                    <span id="uname_response"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Email</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="email" name="email" id="email" placeholder="Email" onkeyup="EmailValidator(this.value);">
                                    <span id="email_response"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Data de Nascimento</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="date" name="nascimento">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Descrição sobre si</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="text" name="description">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Palavra Passe</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="password" name="password" id="password" placeholder="Palavra-Passe"  onkeyup="PasswordValidator(this.value);">
                    <span id='passwordReg'></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Confirmar Palavra Passe</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" required type="password" name="passwordConfirm" id="confirm_password" placeholder="Palavra-Passe"  onkeyup="check();">
                    <span id='message'></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Foto de Perfil</div>
                            <div class="value">
                                <div class="input-group">
                                    <input id="fileUpload" name="fileUpload" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-row">
                            <div class="name">Captcha</div>
                                <div style="display:inline-flex;width:100%; margin-top: 10px;"><img src="captchaImage.php"/>
                    <div class="input-group" style="margin-left:10%">           
                   <input  class="input--style-5" type="text" id="captcha" required name="captcha" id="captcha">
                    </div>
                                </div>
                    <span id="captcha_response"></span>
                           
                        </div>
                        <div style="text-align:center">
                            <input style="width:15%;padding:5px;" class="btn btn-warning" type="submit" id="register" value="Registo"> 
                            <input style="width:15%;padding:5px;" class="btn btn-primary" type="reset" value="Limpar">
                        </div>
                        
                       
                    </form>
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

        <?php include 'footer.php'; ?>
    </body>
</html>
