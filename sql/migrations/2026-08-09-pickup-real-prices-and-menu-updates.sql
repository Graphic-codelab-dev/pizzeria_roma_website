-- =====================================================================
-- Pizzeria Roma — migration: real Pickup prices + menu updates
-- Generated 2026-08-09
--
-- Replaces base `products.price` (the in-house pickup price) with the
-- real prices from the client's current physical/POS menu. Also:
--  - clears is_price_placeholder on the 16" pizza tier (first real
--    pickup prices for that size, added as an estimate in
--    2026-08-06-pizza-16in-and-platform-prices.sql)
--  - renames a handful of items whose pickup-menu name changed
--    (same product, confirmed with client — not a new item)
--  - adds a 15" Panzerotti size and Family-size (4) salad variants,
--    following the same size-tier-as-separate-category pattern used
--    for pizzas (see menu_merge_sized_products() in
--    sections/menu/merge-pizza-sizes.php)
--  - Marinara Dip intentionally left untouched — absent from the
--    client's pickup list but confirmed to still be on the menu
--  - Toppings and Crust Add-ons are NOT included here — they're
--    per-unit add-on pricing with no product to attach to under the
--    current schema/ordering flow; deferred to a future feature
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- New hidden categories for size/portion tiers (merged into their
-- primary category's cards client-side, same as pizzas-15/pizzas-16).
-- ---------------------------------------------------------------------
INSERT INTO `categories` (`id`, `name_en`, `name_fr`, `slug`, `display_order`, `is_active`) VALUES
(11, 'Panzerotti 15"', 'Panzerotti 15 po', 'panzerotti-15', 3, 1),
(12, 'Salads — Family Size', 'Salades — Format familial', 'salads-family', 6, 1);

-- ---------------------------------------------------------------------
-- 12" pizzas — real pickup prices (`products`.`price`)
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 16.99 WHERE `id` = 2;  -- 12" The Margarita Pizza
UPDATE `products` SET `price` = 19.99 WHERE `id` = 3;  -- 12" The Roma Pizza
UPDATE `products` SET `price` = 20.99 WHERE `id` = 6;  -- 12" The Godfather Pizza
UPDATE `products` SET `price` = 20.99 WHERE `id` = 1;  -- 12" The Let's Eat Meat Pizza
UPDATE `products` SET `price` = 19.99 WHERE `id` = 7;  -- 12" The Vegetarian Pizza
UPDATE `products` SET `price` = 20.99 WHERE `id` = 8;  -- 12" New York Steak Pizza
UPDATE `products` SET `price` = 22.99 WHERE `id` = 5;  -- 12" The Vegan Pizza
UPDATE `products` SET `price` = 22.99 WHERE `id` = 4;  -- 12" The Mediterranean Pizza

-- ---------------------------------------------------------------------
-- 15" pizzas
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 21.99 WHERE `id` = 9;   -- 15" The Margarita Pizza
UPDATE `products` SET `price` = 29.99 WHERE `id` = 12;  -- 15" The Roma Pizza
UPDATE `products` SET `price` = 30.99 WHERE `id` = 13;  -- 15" The Godfather Pizza
UPDATE `products` SET `price` = 30.99 WHERE `id` = 10;  -- 15" The Let's Eat Meat Pizza
UPDATE `products` SET `price` = 29.99 WHERE `id` = 16;  -- 15" The Vegetarian Pizza
UPDATE `products` SET `price` = 30.99 WHERE `id` = 15;  -- 15" New York Steak Pizza
UPDATE `products` SET `price` = 32.99 WHERE `id` = 14;  -- 15" The Vegan Pizza
UPDATE `products` SET `price` = 32.99 WHERE `id` = 11;  -- 15" The Mediterranean Pizza

-- ---------------------------------------------------------------------
-- 16" pizzas — first real pickup prices; clear the estimate flag
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 24.99, `is_price_placeholder` = 0 WHERE `id` = 37;  -- 16" The Margarita Pizza
UPDATE `products` SET `price` = 32.99, `is_price_placeholder` = 0 WHERE `id` = 38;  -- 16" The Roma Pizza
UPDATE `products` SET `price` = 33.99, `is_price_placeholder` = 0 WHERE `id` = 41;  -- 16" The Godfather Pizza
UPDATE `products` SET `price` = 33.99, `is_price_placeholder` = 0 WHERE `id` = 36;  -- 16" The Let's Eat Meat Pizza
UPDATE `products` SET `price` = 32.99, `is_price_placeholder` = 0 WHERE `id` = 42;  -- 16" The Vegetarian Pizza
UPDATE `products` SET `price` = 33.99, `is_price_placeholder` = 0 WHERE `id` = 43;  -- 16" New York Steak Pizza
UPDATE `products` SET `price` = 35.99, `is_price_placeholder` = 0 WHERE `id` = 40;  -- 16" The Vegan Pizza
UPDATE `products` SET `price` = 35.99, `is_price_placeholder` = 0 WHERE `id` = 39;  -- 16" The Mediterranean Pizza

-- ---------------------------------------------------------------------
-- Panzerotti — reprice 10", add 15" as a new size-tier product
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 14.99 WHERE `id` = 17;  -- Panzerotti 10"

INSERT INTO `products`
(`id`, `category_id`, `name_en`, `name_fr`, `description_en`, `description_fr`, `price`, `is_price_placeholder`, `image_path`, `is_featured`, `display_order`, `is_active`) VALUES
(44, 11, 'Panzerotti 15"', 'Panzerotti 15 po', NULL, NULL, 20.99, 0, NULL, 0, 1, 1);

-- ---------------------------------------------------------------------
-- Hot Soup — rename to "(single portion)", reprice, add new flavour
-- ---------------------------------------------------------------------
UPDATE `products` SET
  `name_en` = 'Italian Wedding Soup (single portion)',
  `name_fr` = 'Soupe au mariage italien (portion individuelle)',
  `price`   = 8.25
WHERE `id` = 18;

UPDATE `products` SET
  `name_en` = 'Pasta Fagioli Soup (single portion)',
  `name_fr` = 'Soupe Pasta Fagioli (portion individuelle)',
  `price`   = 8.25
WHERE `id` = 19;

INSERT INTO `products`
(`id`, `category_id`, `name_en`, `name_fr`, `description_en`, `description_fr`, `price`, `is_price_placeholder`, `image_path`, `is_featured`, `display_order`, `is_active`) VALUES
(45, 4, 'San Marzano Tomato & Roasted Red Pepper Soup (single portion)', 'Soupe tomate San Marzano et poivron rouge rôti (portion individuelle)', NULL, NULL, 8.25, 0, NULL, 0, 3, 1);

-- ---------------------------------------------------------------------
-- Hot Sandwiches — reprice, rename Arancini and the two Penne dishes
-- ---------------------------------------------------------------------
UPDATE `products` SET
  `name_en` = 'Homemade Arancini Roma',
  `name_fr` = 'Arancini maison Roma',
  `price`   = 12.99
WHERE `id` = 20;

UPDATE `products` SET `price` = 13.95 WHERE `id` = 21;  -- The Meatball Classico
UPDATE `products` SET `price` = 13.95 WHERE `id` = 26;  -- The Real Veal Parmigiana
UPDATE `products` SET `price` = 13.95 WHERE `id` = 23;  -- Buttermilk Chicken Parmigiana
UPDATE `products` SET `price` = 15.95 WHERE `id` = 22;  -- Lasagna 'Al Forno'

UPDATE `products` SET
  `name_en` = 'Penne with Bolognaise Sauce (per person)',
  `name_fr` = 'Penne, sauce bolognaise (par personne)',
  `price`   = 14.99
WHERE `id` = 25;

UPDATE `products` SET
  `name_en` = 'Penne with Marinara Sauce (per person)',
  `name_fr` = 'Penne, sauce marinara (par personne)',
  `price`   = 13.99
WHERE `id` = 24;

-- ---------------------------------------------------------------------
-- Side
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 9.95 WHERE `id` = 29;  -- Garlic Wedges 12"

-- ---------------------------------------------------------------------
-- Salads — reprice existing rows as the "per person" tier, add
-- Family Size (4) as a new size-tier product per salad
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 9.96 WHERE `id` = 27;  -- Caesar Salad (per person)
UPDATE `products` SET `price` = 9.96 WHERE `id` = 28;  -- Green Salad "Roma" (per person)

INSERT INTO `products`
(`id`, `category_id`, `name_en`, `name_fr`, `description_en`, `description_fr`, `price`, `is_price_placeholder`, `image_path`, `is_featured`, `display_order`, `is_active`) VALUES
(46, 12, 'Caesar Salad', 'Salade César', NULL, NULL, 15.99, 0, NULL, 0, 1, 1),
(47, 12, 'Green Salad "Roma"', 'Salade verte « Roma »', NULL, NULL, 15.99, 0, NULL, 0, 2, 1);

-- ---------------------------------------------------------------------
-- Dessert
-- ---------------------------------------------------------------------
UPDATE `products` SET
  `name_en` = 'Custard Lemon Sicilian Cannolis (6 Pieces)',
  `name_fr` = 'Cannolis siciliens à la crème pâtissière au citron (6 morceaux)',
  `price`   = 7.99
WHERE `id` = 30;

-- ---------------------------------------------------------------------
-- Dips — reprice, rename Ranch and Garlic Aioli; Marinara Dip (id 32)
-- intentionally untouched (absent from client's pickup list)
-- ---------------------------------------------------------------------
UPDATE `products` SET `price` = 2.26 WHERE `id` = 31;  -- Caesar Dip
UPDATE `products` SET `price` = 2.26 WHERE `id` = 33;  -- Spicy Roma Dip

UPDATE `products` SET
  `name_en` = 'Roman Ranch Dip',
  `name_fr` = 'Trempette Roman Ranch',
  `price`   = 2.26
WHERE `id` = 34;

UPDATE `products` SET
  `name_en` = 'Garlic Aioli Dip',
  `name_fr` = 'Trempette aïoli à l\'ail',
  `price`   = 2.26
WHERE `id` = 35;
