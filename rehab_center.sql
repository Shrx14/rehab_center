-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 01:54 PM
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
  `email` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `role_id`) VALUES
(1, 'admin1', 'admin1', 'admin1@rehab.com', 1);

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
(1, 14, 1, '2025-03-10', '00:00:00', 'Completed'),
(2, 8, 2, '2025-03-11', '00:00:00', 'Completed'),
(3, 21, 3, '2025-03-12', '00:00:00', 'Completed'),
(4, 22, 4, '2025-03-13', '00:00:00', 'Completed'),
(5, 9, 5, '2025-03-14', '00:00:00', 'Cancelled'),
(6, 7, 6, '2025-03-15', '00:00:00', 'Completed'),
(7, 18, 7, '2025-03-16', '00:00:00', 'Completed'),
(8, 23, 8, '2025-03-17', '00:00:00', 'Scheduled'),
(9, 19, 9, '2025-03-18', '00:00:00', 'Scheduled'),
(10, 17, 10, '2025-03-19', '00:00:00', 'Scheduled'),
(11, 12, 11, '2025-03-20', '00:00:00', 'Completed'),
(12, 15, 12, '2025-03-21', '00:00:00', 'Scheduled'),
(13, 14, 13, '2025-03-22', '00:00:00', 'Cancelled'),
(14, 8, 14, '2025-03-23', '00:00:00', 'Scheduled'),
(15, 21, 15, '2025-03-24', '00:00:00', 'Scheduled'),
(16, 22, 16, '2025-03-25', '00:00:00', 'Completed'),
(17, 9, 17, '2025-03-26', '00:00:00', 'Scheduled'),
(18, 7, 18, '2025-03-27', '00:00:00', 'Scheduled'),
(19, 18, 19, '2025-03-28', '00:00:00', 'Scheduled'),
(20, 23, 20, '2025-03-29', '00:00:00', 'Cancelled'),
(21, 19, 22, '2025-03-30', '00:00:00', 'Scheduled'),
(81, 17, 1, '2025-03-30', '15:30:00', 'Scheduled'),
(82, 18, 1, '2025-03-24', '14:15:00', 'Scheduled'),
(83, 19, 1, '2025-03-15', '14:15:00', 'Completed');

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
  `max_patients` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `appointment_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `name`, `speciality`, `email`, `password`, `phone`, `experience`, `max_patients`, `role_id`, `appointment_count`) VALUES
(1, 'Dr. Amit S', 'Neurologist', 'amits1@rehab.com', 'amits1', '+91 9876543210', '5 years', 4, 2, 2),
(2, 'Dr. John Doe', 'Cardiologist', 'johndoe@rehab.com', 'johndoc1', '+91 9123456781', '10 years', 6, 2, 0),
(3, 'Dr. Sarah Lee', 'Orthopedic', 'sarahlee@rehab.com', 'sarahdoc1', '+91 9234567892', '8 years', 4, 2, 0),
(4, 'Dr. Michael Brown', 'Dermatologist', 'michaelbrown@rehab.com', 'mikedoc1', '+91 9345678903', '12 years', 5, 2, 0),
(5, 'Dr. Emily Davis', 'Pediatrician', 'emilydavis@rehab.com', 'emilydoc1', '+91 9456789014', '7 years', 6, 2, 0),
(6, 'Dr. Liam White', 'Gastroenterologist', 'liamwhite@rehab.com', 'liamdoc1', '+91 9567890125', '9 years', 5, 2, 0),
(7, 'Dr. Sophia Green', 'Psychiatrist', 'sophiagreen@rehab.com', 'sophiadoc1', '+91 9678901236', '5 years', 4, 2, 0),
(8, 'Dr. William Hall', 'Oncologist', 'williamhall@rehab.com', 'willdoc1', '+91 9789012347', '15 years', 8, 2, 1),
(9, 'Dr. Olivia Scott', 'Neurologist', 'oliviascott@rehab.com', 'oliviadoc1', '+91 9890123458', '11 years', 5, 2, 1),
(10, 'Dr. James Martinez', 'Endocrinologist', 'jamesmartinez@rehab.com', 'jamesdoc1', '+91 9901234569', '10 years', 6, 2, 1),
(11, 'Dr. Charlotte King', 'Urologist', 'charlotteking@rehab.com', 'charlottedoc1', '+91 9012345670', '6 years', 4, 2, 0),
(12, 'Dr. Benjamin Lopez', 'Hematologist', 'benjaminlopez@rehab.com', 'benjamindoc1', '+91 9123456781', '8 years', 5, 2, 1),
(13, 'Dr. Mia Clark', 'Radiologist', 'miaclark@rehab.com', 'miadoc1', '+91 9234567892', '7 years', 5, 2, 0),
(14, 'Dr. Elijah Walker', 'Pulmonologist', 'elijahwalker@rehab.com', 'elijahdoc1', '+91 9345678903', '9 years', 6, 2, 1),
(15, 'Dr. Abigail Adams', 'Nephrologist', 'abigailadams@rehab.com', 'abigaildoc1', '+91 9456789014', '10 years', 5, 2, 1),
(16, 'Dr. Lucas Young', 'Ophthalmologist', 'lucasyoung@rehab.com', 'lucasdoc1', '+91 9567890125', '5 years', 4, 2, 0),
(17, 'Dr. Amelia Allen', 'Allergist', 'ameliaallen@rehab.com', 'ameliadoc1', '+91 9678901236', '12 years', 7, 2, 1),
(18, 'Dr. Noah Harris', 'Rheumatologist', 'noahharris@rehab.com', 'noahdoc1', '+91 9789012347', '11 years', 5, 2, 1),
(19, 'Dr. Isabella Hill', 'Surgeon', 'isabellahill@rehab.com', 'isabelladoc1', '+91 9890123458', '8 years', 6, 2, 1),
(20, 'Dr. Ethan Campbell', 'Pathologist', 'ethancampbell@rehab.com', 'ethandoc1', '+91 9901234569', '9 years', 5, 2, 0),
(22, 'Aryan M', 'Psychologist', 'aryanmdoc@rehab.com', '$2y$10$4tCDdCo2uqq/2ylvstnbtekeJtcuODGHQhaUn/Z4AhchRoZKcOBpK', '+919898982341', '4', 2, 2, 1);

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
(1, 'Arjun S', 57, '1A, Srikant Comp, Mumbai', '+919986655111', 'arjuns1@rehab.com', 'arjuns1', 'Cervical Spinal Disorder', 'Not Required', 3, '1969-11-17'),
(6, 'Sam Paul', 54, 'Sector-17, Vashi, Navi Mumbai, Maharashtra', '+917889006000', 'sampaul@rehab.com', 'sampaul123', 'Spinal cord injury', 'Not required', 3, '2025-01-22'),
(7, 'Pooja Jain', 44, 'Alibag, Maharashtra', '+918975648273', 'poojajain@rehab.com', 'poojajain123', 'Vascular Disorder', 'Pending', 3, '2025-01-20'),
(8, 'Riya Louis', 30, 'Vashi, Navi Mumbai', '+918788909908', 'riyalouis@rehab.com', 'riyalouis123', 'Degenrative and Compressive Conditions', 'Completed', 3, '2025-01-01'),
(9, 'Upkar Sharma', 20, 'Dadar East, Maharashtra', '+919832313423', 'upkarsharma@rehab.com', 'upkarsharma123', 'Metabolic and Genetic Disorders', 'Not required', 3, '2025-01-09'),
(12, 'Yash Thorat', 69, 'Pune, Maharashtra', '+917682930157', 'yashthorat@rehab.com', 'yashthorat123', 'Neurological disorders', 'Not required', 3, '2025-01-18'),
(13, 'Pravin Lor', 29, 'New Panvel, Maharashtra', '+919099088747', 'pravinlor@rehab.com', 'pravinlor123', 'Spinal cord injury', 'Completed', 3, '2024-12-22'),
(14, 'Diksha Naidu', 35, 'Byculla, Maharashtra', '+918909878786', 'dikshanaidu@rehab.com', 'dikshanaidu123', 'Autoimmune disorder', 'Not required', 3, '2025-01-25'),
(15, 'Ryan James', 52, 'Vashi, Navi Mumbai', '+918809088747', 'ryanjames@rehab.com', 'ryanjames123', 'Spinal Contusions', 'Pending', 3, '2025-01-05'),
(17, 'Sameer Rao', 45, 'Pune, Maharashtra', '+918806023456', 'sameerrao@rehab.com', 'sameer123', 'Lumbar Spinal Stenosis', 'Completed', 3, '2025-01-11'),
(18, 'Mona Gupta', 35, 'Borivali, Mumbai', '+919890987654', 'monagupta@rehab.com', 'mona123', 'Cervical Spinal Disorder', 'Not Required', 3, NULL),
(19, 'Amit Shah', 50, 'Ahmedabad, Gujarat', '+919404012345', 'amitshah@rehab.com', 'amit123', 'Degenerative Spinal Disorder', 'Pending', 3, '2025-01-12'),
(20, 'Pooja Iyer', 28, 'Bandra, Mumbai', '+919322011111', 'poojaiyer@rehab.com', 'pooja123', 'Spinal Cord Injury', 'Completed', 3, '2025-01-13'),
(21, 'Rahul Joshi', 33, 'Dadar, Mumbai', '+918877012345', 'rahuljoshi@rehab.com', 'rahul123', 'Metabolic Disorder', 'Not Required', 3, NULL),
(22, 'Anjali Verma', 42, 'Goregaon, Mumbai', '+919812345678', 'anjaliverma@rehab.com', 'anjali123', 'Spinal Tumor', 'Pending', 3, '2025-01-14'),
(23, 'Vikram Singh', 60, 'Jaipur, Rajasthan', '+919923456789', 'vikramsingh@rehab.com', 'vikram123', 'Degenerative Conditions', 'Completed', 3, '2025-01-15'),
(24, 'Sneha Kapoor', 27, 'Kolkata, West Bengal', '+919745012345', 'snehakapoor@rehab.com', 'sneha123', 'Spinal Fracture', 'Pending', 3, '2025-01-16'),
(25, 'Karan Mehta', 38, 'Andheri, Mumbai', '+919988112233', 'karanmehta@rehab.com', 'karan123', 'Cervical Disc Disorder', 'Not Required', 3, NULL),
(29, 'Neha Kulkarni', 25, 'Thane, Maharashtra', '+919823012345', 'nehakulkarni@rehab.com', 'neha123', 'Spinal Fracture', 'Pending', 3, '2025-01-10'),
(30, 'Patrick James', 60, 'New Panvel, Maharashtra', '+917889882233', 'patrickjames@rehab.com', '$2y$10$xCmVbOxrsp97GO/hp38mfeTB/9dk/piKajdFjFi0HtpQaLL0qUbf.', 'Spinal Cord Injury', 'Pending', 3, '2025-02-01');

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
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `progress_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `therapy_sessions`
--

INSERT INTO `therapy_sessions` (`session_id`, `patient_id`, `doctor_id`, `appointment_id`, `session_date`, `progress_notes`) VALUES
(2, 12, 1, 12, '2025-01-03', 'Patient demonstrated progress in speech therapy.'),
(3, 8, 3, 82, '2025-01-05', 'Discussed pain management strategies with patient.'),
(5, 18, 3, 19, '2025-01-10', 'Discussed pain management strategies with patient.'),
(6, 24, 9, 6, '2025-01-04', 'Conducted cognitive behavioral therapy session.'),
(7, 17, 8, 17, '2025-01-25', 'Conducted cognitive behavioral therapy session.'),
(9, 14, 1, 1, '2025-03-10', 'Follow-up therapy session for cognitive behavior improvement.'),
(10, 8, 2, 2, '2025-03-11', 'Speech therapy session to improve communication skills.'),
(11, 21, 3, 3, '2025-03-12', 'Physical therapy for motor skill recovery.'),
(12, 12, 11, 12, '2025-03-21', 'Therapy session focused on rehabilitation progress.'),
(13, 22, 16, 16, '2025-03-25', 'Session to track recovery post-surgery.'),
(14, 19, 18, 18, '2025-03-28', 'Pain management and relaxation techniques discussed.'),
(15, 19, 1, 83, '2025-03-15', 'Therapy to improve stress management and mental health.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_admin_role` (`role_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
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
  ADD KEY `fk_therapy_patient` (`patient_id`),
  ADD KEY `fk_therapy_doctor` (`doctor_id`),
  ADD KEY `fk_therapy_appointment` (`appointment_id`);

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
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

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
  ADD CONSTRAINT `fk_therapy_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_therapy_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_therapy_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
