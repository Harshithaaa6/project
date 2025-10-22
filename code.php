<?php
//1️⃣ Tell browser that response will be JSON
header("Content-Type: application/json");

// 2️⃣ Connect to database
$servername = "localhost"; // XAMPP default
$username = "root";
$password = "";            // XAMPP default empty
$dbname = "hackathon_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// If DB connection fails
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed."]));
}

// 3️⃣ Get input from frontend (POST request)
$data = json_decode(file_get_contents("php://input"), true); 
// input JSON ni PHP array ga convert chestundi
$error = trim($data["error"]); // extra spaces remove

// If input is empty
if(empty($error)){
    echo json_encode(["result" => "Please enter an error name."]);
    exit();
}

// 4️⃣ Check database for the error
$sql = "SELECT error_explanation FROM errors WHERE error_name='$error'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc(); // get the explanation
    echo json_encode(["result" => $row["error_explanation"]]);
} else {
    echo json_encode(["result" => "Error not found in database."]);
}

// 5️⃣ Close the database connection
$conn->close();
?>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 06:21 PM
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
-- Database: `hackathon_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `error`
--

CREATE TABLE `error` (
  `id` int(11) NOT NULL,
  `error_name` varchar(100) DEFAULT NULL,
  `error_explanation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `error`
--

INSERT INTO `error` (`id`, `error_name`, `error_explanation`) VALUES
(1, 'Syntax Error', 'There’s a mistake in the code structure (missing bracket, wrong keyword, etc.), so the interpreter/compiler can’t understand it'),
(2, 'Type Error', 'An operation was used on the wrong type of data (e.g., adding a string and a number)'),
(3, 'IndexOutOfRange Error', 'The program tried to access a list/array position that doesn’t exist'),
(4, 'Segmentation Fault', 'The program tried to access memory that doesn’t belong to it'),
(5, 'NullReferenceException', 'The program tried to use a variable/object that is null (or None), but it wasn’t initialized'),
(6, 'Logical Error', 'The program runs without crashing, but produces the wrong output because of a mistake in logic'),
(7, 'Name Error', 'The program tries to use a variable that hasn’t been defined'),
(8, 'Memory leak', 'Memory is allocated but never released, causing wasted memory.'),
(9, 'Runtime Error', 'The code is syntactically correct, but when it runs, it crashes due to invalid operations (like dividing by zero, file not found, etc.)'),
(10, 'Dead Lock', 'Two or more threads wait forever because each is holding a resource the other needs');

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `error_name` varchar(100) DEFAULT NULL,
  `error_explanation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `error`
--
ALTER TABLE `error`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `error_name` (`error_name`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `error_name` (`error_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `error`
--
ALTER TABLE `error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
