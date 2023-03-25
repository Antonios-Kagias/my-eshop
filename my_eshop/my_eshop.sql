-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 07 Ιουν 2020 στις 19:22:37
-- Έκδοση διακομιστή: 10.4.11-MariaDB
-- Έκδοση PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `my_eshop`
--
CREATE DATABASE IF NOT EXISTS `my_eshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `my_eshop`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(1) UNSIGNED NOT NULL,
  `brand_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Xiaomi'),
(2, 'Samsung'),
(3, 'Apple'),
(4, 'Huawei'),
(5, 'LG'),
(6, 'Lenovo'),
(7, 'HP'),
(8, 'Edifier'),
(9, 'JBL'),
(10, 'Sony'),
(11, 'Marshall'),
(12, 'Bose'),
(13, 'Hitachi'),
(14, 'Philips');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `category_id` int(1) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Smartphones'),
(2, 'Laptops'),
(3, 'Τηλεοράσεις'),
(4, 'Tablets'),
(5, 'Ακουστικά');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `total` decimal(10,2) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total`, `order_date`) VALUES
(1, 6, '986.00', '2019-10-21 06:35:00'),
(2, 4, '193.00', '2019-12-15 14:10:00'),
(3, 4, '429.00', '2020-01-14 10:47:00'),
(4, 4, '309.70', '2020-02-07 16:22:00'),
(5, 4, '398.00', '2020-06-04 14:28:45'),
(6, 6, '501.89', '2020-06-04 14:28:48'),
(7, 7, '1287.00', '2020-06-04 14:28:51'),
(16, 8, '569.00', '2020-06-07 09:04:14'),
(17, 8, '211.00', '2020-06-07 09:42:51');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `order_contents`
--

CREATE TABLE `order_contents` (
  `oc_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(4) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(6,2) UNSIGNED NOT NULL,
  `ship_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `order_contents`
--

INSERT INTO `order_contents` (`oc_id`, `order_id`, `product_id`, `quantity`, `price`, `ship_date`) VALUES
(1, 1, 3, 1, '709.00', NULL),
(2, 1, 4, 1, '277.00', NULL),
(3, 2, 2, 1, '193.00', NULL),
(4, 3, 6, 1, '429.00', NULL),
(5, 4, 8, 1, '309.70', NULL),
(6, 5, 1, 2, '199.00', NULL),
(7, 6, 2, 1, '193.00', NULL),
(8, 6, 9, 1, '308.89', NULL),
(9, 7, 6, 3, '429.00', NULL),
(15, 16, 23, 1, '569.00', NULL),
(16, 17, 28, 1, '211.00', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

CREATE TABLE `products` (
  `product_id` int(4) UNSIGNED NOT NULL,
  `brand_id` int(1) UNSIGNED NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `category_id` int(1) UNSIGNED NOT NULL,
  `price` decimal(6,2) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`product_id`, `brand_id`, `product_name`, `category_id`, `price`, `description`, `image_name`) VALUES
(1, 1, 'Xiaomi Redmi Note 8 Pro (64GB) Mineral Grey', 1, '199.00', 'Το πρώτο κινητό με τετραπλή κάμερα και φακό 64MP. Περιέχει τον πανίσχυρο επεξεργαστή Mediatek Helio G90T ενώ η μπαταρία του υποστηρίζει μέχρι και 10 ώρες ασταμάτητου gaming. Φορτίζει σε 2 ώρες μέχρι το 100% και υποστηρίζει γρήγορη φόρτιση 18W.', '1'),
(2, 1, 'Xiaomi Redmi Note 9S (64GB) Aurora Blue', 1, '193.00', 'Με επεξεργαστή Snapdragon 720G, μπαταρία 5020mAh, τετραπλή κάμερα 48MP με AI και  συνδυασμό του κουμπιού power με τον αισθητήρα αποτυπώματος για μια φυσική εμπειρία ξεκλειδώματος.', '2'),
(3, 3, 'Apple iPhone 11 (64GB) Black', 1, '709.00', 'Με σύστημα διπλής κάμερας, μπαταρία που κρατάει όλη μέρα και το γρηγορότερο chip που είχε ποτέ ένα smartphone.', '3'),
(4, 2, 'Samsung Galaxy A51 (128GB) Prism Crush Black', 1, '277.00', 'Οθόνη super AMOLED 6.5\", τετραπλή κάμερα και δακτυλικό αποτύπωμα στην οθόνη.', '4'),
(5, 4, 'Huawei P30 Lite Dual (128GB) Peacock Blue', 1, '214.00', 'Τριπλή Κάμερα 48 MP με υπερευρυγώνιο Φακό και ΑΙ. Δείτε τον κόσμο πιο καθαρά με τον αισθητήρα εικόνας 48MP. Η οπίσθια κάμερα σας επιτρέπει να αποτυπώνετε πιο ευκρινείς από ποτέ φωτογραφίες και επιπλέον η παραμικρή λεπτομέρεια είναι πεντακάθαρη.', '5'),
(6, 6, 'Lenovo Ideapad S145-15API', 2, '429.00', 'Notebook, 15.6\" 1920x1080, CPU: AMD Ryzen 3 2.6GHz, RAM: 8GB, 256GB SSD, GPU: AMD Radeon Vega 3, OS: Windows 10 S', '6'),
(7, 7, 'HP 255 G7', 2, '429.99', 'Notebook, 15.6\" 1920x1080, CPU: AMD A9-Series 3.1GHz, RAM: 8GB, 256GB SSD, GPU: AMD Radeon R5, OS: Windows 10', '7'),
(8, 5, 'LG 43UM7100', 3, '309.70', 'Ανακάλυψε πώς η τηλεόραση UHD 4K της LG θα αλλάξει τον τρόπο που βλέπεις τα πάντα. Σου προσφέρει 4 φορές υψηλότερη ανάλυση σε σχέση με μια τηλεόραση HD και έτσι ζεις μία πιο έντονη και ρεαλιστική εμπειρία θέαση.', '8'),
(9, 2, 'Samsung UE43RU7092', 3, '308.89', 'Απόλαυσε εικόνα ανάλυσης UHD 4K με ποιότητα που εντυπωσιάζει χάρη στον επεξεργαστή UHD. Το HDR εμφανίζει τις λεπτομέρειες με ακρίβεια, ακόμη και στις πιο σκοτεινές και φωτεινές σκηνές, ενώ ταυτόχρονα ο slim σχεδιασμός της προσφέρει κομψότητα στον χώρο.', '9'),
(10, 4, 'Huawei P Smart 2019 (64GB) Midnight Black', 1, '128.36', 'Οθόνη Fullview Dewdrop 6.21 ιντσών, δυνατότητα ξεκλειδώματος με αναγνώριση προσώπου, ισχυρό chipset Kirin 710 και 3400mAh μπαταρία.', 'huawei_p_smart_2019_64gb_black.jpeg'),
(11, 5, 'LG 32LK6200', 3, '230.40', 'Η LG LK6200 έρχεται να προσφέρει μια πρωτόγνωρη εμπειρία, αλλάζοντας ό,τι περί τηλεόρασης. Σου προσφέρει κρυστάλλινη εικόνα και ζωντανά χρώματα σε Full HD ανάλυση, για να απολαύσεις το αγαπημένο σου περιεχόμενο σε σειρές, ταινίες και ντοκιμαντέρ.', 'lg_32lk6200.jpeg'),
(14, 6, 'Lenovo Ideapad L340-15API', 2, '649.00', 'Notebook, 15.6\" 1920x1080, CPU: AMD Ryzen 5 2.10GHz, RAM: 16GB, 128GB SSD + 1TB HDD, GPU: AMD Radeon Vega 8 Graphics, Windows 10', 'lenovo_ideapad_l340_15api_r5_3500u_16gb_128gb_fhd_w10.jpeg'),
(15, 8, 'Edifier W800BT Black', 5, '39.99', 'Το W800BT είναι ένα σετ εντυπωσιακών ασύρματων ακουστικών. Το ελαφρύ πλαίσιο επιτρέπει να απολαμβάνετε μια ολόκληρη μέρα ακρόασης χωρίς ενοχλήσεις. Η άνετη εφαρμογή τους οφείλεται στο αναπνέον, υψηλής ελαστικότητας σφουγγάρι και το πλαστικό δέρμα.', 'edifier_w800bt_black.jpeg'),
(16, 9, 'JBL Tune 500BT Black', 5, '41.90', 'Bluetooth, Μικρόφωνο', 'jbl_tune_500bt.jpeg'),
(17, 10, 'Sony WH-CH510 Black', 5, '42.80', 'Bluetooth, Μικρόφωνο', 'sony_wh_ch510_black.jpeg'),
(18, 10, 'Sony WH-1000XM3 Black', 5, '295.00', '3.5mm / Bluetooth, Μικρόφωνο', 'sony_wh_1000xm3.jpeg'),
(19, 10, 'Sony MDR-ZX110 Black', 5, '19.00', '3.5mm', 'sony_mdr_zx110_black.jpeg'),
(20, 11, 'Marshall Major III Bluetooth Black', 5, '98.41', '3.5mm / Bluetooth, Μικρόφωνο', 'marshall_major_iii_bluetooth.jpeg'),
(21, 8, 'Edifier W800BT Red', 5, '39.99', 'Το W800BT είναι ένα σετ εντυπωσιακών ασύρματων ακουστικών. Το ελαφρύ πλαίσιο επιτρέπει να απολαμβάνετε μια ολόκληρη μέρα ακρόασης χωρίς ενοχλήσεις. Η άνετη εφαρμογή τους οφείλεται στο αναπνέον, υψηλής ελαστικότητας σφουγγάρι και το πλαστικό δέρμα.', 'edifier_w800bt_red.jpeg'),
(22, 12, 'Bose QuietComfort 35 II Black', 5, '258.29', 'Bluetooth / 3.5mm, Μικρόφωνο', 'bose_quietcomfort_35_ii.jpeg'),
(23, 10, 'Sony KD-49XG8096', 3, '569.00', '49\", 4K Ultra HD, Smart, HDR, Edge LED, Μοντέλο: 2019', 'sony_kd_49xg8096.jpeg'),
(24, 10, 'Sony KD-55AG8', 3, '1598.93', '55\", 4K Ultra HD, Smart, HDR, OLED, Μοντέλο: 2019', 'sony_kd_55ag8.jpeg'),
(25, 13, 'Hitachi 32HE4100', 3, '188.00', '32\", Full HD, Smart, Edge LED, Μοντέλο: 2018', 'hitachi_32he4100.jpeg'),
(26, 14, 'Philips 32PHS4503', 3, '147.70', '32\", HD Ready, Direct LED, Μοντέλο: 2018', 'philips_32phs4503.jpeg'),
(27, 3, 'Apple iPad 2019 10.2\" WiFi (32GB) Space Gray', 4, '347.00', 'Το νέο iPad συνδυάζει τη δύναμη και τις ικανότητες ενός υπολογιστή με την ευκολία και την άνεση ενός tablet. Διαθέτει οθόνη Retina 10.2\" και το νέο λειτουργικό iPadOS.', 'apple_ipad_2019_10_2_wifi_32gb.jpeg'),
(28, 2, 'Samsung Galaxy Tab A (2019) 10.1\" (32GB) Black', 4, '211.00', 'Ένα tablet που είναι τόσο ευέλικτο και εκλεπτυσμένο όσο και προσιτό, γιατί η διασκέδαση νέας γενιάς ανήκει σε κάθε γενιά. Ζήστε premium απόλαυση με προσιτή τιμή με το Galaxy Tab A (2019, 10,1\").', 'samsung_galaxy_tab_a_2019_10_1_32gb_black.jpeg'),
(29, 4, 'Huawei MediaPad T5 10.1\" (32GB) Black', 4, '175.50', 'Το Huawei MediaPad T5 είναι ένα tablet με εκλεπτυσμένο σχεδιασμό. Διαθέτει οθόνη 10,1\" (ανάλυσης 1920 X 1200) που αποτυπώνει εξαιρετικά τις λεπτομέρειες, ενώ ο οκταπύρηνος επεξεργαστής με κύρια συχνότητα 2,36 GHz σας προσφέρει εξαιρετικές αποδόσεις.', 'huawei_mediapad_t5_10_1_32gb.jpeg'),
(30, 2, 'Samsung Galaxy Tab S5e 10.5\" 4G (64GB) Black', 4, '417.80', 'Το Galaxy Tab S5e διαθέτει ζωντανή οθόνη sAMOLED 10,5 ιντσών που προσφέρει εξαιρετική αναπαραγωγή χρωμάτων και βέλτιστα επίπεδα φωτεινότητας οθόνης. Αφεθείτε στη μαγεία των αγαπημένων σας ταινιών ή σειρών στο Netflix.', 'samsung_galaxy_tab_s5e_10_5_4g_64gb_black.jpeg'),
(31, 3, 'Apple iPad Air 2019 Wi-Fi 10.5\" (64GB) Space Gray', 4, '544.00', 'Το iPad Air προσφέρει τις πιο ισχυρές τεχνολογίες της Apple σε περισσότερα άτομα από ποτέ. Όπως το A12 Bionic chip με Neural Engine, μια οθόνη Retina 10,5 ιντσών και υποστήριξη του Smart Keyboard. Με βάρος κάτω από μισό κιλό και πάχος μόλις 6,1 mm.', 'apple_ipad_air_2019_wi_fi_10_5_64gb.jpeg');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone_number` char(10) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(40) NOT NULL,
  `postal_code` char(5) NOT NULL,
  `password` char(40) NOT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `city`, `address`, `postal_code`, `password`, `registration_date`) VALUES
(1, 'Obi-Wan', 'Kenobi', 'obiwan@starwars.com', '6942970344', 'Athina', 'Menelaou 17', '13677', 'e4005f5151d3e475df8e1de9130b76f899c37c5e', '2020-05-30 11:18:24'),
(2, 'Luke', 'Skywalker', 'luke@starwars.com', '6980473015', 'Pilio', 'Konstantinou Palaiologou 4', '45783', '6b3799be4300e44489a08090123f3842e6419da5', '2020-05-30 11:18:24'),
(3, 'Padmé', 'Amidala', 'padme@starwars.com', '6975307943', 'Kerkyra', 'Agiwn Pantwn 11', '12876', 'a26f6804d47f1d95c84216c2d73a438edae48ebe', '2020-05-30 11:18:24'),
(4, 'Anakin', 'Skywalker', 'anakin@starwars.com', '6953007814', 'Methana', 'Georgiou Papandreou 6', '27964', '7951276d108732f685ad39766351430a193de32d', '2020-05-30 11:18:24'),
(5, 'Sheev', 'Palpatine', 'palpatine@starwars.com', '6973144950', 'Patra', 'Eleutherias 28', '30047', '3dd6df5648329f5b5c903e8792fb442e5c5991b4', '2020-05-30 11:18:24'),
(6, 'Han', 'Solo', 'han@starwars.com', '6976542098', 'Larissa', 'Sokratous 14', '57892', '4ff615253469989932532e926006ae5c995e5dd6', '2020-05-30 11:18:24'),
(7, 'Leia', 'Organa', 'leia@starwars.com', '6974301789', 'Thessaloniki', 'Agias Sofias 41', '32078', '3ea1ebad1aa28de8fc67188a456b9747bbcca81a', '2020-05-30 11:18:24'),
(8, 'Master', 'Yoda', 'yoda@starwars.com', '6910765482', 'Σέρρες', 'Φιλίππου 22', '27942', 'faa4dba18c9534bb11dffd21a0cf32a8ec5573ac', '2020-06-02 20:57:41');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Ευρετήρια για πίνακα `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Ευρετήρια για πίνακα `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Ευρετήρια για πίνακα `order_contents`
--
ALTER TABLE `order_contents`
  ADD PRIMARY KEY (`oc_id`);

--
-- Ευρετήρια για πίνακα `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT για πίνακα `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `order_contents`
--
ALTER TABLE `order_contents`
  MODIFY `oc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT για πίνακα `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
