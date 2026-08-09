-- =====================================================================
-- Pizzeria Roma — migration: real Uber Eats prices
-- Generated 2026-08-08
--
-- Replaces the placeholder Uber Eats prices (pickup + 30% estimate,
-- inserted in 2026-08-06-pizza-16in-and-platform-prices.sql because
-- Uber Eats blocked automated fetches) with the real prices pulled
-- from the live Uber Eats menu. Clears is_placeholder for each row.
-- =====================================================================

SET NAMES utf8mb4;

UPDATE `product_platform_prices` SET `price` = 17.99, `is_placeholder` = 0 WHERE `product_id` = 2  AND `platform` = 'ubereats'; -- 12" The Margarita Pizza
UPDATE `product_platform_prices` SET `price` = 24.99, `is_placeholder` = 0 WHERE `product_id` = 6  AND `platform` = 'ubereats'; -- 12" The Godfather Pizza
UPDATE `product_platform_prices` SET `price` = 23.99, `is_placeholder` = 0 WHERE `product_id` = 7  AND `platform` = 'ubereats'; -- 12" The Vegetarian Pizza
UPDATE `product_platform_prices` SET `price` = 24.99, `is_placeholder` = 0 WHERE `product_id` = 1  AND `platform` = 'ubereats'; -- 12" The Let's Eat Meat Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 8  AND `platform` = 'ubereats'; -- 12" New York Steak Pizza
UPDATE `product_platform_prices` SET `price` = 23.99, `is_placeholder` = 0 WHERE `product_id` = 3  AND `platform` = 'ubereats'; -- 12" The Roma Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 4  AND `platform` = 'ubereats'; -- 12" The Mediterranean Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 5  AND `platform` = 'ubereats'; -- 12" The Vegan Pizza
UPDATE `product_platform_prices` SET `price` = 24.99, `is_placeholder` = 0 WHERE `product_id` = 9  AND `platform` = 'ubereats'; -- 15" The Margarita Pizza
UPDATE `product_platform_prices` SET `price` = 35.99, `is_placeholder` = 0 WHERE `product_id` = 13 AND `platform` = 'ubereats'; -- 15" The Godfather Pizza
UPDATE `product_platform_prices` SET `price` = 35.99, `is_placeholder` = 0 WHERE `product_id` = 10 AND `platform` = 'ubereats'; -- 15" The Let's Eat Meat Pizza
UPDATE `product_platform_prices` SET `price` = 34.99, `is_placeholder` = 0 WHERE `product_id` = 16 AND `platform` = 'ubereats'; -- 15" The Vegetarian Pizza
UPDATE `product_platform_prices` SET `price` = 36.99, `is_placeholder` = 0 WHERE `product_id` = 15 AND `platform` = 'ubereats'; -- 15" New York Steak Pizza
UPDATE `product_platform_prices` SET `price` = 33.99, `is_placeholder` = 0 WHERE `product_id` = 12 AND `platform` = 'ubereats'; -- 15" The Roma Pizza
UPDATE `product_platform_prices` SET `price` = 37.99, `is_placeholder` = 0 WHERE `product_id` = 11 AND `platform` = 'ubereats'; -- 15" The Mediterranean Pizza
UPDATE `product_platform_prices` SET `price` = 36.99, `is_placeholder` = 0 WHERE `product_id` = 14 AND `platform` = 'ubereats'; -- 15" The Vegan Pizza
UPDATE `product_platform_prices` SET `price` = 16.99, `is_placeholder` = 0 WHERE `product_id` = 17 AND `platform` = 'ubereats'; -- Panzerotti 10"
UPDATE `product_platform_prices` SET `price` = 9.99,  `is_placeholder` = 0 WHERE `product_id` = 18 AND `platform` = 'ubereats'; -- Italian Wedding soup (16 Oz)
UPDATE `product_platform_prices` SET `price` = 9.99,  `is_placeholder` = 0 WHERE `product_id` = 19 AND `platform` = 'ubereats'; -- Pasta Faggioli soup (16 Oz)
UPDATE `product_platform_prices` SET `price` = 16.99, `is_placeholder` = 0 WHERE `product_id` = 20 AND `platform` = 'ubereats'; -- Arancini "Roma" (3 Arancini)
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 25 AND `platform` = 'ubereats'; -- Penne with Bolognaise Sauce
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 21 AND `platform` = 'ubereats'; -- The Meatball Classico
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 22 AND `platform` = 'ubereats'; -- Lasagna 'Al Forno'
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 23 AND `platform` = 'ubereats'; -- Buttermilk Chicken Parmigiana
UPDATE `product_platform_prices` SET `price` = 16.50, `is_placeholder` = 0 WHERE `product_id` = 24 AND `platform` = 'ubereats'; -- Penne with Marinara Sauce
UPDATE `product_platform_prices` SET `price` = 17.99, `is_placeholder` = 0 WHERE `product_id` = 26 AND `platform` = 'ubereats'; -- The Real Veal Parmigiana
UPDATE `product_platform_prices` SET `price` = 11.00, `is_placeholder` = 0 WHERE `product_id` = 27 AND `platform` = 'ubereats'; -- Caesar Salad
UPDATE `product_platform_prices` SET `price` = 10.00, `is_placeholder` = 0 WHERE `product_id` = 28 AND `platform` = 'ubereats'; -- Green Salad "Roma"
UPDATE `product_platform_prices` SET `price` = 13.99, `is_placeholder` = 0 WHERE `product_id` = 29 AND `platform` = 'ubereats'; -- Garlic Wedges 12"
UPDATE `product_platform_prices` SET `price` = 11.99, `is_placeholder` = 0 WHERE `product_id` = 30 AND `platform` = 'ubereats'; -- Italian Cannolis (6 Pieces)
UPDATE `product_platform_prices` SET `price` = 2.50,  `is_placeholder` = 0 WHERE `product_id` = 31 AND `platform` = 'ubereats'; -- Caesar Dip
UPDATE `product_platform_prices` SET `price` = 2.50,  `is_placeholder` = 0 WHERE `product_id` = 32 AND `platform` = 'ubereats'; -- Marinara Dip
UPDATE `product_platform_prices` SET `price` = 2.50,  `is_placeholder` = 0 WHERE `product_id` = 33 AND `platform` = 'ubereats'; -- Spicy Roma Dip
UPDATE `product_platform_prices` SET `price` = 2.50,  `is_placeholder` = 0 WHERE `product_id` = 34 AND `platform` = 'ubereats'; -- Ranch Dip
UPDATE `product_platform_prices` SET `price` = 2.50,  `is_placeholder` = 0 WHERE `product_id` = 35 AND `platform` = 'ubereats'; -- Garlic aioli
