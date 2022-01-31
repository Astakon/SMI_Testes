<?php
session_start();

function databaseDeletion(){
    $mysql_id = new mysqli('localhost', 'root', '');
    $db = mysqli_select_db($mysql_id, "smi_final");
    
    if($db != 0){
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS CLASSIFICACAO;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS COMENTARIO;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS SUBSCRICAO_CATEGORIA;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS SUBSCRICAO_UTILIZADOR;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS CONTEUDO_SUB_CATEGORIA;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS CONTEUDO;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS SUBCATEGORIA;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS UTILIZADOR;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS CATEGORIA;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS TIPO_CONTEUDO;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS TIPO_UTILIZADOR;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS TIPO_IDIOMA;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS EMAILACCOUNTS;" );
        mysqli_query($mysql_id,"DROP TABLE IF EXISTS NOTIFICACAO;" );
        
    }
    mysqli_close($mysql_id);
}

function databaseCreation(){
    $mysql_id = new mysqli('localhost', 'root', '');
    mysqli_query($mysql_id, "CREATE DATABASE smi_final");
    mysqli_close($mysql_id);
}

function databaseInitiation(){
    $mysql_id = new mysqli('localhost', 'root', '');
    $db = mysqli_select_db($mysql_id, "smi_final");
    
    if($db != 0){
        //Tabelas
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS CATEGORIA (
				idCategoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				nome VARCHAR(16) NOT NULL,
                                publico BOOLEAN DEFAULT TRUE
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS TIPO_CONTEUDO (
				idTipoConteudo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				tipo VARCHAR(20) NOT NULL
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS TIPO_UTILIZADOR (
				idTipoUtilizador INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				tipo VARCHAR(20) NOT NULL
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS TIPO_IDIOMA (
				idTipoIdioma INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				tipo VARCHAR(20) NOT NULL
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS UTILIZADOR (
				idUtilizador INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				idTipoUtilizador INT NOT NULL,
                                username VARCHAR (16) NOT NULL,
                                email VARCHAR(100) NOT NULL,
                                pword VARCHAR(16) NOT NULL,
                                descricao VARCHAR(800) NOT NULL,
                                data_nascimento DATE NOT NULL CHECK (data_nascimento < '2021-07-31'),
                                path VARCHAR(500) NOT NULL,
                                ativo BOOLEAN DEFAULT FALSE,
                                CONSTRAINT fk_idTipoUtilizador FOREIGN KEY (idTipoUtilizador) references TIPO_UTILIZADOR(idTipoUtilizador)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS SUBCATEGORIA (
				idSubCategoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                idCategoria INT NOT NULL,
                                nome VARCHAR(30) NOT NULL,
				publico BOOLEAN DEFAULT TRUE,
                                CONSTRAINT fk_idCat FOREIGN KEY (idCategoria) references CATEGORIA(idCategoria)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS CONTEUDO (
				idConteudo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                idUtilizador INT NOT NULL,
                                idTipoConteudo INT NOT NULL,
                                idTipoIdioma INT NOT NULL,
				titulo VARCHAR(100) NOT NULL,
                                descricao VARCHAR(800) NOT NULL,
                                path VARCHAR(500) NOT NULL,
                                thumbnailPath VARCHAR(500) NOT NULL,
                                dataHora DATETIME NOT NULL DEFAULT NOW(),
                                classificacao INT NOT NULL DEFAULT 0,
                                publico BOOLEAN DEFAULT TRUE,
                                CONSTRAINT fk_idUtili FOREIGN KEY (idUtilizador) references UTILIZADOR(idUtilizador),
                                CONSTRAINT fk_idTipoConteudo FOREIGN KEY (idTipoConteudo) references TIPO_CONTEUDO(idTipoConteudo),
                                CONSTRAINT fk_idTipoIdioma FOREIGN KEY (idTipoIdioma) references TIPO_IDIOMA(idTipoIdioma)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS CONTEUDO_SUB_CATEGORIA (
				idConteudo INT NOT NULL,
                                idSubCategoria INT NOT NULL,
				PRIMARY KEY(idConteudo, idSubCategoria),
                                CONSTRAINT fk_idCont FOREIGN KEY (idConteudo) references CONTEUDO(idConteudo),
				CONSTRAINT fk_idSubCat FOREIGN KEY (idSubCategoria) references SUBCATEGORIA(idSubCategoria)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS EMAILACCOUNTS (
				id INT NOT NULL PRIMARY KEY AUTO_INCREMENT ,
				accountName VARCHAR( 32 ) NOT NULL ,
				smtpServer VARCHAR( 32 ) NOT NULL ,
				port INT NOT NULL ,
				useSSL TINYINT NOT NULL ,
				timeout INT NOT NULL ,
				loginName VARCHAR( 128 ) NOT NULL ,
				password VARCHAR( 128 ) NOT NULL ,
				email VARCHAR( 128 ) NOT NULL ,
				displayName VARCHAR( 128 ) NOT NULL
                                ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS SUBSCRICAO_UTILIZADOR(
				idSubscritor INT NOT NULL,
                                idPublicador INT NOT NULL,
				PRIMARY KEY(idSubscritor, idPublicador),
                                CONSTRAINT fk_idUtiliz FOREIGN KEY (idSubscritor) references UTILIZADOR(idUtilizador),
				CONSTRAINT fk_idUtiliza FOREIGN KEY (idPublicador) references UTILIZADOR(idUtilizador)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS SUBSCRICAO_CATEGORIA(
				idSubscritor INT NOT NULL,
                                idCategoria INT NOT NULL,
				PRIMARY KEY(idSubscritor, idCategoria),
                                CONSTRAINT fk_idUtilizad FOREIGN KEY (idSubscritor) references UTILIZADOR(idUtilizador),
				CONSTRAINT fk_idCate FOREIGN KEY (idCategoria) references CATEGORIA(idCategoria)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS COMENTARIO(
				idComentario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                idUtilizador INT NOT NULL,
                                idConteudo INT NOT NULL,
                                texto VARCHAR(500) NOT NULL,
                                publico BOOLEAN DEFAULT TRUE,
                                CONSTRAINT fk_idUtilizado FOREIGN KEY (idUtilizador) references UTILIZADOR(idUtilizador),
                                CONSTRAINT fk_idConte FOREIGN KEY (idConteudo) references CONTEUDO(idConteudo)
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS CLASSIFICACAO(
				idUtilizador INT NOT NULL,
                                idConteudo INT NOT NULL,
				PRIMARY KEY(idUtilizador, idConteudo),
                                gostou BOOLEAN DEFAULT TRUE,
				CONSTRAINT fk_idU FOREIGN KEY (idUtilizador) references UTILIZADOR(idUtilizador),
                                CONSTRAINT fk_idConteudo FOREIGN KEY (idConteudo) references CONTEUDO(idConteudo)                
                                );");
        
        mysqli_query($mysql_id, "CREATE TABLE IF NOT EXISTS Notificacao(
				idUtilizador INT NOT NULL,
                                idConteudo INT NOT NULL,
                                hora DATETIME DEFAULT NOW(),
                                seen BOOLEAN DEFAULT FALSE,
                                PRIMARY KEY(idUtilizador,idConteudo),
                                CONSTRAINT fk_id FOREIGN KEY (idUtilizador) references UTILIZADOR(idUtilizador),
                                CONSTRAINT fk_idC FOREIGN KEY (idConteudo) references CONTEUDO(idConteudo) 
                                );");
        
        //Tipo Utilizador
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_utilizador` (`tipo`) VALUES ('Utilizador');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_utilizador` (`tipo`) VALUES ('Simpatizante');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_utilizador` (`tipo`) VALUES ('Administrador');");
        
        //Idioma
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_idioma` (`tipo`) VALUES ('Português');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_idioma` (`tipo`) VALUES ('Inglês');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_idioma` (`tipo`) VALUES ('Espanhol');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_idioma` (`tipo`) VALUES ('Francês');");
        
        //Conteudo
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_conteudo` (`tipo`) VALUES ('Audio');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_conteudo` (`tipo`) VALUES ('Foto');");
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`tipo_conteudo` (`tipo`) VALUES ('Video');");
        
        //Email de Autentificacao
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`emailaccounts`
                                (`accountName`, `smtpServer`, `port`, `useSSL`, `timeout`, `loginName`, `password`, `email`, `displayName`) values
                                ('Gmail - SMI', 'smtp.gmail.com', '465', '1', '30', 'smigrupo2@gmail.com', 'smigrupo2', 'smigrupo2@gmail.com', 'Game Along');");
        
        //Utilizador Administrador
        mysqli_query($mysql_id, "INSERT INTO `smi_final`.`utilizador`
                                (`idTipoUtilizador`, `username`, `email`, `pword`, `descricao`, `data_nascimento`, `path`,`ativo`) values 
                                (3, 'admin', '', 'admin', 'sem descricao', '1999-03-12', 'imagesDataBase\\admin.jpg', 1)");
    }
    
    mysqli_close($mysql_id);
}

function backupCreation() {
    $mysql_id = new mysqli('localhost', 'root', '');
    mysqli_select_db($mysql_id, 'smi_final');
    
    $tables = array();
    $result = mysqli_query($mysql_id,"SHOW TABLES");
    while($row = mysqli_fetch_row($result)){
      $tables[] = $row[0];
    }
    
    $return = '';
    foreach($tables as $table){
      $result = mysqli_query($mysql_id,"SELECT * FROM ".$table);
      $num_fields = mysqli_num_fields($result);

      $return .= 'DROP TABLE '.$table.';';
      $row2 = mysqli_fetch_row(mysqli_query($mysql_id,"SHOW CREATE TABLE " . $table));
      $return .= "\n\n".$row2[1].";\n\n";

      for($i=0;$i<$num_fields;$i++){
        while($row = mysqli_fetch_row($result)){
          $return .= 'INSERT INTO '.$table.' VALUES(';
          for($j=0;$j<$num_fields;$j++){
            $row[$j] = addslashes($row[$j]);
            if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
            else{ $return .= '""';}
            if($j<$num_fields-1){ $return .= ',';}
          }
          $return .= ");\n";
        }
      }
      $return .= "\n\n\n";
    }
    //save file
    $handle = fopen("files/backup.sql","w+");
    fwrite($handle,$return);
    fclose($handle);
    echo 'files/backup.sql';
    
}

function ImportBackUp() {
    
    if(!empty($_FILES["myfile2"])) {

        $filename = basename($_FILES["myfile2"]["name"]); 

        $values = explode(".", $filename);
        $ext = $values[count($values) - 1];

        if (in_array($ext, array("sql"))) {
            $source_file = $_FILES["myfile2"]["tmp_name"];

            $mysql_id = new mysqli('localhost', 'root', '');
            $db = mysqli_select_db($mysql_id, $_POST['namedb']);
            
            if ($db) {
                $handle = fopen($source_file,"r+");
                $contents = fread($handle,filesize($source_file));
                $sql = explode(';',$contents);
                foreach($sql as $query){
                  mysqli_query($mysql_id,$query);
                }
                fclose($handle);
    //            echo 'Successfully imported';
            }
        }
    }
}


if(!empty($_POST['database'])) { 
 
    if(strcmp($_POST['database'], 'Reiniciar') == 0) {  
        if($_SESSION['userType'] == 3) {
            databaseDeletion();
            databaseInitiation();
            header("Location: database_handler.php");  
        } else {
            header("Location: index.php"); 
        }

    } else if (strcmp($_POST['database'], 'Importar') == 0) {
        if($_SESSION['userType'] == 3) {
            ImportBackUp();
            header("Location: database_handler.php");  
        } else {
            header("Location: index.php"); 
        }
    } else {
         header("Location: index.php"); 
    }
    
    

    
} else if(!empty($_GET['database'])) { 
    if(strcmp($_GET['database'], 'Backup') == 0) {  
        if($_SESSION['userType'] == 3) {
            backupCreation();
        } else {
            header("Location: index.php"); 
        }
    } else {
        header("Location: index.php"); 
    }
    
}else {
    header("Location: index.php"); 
}

#INSERT INTO `smi_final`.`subscricao_utilizador` (idSubscritor,idPublicador) Values (1,1)
#INSERT INTO `smi_final`.`subscricao_categoria` (idSubscritor,idCategoria) Values (1,1)