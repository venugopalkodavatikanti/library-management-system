--
-- Database: `library_database`
--

CREATE DATABASE library_database;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
);

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `publisher`, `isbn`, `price`, `publication_year`, `image`, `category_id`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', '9780743273565', '10.99', 1925, 'https://images.penguinrandomhouse.com/cover/9780743273565', 1),
(2, 'To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', '9780060935467', '7.99', 1960, 'https://images.penguinrandomhouse.com/cover/9780060935467', 1),
(3, '1984', 'George Orwell', 'Secker & Warburg', '9780451524935', '9.99', 1949, 'https://images.penguinrandomhouse.com/cover/9780451524935', 1),
(4, 'A Brief History of Time', 'Stephen Hawking', 'Bantam Books', '9780553380163', '15.99', 1988, 'https://images.penguinrandomhouse.com/cover/9780553380163', 3),
(5, 'The Origin of Species', 'Charles Darwin', 'John Murray', '9780486450063', '11.99', 1997, 'https://images.penguinrandomhouse.com/cover/9780486450063', 3),
(6, 'The Diary of a Young Girl', 'Anne Frank', 'Contact Publishing', '9780553296983', '8.99', 1947, 'https://images.penguinrandomhouse.com/cover/9780553296983', 4),
(7, 'Steve Jobs', 'Walter Isaacson', 'Simon & Schuster', '9781451648539', '18.99', 2011, 'https://res.cloudinary.com/bloomsbury-atlas/image/upload/w_568,c_scale/jackets/9781610694971.jpg', 5),
(8, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'Bloomsbury', '9780747532699', '12.99', 1997, 'https://m.media-amazon.com/images/I/91ocU8970hL._AC_UF1000,1000_QL80_.jpg', 6),
(9, 'The Cat in the Hat', 'Dr. Seuss', 'Random House', '9780394800011', '6.99', 1957, 'https://images.penguinrandomhouse.com/cover/9780394800011', 6),
(10, 'The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', '9780547928227', '14.99', 1937, 'https://images.penguinrandomhouse.com/cover/9780547928227', 7),
(11, 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', '9780316769488', '10.99', 1951, 'https://images.penguinrandomhouse.com/cover/9780316769488', 1),
(12, 'The Da Vinci Code', 'Dan Brown', 'Doubleday', '9780385504201', '9.99', 2003, 'https://images.penguinrandomhouse.com/cover/9780385504201', 8),
(13, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton', '9780141040349', '8.99', 1965, 'https://images.penguinrandomhouse.com/cover/9780141040349', 9),
(14, 'Dracula', 'Bram Stoker', 'Archibald Constable and Company', '9780486411095', '7.99', 1999, 'https://images.penguinrandomhouse.com/cover/9780486411095', 10),
(15, 'Brave New World', 'Aldous Huxley', 'Chatto & Windus', '9780060850524', '9.99', 1932, 'https://images.penguinrandomhouse.com/cover/9780060850524', 1),
(16, 'The Art of War', 'Sun Tzu', 'Unknown', '9781599869773', '5.99', 2002, 'https://m.media-amazon.com/images/I/61lBRY5h+NL._AC_UF1000,1000_QL80_.jpg', 3),
(17, 'Moby-Dick', 'Herman Melville', 'Harper & Brothers', '9781503280786', '11.99', 1995, 'https://m.media-amazon.com/images/I/71d5wo+-MuL._AC_UF1000,1000_QL80_.jpg', 1),
(18, 'The Adventures of Huckleberry Finn', 'Mark Twain', 'Chatto & Windus / Charles L. Webster And Company', '9780486280615', '8.99', 1993, 'https://images.penguinrandomhouse.com/cover/9780486280615', 1),
(19, 'War and Peace', 'Leo Tolstoy', 'The Russian Messenger', '9780199232765', '12.99', 1945, 'https://images.penguinrandomhouse.com/cover/9780199232765', 4),
(20, 'The Little Prince', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', '9780156012195', '6.99', 1943, 'https://rukminim2.flixcart.com/image/850/1000/kufuikw0/book/0/h/i/the-little-prince-original-imag7jhtw8gdhz5d.jpeg?q=90&crop=false', 5);

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
);

--
-- Dumping data for table `book_category`
--

INSERT INTO `book_category` (`category_id`, `category_name`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction'),
(3, 'Science'),
(4, 'History'),
(5, 'Biography'),
(6, 'Children'),
(7, 'Fantasy'),
(8, 'Mystery'),
(9, 'Romance'),
(10, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `book_copy`
--

CREATE TABLE `book_copy` (
  `copy_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `current_status_id` int(11) DEFAULT NULL
);

--
-- Dumping data for table `book_copy`
--

INSERT INTO `book_copy` (`copy_id`, `book_id`, `current_status_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 2, 1),
(5, 2, 1),
(6, 3, 3),
(7, 3, 3),
(8, 4, 1),
(9, 4, 1),
(10, 5, 1),
(11, 5, 1),
(12, 6, 1),
(13, 6, 1),
(14, 7, 1),
(15, 7, 1),
(16, 8, 1),
(17, 8, 1),
(18, 9, 1),
(19, 9, 1),
(20, 10, 1),
(21, 10, 1),
(22, 11, 1),
(23, 11, 1),
(24, 12, 1),
(25, 12, 1),
(26, 13, 1),
(27, 13, 1),
(28, 14, 1),
(29, 14, 1),
(30, 15, 1),
(31, 15, 1),
(32, 16, 1),
(33, 16, 1),
(34, 17, 1),
(35, 17, 1),
(36, 18, 1),
(37, 18, 1),
(38, 19, 1),
(39, 19, 1),
(40, 20, 1),
(41, 20, 1),
(42, 1, 1),
(43, 2, 1),
(44, 3, 3),
(45, 4, 1),
(46, 5, 1),
(47, 6, 1),
(48, 7, 1),
(49, 8, 1),
(50, 9, 1),
(51, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book_status`
--

CREATE TABLE `book_status` (
  `status_id` int(11) NOT NULL,
  `status` enum('available','borrowed','lost','damaged') NOT NULL
);

--
-- Dumping data for table `book_status`
--

INSERT INTO `book_status` (`status_id`, `status`) VALUES
(1, 'available'),
(2, 'borrowed'),
(3, 'lost'),
(4, 'damaged');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_request`
--

CREATE TABLE `borrow_request` (
  `request_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `request_status` varchar(30) NOT NULL DEFAULT 'requested',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL
);

--
-- Dumping data for table `borrow_request`
--

INSERT INTO `borrow_request` (`request_id`, `student_id`, `book_id`, `request_status`, `request_date`, `approved_by`) VALUES
(1, 1, 2, 'approved', '2024-07-04 19:12:03', 2),
(2, 1, 3, 'requested', '2024-07-04 19:18:54', NULL),
(3, 1, 1, 'approved', '2024-07-04 19:51:47', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `copy_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT 0.00
);

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `user_id`, `copy_id`, `borrow_date`, `return_date`, `fine_amount`) VALUES
(5, 1, 4, '2024-06-18', NULL, '10.00'),
(6, 1, 1, '2024-07-05', NULL, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_role_id` int(11) DEFAULT NULL
);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `phone`, `address`, `password`, `user_role_id`) VALUES
(1, 'John Doe', 'john.doe@gmail.com', '9988776655', 'John\'s Address', 'John@123', 2),
(2, 'Jack M', 'jack@gmail.com', '8889999777', 'Jack\'s House', 'Jack@123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
);

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role`) VALUES
(1, 'Librarian'),
(2, 'Student'),
(3, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD PRIMARY KEY (`copy_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `current_status_id` (`current_status_id`);

--
-- Indexes for table `book_status`
--
ALTER TABLE `book_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `borrow_request`
--
ALTER TABLE `borrow_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_student_id` (`student_id`),
  ADD KEY `fk_book_id` (`book_id`),
  ADD KEY `fk_approved_by` (`approved_by`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `copy_id` (`copy_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `book_copy`
--
ALTER TABLE `book_copy`
  MODIFY `copy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `book_status`
--
ALTER TABLE `book_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `borrow_request`
--
ALTER TABLE `borrow_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `book_category` (`category_id`);

--
-- Constraints for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD CONSTRAINT `book_copy_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  ADD CONSTRAINT `book_copy_ibfk_2` FOREIGN KEY (`current_status_id`) REFERENCES `book_status` (`status_id`);

--
-- Constraints for table `borrow_request`
--
ALTER TABLE `borrow_request`
  ADD CONSTRAINT `fk_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`copy_id`) REFERENCES `book_copy` (`copy_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`role_id`);
COMMIT;

