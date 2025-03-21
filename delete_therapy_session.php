<?php
session_start();
include 'connection.php'; // Database connection file

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php"); // Redirect to login page if not an admin
    exit();
}

// Delete the therapy session
if (isset($_GET['id'])) {
    $session_id = $_GET['id'];
    $delete_query = "DELETE FROM therapy_sessions WHERE session_id = $session_id";
    mysqli_query($conn, $delete_query);
}

// Redirect back to the therapy sessions page
header("Location: all_therapy_sessions.php");
exit();
?>
