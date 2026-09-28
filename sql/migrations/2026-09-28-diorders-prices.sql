-- =====================================================================
-- Pizzeria Roma — migration: DI orders prices
-- Generated 2026-09-28
--
-- Adds the 'diorders' platform (own ordering site, pizzeria-roma1894.com)
-- to product_platform_prices. menu_platform_list_for_product() only shows
-- a platform when a row exists, so products not listed here (16" pizzas,
-- 15" Panzerotti, San Marzano soup, family salads, dips) keep no DI orders
-- option in the order popup.
-- =====================================================================

SET NAMES utf8mb4;

INSERT INTO `product_platform_prices` (`product_id`, `platform`, `price`, `is_placeholder`) VALUES
  (1,  'diorders', 24.99, 0), -- 12" The Let's Eat Meat Pizza
  (2,  'diorders', 17.99, 0), -- 12" The Margarita Pizza
  (3,  'diorders', 23.99, 0), -- 12" The Roma Pizza
  (4,  'diorders', 25.99, 0), -- 12" The Mediterranean Pizza
  (5,  'diorders', 25.99, 0), -- 12" The Vegan Pizza
  (6,  'diorders', 24.99, 0), -- 12" The Godfather Pizza
  (7,  'diorders', 23.99, 0), -- 12" The Vegetarian Pizza
  (8,  'diorders', 25.99, 0), -- 12" New York Steak Pizza
  (9,  'diorders', 24.99, 0), -- 15" The Margarita Pizza
  (10, 'diorders', 35.99, 0), -- 15" The Let's Eat Meat Pizza
  (11, 'diorders', 37.99, 0), -- 15" The Mediterranean Pizza
  (12, 'diorders', 33.99, 0), -- 15" The Roma Pizza
  (13, 'diorders', 35.99, 0), -- 15" The Godfather Pizza
  (14, 'diorders', 36.99, 0), -- 15" The Vegan Pizza
  (15, 'diorders', 36.99, 0), -- 15" New York Steak Pizza
  (16, 'diorders', 34.99, 0), -- 15" The Vegetarian Pizza
  (17, 'diorders', 16.99, 0), -- Panzerotti 10"
  (18, 'diorders', 9.99,  0), -- Italian Wedding Soup (16 oz)
  (19, 'diorders', 9.99,  0), -- Pasta Fagioli Soup (16 oz)
  (20, 'diorders', 16.99, 0), -- Arancini "Roma" (3 pcs)
  (21, 'diorders', 17.50, 0), -- The Meatball Classico
  (22, 'diorders', 17.50, 0), -- Lasagna 'Al Forno'
  (23, 'diorders', 17.50, 0), -- Buttermilk Chicken Parmigiana
  (24, 'diorders', 16.50, 0), -- Penne with Marinara Sauce
  (25, 'diorders', 17.50, 0), -- Penne with Bolognese Sauce
  (26, 'diorders', 17.99, 0), -- The Real Veal Parmigiana
  (27, 'diorders', 11.00, 0), -- Caesar Salad
  (28, 'diorders', 10.00, 0), -- Green Salad "Roma"
  (29, 'diorders', 13.99, 0), -- Garlic Wedges 12"
  (30, 'diorders', 11.99, 0)  -- Italian Cannolis (6 pcs)
ON DUPLICATE KEY UPDATE `price` = VALUES(`price`), `is_placeholder` = VALUES(`is_placeholder`);
