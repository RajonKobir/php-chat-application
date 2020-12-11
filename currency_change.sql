CREATE TABLE `user` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `name` varchar(18) NOT NULL
)
CREATE TABLE `login_details` (
  `login_details_id` int(255) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
)
CREATE TABLE `all_listing` (
  `id` int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `name` varchar(18) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_currency` varchar(11) NOT NULL,
  `to_currency` varchar(11) NOT NULL DEFAULT 'SGD',
  `from_amount` float(15,2) NOT NULL,
  `to_amount` float(15,2) NOT NULL,
  `rate` float(15,2)) NOT NULL,
  `location` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `live` enum('yes','no') NOT NULL
)
CREATE TABLE `chat_message` (
  `chat_message_id` int(255) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
)