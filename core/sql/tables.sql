/* Creacion de tablas de la base de datos */


/* Tabla de usuarios */
CREATE TABLE `freedomwallpapers`.`users`
(
  `id` BIGINT(255) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(20) NOT NULL UNIQUE,
  `email` VARCHAR(30) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `registration_date` DATE NOT NULL,
  `type_of_user` SMALLINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;
