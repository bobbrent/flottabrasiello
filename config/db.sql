CREATE TABLE `brasiello_fleet`.`macchina` ( 
  `id` INT(10) NOT NULL AUTO_INCREMENT , 
  `id_piazzale` INT(10) NOT NULL , 
  `targa` VARCHAR(40) NOT NULL , 
  `telaio` VARCHAR(40) NOT NULL , 
  `marca` VARCHAR(40) NOT NULL , 
  `modello` VARCHAR(40) NOT NULL , 
  `colore` VARCHAR(25) NOT NULL , 
  `data_arrivo` TIMESTAMP NOT NULL , 
  `presenza_bolla_arrivo` BOOLEAN NOT NULL , 
  `km` INT(15) NOT NULL , 
  `doppia_chiave` BOOLEAN NOT NULL , 
  `libretto_circolazione` BOOLEAN NOT NULL , 
  `sd_card` BOOLEAN NOT NULL , 
  `tappetini` BOOLEAN NOT NULL , 
  `rscorta_gonfiaggio` BOOLEAN NOT NULL , 
  `antenna` BOOLEAN NOT NULL , 
  `libretto_manutenzione` BOOLEAN NOT NULL , 
  `data_uscita` TIMESTAMP NOT NULL , 
  `id_bolla_uscita` INT(10) NOT NULL , 
  `note` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `brasiello_fleet`.`bolla` ( 
  `id` INT(10) NOT NULL AUTO_INCREMENT , 
  `progressivo` INT(10) NOT NULL , 
  `data_bolla` TIMESTAMP NOT NULL , 
  `destinatario` VARCHAR(50) NOT NULL , 
  `luogo_destinazione` TEXT NOT NULL , 
  `causale_trasporto` TEXT NOT NULL , 
  `vettori` TEXT NOT NULL , 
  `annotazioni` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `brasiello_fleet`.`lavorazioni` ( 
  `id` INT(10) NOT NULL AUTO_INCREMENT , 
  `id_macchina` INT(10) NOT NULL , 
  `smontaggio_targhe` BOOLEAN NOT NULL , 
  `lavaggio` BOOLEAN NOT NULL , 
  `lavaggio_est_int` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `brasiello_fleet`.`piazzali` ( 
  `id` INT(10) NOT NULL , 
  `via` VARCHAR(50) NOT NULL , 
  `citta` VARCHAR(50) NOT NULL , 
  `numero_civico` VARCHAR(5) NOT NULL ) ENGINE = InnoDB;