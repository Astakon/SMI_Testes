DROP TABLE categoria;

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(16) NOT NULL,
  `publico` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO categoria VALUES("1","gta v","1");



DROP TABLE classificacao;

CREATE TABLE `classificacao` (
  `idUtilizador` int(11) NOT NULL,
  `idConteudo` int(11) NOT NULL,
  `gostou` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idUtilizador`,`idConteudo`),
  KEY `fk_idConteudo` (`idConteudo`),
  CONSTRAINT `fk_idConteudo` FOREIGN KEY (`idConteudo`) REFERENCES `conteudo` (`idConteudo`),
  CONSTRAINT `fk_idU` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE comentario;

CREATE TABLE `comentario` (
  `idComentario` int(11) NOT NULL AUTO_INCREMENT,
  `idUtilizador` int(11) NOT NULL,
  `idConteudo` int(11) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `publico` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idComentario`),
  KEY `fk_idUtilizado` (`idUtilizador`),
  KEY `fk_idConte` (`idConteudo`),
  CONSTRAINT `fk_idConte` FOREIGN KEY (`idConteudo`) REFERENCES `conteudo` (`idConteudo`),
  CONSTRAINT `fk_idUtilizado` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE conteudo;

CREATE TABLE `conteudo` (
  `idConteudo` int(11) NOT NULL AUTO_INCREMENT,
  `idUtilizador` int(11) NOT NULL,
  `idTipoConteudo` int(11) NOT NULL,
  `idTipoIdioma` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descricao` varchar(800) NOT NULL,
  `path` varchar(500) NOT NULL,
  `dataHora` date NOT NULL,
  `classificacao` int(11) NOT NULL,
  `publico` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idConteudo`),
  KEY `fk_idUtili` (`idUtilizador`),
  KEY `fk_idTipoConteudo` (`idTipoConteudo`),
  KEY `fk_idTipoIdioma` (`idTipoIdioma`),
  CONSTRAINT `fk_idTipoConteudo` FOREIGN KEY (`idTipoConteudo`) REFERENCES `tipo_conteudo` (`idTipoConteudo`),
  CONSTRAINT `fk_idTipoIdioma` FOREIGN KEY (`idTipoIdioma`) REFERENCES `tipo_idioma` (`idTipoIdioma`),
  CONSTRAINT `fk_idUtili` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE conteudo_sub_categoria;

CREATE TABLE `conteudo_sub_categoria` (
  `idConteudo` int(11) NOT NULL,
  `idSubCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idConteudo`,`idSubCategoria`),
  KEY `fk_idSubCat` (`idSubCategoria`),
  CONSTRAINT `fk_idCont` FOREIGN KEY (`idConteudo`) REFERENCES `conteudo` (`idConteudo`),
  CONSTRAINT `fk_idSubCat` FOREIGN KEY (`idSubCategoria`) REFERENCES `subcategoria` (`idSubCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE emailaccounts;

CREATE TABLE `emailaccounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `smtpServer` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(11) NOT NULL,
  `useSSL` tinyint(4) NOT NULL,
  `timeout` int(11) NOT NULL,
  `loginName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO emailaccounts VALUES("1","Gmail - SMI","smtp.gmail.com","465","1","30","smigrupo2@gmail.com","smigrupo2","smigrupo2@gmail.com","Game Along");



DROP TABLE subcategoria;

CREATE TABLE `subcategoria` (
  `idSubCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `idUtilizador` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `publico` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idSubCategoria`),
  KEY `fk_idCat` (`idCategoria`),
  KEY `fk_idUtil` (`idUtilizador`),
  CONSTRAINT `fk_idCat` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  CONSTRAINT `fk_idUtil` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE subscricao_categoria;

CREATE TABLE `subscricao_categoria` (
  `idSubscritor` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idSubscritor`,`idCategoria`),
  KEY `fk_idCate` (`idCategoria`),
  CONSTRAINT `fk_idCate` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  CONSTRAINT `fk_idUtilizad` FOREIGN KEY (`idSubscritor`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE subscricao_utilizador;

CREATE TABLE `subscricao_utilizador` (
  `idSubscritor` int(11) NOT NULL,
  `idPublicador` int(11) NOT NULL,
  PRIMARY KEY (`idSubscritor`,`idPublicador`),
  KEY `fk_idUtiliza` (`idPublicador`),
  CONSTRAINT `fk_idUtiliz` FOREIGN KEY (`idSubscritor`) REFERENCES `utilizador` (`idUtilizador`),
  CONSTRAINT `fk_idUtiliza` FOREIGN KEY (`idPublicador`) REFERENCES `utilizador` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE tipo_conteudo;

CREATE TABLE `tipo_conteudo` (
  `idTipoConteudo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoConteudo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO tipo_conteudo VALUES("1","Audio");
INSERT INTO tipo_conteudo VALUES("2","Foto");
INSERT INTO tipo_conteudo VALUES("3","Video");



DROP TABLE tipo_idioma;

CREATE TABLE `tipo_idioma` (
  `idTipoIdioma` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO tipo_idioma VALUES("1","Português");
INSERT INTO tipo_idioma VALUES("2","Inglês");
INSERT INTO tipo_idioma VALUES("3","Espanhol");
INSERT INTO tipo_idioma VALUES("4","Francês");



DROP TABLE tipo_utilizador;

CREATE TABLE `tipo_utilizador` (
  `idTipoUtilizador` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoUtilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO tipo_utilizador VALUES("1","Utilizador");
INSERT INTO tipo_utilizador VALUES("2","Simpatizante");
INSERT INTO tipo_utilizador VALUES("3","Administrador");



DROP TABLE utilizador;

CREATE TABLE `utilizador` (
  `idUtilizador` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoUtilizador` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pword` varchar(16) NOT NULL,
  `descricao` varchar(800) NOT NULL,
  `data_nascimento` date NOT NULL CHECK (`data_nascimento` < '2021-07-31'),
  `path` varchar(500) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idUtilizador`),
  KEY `fk_idTipoUtilizador` (`idTipoUtilizador`),
  CONSTRAINT `fk_idTipoUtilizador` FOREIGN KEY (`idTipoUtilizador`) REFERENCES `tipo_utilizador` (`idTipoUtilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO utilizador VALUES("1","3","admin","","admin","sem descricao","1999-03-12","","1");



