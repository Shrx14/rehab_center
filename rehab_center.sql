-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 02:07 PM
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
-- Database: `rehab_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`) VALUES
(1, 'admin1', 'admin1', 'admin1@rehab.com');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `status`) VALUES
(1, 1, 1, '2025-01-22', '11:00:00', 'Completed'),
(40, 9, 1, '2025-02-18', '10:00:00', 'Pending'),
(41, 12, 1, '2025-01-03', '11:00:00', 'Completed'),
(42, 7, 2, '2025-02-19', '10:00:00', 'Pending'),
(43, 29, 2, '2025-03-02', '11:00:00', 'Pending'),
(44, 8, 3, '2025-01-05', '10:00:00', 'Completed'),
(45, 13, 3, '2025-01-13', '11:00:00', 'Completed'),
(46, 15, 3, '2025-02-01', '12:00:00', 'Pending'),
(47, 18, 3, '2025-01-10', '13:00:00', 'Completed'),
(48, 24, 9, '2025-01-04', '10:00:00', 'Completed'),
(49, 17, 8, '2025-01-25', '11:00:00', 'Completed'),
(50, 21, 8, '2025-02-01', '12:00:00', 'Pending'),
(51, 22, 8, '2025-02-01', '13:00:00', 'Pending'),
(52, 19, 10, '2025-02-01', '10:00:00', 'Pending'),
(53, 20, 10, '2025-01-03', '11:00:00', 'Completed'),
(54, 23, 10, '2025-02-14', '12:00:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `speciality` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `visit_days` varchar(100) DEFAULT NULL,
  `max_patients` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `name`, `speciality`, `email`, `password`, `phone`, `experience`, `visit_days`, `max_patients`, `role_id`) VALUES
(1, 'Amit S', 'Neurologist', 'amits1@rehab.com', 'amits1', '+911111111111', '5 years', 'Monday, Tuesday, Friday', 4, 2),
(2, 'Dr. John Doe', 'Cardiologist', 'johndoe@rehab.com', 'johndoc1', '+912222222222', '10 years', 'Monday, Wednesday, Friday', 6, 2),
(3, 'Dr. Sarah Lee', 'Orthopedic', 'sarahlee@rehab.com', 'sarahdoc1', '+913333333333', '8 years', 'Tuesday, Thursday, Saturday', 4, 2),
(4, 'Dr. Michael Brown', 'Dermatologist', 'michaelbrown@rehab.com', 'mikedoc1', '+914444444444', '12 years', 'Monday, Tuesday, Thursday', 5, 2),
(5, 'Dr. Emily Davis', 'Pediatrician', 'emilydavis@rehab.com', 'emilydoc1', '+915555555555', '7 years', 'Wednesday, Friday, Saturday', 6, 2),
(6, 'Dr. Liam White', 'Gastroenterologist', 'liamwhite@rehab.com', 'liamdoc1', '+916666666666', '9 years', 'Tuesday, Thursday, Friday', 5, 2),
(7, 'Dr. Sophia Green', 'Psychiatrist', 'sophiagreen@rehab.com', 'sophiadoc1', '+917777777777', '5 years', 'Monday, Wednesday, Friday', 4, 2),
(8, 'Dr. William Hall', 'Oncologist', 'williamhall@rehab.com', 'willdoc1', '+918888888888', '15 years', 'Monday, Tuesday, Friday', 8, 2),
(9, 'Dr. Olivia Scott', 'Neurologist', 'oliviascott@rehab.com', 'oliviadoc1', '+919999999999', '11 years', 'Tuesday, Thursday, Saturday', 5, 2),
(10, 'Dr. James Martinez', 'Endocrinologist', 'jamesmartinez@rehab.com', 'jamesdoc1', '+911010101010', '10 years', 'Wednesday, Friday, Saturday', 6, 2),
(11, 'Dr. Charlotte King', 'Urologist', 'charlotteking@rehab.com', 'charlottedoc1', '+911111111111', '6 years', 'Monday, Wednesday, Friday', 4, 2),
(12, 'Dr. Benjamin Lopez', 'Hematologist', 'benjaminlopez@rehab.com', 'benjamindoc1', '+911212121212', '8 years', 'Tuesday, Thursday, Saturday', 5, 2),
(13, 'Dr. Mia Clark', 'Radiologist', 'miaclark@rehab.com', 'miadoc1', '+911313131313', '7 years', 'Monday, Tuesday, Thursday', 5, 2),
(14, 'Dr. Elijah Walker', 'Pulmonologist', 'elijahwalker@rehab.com', 'elijahdoc1', '+911414141414', '9 years', 'Wednesday, Friday, Saturday', 6, 2),
(15, 'Dr. Abigail Adams', 'Nephrologist', 'abigailadams@rehab.com', 'abigaildoc1', '+911515151515', '10 years', 'Monday, Wednesday, Friday', 5, 2),
(16, 'Dr. Lucas Young', 'Ophthalmologist', 'lucasyoung@rehab.com', 'lucasdoc1', '+911616161616', '5 years', 'Tuesday, Thursday, Friday', 4, 2),
(17, 'Dr. Amelia Allen', 'Allergist', 'ameliaallen@rehab.com', 'ameliadoc1', '+911717171717', '12 years', 'Monday, Wednesday, Friday', 7, 2),
(18, 'Dr. Noah Harris', 'Rheumatologist', 'noahharris@rehab.com', 'noahdoc1', '+911818181818', '11 years', 'Tuesday, Thursday, Saturday', 5, 2),
(19, 'Dr. Isabella Hill', 'Surgeon', 'isabellahill@rehab.com', 'isabelladoc1', '+911919191919', '8 years', 'Wednesday, Friday, Saturday', 6, 2),
(20, 'Dr. Ethan Campbell', 'Pathologist', 'ethancampbell@rehab.com', 'ethandoc1', '+912020202020', '9 years', 'Monday, Tuesday, Thursday', 5, 2),
(21, 'Dr. Ava Evans', 'General Practitioner', 'avaevans@rehab.com', 'avadoc1', '+912121212121', '6 years', 'Monday, Wednesday, Friday', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `diagnosis_type` varchar(100) DEFAULT NULL,
  `Surgery_status` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `admitted_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `name`, `age`, `address`, `phone`, `email`, `password`, `diagnosis_type`, `Surgery_status`, `role_id`, `admitted_date`) VALUES
(1, 'Arjun S', 57, '1A, Srikant Comp, Mumbai', '+919999999999', 'arjuns1@rehab.com', 'arjuns1', 'Cervical Spinal Disorder', 'Not Required', 3, NULL),
(6, 'Sam Paul', 54, 'Sector-17, Vashi, Navi Mumbai, Maharashtra', '+917889006000', 'sampaul@rehab.com', 'sampaul123', 'Spinal cord injury', 'Not required', 3, '2025-01-22'),
(7, 'Pooja Jain', 44, 'Alibag, Maharashtra', '+918975648273', 'poojajain@rehab.com', 'poojajain123', 'Vascular Disorder', 'Pending', 3, '2025-01-20'),
(8, 'Riya Louis', 30, 'Vashi, Navi Mumbai', '788909908', 'riyalouis@rehab.com', 'riyalouis123', 'Degenrative and Compressive Conditions', 'Completed', 3, '2025-01-01'),
(9, 'Upkar Sharma', 20, 'Dadar East, Maharashtra', '98323134239', 'upkarsharma@rehab.com', 'upkarsharma123', 'Metabolic and Genetic Disorders', 'Not required', 3, '2025-01-09'),
(10, 'Trisha Gaur', 50, 'Juinagar, Navi Mumbai', '67763409087', 'trishagaur@rehab.com', 'trishagaur123', 'Post-Surgical Causes', 'Completed', 3, '2025-01-26'),
(11, 'Tanwar Mumbaikar', 40, 'Byculla, Maharashtra', '777790078', 'tanwarmumbaikar@rehab.com', 'tanwarmumbaikar123', 'Degenrative Spinal disorder ', 'Pending', 3, '2024-12-27'),
(12, 'Yash Thorat', 69, 'Pune, Maharashtra', '282930157', 'yashthorat@rehab.com', 'yashthorat123', 'Neurological disorders', 'Not required', 3, '2025-01-18'),
(13, 'Pravin Lor', 29, 'New Panvel, Maharashtra', '+919099088747', 'pravinlor@rehab.com', 'pravinlor123', 'Spinal cord injury', 'Completed', 3, '2024-12-22'),
(14, 'Diksha Naidu', 35, 'Byculla, Maharashtra', '+918909878786', 'dikshanaidu@rehab.com', 'dikshanaidu123', 'Autoimmune disorder', 'Not required', 3, '2025-01-25'),
(15, 'Ryan James', 52, 'Vashi, Navi Mumbai', '+918809088747', 'ryanjames@rehab.com', 'ryanjames123', 'Spinal Contusions', 'Pending', 3, '2025-01-05'),
(16, 'Krutika Patil', 27, 'Old Panvel, Maharashtra', '98754349507', 'krutikapatil@rehab.com', 'krutikapatil123', 'Spinal cord injury', 'Pending', 3, '2025-01-18'),
(17, 'Sameer Rao', 45, 'Pune, Maharashtra', '+918806023456', 'sameerrao@rehab.com', 'sameer123', 'Lumbar Spinal Stenosis', 'Completed', 3, '2025-01-11'),
(18, 'Mona Gupta', 35, 'Borivali, Mumbai', '+919890987654', 'monagupta@rehab.com', 'mona123', 'Cervical Spinal Disorder', 'Not Required', 3, NULL),
(19, 'Amit Shah', 50, 'Ahmedabad, Gujarat', '+919404012345', 'amitshah@rehab.com', 'amit123', 'Degenerative Spinal Disorder', 'Pending', 3, '2025-01-12'),
(20, 'Pooja Iyer', 28, 'Bandra, Mumbai', '+919322011111', 'poojaiyer@rehab.com', 'pooja123', 'Spinal Cord Injury', 'Completed', 3, '2025-01-13'),
(21, 'Rahul Joshi', 33, 'Dadar, Mumbai', '+918877012345', 'rahuljoshi@rehab.com', 'rahul123', 'Metabolic Disorder', 'Not Required', 3, NULL),
(22, 'Anjali Verma', 42, 'Goregaon, Mumbai', '+919812345678', 'anjaliverma@rehab.com', 'anjali123', 'Spinal Tumor', 'Pending', 3, '2025-01-14'),
(23, 'Vikram Singh', 60, 'Jaipur, Rajasthan', '+919923456789', 'vikramsingh@rehab.com', 'vikram123', 'Degenerative Conditions', 'Completed', 3, '2025-01-15'),
(24, 'Sneha Kapoor', 27, 'Kolkata, West Bengal', '+919745012345', 'snehakapoor@rehab.com', 'sneha123', 'Spinal Fracture', 'Pending', 3, '2025-01-16'),
(25, 'Karan Mehta', 38, 'Andheri, Mumbai', '+919988112233', 'karanmehta@rehab.com', 'karan123', 'Cervical Disc Disorder', 'Not Required', 3, NULL),
(29, 'Neha Kulkarni', 25, 'Thane, Maharashtra', '+919823012345', 'nehakulkarni@rehab.com', 'neha123', 'Spinal Fracture', 'Pending', 3, '2025-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Doctor'),
(3, 'Patient');

-- --------------------------------------------------------

--
-- Table structure for table `therapy_sessions`
--

CREATE TABLE `therapy_sessions` (
  `session_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `session_date` date NOT NULL,
  `progress_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `therapy_sessions`
--

INSERT INTO `therapy_sessions` (`session_id`, `patient_id`, `doctor_id`, `session_date`, `progress_notes`) VALUES
(1, 1, 1, '2025-01-22', 'Conducted cognitive behavioral therapy session.'),
(2, 12, 1, '2025-01-03', 'Patient demonstrated progress in speech therapy.'),
(3, 8, 3, '2025-01-05', 'Discussed pain management strategies with patient.'),
(4, 13, 3, '2025-01-13', 'Conducted cognitive behavioral therapy session.'),
(5, 18, 3, '2025-01-10', 'Discussed pain management strategies with patient.'),
(6, 24, 9, '2025-01-04', 'Conducted cognitive behavioral therapy session.'),
(7, 17, 8, '2025-01-25', 'Conducted cognitive behavioral therapy session.'),
(8, 20, 10, '2025-01-03', 'Conducted cognitive behavioral therapy session.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `therapy_sessions`
--
ALTER TABLE `therapy_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `therapy_sessions`
--
ALTER TABLE `therapy_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `therapy_sessions`
--
ALTER TABLE `therapy_sessions`
  ADD CONSTRAINT `therapy_sessions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `therapy_sessions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
