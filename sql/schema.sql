-- =====================================================================
-- Pizzeria Roma — schema.sql
-- MySQL 5.7+ / MariaDB 10.3+
-- Charset: utf8mb4 (soporte completo de acentos franceses e italianos)
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- categories
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en`        VARCHAR(100) NOT NULL,
  `name_fr`        VARCHAR(100) NOT NULL,
  `slug`           VARCHAR(100) NOT NULL,
  `display_order`  INT UNSIGNED NOT NULL DEFAULT 0,
  `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categories_slug` (`slug`),
  KEY `idx_categories_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- products
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id`      INT UNSIGNED NOT NULL,
  `name_en`          VARCHAR(150) NOT NULL,
  `name_fr`          VARCHAR(150) NOT NULL,
  `description_en`   TEXT NULL,
  `description_fr`   TEXT NULL,
  `price`            DECIMAL(6,2) NOT NULL,
  `image_path`       VARCHAR(255) NULL,
  `is_featured`      TINYINT(1) NOT NULL DEFAULT 0,
  `display_order`    INT UNSIGNED NOT NULL DEFAULT 0,
  `is_active`        TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_products_category` (`category_id`),
  KEY `idx_products_order` (`display_order`),
  KEY `idx_products_featured` (`is_featured`),
  CONSTRAINT `fk_products_category`
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- promotions
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text_en`     VARCHAR(255) NOT NULL,
  `text_fr`     VARCHAR(255) NOT NULL,
  `is_active`   TINYINT(1) NOT NULL DEFAULT 0,
  `start_date`  DATE NULL,
  `end_date`    DATE NULL,
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- admin_users
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`            VARCHAR(150) NOT NULL,
  `password_hash`    VARCHAR(255) NOT NULL,
  `failed_attempts`  INT UNSIGNED NOT NULL DEFAULT 0,
  `locked_until`     DATETIME NULL,
  `last_login`       DATETIME NULL,
  `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- SEED DATA
-- =====================================================================

-- Categorías
INSERT INTO `categories` (`id`, `name_en`, `name_fr`, `slug`, `display_order`, `is_active`) VALUES
(1, 'Pizzas',     'Pizzas',       'pizzas',     1, 1),
(2, 'Pasta',      'Pâtes',        'pasta',      2, 1),
(3, 'Appetizers', 'Entrées',      'appetizers', 3, 1),
(4, 'Salads',     'Salades',      'salads',     4, 1),
(5, 'Desserts',   'Desserts',     'desserts',   5, 1),
(6, 'Drinks',     'Boissons',     'drinks',     6, 1);

-- Productos
INSERT INTO `products`
(`category_id`, `name_en`, `name_fr`, `description_en`, `description_fr`, `price`, `image_path`, `is_featured`, `display_order`, `is_active`) VALUES
(1, 'Margherita',
    'Margherita',
    'San Marzano tomato sauce, fresh mozzarella, basil, extra virgin olive oil — fired in our wood oven.',
    'Sauce tomate San Marzano, mozzarella fraîche, basilic, huile d''olive extra vierge — cuite au four à bois.',
    16.00, 'assets/images/menu/margherita.webp', 1, 1, 1),
(1, 'Prosciutto e Funghi',
    'Prosciutto e Funghi',
    'Tomato sauce, mozzarella, prosciutto cotto, wild mushrooms, fresh thyme.',
    'Sauce tomate, mozzarella, prosciutto cotto, champignons sauvages, thym frais.',
    19.00, 'assets/images/menu/prosciutto-funghi.webp', 1, 2, 1),
(1, 'Diavola',
    'Diavola',
    'Tomato sauce, mozzarella, spicy salami, calabrian chili, honey drizzle.',
    'Sauce tomate, mozzarella, salami épicé, piment calabrais, filet de miel.',
    18.50, 'assets/images/menu/diavola.webp', 1, 3, 1),
(1, 'Quattro Formaggi',
    'Quattro Formaggi',
    'Mozzarella, gorgonzola, fontina, parmigiano reggiano, cracked black pepper.',
    'Mozzarella, gorgonzola, fontina, parmigiano reggiano, poivre noir concassé.',
    18.00, 'assets/images/menu/quattro-formaggi.webp', 0, 4, 1),
(2, 'Tagliatelle al Ragù',
    'Tagliatelle al Ragù',
    'Fresh tagliatelle, slow-cooked beef and pork ragù, parmigiano reggiano.',
    'Tagliatelles fraîches, ragù de bœuf et de porc mijoté, parmigiano reggiano.',
    21.00, 'assets/images/menu/tagliatelle-ragu.webp', 0, 1, 1),
(2, 'Penne alla Vodka',
    'Penne alla Vodka',
    'Penne, tomato-vodka cream sauce, parmigiano, fresh basil.',
    'Penne, sauce crémeuse tomate-vodka, parmigiano, basilic frais.',
    19.00, 'assets/images/menu/penne-vodka.webp', 0, 2, 1),
(3, 'Bruschetta al Pomodoro',
    'Bruschetta al Pomodoro',
    'Grilled sourdough, San Marzano tomatoes, garlic, basil, olive oil.',
    'Pain au levain grillé, tomates San Marzano, ail, basilic, huile d''olive.',
    9.50, 'assets/images/menu/bruschetta.webp', 0, 1, 1),
(3, 'Arancini',
    'Arancini',
    'Crispy risotto balls, mozzarella core, San Marzano dipping sauce.',
    'Boulettes de risotto croustillantes, cœur de mozzarella, sauce San Marzano.',
    11.00, 'assets/images/menu/arancini.webp', 0, 2, 1),
(4, 'Caesar Salad',
    'Salade César',
    'Romaine, house Caesar dressing, parmigiano, garlic croutons.',
    'Romaine, vinaigrette César maison, parmigiano, croûtons à l''ail.',
    12.00, 'assets/images/menu/caesar.webp', 0, 1, 1),
(5, 'Tiramisu',
    'Tiramisu',
    'Espresso-soaked ladyfingers, mascarpone cream, cocoa.',
    'Biscuits imbibés d''espresso, crème de mascarpone, cacao.',
    8.50, 'assets/images/menu/tiramisu.webp', 0, 1, 1),
(6, 'San Pellegrino',
    'San Pellegrino',
    'Sparkling mineral water, 500ml.',
    'Eau minérale gazeuse, 500ml.',
    3.50, 'assets/images/menu/san-pellegrino.webp', 0, 1, 1);

-- Promoción activa (texto por defecto — editable desde /admin/promociones)
INSERT INTO `promotions` (`text_en`, `text_fr`, `is_active`, `start_date`, `end_date`) VALUES
('Buy any size Margherita pizza and get 3 free toppings.',
 'Achetez une pizza Margherita, peu importe la taille, et obtenez 3 garnitures gratuites.',
 1, NULL, NULL);

-- Usuario admin de ejemplo (contraseña: CAMBIAR_ESTA_CONTRASENA)
-- Generar un hash real con: php -r "echo password_hash('tu-contraseña', PASSWORD_DEFAULT);"
INSERT INTO `admin_users` (`email`, `password_hash`) VALUES
('owner@pizzeriaroma.example', '$2y$10$REEMPLAZAR.CON.UN.HASH.REAL.GENERADO.CON.password_hash');
