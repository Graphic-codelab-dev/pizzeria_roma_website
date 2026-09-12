-- =====================================================================
-- Pizzeria Roma — schema.sql
-- MySQL 5.7+ / MariaDB 10.3+
-- Charset: utf8mb4 (soporte completo de acentos franceses e italianos)
--
-- Generado a partir del estado real de producción (incluye las 5
-- migraciones de sql/migrations/ ya aplicadas: tamaño 16", precios por
-- plataforma, precios de pickup reales y actualizaciones de menú).
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- categories
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categories_slug` (`slug`),
  KEY `idx_categories_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- products
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `name_en` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_fr` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(6,2) NOT NULL,
  `is_price_placeholder` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_products_category` (`category_id`),
  KEY `idx_products_order` (`display_order`),
  KEY `idx_products_featured` (`is_featured`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- product_platform_prices
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `product_platform_prices`;
CREATE TABLE `product_platform_prices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `is_placeholder` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_product_platform` (`product_id`,`platform`),
  KEY `idx_ppp_product` (`product_id`),
  CONSTRAINT `fk_ppp_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- promotions
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `text_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- admin_users
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_attempts` int unsigned NOT NULL DEFAULT '0',
  `locked_until` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- SEED DATA (estado real del menú, exportado de la base de datos)
-- =====================================================================

-- Categorías
INSERT INTO `categories` VALUES (1,'Pizzas','Pizzas','pizzas-12',1,1,'2026-07-22 16:49:18','2026-08-06 15:12:19');
INSERT INTO `categories` VALUES (2,'15\" Principal Pizzas','Pizzas principales 15 po','pizzas-15',2,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (3,'Panzerotti','Panzerotti','panzerotti',3,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (4,'Hot Soup','Soupe chaude','hot-soup',4,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (5,'Hot Sandwiches','Sandwichs chauds','hot-sandwiches',5,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (6,'Salads','Salades','salads',6,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (7,'Side','Accompagnement','side',7,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (8,'Dessert','Dessert','dessert',8,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (9,'Dips','Trempettes','dips',9,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `categories` VALUES (10,'16\" Principal Pizzas','Pizzas Principales 16\"','pizzas-16',1,1,'2026-08-06 15:12:19','2026-08-06 15:12:19');
INSERT INTO `categories` VALUES (11,'Panzerotti 15\"','Panzerotti 15 po','panzerotti-15',3,1,'2026-08-09 11:52:54','2026-08-09 11:52:54');
INSERT INTO `categories` VALUES (12,'Salads — Family Size','Salades — Format familial','salads-family',6,1,'2026-08-09 11:52:54','2026-08-09 11:52:54');

-- Productos
INSERT INTO `products` VALUES (1,1,'12\" The Let\'s Eat Meat Pizza','Pizza Let\'s Eat Meat 12 po',NULL,NULL,20.99,0,'uploads/products/the-lets-eat-meat-pizza.webp',0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (2,1,'12\" The Margarita Pizza','Pizza Margarita 12 po',NULL,NULL,16.99,0,'uploads/products/the-margarita-pizza.webp',0,2,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (3,1,'12\" The Roma Pizza','Pizza Roma 12 po',NULL,NULL,19.99,0,'uploads/products/the-roma-pizza.webp',1,3,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (4,1,'12\" The Mediterranean Pizza','Pizza méditerranéenne 12 po',NULL,NULL,22.99,0,'uploads/products/the-mediterranean-pizza.webp',0,4,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (5,1,'12\" The Vegan Pizza','Pizza végane 12 po',NULL,NULL,22.99,0,'uploads/products/the-vegan-pizza.webp',0,5,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (6,1,'12\" The Godfather Pizza','Pizza Godfather 12 po',NULL,NULL,20.99,0,'uploads/products/the-godfather-pizza.webp',0,6,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (7,1,'12\" The Vegetarian Pizza','Pizza végétarienne 12 po',NULL,NULL,19.99,0,'uploads/products/the-vegetarian-pizza.webp',0,7,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (8,1,'12\" New York Steak Pizza','Pizza au steak New York 12 po',NULL,NULL,20.99,0,'uploads/products/new-york-steak-pizza.webp',0,8,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (9,2,'15\" The Margarita Pizza','Pizza Margarita 15 po',NULL,NULL,21.99,0,'uploads/products/the-margarita-pizza.webp',0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (10,2,'15\" The Let\'s Eat Meat Pizza','Pizza Let\'s Eat Meat 15 po',NULL,NULL,30.99,0,'uploads/products/the-lets-eat-meat-pizza.webp',0,2,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (11,2,'15\" The Mediterranean Pizza','Pizza méditerranéenne 15 po',NULL,NULL,32.99,0,'uploads/products/the-mediterranean-pizza.webp',0,3,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (12,2,'15\" The Roma Pizza','Pizza Roma 15 po',NULL,NULL,29.99,0,'uploads/products/the-roma-pizza.webp',0,4,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (13,2,'15\" The Godfather Pizza','Pizza Godfather 15 po',NULL,NULL,30.99,0,'uploads/products/the-godfather-pizza.webp',0,5,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (14,2,'15\" The Vegan Pizza','Pizza végane 15 po',NULL,NULL,32.99,0,'uploads/products/the-vegan-pizza.webp',0,6,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (15,2,'15\" New York Steak Pizza','Pizza au steak New York 15 po',NULL,NULL,30.99,0,'uploads/products/new-york-steak-pizza.webp',0,7,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (16,2,'15\" The Vegetarian Pizza','Pizza végétarienne 15 po',NULL,NULL,29.99,0,'uploads/products/the-vegetarian-pizza.webp',0,8,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (17,3,'Panzerotti 10\"','Panzerotti 10 po',NULL,NULL,14.99,0,'uploads/products/panzerotti.webp',1,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (18,4,'Italian Wedding Soup (single portion)','Soupe au mariage italien (portion individuelle)',NULL,NULL,8.25,0,'uploads/products/italian-wedding-soup.webp',0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (19,4,'Pasta Fagioli Soup (single portion)','Soupe Pasta Fagioli (portion individuelle)',NULL,NULL,8.25,0,'uploads/products/pasta-faggioli-soup.webp',0,2,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (20,5,'Homemade Arancini Roma','Arancini maison Roma',NULL,NULL,12.99,0,'uploads/products/arancini.webp',0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (21,5,'The Meatball Classico','Le Meatball Classico',NULL,NULL,13.95,0,'uploads/products/the-meatball-classico.webp',0,2,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (22,5,'Lasagna \'Al Forno\'','Lasagna « Al Forno »',NULL,NULL,15.95,0,'uploads/products/lasagna-al-forno.webp',0,3,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (23,5,'Buttermilk Chicken Parmigiana','Poulet Parmigiana au babeurre',NULL,NULL,13.95,0,'uploads/products/buttermilk-chicken-parmigiana.webp',0,4,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (24,5,'Penne with Marinara Sauce (per person)','Penne, sauce marinara (par personne)',NULL,NULL,13.99,0,'uploads/products/penne-with-marinara-sauce.webp',0,5,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (25,5,'Penne with Bolognaise Sauce (per person)','Penne, sauce bolognaise (par personne)',NULL,NULL,14.99,0,NULL,0,6,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (26,5,'The Real Veal Parmigiana','Le vrai veau Parmigiana',NULL,NULL,13.95,0,NULL,0,7,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (27,6,'Caesar Salad','Salade César',NULL,NULL,9.96,0,'uploads/products/caesar-salad.webp',1,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (28,6,'Green Salad \"Roma\"','Salade verte « Roma »',NULL,NULL,9.96,0,'uploads/products/green-salad-roma.webp',0,2,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (29,7,'Garlic Wedges 12\"','Quartiers à l\'ail 12 po',NULL,NULL,9.95,0,'uploads/products/garlic-wedges.webp',0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (30,8,'Custard Lemon Sicilian Cannolis (6 Pieces)','Cannolis siciliens à la crème pâtissière au citron (6 morceaux)',NULL,NULL,7.99,0,'uploads/products/italian-cannolis.webp',1,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (31,9,'Caesar Dip','Trempette César',NULL,NULL,2.26,0,NULL,0,1,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (32,9,'Marinara Dip','Trempette marinara',NULL,NULL,2.50,0,NULL,0,2,1,'2026-07-22 16:49:18','2026-07-22 16:49:18');
INSERT INTO `products` VALUES (33,9,'Spicy Roma Dip','Trempette épicée Roma',NULL,NULL,2.26,0,NULL,0,3,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (34,9,'Roman Ranch Dip','Trempette Roman Ranch',NULL,NULL,2.26,0,NULL,0,4,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (35,9,'Garlic Aioli Dip','Trempette aïoli à l\'ail',NULL,NULL,2.26,0,NULL,0,5,1,'2026-07-22 16:49:18','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (36,10,'16\" The Let\'s Eat Meat Pizza','Pizza Let\'s Eat Meat 16 po',NULL,NULL,33.99,0,'uploads/products/the-lets-eat-meat-pizza.webp',0,100,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (37,10,'16\" The Margarita Pizza','Pizza Margarita 16 po',NULL,NULL,24.99,0,'uploads/products/the-margarita-pizza.webp',0,101,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (38,10,'16\" The Roma Pizza','Pizza Roma 16 po',NULL,NULL,32.99,0,'uploads/products/the-roma-pizza.webp',0,102,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (39,10,'16\" The Mediterranean Pizza','Pizza méditerranéenne 16 po',NULL,NULL,35.99,0,'uploads/products/the-mediterranean-pizza.webp',0,103,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (40,10,'16\" The Vegan Pizza','Pizza végane 16 po',NULL,NULL,35.99,0,'uploads/products/the-vegan-pizza.webp',0,104,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (41,10,'16\" The Godfather Pizza','Pizza Godfather 16 po',NULL,NULL,33.99,0,'uploads/products/the-godfather-pizza.webp',0,105,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (42,10,'16\" The Vegetarian Pizza','Pizza végétarienne 16 po',NULL,NULL,32.99,0,'uploads/products/the-vegetarian-pizza.webp',0,106,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (43,10,'16\" New York Steak Pizza','Pizza au steak New York 16 po',NULL,NULL,33.99,0,'uploads/products/new-york-steak-pizza.webp',0,107,1,'2026-08-06 15:12:19','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (44,11,'Panzerotti 15\"','Panzerotti 15 po',NULL,NULL,20.99,0,NULL,0,1,1,'2026-08-09 11:52:54','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (45,4,'San Marzano Tomato & Roasted Red Pepper Soup (single portion)','Soupe tomate San Marzano et poivron rouge rôti (portion individuelle)',NULL,NULL,8.25,0,NULL,0,3,1,'2026-08-09 11:52:54','2026-08-09 11:52:54');
INSERT INTO `products` VALUES (46,12,'Caesar Salad','Salade César',NULL,NULL,15.99,0,'uploads/products/79525d270591cabb70ca76df61fa4e58.png',0,1,1,'2026-08-09 11:52:54','2026-08-11 16:10:32');
INSERT INTO `products` VALUES (47,12,'Green Salad \"Roma\"','Salade verte « Roma »',NULL,NULL,15.99,0,NULL,0,2,1,'2026-08-09 11:52:54','2026-08-09 11:52:54');

-- Precios por plataforma de delivery (IndiEats, UberEats, Skip, DoorDash)
INSERT INTO `product_platform_prices` VALUES (1,1,'indieats',23.99,0);
INSERT INTO `product_platform_prices` VALUES (2,1,'ubereats',24.99,0);
INSERT INTO `product_platform_prices` VALUES (3,1,'skip',24.99,0);
INSERT INTO `product_platform_prices` VALUES (4,1,'doordash',24.99,0);
INSERT INTO `product_platform_prices` VALUES (5,10,'indieats',32.99,0);
INSERT INTO `product_platform_prices` VALUES (6,10,'ubereats',35.99,0);
INSERT INTO `product_platform_prices` VALUES (7,10,'skip',35.99,0);
INSERT INTO `product_platform_prices` VALUES (8,10,'doordash',35.99,0);
INSERT INTO `product_platform_prices` VALUES (9,2,'indieats',16.99,0);
INSERT INTO `product_platform_prices` VALUES (10,2,'ubereats',17.99,0);
INSERT INTO `product_platform_prices` VALUES (11,2,'skip',17.99,0);
INSERT INTO `product_platform_prices` VALUES (12,2,'doordash',17.99,0);
INSERT INTO `product_platform_prices` VALUES (13,9,'indieats',23.99,0);
INSERT INTO `product_platform_prices` VALUES (14,9,'ubereats',24.99,0);
INSERT INTO `product_platform_prices` VALUES (15,9,'skip',24.99,0);
INSERT INTO `product_platform_prices` VALUES (17,3,'indieats',22.99,0);
INSERT INTO `product_platform_prices` VALUES (18,3,'ubereats',23.99,0);
INSERT INTO `product_platform_prices` VALUES (19,3,'skip',23.99,0);
INSERT INTO `product_platform_prices` VALUES (20,3,'doordash',23.99,0);
INSERT INTO `product_platform_prices` VALUES (21,12,'indieats',30.99,0);
INSERT INTO `product_platform_prices` VALUES (22,12,'ubereats',33.99,0);
INSERT INTO `product_platform_prices` VALUES (23,12,'skip',33.99,0);
INSERT INTO `product_platform_prices` VALUES (24,12,'doordash',33.99,0);
INSERT INTO `product_platform_prices` VALUES (25,4,'indieats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (26,4,'ubereats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (27,4,'skip',25.99,0);
INSERT INTO `product_platform_prices` VALUES (28,4,'doordash',25.99,0);
INSERT INTO `product_platform_prices` VALUES (29,11,'indieats',34.99,0);
INSERT INTO `product_platform_prices` VALUES (30,11,'ubereats',37.99,0);
INSERT INTO `product_platform_prices` VALUES (31,11,'skip',37.99,0);
INSERT INTO `product_platform_prices` VALUES (32,11,'doordash',37.99,0);
INSERT INTO `product_platform_prices` VALUES (33,5,'indieats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (34,5,'ubereats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (35,5,'skip',25.99,0);
INSERT INTO `product_platform_prices` VALUES (36,5,'doordash',25.99,0);
INSERT INTO `product_platform_prices` VALUES (37,14,'indieats',31.95,0);
INSERT INTO `product_platform_prices` VALUES (38,14,'ubereats',36.99,0);
INSERT INTO `product_platform_prices` VALUES (39,14,'skip',36.99,0);
INSERT INTO `product_platform_prices` VALUES (40,14,'doordash',36.99,0);
INSERT INTO `product_platform_prices` VALUES (41,6,'indieats',23.99,0);
INSERT INTO `product_platform_prices` VALUES (42,6,'ubereats',24.99,0);
INSERT INTO `product_platform_prices` VALUES (43,6,'skip',24.99,0);
INSERT INTO `product_platform_prices` VALUES (44,6,'doordash',24.99,0);
INSERT INTO `product_platform_prices` VALUES (45,13,'indieats',32.99,0);
INSERT INTO `product_platform_prices` VALUES (46,13,'ubereats',35.99,0);
INSERT INTO `product_platform_prices` VALUES (47,13,'skip',35.99,0);
INSERT INTO `product_platform_prices` VALUES (48,13,'doordash',35.99,0);
INSERT INTO `product_platform_prices` VALUES (49,7,'indieats',22.99,0);
INSERT INTO `product_platform_prices` VALUES (50,7,'ubereats',23.99,0);
INSERT INTO `product_platform_prices` VALUES (51,7,'skip',23.99,0);
INSERT INTO `product_platform_prices` VALUES (52,7,'doordash',23.99,0);
INSERT INTO `product_platform_prices` VALUES (53,16,'indieats',31.99,0);
INSERT INTO `product_platform_prices` VALUES (54,16,'ubereats',34.99,0);
INSERT INTO `product_platform_prices` VALUES (55,16,'skip',34.99,0);
INSERT INTO `product_platform_prices` VALUES (56,16,'doordash',34.99,0);
INSERT INTO `product_platform_prices` VALUES (57,8,'indieats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (58,8,'ubereats',25.99,0);
INSERT INTO `product_platform_prices` VALUES (59,8,'skip',25.99,0);
INSERT INTO `product_platform_prices` VALUES (60,8,'doordash',25.99,0);
INSERT INTO `product_platform_prices` VALUES (61,15,'indieats',33.99,0);
INSERT INTO `product_platform_prices` VALUES (62,15,'ubereats',36.99,0);
INSERT INTO `product_platform_prices` VALUES (63,15,'skip',36.99,0);
INSERT INTO `product_platform_prices` VALUES (64,15,'doordash',36.99,0);
INSERT INTO `product_platform_prices` VALUES (65,17,'indieats',16.95,0);
INSERT INTO `product_platform_prices` VALUES (66,17,'ubereats',16.99,0);
INSERT INTO `product_platform_prices` VALUES (67,17,'skip',16.99,0);
INSERT INTO `product_platform_prices` VALUES (68,17,'doordash',16.99,0);
INSERT INTO `product_platform_prices` VALUES (69,18,'indieats',9.99,0);
INSERT INTO `product_platform_prices` VALUES (70,18,'ubereats',9.99,0);
INSERT INTO `product_platform_prices` VALUES (71,18,'skip',9.99,0);
INSERT INTO `product_platform_prices` VALUES (72,18,'doordash',9.99,0);
INSERT INTO `product_platform_prices` VALUES (73,19,'indieats',9.99,0);
INSERT INTO `product_platform_prices` VALUES (74,19,'ubereats',9.99,0);
INSERT INTO `product_platform_prices` VALUES (75,19,'skip',9.99,0);
INSERT INTO `product_platform_prices` VALUES (76,19,'doordash',9.99,0);
INSERT INTO `product_platform_prices` VALUES (77,20,'indieats',15.99,0);
INSERT INTO `product_platform_prices` VALUES (78,20,'ubereats',16.99,0);
INSERT INTO `product_platform_prices` VALUES (79,20,'skip',15.99,0);
INSERT INTO `product_platform_prices` VALUES (80,20,'doordash',15.99,0);
INSERT INTO `product_platform_prices` VALUES (81,21,'indieats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (82,21,'ubereats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (83,21,'skip',17.50,0);
INSERT INTO `product_platform_prices` VALUES (84,21,'doordash',17.50,0);
INSERT INTO `product_platform_prices` VALUES (85,22,'indieats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (86,22,'ubereats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (87,22,'skip',17.50,0);
INSERT INTO `product_platform_prices` VALUES (88,22,'doordash',17.50,0);
INSERT INTO `product_platform_prices` VALUES (89,23,'indieats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (90,23,'ubereats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (91,23,'skip',17.50,0);
INSERT INTO `product_platform_prices` VALUES (92,23,'doordash',17.50,0);
INSERT INTO `product_platform_prices` VALUES (93,24,'indieats',16.50,0);
INSERT INTO `product_platform_prices` VALUES (94,24,'ubereats',16.50,0);
INSERT INTO `product_platform_prices` VALUES (95,24,'skip',16.50,0);
INSERT INTO `product_platform_prices` VALUES (96,24,'doordash',16.50,0);
INSERT INTO `product_platform_prices` VALUES (97,25,'indieats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (98,25,'ubereats',17.50,0);
INSERT INTO `product_platform_prices` VALUES (99,25,'skip',17.50,0);
INSERT INTO `product_platform_prices` VALUES (100,25,'doordash',17.50,0);
INSERT INTO `product_platform_prices` VALUES (101,26,'indieats',17.99,0);
INSERT INTO `product_platform_prices` VALUES (102,26,'ubereats',17.99,0);
INSERT INTO `product_platform_prices` VALUES (103,26,'skip',17.99,0);
INSERT INTO `product_platform_prices` VALUES (104,26,'doordash',17.99,0);
INSERT INTO `product_platform_prices` VALUES (105,27,'indieats',11.00,0);
INSERT INTO `product_platform_prices` VALUES (106,27,'ubereats',11.00,0);
INSERT INTO `product_platform_prices` VALUES (107,27,'skip',11.00,0);
INSERT INTO `product_platform_prices` VALUES (108,27,'doordash',11.00,0);
INSERT INTO `product_platform_prices` VALUES (109,28,'indieats',11.00,0);
INSERT INTO `product_platform_prices` VALUES (110,28,'ubereats',10.00,0);
INSERT INTO `product_platform_prices` VALUES (111,28,'skip',11.00,0);
INSERT INTO `product_platform_prices` VALUES (112,28,'doordash',11.00,0);
INSERT INTO `product_platform_prices` VALUES (113,29,'indieats',13.99,0);
INSERT INTO `product_platform_prices` VALUES (114,29,'ubereats',13.99,0);
INSERT INTO `product_platform_prices` VALUES (115,29,'skip',13.99,0);
INSERT INTO `product_platform_prices` VALUES (116,29,'doordash',13.99,0);
INSERT INTO `product_platform_prices` VALUES (117,30,'indieats',11.99,0);
INSERT INTO `product_platform_prices` VALUES (118,30,'ubereats',11.99,0);
INSERT INTO `product_platform_prices` VALUES (119,30,'skip',11.99,0);
INSERT INTO `product_platform_prices` VALUES (120,30,'doordash',11.99,0);
INSERT INTO `product_platform_prices` VALUES (121,31,'indieats',1.75,0);
INSERT INTO `product_platform_prices` VALUES (122,31,'ubereats',2.50,0);
INSERT INTO `product_platform_prices` VALUES (123,31,'skip',2.50,0);
INSERT INTO `product_platform_prices` VALUES (125,32,'ubereats',2.50,0);
INSERT INTO `product_platform_prices` VALUES (126,32,'skip',2.50,0);
INSERT INTO `product_platform_prices` VALUES (128,33,'indieats',1.75,0);
INSERT INTO `product_platform_prices` VALUES (129,33,'ubereats',2.50,0);
INSERT INTO `product_platform_prices` VALUES (130,33,'skip',2.50,0);
INSERT INTO `product_platform_prices` VALUES (132,34,'indieats',1.75,0);
INSERT INTO `product_platform_prices` VALUES (133,34,'ubereats',2.50,0);
INSERT INTO `product_platform_prices` VALUES (134,34,'skip',2.50,0);
INSERT INTO `product_platform_prices` VALUES (136,35,'ubereats',2.50,0);
INSERT INTO `product_platform_prices` VALUES (137,35,'skip',2.50,0);

-- Promoción activa
INSERT INTO `promotions` VALUES (1,'Buy any size Margherita pizza and get 3 free toppings.','Achetez une pizza Margherita, peu importe la taille, et obtenez 3 garnitures gratuites.',1,NULL,NULL,'2026-07-22 16:15:48','2026-08-11 16:12:07');

-- Usuario admin de ejemplo (contraseña: CAMBIAR_ESTA_CONTRASENA)
-- Generar un hash real con: php -r "echo password_hash('tu-contraseña', PASSWORD_DEFAULT);"
INSERT INTO `admin_users` (`email`, `password_hash`) VALUES
('owner@pizzeriaroma.example', '$2y$10$REEMPLAZAR.CON.UN.HASH.REAL.GENERADO.CON.password_hash');
