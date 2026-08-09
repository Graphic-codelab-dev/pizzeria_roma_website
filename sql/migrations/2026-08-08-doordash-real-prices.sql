-- =====================================================================
-- Pizzeria Roma — migration: real DoorDash prices
-- Generated 2026-08-08
--
-- Replaces the placeholder DoorDash prices (pickup + 30% estimate,
-- inserted in 2026-08-06-pizza-16in-and-platform-prices.sql because
-- DoorDash blocked automated fetches) with the real prices pulled
-- from the live DoorDash menu. Clears is_placeholder for each row.
--
-- DoorDash does not carry every item: 15" Margarita and all 5 dips
-- are absent from their menu, so those placeholder rows are deleted
-- outright — menu_platform_list_for_product() only shows a platform
-- icon when a row exists, so removing the row hides the DoorDash
-- option for those products instead of showing a wrong price.
-- =====================================================================

SET NAMES utf8mb4;

UPDATE `product_platform_prices` SET `price` = 17.99, `is_placeholder` = 0 WHERE `product_id` = 2  AND `platform` = 'doordash'; -- 12" The Margarita Pizza
UPDATE `product_platform_prices` SET `price` = 24.99, `is_placeholder` = 0 WHERE `product_id` = 6  AND `platform` = 'doordash'; -- 12" The Godfather Pizza
UPDATE `product_platform_prices` SET `price` = 24.99, `is_placeholder` = 0 WHERE `product_id` = 1  AND `platform` = 'doordash'; -- 12" The Let's Eat Meat Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 5  AND `platform` = 'doordash'; -- 12" The Vegan Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 4  AND `platform` = 'doordash'; -- 12" The Mediterranean Pizza
UPDATE `product_platform_prices` SET `price` = 23.99, `is_placeholder` = 0 WHERE `product_id` = 7  AND `platform` = 'doordash'; -- 12" The Vegetarian Pizza
UPDATE `product_platform_prices` SET `price` = 23.99, `is_placeholder` = 0 WHERE `product_id` = 3  AND `platform` = 'doordash'; -- 12" The Roma Pizza
UPDATE `product_platform_prices` SET `price` = 25.99, `is_placeholder` = 0 WHERE `product_id` = 8  AND `platform` = 'doordash'; -- 12" New York Steak Pizza
UPDATE `product_platform_prices` SET `price` = 35.99, `is_placeholder` = 0 WHERE `product_id` = 13 AND `platform` = 'doordash'; -- 15" The Godfather Pizza
UPDATE `product_platform_prices` SET `price` = 35.99, `is_placeholder` = 0 WHERE `product_id` = 10 AND `platform` = 'doordash'; -- 15" The Let's Eat Meat Pizza
UPDATE `product_platform_prices` SET `price` = 34.99, `is_placeholder` = 0 WHERE `product_id` = 16 AND `platform` = 'doordash'; -- 15" The Vegetarian Pizza
UPDATE `product_platform_prices` SET `price` = 33.99, `is_placeholder` = 0 WHERE `product_id` = 12 AND `platform` = 'doordash'; -- 15" The Roma Pizza
UPDATE `product_platform_prices` SET `price` = 37.99, `is_placeholder` = 0 WHERE `product_id` = 11 AND `platform` = 'doordash'; -- 15" The Mediterranean Pizza
UPDATE `product_platform_prices` SET `price` = 36.99, `is_placeholder` = 0 WHERE `product_id` = 15 AND `platform` = 'doordash'; -- 15" New York Steak Pizza
UPDATE `product_platform_prices` SET `price` = 36.99, `is_placeholder` = 0 WHERE `product_id` = 14 AND `platform` = 'doordash'; -- 15" The Vegan Pizza
UPDATE `product_platform_prices` SET `price` = 16.99, `is_placeholder` = 0 WHERE `product_id` = 17 AND `platform` = 'doordash'; -- Panzerotti 10"
UPDATE `product_platform_prices` SET `price` = 9.99,  `is_placeholder` = 0 WHERE `product_id` = 18 AND `platform` = 'doordash'; -- Italian Wedding Soup (16 Oz)
UPDATE `product_platform_prices` SET `price` = 9.99,  `is_placeholder` = 0 WHERE `product_id` = 19 AND `platform` = 'doordash'; -- Pasta Faggioli soup (16 Oz)
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 23 AND `platform` = 'doordash'; -- Buttermilk Chicken Parmigiana
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 25 AND `platform` = 'doordash'; -- Penne with Bolognaise Sauce
UPDATE `product_platform_prices` SET `price` = 16.50, `is_placeholder` = 0 WHERE `product_id` = 24 AND `platform` = 'doordash'; -- Penne with Marinara Sauce
UPDATE `product_platform_prices` SET `price` = 17.99, `is_placeholder` = 0 WHERE `product_id` = 26 AND `platform` = 'doordash'; -- The Real Veal Parmigiana
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 22 AND `platform` = 'doordash'; -- Lasagna 'Al Forno'
UPDATE `product_platform_prices` SET `price` = 15.99, `is_placeholder` = 0 WHERE `product_id` = 20 AND `platform` = 'doordash'; -- Arancini "Roma" (3 Arancini)
UPDATE `product_platform_prices` SET `price` = 17.50, `is_placeholder` = 0 WHERE `product_id` = 21 AND `platform` = 'doordash'; -- The Meatball Classico
UPDATE `product_platform_prices` SET `price` = 11.00, `is_placeholder` = 0 WHERE `product_id` = 27 AND `platform` = 'doordash'; -- Caesar Salad
UPDATE `product_platform_prices` SET `price` = 11.00, `is_placeholder` = 0 WHERE `product_id` = 28 AND `platform` = 'doordash'; -- Green Salad "Roma"
UPDATE `product_platform_prices` SET `price` = 13.99, `is_placeholder` = 0 WHERE `product_id` = 29 AND `platform` = 'doordash'; -- Garlic Wedges 12"
UPDATE `product_platform_prices` SET `price` = 11.99, `is_placeholder` = 0 WHERE `product_id` = 30 AND `platform` = 'doordash'; -- Italian Cannolis (6 Pieces)

-- Not sold on DoorDash — drop the placeholder row so the DoorDash icon/option
-- no longer appears for these products.
DELETE FROM `product_platform_prices` WHERE `platform` = 'doordash' AND `product_id` IN (9, 31, 32, 33, 34, 35);
-- 9  = 15" The Margarita Pizza
-- 31 = Caesar Dip
-- 32 = Marinara Dip
-- 33 = Spicy Roma Dip
-- 34 = Ranch Dip
-- 35 = Garlic Aioli
