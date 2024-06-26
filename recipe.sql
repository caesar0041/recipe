-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 03:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` tinyint(4) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_type`) VALUES
(11, 'Breakfast', 'Meal Type'),
(12, 'Lunch', 'Meal Type'),
(13, 'Dinner', 'Meal Type'),
(14, 'Snack', 'Meal Type'),
(15, 'Filipino', 'Cuisine Type'),
(16, 'Italian', 'Cuisine Type'),
(17, 'Vegetarian', 'Dietary Restrictions'),
(18, 'Birthday', 'Occasion'),
(35, 'Wedding', 'Occasion'),
(40, 'Dessert', 'Meal Type');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `ingredient_name`) VALUES
(2019, ' Bay Leaf'),
(2022, ' Ground Pepper'),
(2021, ' Lechon Sarsa'),
(2017, ' Vegetable Oil'),
(2035, '2'),
(2038, 'a'),
(2024, 'Bacon'),
(2042, 'Baking powder'),
(2043, 'Baking soda'),
(2046, 'Bay leaf'),
(2015, 'Black pepper'),
(2047, 'Brown Sugad'),
(2010, 'Brown Sugar'),
(2040, 'Butter'),
(2032, 'Chicken'),
(2048, 'Cooking Oil'),
(2013, 'Cornstarch'),
(2001, 'Egg'),
(2041, 'Flour'),
(2005, 'Garlic'),
(2027, 'Ginger'),
(2008, 'Ground Beef'),
(2023, 'Hotdog'),
(2026, 'Hotdog Buns'),
(2028, 'Knorr chicken cubes'),
(2018, 'Lechon'),
(2033, 'Live Chick Egg'),
(2030, 'Moringa leaves'),
(2002, 'Mustard'),
(2025, 'Oil'),
(2004, 'Onion'),
(2029, 'Papaya'),
(2036, 'pasta'),
(2007, 'Pepper'),
(2034, 'pork'),
(2014, 'Red pepper flakes'),
(2031, 's'),
(2006, 'Salt'),
(2009, 'Sirloin'),
(2011, 'Soy Sauce'),
(2039, 'Strawberries'),
(2044, 'Vanilla extract'),
(2016, 'Vegetable Oil'),
(2045, 'Vinegar'),
(2037, 'w'),
(2020, 'Water'),
(2012, 'White Vinegar'),
(2003, 'Worcestershire sauce');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `recipe_id` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `cooking_time` int(11) NOT NULL,
  `serving_size` int(11) NOT NULL,
  `instructions` text NOT NULL,
  `recipe_image` blob DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `published_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `user_id`, `recipe_name`, `cooking_time`, `serving_size`, `instructions`, `recipe_image`, `status`, `created_at`, `published_at`) VALUES
(3001, 5002, 'TAPSILOG', 50, 5, '<div class=\"InstructionsWrapper-hZXqPx RmryN\" data-testid=\"InstructionsWrapper\" data-event-boundary=\"click\" data-event-click=\"{\" pattern\":\"instructionlist\"}\"=\"\" data-in-view=\"{\" data-include-experiments=\"true\" style=\"margin-bottom: 2rem; color: rgb(0, 0, 0); font-family: Radley, Georgia, serif; font-size: 18px;\"><h6 style=\"margin: 0.5rem 0px; --color__token-name: colors.consumption.body.standard.body; --type-token: consumptionEditorial.body-core; font-feature-settings: normal; line-break: auto; line-height: 1.80647em; overflow-wrap: normal;\" class=\"\"><span style=\"font-family: Arial;\"><b>Step 1:&nbsp;</b></span><span style=\"font-family: Arial;\">Pat beef dry with paper towels. Whisk garlic, brown sugar, soy sauce, vinegar, cornstarch, red pepper flakes, black pepper, and salt in a medium bowl. Add beef to marinade and toss well to coat. Cover and chill at least 6 hours and up to 1 day.<br></span><span style=\"font-family: Arial;\"><b>Step 2:&nbsp;</b></span><span style=\"font-family: Arial;\">Heat oil in a large nonstick skillet over high. Drain beef in a sieve, letting as much excess marinade drip off as possible. Add half of beef to skillet, arranging in a single layer and cook, turning halfway through, until beef is cooked through and deeply browned in spots, about 3 minutes (be careful; the marinade will splatter). Transfer beef to a plate. Discard any garlic remaining in pan and repeat process with remaining beef. Keep warm. Clean skillet and set aside.<br></span><span style=\"font-family: Arial;\"><b>Step 3:&nbsp;</b></span><span style=\"font-family: Arial;\">Place rice in a large bowl and break up with a rubber spatula. Stir in 1 tsp. Diamond Crystal or ½ tsp. Morton kosher salt; set aside.<br></span><span style=\"font-family: Arial;\"><b>Step 4:&nbsp;</b></span><span style=\"font-family: Arial;\">Heat oil in reserved skillet over medium-low. Cook garlic, stirring occasionally, until golden brown and crisp, about 5 minutes. Drain garlic in a fine-mesh sieve set over a small bowl; transfer to a small plate.<br></span><span style=\"font-family: Arial;\"><b>Step 5:&nbsp;</b></span><span style=\"font-family: Arial;\">Pour 2 Tbsp. garlic oil back into skillet and heat over medium-high. Add reserved rice mixture and stir to coat in oil. Cook, stirring occasionally, until heated through, about 5 minutes. Set 1 Tbsp. fried garlic aside for serving and stir remaining fried garlic into rice. Transfer to a bowl and keep warm.<br></span><span style=\"font-family: Arial;\"><b>Step 6:&nbsp;</b></span><span style=\"font-family: Arial;\">Heat remaining garlic oil in the same skillet over medium-high (you should have 2 Tbsp.; add vegetable oil to make up the difference if needed). Crack eggs into skillet and season with salt. Cook until whites are almost set, about 2 minutes. Carefully tilt skillet so oil pools on one side. Spoon oil over egg whites until fully set, about 1 minute.<br></span><span style=\"font-family: Arial;\"><b>Step 7:&nbsp;</b></span><span style=\"font-family: Arial;\">Divide rice mixture, meat, and eggs among plates and top with reserved fried garlic.</span></h6></div>', 0x32303231313230382054617073696c6f67204c4544452e77656270, 1, '2024-06-01 13:35:35', '2024-06-02 12:32:21'),
(3002, 5002, 'PORK ADOBO', 30, 4, '&amp;lt;ol&amp;gt;&amp;lt;li&amp;gt;Heat a little cooking oil in a large pan or pot over medium\r\nheat.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Sauté the garlic and onions until fragrant and translucent.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Add the pork pieces and cook until browned on all sides.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Pour in the soy sauce, vinegar, water, bay leaf, and\r\npeppercorns. If using brown sugar, add it now.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Stir everything together and bring to a boil.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Once boiling, reduce the heat to low, cover the pot, and let\r\nit simmer for about 1 to 1.5 hours or until the pork is tender. Stir\r\noccasionally.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Once the pork is tender and the sauce has thickened, taste\r\nand adjust the seasoning if needed. You can add more soy sauce or vinegar\r\naccording to your preference.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;li&amp;gt;Serve hot with steamed rice.&amp;lt;o:p&amp;gt;&amp;lt;/o:p&amp;gt;&amp;lt;/li&amp;gt;&amp;lt;/ol&amp;gt;', 0x494d475f363231382d353030783530302e6a7067, 1, '2024-06-02 08:54:55', '2024-06-03 01:22:52'),
(3003, 5001, 'STRAWBERRY POKE CAKE', 180, 15, '<p class=\"MsoNoSpacing\"><span style=\"border:none windowtext 1.0pt;mso-border-alt:\r\nnone windowtext 0in;padding:0in\">Directions</span><o:p></o:p></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">1.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">For the cake:\r\nPosition an oven rack in the lower third of the oven and preheat to 350 degrees\r\nF. Butter the bottom and sides of a 9-by-13-inch pan.<o:p></o:p></span></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">2.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">Whisk the\r\nflour, baking powder, baking soda and salt in a medium bowl; set aside. Whisk\r\nthe buttermilk and vanilla in a spouted measuring cup; set aside.<o:p></o:p></span></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">3.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">Beat the sugar\r\nand butter in a stand mixer (or a large bowl if using a hand mixer) at medium\r\nspeed until very light in color and fluffy, about 5 minutes, scraping down the\r\nside of the bowl as needed. Slowly add the eggs and beat until fully\r\nincorporated. Reduce the speed to the lowest setting; with the mixer running,\r\nalternate beating in the flour mixture in three additions and the buttermilk\r\nmixture in two, starting and ending with the flour mixture. Scrape down the\r\nside of the bowl, and beat until the batter is well mixed. Spread into the\r\nprepared pan.<o:p></o:p></span></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">4.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">Bake the cake\r\nuntil golden brown and a toothpick inserted in the center comes out clean,\r\nabout 30 minutes, rotating the pan halfway through. Let cool in the pan for 30\r\nminutes. Using a fork, poke holes in the top and all the way through the cake.<o:p></o:p></span></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">5.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">Bring 1 cup\r\nwater to a boil, pour over the gelatin in a small bowl and stir until\r\ncompletely dissolved, about 2 minutes. Stir in 1/2 cup cold water. Pour the\r\nmixture evenly over the cooled cake. Refrigerate for 2 hours. Put a large bowl\r\n(for whipping the cream) in the refrigerator.<o:p></o:p></span></p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">6.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">For the\r\nsweetened berries: While the cake chills, hull and quarter the strawberries.\r\nToss with the granulated sugar in a medium bowl, and set aside until soft and\r\njuicy, about 1 hour.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNoSpacing\" style=\"margin-left:.5in;text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-fareast-font-family:inherit;mso-bidi-font-family:\r\ninherit;mso-bidi-font-weight:normal\">7.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><!--[endif]--><span style=\"font-family:&quot;inherit&quot;,serif;mso-bidi-font-weight:normal\">For the\r\ntopping: Remove the cake from the refrigerator. Whip the cream with the sugar\r\nand vanilla in the chilled bowl until fluffy. Spread it over the cake, slice\r\nthe cake and serve with the strawberries.<o:p></o:p></span></p>', 0x313339333837343237363835352e6a706567, 1, '2024-06-02 17:35:22', '2024-06-02 17:39:47'),
(3004, 5002, 'PORK ADOBO', 1, 1, '<p>1</p>', 0x53637265656e73686f7420323032342d30352d3237203039333831392e706e67, 1, '2024-06-02 18:42:28', '2024-06-02 18:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_category`
--

CREATE TABLE `recipe_category` (
  `recipe_id` int(4) NOT NULL,
  `category_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_category`
--

INSERT INTO `recipe_category` (`recipe_id`, `category_id`) VALUES
(3001, 11),
(3001, 12),
(3001, 15),
(3002, 12),
(3002, 13),
(3002, 15),
(3003, 14),
(3003, 40),
(3004, 17);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredient`
--

CREATE TABLE `recipe_ingredient` (
  `recipe_id` int(4) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredient`
--

INSERT INTO `recipe_ingredient` (`recipe_id`, `ingredient_id`, `quantity`) VALUES
(3003, 2039, '2 pounds'),
(3003, 2040, '1 cup'),
(3003, 2041, '2 1/2 cup'),
(3003, 2042, '1/2 tsp'),
(3003, 2043, '1/2 tsp'),
(3003, 2006, '1/2 tsp'),
(3003, 2044, '2 cups'),
(3001, 2005, '6 coarsely chopped cloves'),
(3001, 2006, '1/4 tsp'),
(3001, 2009, '1lb, thinly sliced against the grain into bite-siz'),
(3001, 2010, '1/2 cup'),
(3001, 2011, '1/4'),
(3001, 2012, '1tbsp distilled'),
(3001, 2013, '1tbsp'),
(3001, 2014, '1/2 tsp crushed'),
(3001, 2015, '1/2 freshly crushed'),
(3001, 2016, '1/4 cup'),
(3004, 2035, '5'),
(3002, 2004, '1 pc chopped'),
(3002, 2005, '4 cloves, minced'),
(3002, 2011, '1/2 cup'),
(3002, 2020, '1 cup'),
(3002, 2034, '1 kg'),
(3002, 2045, '1/2 cup'),
(3002, 2046, '1 pc'),
(3002, 2047, '1 tsp'),
(3002, 2048, '1/2 cup');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(4) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `username`, `password`, `created_at`, `updated_at`, `last_login`, `role`, `name`, `user_image`) VALUES
(1001, 'admin', 'user', 'admin_user', '$2y$10$dV.Wfa3L4Yjcooc1cD02i.zZF3sAB5FnuyfUQQnsIdzE.T5c2OKy.', '2024-05-12 14:26:52', '2024-06-02 18:10:35', '2024-06-02 18:10:35', 'Admin', 'admin user', ''),
(5001, 'Jam', 'Misola', 'jammisola5001', '$2y$10$EOpDCBEpDtf.SmleaEdqseExg0zN99vN9xfHC0G8jMZ0AFCF5DSxG', '2024-05-20 00:59:38', '2024-06-02 17:02:18', '2024-06-02 17:02:18', 'Chef', 'Jam Misola', 0x2e2e2f75706c6f6164732f4d495a492e6a7067),
(5002, 'Josephe-Anne', 'Marcellana', 'josepheanne5002', '$2y$10$YUEAUPO9iNiPHCSGLpWeRuLksCkDcuSfLYb4Xi3B8NlLy3kIqBqlK', '2024-05-20 01:20:12', '2024-06-02 11:52:55', '2024-06-03 01:22:29', 'Chef', 'Josephe-Anne Marcellana', 0x2e2e2f75706c6f6164732f53637265656e73686f7420323032342d30362d3031203232353635372e706e67),
(5003, 'Maricel', 'Sandoval', 'sandoval5003', '$2y$10$2CuKwWGu0ZVrG4UjsWLllOh79dAp.Zy1.T4Cqj/GsnidSzRPEhcGe', '2024-05-20 06:44:41', '2024-06-02 17:44:33', '2024-06-02 17:44:33', 'Chef', 'Maricel Sandoval', ''),
(5004, 'Jeremiah', 'Horca', 'jem5004', '$2y$10$0JUIJJHRO95o8WAGnLGZXu.xHhn1MMYZzDvoX1D23T0NgoKo4ARCS', '2024-05-21 01:14:10', '2024-05-27 01:34:07', '2024-05-27 01:34:07', 'Chef', 'Jeremiah Horca', ''),
(5005, 'Romar', 'Madrigal', 'madrigal5005', '$2y$10$sBY1DU1U3mMtfalYLSjsOOuOVeL15PiX8pc4ry76llP9eKNNPyT2K', '2024-05-21 01:15:26', '2024-05-21 01:15:26', '2024-05-21 01:15:26', 'Chef', 'Romar Madrigal', ''),
(5007, 'Dio', 'Brando', 'Dio_Wind', '$2y$10$NenT2dExIzPmqvJ2cyuSjOuRH8rVUdM2JqCWRkTAjDTdPILboiMhu', '2024-05-31 07:17:18', '2024-06-01 14:54:07', '2024-06-01 14:54:07', 'Chef', 'Dio Brando', ''),
(5008, 'Anne', 'Misola', 'anne', '$2y$10$dzLbMfHBOykU0e5gWEQtWecAv0PrkLDwsEiNWlQ3xCl/1K3kHLG9.', '2024-05-31 07:37:41', '2024-06-01 15:22:25', '2024-06-01 15:22:25', 'Chef', 'Anne Misola', '');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `before_insert_users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    SET NEW.name = CONCAT(NEW.fname, ' ', NEW.lname);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_users` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    SET NEW.name = CONCAT(NEW.fname, ' ', NEW.lname);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD UNIQUE KEY `ingredient_name` (`ingredient_name`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `recipe_ibfk_1` (`user_id`);

--
-- Indexes for table `recipe_category`
--
ALTER TABLE `recipe_category`
  ADD KEY `FOREIGN` (`recipe_id`,`category_id`) USING BTREE,
  ADD KEY `recipe_category_ibfk_2` (`category_id`);

--
-- Indexes for table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD KEY `recipe_ingredient_ibfk_2` (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`,`ingredient_id`),
  ADD KEY `recipe_id_2` (`recipe_id`,`ingredient_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2049;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipe_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3005;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5009;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_category`
--
ALTER TABLE `recipe_category`
  ADD CONSTRAINT `recipe_category_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD CONSTRAINT `recipe_ingredient_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
