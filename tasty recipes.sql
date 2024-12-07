-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 02:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasty recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `cookbook`
--

CREATE TABLE `cookbook` (
  `cookbook_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `recipe_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cookbook`
--

INSERT INTO `cookbook` (`cookbook_ID`, `user_ID`, `recipe_ID`) VALUES
(2, 1, 1),
(1, 1, 2),
(3, 3, 4),
(6, 15, 8),
(5, 16, 3),
(4, 16, 8);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_ID` int(255) UNSIGNED NOT NULL,
  `user_ID` int(255) UNSIGNED NOT NULL,
  `title` varchar(32) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `ingredients` varchar(700) NOT NULL,
  `instructions` varchar(700) NOT NULL,
  `cooking_time` varchar(12) NOT NULL,
  `category` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='unsure if image is anywhere near correct';

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_ID`, `user_ID`, `title`, `image`, `ingredients`, `instructions`, `cooking_time`, `category`) VALUES
(1, 5, 'Spaghetti Bolognese', 'spaghetti.jpg', '200g spaghetti\n100g ground beef\n1 onion, chopped\n2 garlic cloves, minced\n400g can of tomatoes\nSalt and pepper to taste', 'Boil the spaghetti. In another pan, fry the onion and garlic, then add the beef. Cook until browned. Add the tomatoes and simmer for 20 minutes. Serve over spaghetti.', '30 minutes', 'Dinner'),
(2, 1, 'Chicken Caesar Salad', 'caesar_salad.jpg', '2 chicken breasts\n2 romaine lettuce\nCaesar dressing\nCroutons\nParmesan cheese', 'Grill the chicken and slice it. Toss the lettuce with Caesar dressing, top with chicken, croutons, and Parmesan.', '15 minutes', 'Lunch'),
(3, 3, 'Beef Tacos', 'beef_tacos.jpg', '100g ground beef\nTaco shells\n1 onion, chopped\n1 tomato, diced\nLettuce, shredded\nCheddar cheese, grated\nSour cream\nTaco seasoning', 'Cook the ground beef in a pan with taco seasoning. Assemble the tacos by adding the beef, onion, tomato, lettuce, cheese, and sour cream to the taco shells.', '25 minutes', 'Dinner'),
(4, 1, 'Pancakes', 'pancakes.jpg', '1 cup flour\n1 egg\n1 cup milk\n2 tbsp sugar\n1 tsp baking powder\nPinch of salt\nButter for cooking', 'Mix all the ingredients into a smooth batter. Heat a non-stick pan and cook pancakes until golden brown on both sides. Serve with syrup or toppings of your choice.', '15 minutes', 'Breakfast'),
(5, 2, 'Caprese Salad', 'caprese_salad.jpg', '2 tomatoes, sliced\n1 ball of mozzarella, sliced\nFresh basil leaves\nOlive oil\nBalsamic vinegar\nSalt and pepper to taste', 'Layer the tomato and mozzarella slices on a plate. Add fresh basil leaves on top. Drizzle with olive oil and balsamic vinegar, and season with salt and pepper.', '10 minutes', 'Appetizer'),
(6, 3, 'Chocolate Chip Cookies', 'cookies.jpg', '1 cup butter\n1 cup sugar\n1 cup brown sugar\n2 eggs\n2 tsp vanilla extract\n3 cups flour\n1 tsp baking soda\n1/2 tsp salt\n2 cups chocolate chips', 'Preheat oven to 350°F. Cream butter and sugars, add eggs and vanilla. Mix dry ingredients and combine. Fold in chocolate chips. Drop by spoonfuls onto a baking sheet and bake for 10-12 minutes.', '20 minutes', 'Dessert'),
(7, 4, 'Vegetable Stir-Fry', 'stir_fry.jpg', '1 bell pepper, sliced\n1 broccoli head, chopped\n1 carrot, sliced\n1 zucchini, sliced\n2 tbsp soy sauce\n1 tbsp olive oil\n1 tsp garlic, minced\n1 tsp ginger, minced', 'Heat oil in a wok, stir-fry garlic and ginger. Add vegetables and stir-fry for 5-7 minutes. Add soy sauce and cook for another 2 minutes. Serve with rice or noodles.', '15 minutes', 'Dinner'),
(8, 1, 'Tomato Soup', 'tomato_soup.jpg', '4 cups tomatoes, chopped\n1 onion, chopped\n2 garlic cloves, minced\n2 cups vegetable stock\n1/2 cup cream\nSalt and pepper to taste', 'Cook onion and garlic until soft. Add tomatoes and stock, simmer for 20 minutes. Blend until smooth, add cream, and season with salt and pepper.', '30 minutes', 'Lunch'),
(9, 2, 'Classic Burger', 'burger.jpg', '500g ground beef\n4 burger buns\nLettuce\nTomato slices\nCheddar cheese\nKetchup\nMayonnaise\nSalt and pepper', 'Form beef into patties, season with salt and pepper. Grill or pan-fry patties until done. Assemble burgers with lettuce, tomato, cheese, and condiments on buns.', '20 minutes', 'Dinner'),
(10, 3, 'Avocado Toast', 'avocado_toast.jpg', '2 slices of bread\n1 avocado\n1 tsp lemon juice\nSalt and pepper to taste\nOptional: chili flakes or feta cheese', 'Toast the bread. Mash avocado with lemon juice, salt, and pepper. Spread avocado on toast and add optional toppings.', '10 minutes', 'Breakfast'),
(12, 4, 'French Toast', 'french_toast.jpg', '2 slices of bread\n2 eggs\n1/2 cup milk\n1 tsp vanilla extract\n1 tbsp sugar\nButter for cooking', 'Whisk eggs, milk, vanilla, and sugar. Dip bread slices in the mixture and cook on a buttered pan until golden brown on both sides.', '15 minutes', 'Breakfast'),
(13, 1, 'Vegetable Curry', 'vegetable_curry.jpg', '1 cup cauliflower florets\n1 cup potatoes, diced\n1 cup peas\n1 can coconut milk\n2 tbsp curry powder\n1 onion, chopped\n1 garlic clove, minced\n1 tbsp oil', 'Heat oil, sauté onion and garlic. Add curry powder, vegetables, and coconut milk. Simmer until vegetables are tender. Serve with rice.', '30 minutes', 'Dinner'),
(14, 2, 'Greek Salad', 'greek_salad.jpg', '2 cucumbers, diced\n3 tomatoes, diced\n1 red onion, sliced\n1/2 cup olives\n1/2 cup feta cheese, crumbled\n2 tbsp olive oil\n1 tbsp lemon juice\nSalt and pepper to taste', 'Combine cucumbers, tomatoes, onion, olives, and feta in a bowl. Drizzle with olive oil and lemon juice. Season with salt and pepper.', '10 minutes', 'Appetizer'),
(15, 3, 'Banana Smoothie', 'banana_smoothie.jpg', '2 bananas\n1 cup milk\n1 tbsp honey\n1/2 tsp vanilla extract\nIce cubes (optional)', 'Blend bananas, milk, honey, and vanilla until smooth. Add ice cubes if desired. Serve chilled.', '5 minutes', 'Beverage'),
(16, 4, 'Grilled Cheese', '../img/No_Image_Available.jpg', 'Bread\r\nCheese\r\nButter', 'Grill it on each side over med-high heat for 4 minutes', '10', 'lunch');

-- --------------------------------------------------------

--
-- Table structure for table `recipes_r_tags`
--

CREATE TABLE `recipes_r_tags` (
  `ID` int(10) NOT NULL,
  `recipe_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `role` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `email`, `password`, `firstname`, `lastname`, `role`) VALUES
(1, 'perduej7@nku.edu', '$2y$10$Q7BdfP1vEQapVOsonCFQQ.i58.sx.ynKdWHItNOfoRoUKucUrVNYG', 'Jeff', 'Perdue', 1),
(2, 'millern28@nku.edu', '$2y$10$LBMoAiE2D6Kw/SfMhVmkx.fRFQx70nCNHqe6SH0UCSTOmbKuakOTW', 'Nick', 'Miller', 1),
(3, 'anthonyb1@nku.edu', '$2y$10$oiyRJI5TD./rdEcB.7JMP.tNgyaifMNWKugmum7YvINfptBanAGge', 'Brandon', 'Anthony', 1),
(4, 'caporusso@user.com', '$2y$10$A1sfbJXgY17MEsZ8Hr4mE.7uT462yttpqlWN1peLlsNRgg71ESvjC', 'Nicholas', 'Caporusso (User)', 1),
(5, 'caporusso@admin.com', '$2y$10$6GD/YYYvVFfvN7jKy43tCeGmrZfmlfBefWB6FINEQxl0NyVV.Zs82', 'Nicholas', 'Caporusso (Admin)', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cookbook`
--
ALTER TABLE `cookbook`
  ADD PRIMARY KEY (`cookbook_ID`),
  ADD UNIQUE KEY `user_ID` (`user_ID`,`recipe_ID`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `recipes_r_tags`
--
ALTER TABLE `recipes_r_tags`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cookbook`
--
ALTER TABLE `cookbook`
  MODIFY `cookbook_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_ID` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `recipes_r_tags`
--
ALTER TABLE `recipes_r_tags`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
