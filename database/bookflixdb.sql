-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 04:15 PM
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
-- Database: `bookflixdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_info`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `category` (`id`, `Name`) VALUES
(1, 'Sách văn học'),
(2, 'Sách lịch sử'),
(3, 'Sách trinh thám');

CREATE TABLE `book_info` (
  `bid` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`bid`), -- Define `bid` as the primary key
  FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `book_info`
--

INSERT INTO `book_info` (`bid`, `name`, `title`, `price`, `category_id`, `description`, `image`, `date`) VALUES
(1, '7 Bước tới mùa hè', 'Nguyễn Nhật Ánh', 99000, 1, '“Bảy bước tới mùa hè” là câu chuyện về một mùa hè ngọt ngào, những trò chơi nghịch ngợm và bâng khuâng tình cảm tuổi mới lớn. Chỉ vậy thôi nhưng chứng tỏ tác giả đúng là nhà kể chuyện hóm hỉnh, khiến đọc cuốn hút từ tựa đến trang cuối cùng, có lẽ chính vì giọng văn giản dị và trong trẻo của Nguyễn Nhật Ánh, và kết thúc thì có hậu đầy thuyết phục. Câu chuyện cho tuổi học trò, đọc xong là thấy ngập lên khao khát quay về một thời thơ bé, với tình thầy trò, bè bạn, tình xóm giềng, họ hàng, qua cách nhìn đời nhẹ nhõm, rộng lượng.', '7buoctoimuahe_nguyennhatanh.jpg', '2024-04-14 21:03:09'),
(2, 'Ai từng là con nít', 'Vô danh', 78000, 2, 'sách trẻ em', 'aitunglaconnit.jpg', '2024-04-15 21:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `book_id` int(20) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `image` varchar(250) NOT NULL,
  `quantity` int(25) NOT NULL,
  `total` double(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--



-- --------------------------------------------------------

--
-- Table structure for table `confirm_order`
--

CREATE TABLE `confirm_order` (
  `order_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(12) NOT NULL,
  `address` varchar(500) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `total_books` varchar(500) NOT NULL,
  `order_date` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending',
  `date` varchar(20) NOT NULL,
  `total_price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confirm_order`
--

INSERT INTO `confirm_order` (`order_id`, `user_id`, `name`, `email`, `number`, `address`, `payment_method`, `total_books`, `order_date`, `payment_status`, `date`, `total_price`) VALUES
(1, 1, 'nguyen', 'cdf@fdfs', 165, 'dsfd, df', 'cash on delivery', '', '15-Apr-2024', 'pending', '', 0.00),
(2, 1, 'Tan Nguyen', 'Nguyen@gmail.com', 44564658, 'hhsdifh, njsdkfjh', 'cash on delivery', ' Số đỏ chót #99,(1) ', '15-Apr-2024', 'pending', '', 89000.00);

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` int(20) NOT NULL,
  `msg` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(225) NOT NULL,
  `user_id` int(100) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `pincode` int(6) NOT NULL,
  `book` varchar(50) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `sub_total` double(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `city`, `state`, `country`, `pincode`, `book`, `unit_price`, `quantity`, `sub_total`, `payment_status`) VALUES
(1, 1, '123 Example St', 'Example City', 'Example State', 'Example Country', 123456, 'Example Book', 100.00, 1, 100.00, 'pending'),
(33, 1, 'acsdv', 'csdvbd', 'fwefwe', 'vietnam', 23, 'Chí phèo ', 89000.00, 1, 89000.00, 'pending'),
(35, 1, 'dsfd', 'df', '', '', 0, 'Số đỏ chót', 89000.00, 1, 89000.00, 'pending'),
(35, 1, 'dsfd', 'df', '', '', 0, 'Chí phèo ', 89000.00, 1, 89000.00, 'pending'),
(35, 1, 'dsfd', 'df', '', '', 0, 'Đất rừng phương nam', 49000.00, 1, 49000.00, 'pending'),
(37, 1, 'hhsdifh', 'njsdkfjh', '', '', 0, 'Số đỏ chót', 89000.00, 1, 89000.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `Id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_type` varchar(200) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`Id`, `name`, `surname`, `email`, `password`, `user_type`) VALUES
(1, 'Nguyên', 'Trần Tấn', 'user@gmail.com', '12345678', 'User'),
(2, 'Nguyên', 'Trần Tấn ', 'admin@gmail.com', '12345678', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_info`
--
ALTER TABLE `book_info`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirm_order`
--
ALTER TABLE `confirm_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_info`
--
ALTER TABLE `book_info`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confirm_order`
--
ALTER TABLE `confirm_order`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

ALTER TABLE `book_info`
ADD COLUMN `category_id` INT,
ADD CONSTRAINT `FK_category`
FOREIGN KEY (`category_id`)
REFERENCES `category` (`id`)
ON DELETE RESTRICT
ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
