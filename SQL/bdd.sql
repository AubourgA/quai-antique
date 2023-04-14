-- creation de la BDD
DROP SCHEMA IF EXISTS LEQUAIANTIQUE;
CREATE SCHEMA LEQUAIANTIQUE; 


use LEQUAIANTIQUE

-- creation table `user`

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`email`)
)
ENGINE=InnoDB;

-- creation table admin

CREATE TABLE admin (
  `id` int(11) NOT NULL,
  `alias` varchar(100)  NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) 
ENGINE=InnoDB ;

-- creation table `capacity`

CREATE TABLE `capacity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) NOT NULL,
  `lunch_limit` int(11) NOT NULL,
  `dinner_limit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`supervisor_id`) REFERENCES `admin` (`id`)
) 
ENGINE=InnoDB;


-- Creation table `customer`

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255)NOT NULL,
  `lastname` varchar(255)  NOT NULL,
  `allergy` longtext,
  `default_person` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) 
ENGINE=InnoDB;


-- creation table `booking`

CREATE TABLE `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `number_person` int(11) NOT NULL,
  `allergy` longtext,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) 
ENGINE=InnoDB; 

-- Creation table `dessert`

CREATE TABLE `dessert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE=InnoDB;


-- Creation table `entree`

CREATE TABLE `entree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255)  NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE=InnoDB;



-- Creation table `gallery`

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `urlimage` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`supervisor_id`) REFERENCES `admin` (`id`)
)
ENGINE=InnoDB;



-- Creation table `meals`

CREATE TABLE `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=InnoDB;



-- Creation table `menu`

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`)
) ENGINE=InnoDB;





-- Creaztion table `menu_entree`

CREATE TABLE `menu_entree` (
  `menu_id` int(11) NOT NULL,
  `entree_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`entree_id`),
  FOREIGN KEY (`entree_id`) REFERENCES `entree` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;


-- Creation table `menu_meals`

CREATE TABLE `menu_meals` (
  `menu_id` int(11) NOT NULL,
  `meals_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`meals_id`),
  FOREIGN KEY (`meals_id`) REFERENCES `meals` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;


-- Creation table `schedule`

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `lunch_start` time DEFAULT NULL,
  `lunch_end` time NOT NULL,
  `dinner_start` time NOT NULL,
  `dinner_end` time NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`)
)
ENGINE=InnoDB;


-- Creation table `menu_dessert`

CREATE TABLE `menu_dessert` (
  `menu_id` int(11) NOT NULL,
  `dessert_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`dessert_id`),
  FOREIGN KEY (`dessert_id`) REFERENCES `dessert` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;


-- ---------------------------
-- INSERTION DU JEU DE DONNEES
-- ---------------------------
-- password : passwordADMIN

INSERT INTO `dessert` VALUES (1,'Moelleux au Chocolat des Alpes',5.9,'2023-02-26 13:36:59',1),(2,'Tarte au Citron Meringué',8.9,'2023-02-26 13:37:20',1);
INSERT INTO `entree` VALUES (1,'Salade accompagné de son lit de creuson','salade, creusson, paim cheve',15.00,'2023-02-26 13:34:38',1),(2,'Paim pita avec son lit de courgette','paim, courgette, sauce aigre douce',17.50,'2023-02-26 13:34:54',1),(3,'test','test',5.00,'2023-03-05 15:57:07',1);
INSERT INTO `meals` VALUES (1,'Burger et son savoureux accompagnement frites','burger, oignon, paim toaste, sauce chedar',17.90,'2023-02-26 13:35:09',1),(2,'Gratin de fromage au pomme de terre de la region','pomme de terre, lardon, raclette, oignon',17.50,'2023-02-26 13:35:55',1);
INSERT INTO `user` VALUES (1,'admin@admin.fr','[\"ROLE_ADMIN\"]','$2y$10$SIijBI7WE88tu4ew1ocRzu.GwzEK/Q7gD4Uc8RMMZInKiyXjMZyoO','2023-02-26 13:33:41','admin',NULL),(2,'test@test.fr','[]','$2y$10$MQb6aXvuhuuerQ/QCV4qUOTFU4TB2.mZHqwIte8PYKNz1QJPKm2FG','2023-03-05 16:32:39','customer',NULL),(10,'test@test.com','[\"ROLE_CUSTOMER\"]','$2y$13$ZIXRkZpvSWp0Souf/oia1uJcASPfYClTQIXLWIu9CrkW74Ep6rOZO','2023-03-07 11:54:54','customer',NULL),(11,'customer1@gmail.com','[\"ROLE_CUSTOMER\"]','$2y$13$VJBsUiPRSpa8tdiyohwfqehM0ZbW/Vx7Sj2otXfcgXNv2QqhTPthq','2023-03-07 16:05:22','customer',''),(12,'customer2@gmail.com','[\"ROLE_CUSTOMER\"]','$2y$13$zyc4KZaWCe14luC1T5wgbeWg252BYRA0.MfxRAH51c81/go2Jqu4K','2023-03-11 16:01:34','customer',NULL),(13,'alain.dupont@gmail.com','[\"ROLE_CUSTOMER\"]','$2y$13$uSRZOM7VOKVW5nKwEuyCwe.uGO5AO0VqK13ClNUP2zFusEDO5Epxe','2023-04-02 12:26:14','customer',NULL),(14,'alain.dupont@gmail.co','[\"ROLE_CUSTOMER\"]','$2y$13$Y5KZ8Lnf0erEQxKv3oqiBO9VqcxexPNsBNo6f5ECgz7ulrz86ZUQu','2023-04-02 12:32:09','customer',NULL),(15,'jean@gmail.com','[\"ROLE_CUSTOMER\"]','$2y$13$sN8J4J7..ePKyGnyXQZjceBw4a.NTuL.1tRnaw5xcuQmfZN29uYo.','2023-04-11 09:03:02','customer',NULL);
INSERT INTO `admin` VALUES (1,'supervisor');
INSERT INTO `customer` VALUES (11,'customer1','customer1','poellen et oeuf',5),(12,'customer2','customer2','euf',4),(13,'alain','dupont','rien',2),(14,'d','f',NULL,4),(15,'Jean','DUJARDIN','test df',8);
INSERT INTO `booking` VALUES (3,11,'2023-02-13','19:47:23',2,'RAS','2023-03-08 14:47:23'),(7,11,'2023-02-14','12:06:00',3,NULL,'2023-03-11 15:14:08'),(8,12,'2023-02-14','12:01:29',2,NULL,'2023-03-11 17:01:29'),(9,12,'2023-03-17','19:02:09',2,NULL,'2023-03-11 17:02:09'),(10,11,'2023-02-23','13:34:49',3,NULL,'2023-03-12 15:34:49'),(11,12,'2023-03-13','13:38:40',4,NULL,'2023-03-12 15:38:39'),(12,11,'2023-03-08','20:39:33',3,NULL,'2023-03-12 15:39:33'),(13,12,'2023-03-12','19:41:46',1,NULL,'2023-03-12 15:41:46'),(14,12,'2023-03-11','13:56:19',10,NULL,'2023-03-12 15:56:19'),(18,11,'2023-03-24','12:30:00',4,'poellen et oeuf','2023-03-25 16:24:05'),(19,11,'2023-03-24','12:30:00',4,'poellen et oeuf','2023-03-25 16:32:05'),(45,11,'2023-03-23','21:00:00',3,'poellen et oeuf','2023-03-26 14:18:08'),(49,11,'2023-03-31','12:30:00',3,'poellen et oeuf','2023-03-26 17:00:20'),(50,11,'2023-03-31','12:30:00',3,'poellen et oeuf','2023-03-26 17:05:17'),(51,11,'2023-03-31','12:30:00',3,'poellen et oeuf','2023-03-26 17:05:40'),(52,11,'2023-03-31','12:30:00',3,'poellen et oeuf','2023-03-26 17:06:41'),(53,11,'2023-03-31','12:30:00',3,'poellen et oeuf','2023-03-26 17:09:35'),(54,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-26 17:10:45'),(55,11,'2023-03-25','20:00:00',3,'poellen et oeuf','2023-03-26 17:13:53'),(56,11,'2023-03-30','21:00:00',3,'poellen et oeuf','2023-03-26 17:46:42'),(57,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-26 17:48:57'),(58,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-26 17:57:29'),(60,11,'2023-03-27','20:00:00',3,'poellen et oeuf','2023-03-27 14:38:50'),(61,11,'2023-03-28','19:00:00',3,'poellen et oeuf','2023-03-27 14:40:27'),(62,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-27 14:55:20'),(63,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-27 14:58:17'),(64,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-29 18:37:28'),(65,11,'2023-03-31','19:00:00',3,'poellen et oeuf','2023-03-29 18:38:35');
INSERT INTO `capacity` VALUES (1,1,5,25);
INSERT INTO `schedule` VALUES (1,1,'Lundi','00:00:00','00:00:00','19:00:00','21:00:00'),(2,1,'Mardi','11:00:00','14:00:00','19:00:00','21:00:00'),(3,1,'Mercredi','12:00:00','14:00:00','19:00:00','22:00:00'),(4,1,'Jeudi','12:00:00','14:00:00','19:00:00','22:00:00'),(5,1,'Vendredi','12:00:00','14:00:00','19:00:00','20:00:00'),(6,1,'Samedi','12:00:00','14:00:00','19:00:00','22:00:00'),(7,1,'Dimanche','00:00:00','00:00:00','00:00:00','00:00:00');
INSERT INTO `menu` VALUES (1,'MENU MONTAGE',45.50,'menu-montagne-1677415442.jpg','2023-02-26 13:44:01',1,1),(2,'MENU ENFANT',45.50,'menu-enfant-1677415899.jpg','2023-02-26 13:51:39',1,1),(3,'MENU GOURMET',95.00,'menu-gourmet-1677515895.jpg','2023-02-27 17:38:15',1,1);
INSERT INTO `menu_dessert` VALUES (1,1),(2,2),(3,1);
INSERT INTO `menu_meals` VALUES (1,1),(2,2),(3,1);
INSERT INTO `menu_entree` VALUES (1,1),(2,2),(3,1);
INSERT INTO `gallery` VALUES (1,1,'Burger et son pain moelleux','burger-1678195729.jpg'),(2,1,'Salade Végé du printemps','salad-1678196032.jpg'),(3,1,'Roulé de volaille avec sa fondue de poirreux','roule-1678196101.jpg');